<html lang="fr">

    <head>
        <title>Creation d'un exercice</title>
    </head>
    <body>
        <h1>nouvel exo</h1>
        <form method="POST" action="/exercice/create">
            @csrf
            <a>nom:</a>
            <input type="text" name="name"><br>
            <label for="name">Description exo</label>
            <textarea name="description"></textarea><br>
            <a>duration:</a>
            <input type="text" name="duration"><br>
            <a>type:</a>
            <input type="text" name="type"><br>
            <a>distance:</a>
            <input type="text" name="distance"><br>
            <a>poids:</a>
            <input type="text" name="weight"><br>
            <a>repetition:</a>
            <input type="text" name="repetition"><br>
            <input type="submit" value="Valider">
        </form>
    </body>

