<?php
/**
 * @source: https://gist.github.com/basvandorst/1468593
 * @source: http://stackoverflow.com/a/4897274/1238019
 */

ini_set('include_path', ini_get('include_path') . ':./app/shoow');

require_once('app/autoloader.php');
require_once('vendor/simplehtmldom/simple_html_dom.php');

use shoow\util\SourceParser;

$data = SourceParser::load('Strasbourg');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shoow — Les prochaines séances près de chez vous</title>
    <meta name="description" content="Les prochaines séances dans les cinémas près de chez vous.">

    <meta property="og:site_name" content="Shoow" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:url" content="http://shoow.io" />
    <!-- <meta property="og:image" content="http://smarchal.com/images/zessx.png" /> -->
    <meta property="og:description" content="Les prochaines séances dans les cinémas près de chez vous." />
    <meta property="og:type" content="website" />

    <meta property="twitter:card" content="summary" />
    <meta property="twitter:site" content="Shoow" />
    <meta property="twitter:creator" content="zessx" />
    <!-- <meta property="twitter:image" content="http://smarchal.com/images/zessx.png" /> -->
    <meta property="twitter:image:width" content="360" />
    <meta property="twitter:image:height" content="360" />
    <meta property="twitter:description" content="Les prochaines séances dans les cinémas près de chez vous." />
    <meta property="twitter:title" content="Shoow" />

    <!-- <meta name="theme-color" content="#b3A1bc" /> -->

    <link rel="stylesheet" href="public/app.css">
    <link rel="canonical" href="http://shoow.io">
    <link rel="me" href="https://twitter.com/zessx">
    <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->
</head>
<body>

    <header>
        <h1>Shoow</h1>

        <?php
        foreach ($data['theaters'] as $theater) {
            $theater->render();
        }
        ?>
    </header>

    <main>
        <?php
        foreach ($data['movies'] as $movie) {
            $movie->render();
        }
        ?>
    </main>


</body>
</html>