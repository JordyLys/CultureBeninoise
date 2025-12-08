<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    /**
     * Affiche la page d’abonnement
     */
    public function show($id)
    {
        return view('front.abonnement', compact('id'));
    }

    /**
     * Lancement du paiement
     */
    public function payer(Request $request)
    {
        $request->validate([
            'offre' => 'required|in:100f,500f,1000f,2500f',
        ]);

        $offre = $request->offre;

        // Définition des offres
        $offres = [
            '100f'  => ['amount' => 100,  'desc' => '3 contenus',    'jours' => 30, 'max' => 3],
            '500f'  => ['amount' => 500,  'desc' => 'Accès 3 jours',  'jours' => 3,  'max' => null],
            '1000f' => ['amount' => 1000, 'desc' => 'Accès 7 jours',  'jours' => 7,  'max' => null],
            '2500f' => ['amount' => 2500, 'desc' => 'Accès 30 jours', 'jours' => 30, 'max' => null],
        ];

        $conf = $offres[$offre];

        // Stockage sécurisé en session
        session([
            'abonnement_en_cours' => [
                'offre'      => $offre,
                'jours'      => $conf['jours'],
                'contenus_max'=> $conf['max'],
                'user_id'    => auth()->id(),
                'contenu_id' => $request->id,
            ],
        ]);

        // Configuration FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret'));
        FedaPay::setEnvironment('sandbox');

        // Création transaction
        //dd(config('services.fedapay.secret'));
        $transaction = Transaction::create([
            'amount'       => $conf['amount'],
            'currency'     => ['iso' => 'XOF'],
            'description'  => 'Abonnement Culture Béninoise - '.$conf['desc'],
            'callback_url' => 'https://unstupefied-antonina-scissile.ngrok-free.dev/abonnement/callback',
            'return_url'   => 'https://unstupefied-antonina-scissile.ngrok-free.dev/abonnement.success',
        ]);
       // dd($transaction);

        return redirect()->away($transaction->payment_url);

    }

    /**
     * CALLBACK FedaPay (serveur → serveur)
     */
    public function callback(Request $request)
    {
        \Log::info('FedaPay Callback', $request->all());

        FedaPay::setApiKey(config('services.fedapay.secret'));
        FedaPay::setEnvironment('sandbox');

        if (! $request->transaction_id) {
            \Log::error('Transaction ID manquant');
            return response()->json(['error' => 'missing transaction id'], 400);
        }

        $transaction = Transaction::retrieve($request->transaction_id);

        if ($transaction->status !== 'approved') {
            \Log::warning('Paiement non validé', ['status' => $transaction->status]);
            return response()->json(['status' => 'not approved'], 200);
        }

        // Paiement validé
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * RETOUR UTILISATEUR APRÈS PAIEMENT
     */
    public function success()
    {
        $data = session('abonnement_en_cours');

        if (! $data) {
            return redirect()->route('home')->with('error', 'Session expirée');
        }

        $user = auth()->user();

        $user->abonnements()->create([
            'type'        => $data['offre'],
            'contenus_max'=> $data['contenus_max'],
            'contenus_lus'=> 0,
            'date_debut'  => now(),
            'date_fin'    => now()->addDays($data['jours']),
        ]);

        $contenuId = $data['contenu_id'];
        session()->forget('abonnement_en_cours');

        return redirect()
            ->route('front.contenu.show', ['id' => $contenuId])
            ->with('success', 'Paiement effectué avec succès');
    }
}
