<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <style>
        :root {
            --green: #2e7d32;
            --green-light: #60ad5e;
            --orange-soft: #ffb366;
            --pink-light: #ffe6f0;
            --bg-light: #fdf7f7;
            --text-main: #003366;
            --shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --radius: 12px;
            --font: 'Roboto', sans-serif;
        }

        body {
            font-family: var(--font);
            background-color: var(--pink-light);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
        }

        .container {
            max-width: 480px;
            width: 100%;
            background-color: var(--bg-light);
            padding: 40px 35px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border-top: 5px solid var(--green);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--green);
            border-bottom: 2px solid var(--orange-soft);
            padding-bottom: 10px;
            font-weight: 700;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        label.required::after {
            content: " *";
            color: var(--orange-soft);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: var(--radius);
            font-size: 15px;
        }

        input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
            outline: none;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .form-actions .btn {
            flex: 1;
            padding: 12px;
            font-weight: bold;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 15px;
            border: none;
        }

        .btn-submit {
            background-color: var(--green);
            color: white;
        }

        .btn-submit:hover {
            background-color: var(--green-light);
        }

        .btn-cancel {
            background-color: transparent;
            border: 2px solid #b0bec5;
            color: #546e7a;
        }

        .btn-cancel:hover {
            background-color: #eceff1;
            color: #37474f;
            text-decoration: none;
        }

        .forgot {
            display: block;
            margin-top: 18px;
            color: var(--green);
            font-size: 0.95rem;
            text-align: right;
        }

        .forgot:hover {
            color: var(--green-light);
            text-decoration: underline;
        }

        .bottom-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: var(--green);
        }

        .bottom-link:hover {
            color: var(--green-light);
        }

        @media (max-width: 576px) {
            .form-actions {
                flex-direction: column-reverse;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <center>
            <img src="{{ asset('adminlte/img/cultureBeninoise.png') }}" alt="Logo"
                style="width: 90px; border-radius: 12px;">
        </center>

        <h2>Connexion</h2>

        <!-- Session status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <div>
                <label for="email" class="required">Email</label>
                <input type="email" id="email" name="email" required autocomplete="new-email">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="required">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">
                    Mot de passe oublié ?
                </a>
            @endif

            <div class="form-actions">
                <a href="{{ route('home') }}" class="btn btn-cancel">
                    Annuler
                </a>

                <button type="submit" class="btn btn-submit">
                    Se connecter
                </button>
            </div>
        </form>

        <a href="{{ route('register') }}" class="bottom-link">
            Pas encore de compte ? Inscrivez-vous
        </a>
    </div>

</body>

</html>
