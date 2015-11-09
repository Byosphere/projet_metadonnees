<html lang="fr"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('meta')
    <link rel="icon" href="../../favicon.ico">

    <title>Projet Métadonnée des images</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

    <body>
        <nav class="top-bar" role="navigation">
            <h1><a href="{{ url('/') }}"><strong>DATA</strong>#photos</a></h1>
            <section class="pull-right">
                <a class="button" href="{{ url('/apropos') }}">A propos du projet</a>
            </section>
            <section class="pull-right">
                <a class="button" href="{{ url('/upload') }}">Ajouter une photo</a>
            </section>
        </nav>
        @if ( Session::has('message') )
            <div class="message">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="wrap">

            @yield('content')

        </div><!-- /.container -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    </body>
</html>
