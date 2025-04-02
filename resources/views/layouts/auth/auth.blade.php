<!DOCTYPE html>
<html lang="fr">


<head>
    <title> @yield('title', 'aquafit') </title>
    <link href="/css/style.css" rel="stylesheet">
</head>

<body>
    @include('layouts.navigation')
    <main>

        @yield('content')
    </main>
    @include('layouts.footer')
</body>


</html>
