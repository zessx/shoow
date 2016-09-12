<?php
/**
 * @source: https://gist.github.com/basvandorst/1468593
 * @source: http://stackoverflow.com/a/4897274/1238019
 */

require_once('vendor/simplehtmldom/simple_html_dom.php');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://www.google.fr/movies?near=strasbourg');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
$str = curl_exec($curl);
curl_close($curl);

$html = str_get_html($str);

function data($element) {
    return iconv('ISO-8859-1', 'UTF-8', $element->innertext);
}

$theaters = array();

foreach ($html->find('#movie_results .theater') as $theater) {

    $tid = $theater->find('.desc', 0)->id;
    $theaters[$tid] = array(
        'name'    => data($theater->find('h2 a', 0)),
        'address' => data($theater->find('.info', 0)),
        'movies'  => array()
    );

    foreach ($theater->find('.movie') as $movie) {

        $mid = preg_replace('/^.*mid=([\da-f]+).*$/', '$1', $movie->find('.name a', 0)->href);
        $theaters[$tid]['movies'][$mid] = array(
            'name'      => data($movie->find('.name a', 0)),
            'info'      => data($movie->find('.info', 0)),
            'showtimes' => data($movie->find('.times', 0))
        );

    }

}

print '<pre>';
var_dump($theaters);
print '</pre>';

$html->clear();
