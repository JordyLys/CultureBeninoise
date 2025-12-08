<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class AbonnementController extends Controller
{
    public function show($id)
    {
        return view('front.abonnement', compact('id'));
    }

    public function payer(Request $request)
    {
        try {
            $offre = $request->input('offre');

            // Définir le montant et la description selon l'offre
            switch ($offre) {
                case '100f':
                    $amount = 100;
                    $description = 'Abonnement Culture Béninoise - 3 contenus';
                    $duration = 1; // 1 utilisation
                    break;
                case '500f':
                    $amount = 500;
                    $description = 'Abonnement Culture Béninoise - 3 jours accès complet';
                    $duration = 3; // 3 jours
                    break;
                case '1000f':
                    $amount = 1000;
                    $description = 'Abonnement Culture Béninoise - 1 semaine accès complet';
                    $duration = 7; // 7 jours
                    break;
                case '2500f':
                    $amount = 2500;
                    $description = 'Abonnement Culture Béninoise - 1 mois accès complet';
                    $duration = 30; // 30 jours
                    break;
                default:
                    return redirect()->back()->with('error', 'Offre invalide');
            }

            /** 1. Clé API live */
            FedaPay::setApiKey(env('FEDAPAY_SECRET_KEY_LIVE'));
            FedaPay::setEnvironment('production');

            /** 2. Créer la transaction */
            $transaction = Transaction::create([
                'amount' => $amount,
                'description' => $description,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('front.abonnement.callback', ['id' => $request->id]),
            ]);

            /** 3. Redirection vers FedaPay */
            return redirect()->away($transaction->payment_url);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

   public function callback(Request $request)
{
    $user = auth()->user();
    $offre = $request->input('offre'); // envoyer via callback si possible

    // Définir durée et max contenus
    $data = [
        '100f'  => ['contenus_max' => 3,   'jours' => 30], // durée arbitraire ou infinie
        '500f'  => ['contenus_max' => null,'jours' => 3],
        '1000f' => ['contenus_max' => null,'jours' => 7],
        '2500f' => ['contenus_max' => null,'jours' => 30],
    ];

    if(!isset($data[$offre])){
        return redirect()->route('front.abonnement.show', $request->id)
                         ->with('error', 'Offre invalide');
    }

    $abonnement = $user->abonnements()->create([
        'type' => $offre,
        'contenus_max' => $data[$offre]['contenus_max'],
        'contenus_lus' => 0,
        'date_debut' => now(),
        'date_fin' => $data[$offre]['jours'] ? now()->addDays($data[$offre]['jours']) : null,
    ]);

    return redirect()->route('front.contenu.show', $request->id)
                     ->with('success', 'Paiement réussi !');
}

}
