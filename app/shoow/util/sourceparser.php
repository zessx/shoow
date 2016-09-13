<?php

namespace shoow\util;

use shoow\model\Theater;
use shoow\model\Movie;
use shoow\model\Showtime;

class SourceParser
{

    public static function load($location = 'Strasbourg', $tld = 'fr') {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.google.'. $tld .'/movies?near='. $location);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        $str = curl_exec($curl);
        curl_close($curl);

        $html = str_get_html($str);

        $theaters = array();

        foreach ($html->find('#movie_results .theater') as $theater) {
            $tid      = $theater->find('.desc', 0)->id;
            $tname    = self::convert($theater->find('h2 a', 0)->innertext);
            $taddress = self::convert($theater->find('.info', 0)->innertext);
            $tmovies  = array();

            foreach ($theater->find('.movie') as $movie) {
                $mid        = preg_replace('/^.*mid=([\da-f]+).*$/', '$1', $movie->find('.name a', 0)->href);
                $mname      = self::convert($movie->find('.name a', 0)->innertext);
                $minfo      = self::convert($movie->find('.info', 0)->innertext);
                $mshowtimes = self::convert($movie->find('.times', 0)->innertext);

                $tmovies[] = new Movie($mid, $mname, $minfo, $mshowtimes);
            }

            $theaters[] = new Theater($tid, $tname, $taddress, $tmovies);
        }

        $html->clear();

        return $theaters;

    }

    public static function convert($text) {
        return iconv('ISO-8859-1', 'UTF-8', $text);
    }

}