<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Mail\VerificationCodeMail;

class RegisteredUserController extends Controller
{
    // Étape 1 : Affiche formulaire email/mot de passe
    public function showStep1() {
        return view('auth.register');
    }

    // Étape 1 : Traitement du formulaire
    public function step1(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $code = rand(100000, 999999); // code 6 chiffres

        // Enregistrement temporaire (session)
        session([
            'register_email' => $request->email,
            'register_password' => Hash::make($request->password),
            'register_code' => $code,
        ]);

        // Envoyer email
        Mail::to($request->email)->send(new VerificationCodeMail($code));

        return redirect()->route('register.verify')->with('status', 'Un code de confirmation a été envoyé à votre email.');
    }

    // Étape 2 : page de saisie du code
    public function showVerify() {
        return view('auth.register_verify');
    }

    // Vérification du code
    public function verifyCode(Request $request) {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if ($request->code != session('register_code')) {
            return back()->withErrors(['code' => 'Code incorrect']);
        }

        return redirect()->route('register.step2');
    }

    // Étape 3 : formulaire final
    public function showStep2() {
        return view('auth.register_step2');
    }

    // Traitement formulaire final
    public function step2(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => session('register_email'),
            'password' => session('register_password'),
            'phone' => $request->phone,
        ]);

        // Nettoyer session
        session()->forget(['register_email','register_password','register_code']);

        auth()->login($user);

        return redirect()->route('home')->with('success','Compte créé avec succès!');
    }


    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }

}
