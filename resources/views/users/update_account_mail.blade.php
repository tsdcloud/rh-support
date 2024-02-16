<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application de gestion disciplinaire</title>
</head>
<body>
    <br>
    Bonjour {{ $mailData['user']->fname }}  {{ $mailData['user']->lname }}, <br>

    <p>Votre compte sur la plateforme de gestion disciplinaire a été mis à jour</p>
    <p>Ci-dessous vos identifiants de connexion</p>
    <p><strong>Email: </strong> {{ $mailData['user']->email }}</p>
    <p><strong> Mot de passe:</strong>  {{ $mailData['password'] }}</p>

    <p>
        <a href="{{ url('http://supportrh.bfclimited.com:8070/users/profil/'. $mailData['user']->id) }}">
            Cliquer ici pour accéder à votre page de profil.
        </a>
    </p>
</body>
</html>
