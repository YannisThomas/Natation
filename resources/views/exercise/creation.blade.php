<html lang="fr">

<head>
    <title>Creation d'un exercice</title>
</head>

<body>
    <h1>nouvel exo</h1>
    @if ($errors->any())
        <p>Erreurs!</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif




    <form method="POST" action="/exercice/creation">
        @csrf
        <div>
            <label for="name">Nom</label>
            <input id="name" type="text" name="name" placeholder="nom de l'exo" />
        </div>
        <div>
            <label for="duration">Durée</label>
            <input id= "duration" type="text" name="duration" placeholder="temps en minutes" />
        </div>
        <div>
            <label for="type">Type d'exercice</label>
            <select id="type" name="type">
                <option value="cardio">cardio</option>
                <option value="musculaire">musculaire</option>
                <option value="endurance">endurance</option>

            </select>
        </div>
        <div>
            <label for="distance">Distance</label>
            <input id="distance" type="text" name="distance" placeholder="distance en km" />
        </div>
        <div>
            <label for="weight">Poids</label>
            <input id="weight" type="text" name="weight" placeholder="poids en kg" />
        </div>
        <div>
            <label for="repetition">Répétition</label>
            <input id="repetition" type="text" name="repetition" placeholder="nombre de répétition" />
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="description de l'exo"></textarea>
        </div>
        <div>
            <input type="submit" value="Valider">

        </div>
    </form>
</body>
