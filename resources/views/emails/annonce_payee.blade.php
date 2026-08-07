<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Annonce publiée</title>
</head>
<body>
  <p>Bonjour,</p>
  <p>Votre annonce "{{ $appartement->type }} - {{ \Illuminate\Support\Str::limit($appartement->quartier, 40) }}" a été publiée avec succès.</p>
  <p>Référence : <strong>{{ $appartement->id }}</strong></p>
  <p>Merci d'avoir utilisé notre service.</p>
</body>
</html>
