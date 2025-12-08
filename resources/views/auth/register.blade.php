<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscription</title>
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
    box-sizing: border-box;
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

input[type="text"],
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

button {
    width: 100%;
    padding: 12px;
    font-weight: bold;
    border-radius: var(--radius);
    cursor: pointer;
    font-size: 15px;
    border: none;
    transition: transform 0.2s;
}

button:hover {
    transform: scale(1.03);
}

.btn-submit {
    background-color: var(--green);
    color: white;
}

.btn-submit:hover {
    background-color: var(--green-light);
}

a {
    color: var(--green);
    display: inline-block;
    margin-top: 15px;
}

a:hover {
    color: var(--green-light);
}
</style>
</head>

<body>

<div class="container">
    <center>
        <img src="{{ asset('adminlte/img/cultureBeninoise.png') }}" alt="Logo" style="width: 90px; border-radius: 12px;">
    </center>

    <h2>Inscription</h2>

    <!-- Étape 1 : Email & mot de passe -->
    <form method="POST" action="{{ route('register.step1') }}">
        @csrf

        <div>
            <label for="email" class="required">Email</label>
            <input type="email" id="email" name="email" required>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="required">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="required">Confirmer mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-submit">S’inscrire</button>
    </form>

    <a href="{{ route('login') }}">Déjà un compte ? Connectez-vous</a>
</div>

</body>
</html>
