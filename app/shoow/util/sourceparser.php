<?php

namespace shoow\util;

use shoow\model\Theater;
use shoow\model\Movie;
use shoow\model\Showtime;

class SourceParser
{

    public static function load($location = 'Strasbourg') {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.google.fr/movies?near='. $location);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        $str = curl_exec($curl);
        curl_close($curl);

        $html = str_get_html($str);

        $movies   = array();
        $theaters = array();

        foreach ($html->find('#movie_results .theater') as $dom_theater) {
            $tid = preg_replace('/^theater_(.+)$/', '$1', $dom_theater->find('.desc', 0)->id);
            if (!isset($theaters[$tid])) {
                $tname    = self::convert($dom_theater->find('h2 a', 0)->innertext);
                $taddress = self::convert($dom_theater->find('.info', 0)->innertext);
                $theaters[$tid] = new Theater($tid, $tname, $taddress);
            }

            foreach ($dom_theater->find('.movie') as $dom_movie) {
                $mid = preg_replace('/^.*mid=([\da-f]+).*$/', '$1', $dom_movie->find('.name a', 0)->href);
                if (!isset($movies[$mid])) {
                    $mname = self::convert($dom_movie->find('.name a', 0)->innertext);
                    preg_match_all('/^(?<duration>\d+h\d+)mn - Classification: (?<public>.+?) - (?<genre>.+?)(‎ - VO st Fr‎)?$/', self::convert($dom_movie->find('.info', 0)->innertext), $minfo);
                    $movies[$mid] = new Movie($mid, $mname, $minfo['public'][0], $minfo['genre'][0], $minfo['duration'][0]);
                }

                $mversions = explode('<br>', $dom_movie->find('.times', 0)->innertext);
                foreach ($mversions as $mversion) {
                    $text = str_replace('&nbsp', '', strip_tags($mversion));
                    preg_match_all('/^(?<version>V[a-zA-Z\s]+)?(?<times>(?:\d+:\d+\s*)+)$/', $text, $mvshowtimes);
                    if (empty($mvshowtimes['version'][0])) {
                        $sversion = 'VF';
                    } else {
                        $sversion = str_replace(' ', '', strtoupper($mvshowtimes['version'][0]));
                    }

                    $mtimes = explode(' ', $mvshowtimes['times'][0]);
                    foreach ($mtimes as $stime) {
                        $movies[$mid]->addShowtime(new Showtime($theaters[$tid], $movies[$mid], $sversion, trim($stime)));
                    }
                }
            }

        }

        $html->clear();

        usort($movies, function($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        usort($theaters, function($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return array(
            'movies' => $movies,
            'theaters' => $theaters
        );
    }

    private static function convert($text) {
        return iconv('ISO-8859-1', 'UTF-8', $text);
    }

}