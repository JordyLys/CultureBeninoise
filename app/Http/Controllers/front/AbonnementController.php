<?php

namespace App\Http\Controllers\front;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbonnementController extends Controller
{

    public function show($id)
    {
        return view('front.abonnement', compact('id'));
    }

    public function payer(Request $request)
    {
        // Vérifier si l'utilisateur est connecté ou non
    $userId = auth()->check() ? auth()->id() : session('guest_id', (string) Str::uuid());

    // Si l'utilisateur est anonyme (non connecté), enregistre son guest_id dans la session
    if (!auth()->check()) {
        session(['guest_id' => $userId]);
    }
        $request->validate([
            'offre' => 'required|in:100f,500f,1000f,2500f',
        ]);

        $offre = $request->offre;
        $offres = [
            '100f'  => ['amount' => 100,  'desc' => '3 contenus',    'jours' => 30, 'max' => 3],
            '500f'  => ['amount' => 500,  'desc' => 'Accès 3 jours',  'jours' => 3,  'max' => null],
            '1000f' => ['amount' => 1000, 'desc' => 'Accès 7 jours',  'jours' => 7,  'max' => null],
            '2500f' => ['amount' => 2500, 'desc' => 'Accès 30 jours', 'jours' => 30, 'max' => null],
        ];

        $conf = $offres[$offre];
        $contenuId = $request->id ?? 1;

        // Stocker en session
        session([
            'abonnement_en_cours' => [
                'offre'        => $offre,
                'jours'        => $conf['jours'],
                'contenus_max' => $conf['max'],
                'contenu_id'   => $contenuId,
                'amount'       => $conf['amount'],
            ],
        ]);

        \Log::info('Lancement paiement', [
            'contenu_id' => $contenuId,
            'offre' => $offre
        ]);

        // Configuration FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret'));
        FedaPay::setEnvironment('sandbox');


        // URL de callback et return URL
        $callbackUrl = route('front.abonnement.callback', ['contenu_id' => $contenuId]);
        $returnUrl = route('front.abonnement.callback.redirect', ['contenu_id' => $contenuId]);

        \Log::info('URLs FedaPay:', [
            'callback' => $callbackUrl,
            'return' => $returnUrl
        ]);

        try {
            $transaction = Transaction::create([
                'amount'       => $conf['amount'],
                'currency'     => ['iso' => 'XOF'],
                'description'  => 'Abonnement Culture Béninoise - '.$conf['desc'],
                'callback_url' => $callbackUrl,
                'return_url'   => $returnUrl,
            ]);

            session(['abonnement_en_cours.transaction_id' => $transaction->id]);

            return redirect()->away($transaction->payment_url);

        } catch (\Exception $e) {
            \Log::error('Erreur création transaction FedaPay', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur lors de la création du paiement.');
        }
    }


    /**
     * CALLBACK FedaPay (POST - serveur à serveur)
     */
    public function callback(Request $request)
    {
        \Log::info('=== CALLBACK FEDAPAY ===', $request->all());

        $contenu_id = $request->get('contenu_id');
        $transaction_id = $request->get('id');
        $status = $request->get('status');

        \Log::info('Callback params:', [
            'contenu_id' => $contenu_id,
            'transaction_id' => $transaction_id,
            'status' => $status
        ]);

        // Récupérer l'offre depuis la session
        $offre_code = session('abonnement_en_cours.offre');

        if (!$offre_code) {
            \Log::error('Offre non trouvée en session', ['contenu_id' => $contenu_id]);
            return response('Offre non trouvée', 400);
        }

        // Trouver le paiement existant
        $abonnement = \App\Models\Abonnement::where('transaction_id', $transaction_id)->first();

        // Si le paiement est approuvé, créer ou mettre à jour l'abonnement
        if ($status === 'approved') {
            if (!$abonnement) {
                // Créer un nouvel abonnement
                $abonnementData = [
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'guest_id' => !auth()->check() ? session('guest_id') : null,
                    'type' => $offre_code,
                    'contenus_max' => $this->getContenusMax($offre_code),
                    'date_debut' => now(),
                    'date_fin' => now()->addDays($this->getDureeAbonnement($offre_code)),
                    'transaction_id' => $transaction_id,
                ];

                $abonnement = \App\Models\Abonnement::create($abonnementData);
                \Log::info('Abonnement créé', ['transaction_id' => $transaction_id]);
            }

            // Créer une session pour accès immédiat
            session([
                'paid_content_' . $contenu_id => true,
                'payment_time_' . $contenu_id => now()
            ]);

            \Log::info('Paiement approuvé, contenu marqué comme payé', ['contenu_id' => $contenu_id]);
        }


        // Le callback ne doit PAS rediriger l'utilisateur
        // C'est la route 'success' qui s'en charge
        return response('Callback traité', 200);
    }

    /**
     * Redirection utilisateur depuis callback (GET)
     */
    public function callbackRedirect(Request $request)
    {
        \Log::info('=== CALLBACK REDIRECT (GET) ===', $request->all());

        $contenuId = $request->contenu_id;
        $transactionId = $request->id;
        $status = $request->status;

        \Log::info('Callback redirect params:', [
            'contenu_id' => $contenuId,
            'transaction_id' => $transactionId,
            'status' => $status
        ]);

        // Rediriger vers la route success avec les paramètres
        return redirect()->route('front.abonnement.success', [
            'contenu_id' => $contenuId,
            'id' => $transactionId,
            'status' => $status
        ]);
    }

    private function getContenusMax($offreCode)
    {
        switch ($offreCode) {
            case '100f': return 3;   // 3 contenus
            case '500f': return null; // Illimité
            case '1000f': return null; // Illimité
            case '2500f': return null; // Illimité
            default: return null;
        }
    }

    private function getDureeAbonnement($offreCode)
{
    switch ($offreCode) {
        case '500f': return 3;   // 3 jours
        case '1000f': return 7;  // 7 jours
        case '2500f': return 30; // 30 jours
        default: return 1;       // 1 jour pour l'offre 100f
    }

}

    /**
     * SUCCESS - Redirection utilisateur après paiement
     */
    public function success(Request $request)
    {
        \Log::info('=== SUCCESS ROUTE ===', $request->all());

        // Vérifier les paramètres FedaPay
        $contenuId = $request->contenu_id ?? (session('abonnement_en_cours.contenu_id') ?? 1);
        $transactionId = $request->id ?? $request->transaction_id;
        $status = $request->status;

        \Log::info('Paramètres success:', [
            'contenu_id' => $contenuId,
            'transaction_id' => $transactionId,
            'status' => $status
        ]);

        // Si pas de statut ou transaction ID, erreur
        if (!$status || !$transactionId) {
            \Log::error('Paramètres manquants dans success');
            return redirect()->route('front.abonnement.show', $contenuId)
                ->with('error', 'Paramètres de paiement incomplets.');
        }

        // Vérifier le paiement
        if ($status !== 'approved') {
            \Log::warning('Statut non approuvé dans success');
            return redirect()->route('front.abonnement.show', $contenuId)
                ->with('error', 'Paiement non approuvé: ' . $status);
        }

        try {
            // Vérifier la transaction via FedaPay
            FedaPay::setApiKey(config('services.fedapay.secret'));
            FedaPay::setEnvironment('sandbox');

            $transaction = Transaction::retrieve($transactionId);

            if ($transaction->status !== 'approved') {
                \Log::warning('Transaction non approuvée', ['status' => $transaction->status]);
                return redirect()->route('front.abonnement.show', $contenuId)
                    ->with('error', 'Transaction non validée.');
            }

            // Récupérer le contenu pour la redirection
            $contenu = \App\Models\Contenu::find($contenuId);
            if (!$contenu) {
                \Log::error('Contenu introuvable', ['contenu_id' => $contenuId]);
                return redirect()->route('home')
                    ->with('error', 'Contenu introuvable.');
            }

            // Si la transaction est validée, lier à l'abonnement
            // Recherche ou création de l'abonnement
            $abonnement = \App\Models\Abonnement::where('transaction_id', $transactionId)->first();

            if (!$abonnement) {
                // Si aucun abonnement n'est trouvé, créez-le
                $abonnementData = [
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'guest_id' => !auth()->check() ? session('guest_id') : null,
                    'type' => session('abonnement_en_cours.offre'),
                    'contenus_max' => session('abonnement_en_cours.contenus_max'),
                    'date_debut' => now(),
                    'date_fin' => now()->addDays(session('abonnement_en_cours.jours')),
                    'transaction_id' => $transactionId,
                ];

                // Créer un nouvel abonnement
                $abonnement = \App\Models\Abonnement::create($abonnementData);
            }

            // Marquer le contenu comme payé dans la session
            session(['paid_content_' . $contenuId => true]);
            session(['payment_transaction_' . $contenuId => $transactionId]);

            \Log::info('Paiement validé, redirection vers contenu', [
                'contenu_id' => $contenuId,
                'transaction_id' => $transactionId
            ]);

            // Nettoyer la session d'abonnement
            session()->forget('abonnement_en_cours');

            // Rediriger vers la page du contenu
            return redirect()->route('front.contenu.show', $contenuId)
                ->with('success', 'Paiement effectué avec succès!');

        } catch (\Exception $e) {
            \Log::error('Erreur vérification transaction', ['error' => $e->getMessage()]);
            return redirect()->route('front.abonnement.show', $contenuId)
                ->with('error', 'Erreur de vérification du paiement.');
        }
    }

    /**
     * Gestion de la redirection utilisateur depuis callback
     */
    private function handleUserRedirect(Request $request)
    {
        \Log::info('=== REDIRECTION UTILISATEUR DEPUIS CALLBACK ===', $request->all());

        // Récupérer les paramètres
        $contenuId = $request->contenu_id ?? (session('abonnement_en_cours.contenu_id') ?? 1);
        $transactionId = $request->id ?? $request->transaction_id;
        $status = $request->status;

        \Log::info('Redirection avec paramètres:', [
            'contenu_id' => $contenuId,
            'transaction_id' => $transactionId,
            'status' => $status
        ]);

        // Rediriger vers success pour traitement
        return redirect()->route('front.abonnement.success', [
            'contenu_id' => $contenuId,
            'id' => $transactionId,
            'status' => $status
        ]);
    }
}
