<?php
/**
 * @source: https://gist.github.com/basvandorst/1468593
 * @source: http://stackoverflow.com/a/4897274/1238019
 */

ini_set('include_path', ini_get('include_path') . ':./app/shoow');

require_once('app/autoloader.php');
require_once('vendor/simplehtmldom/simple_html_dom.php');

use shoow\util\SourceParser;

$theaters = SourceParser::load('Strasbourg', 'fr');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shoow</title>
</head>
<body>

    <header>
        <h1>Shoow</h1>
    </header>

    <main>
    <?php
        foreach ($theaters as $theater) {
            $theater->render();
        }
    ?>
    </main>

</body>
</html>