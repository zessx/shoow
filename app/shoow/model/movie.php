<?php

namespace shoow\model;

class Movie
{

    private $id;
    private $name;
    private $public;
    private $genre;
    private $duration;
    public $showtimes;

    function __construct($id, $name, $public, $genre, $duration, $showtimes = array()) {
        if (!is_array($showtimes)) {
            throw new \InvalidArgumentException();
        }
        $this->id        = $id;
        $this->name      = $name;
        $this->public    = $public;
        $this->genre     = $genre;
        $this->duration  = $duration;
        $this->showtimes = $showtimes;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPublic() {
        return $this->public;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getPoster() {
        $poster_name = $this->getId() .'.jpg';
        $poster_path = PUBLIC_PATH .'/images/posters/'. $poster_name;
        if (file_exists($poster_path)) {
            return PUBLIC_URL .'/images/posters/'. $poster_name;
        }
        return PUBLIC_URL .'/images/posters/default.jpg';
    }

    public function getShowtimes() {
        return $this->showtimes;
    }

    public function addShowtime($showtime) {
        if (!($showtime instanceof Showtime)) {
            throw new \InvalidArgumentException();
        }
        $this->showtimes[] = $showtime;
    }

    private function getTimeline() {
        $html = '';
        $showtimes = $this->showtimes;
        usort($showtimes, function($a, $b) {
            return strcmp($a->getTime(), $b->getTime());
        });
        foreach ($showtimes as $showtimes) {
            $html .= $showtimes->render(false) . PHP_EOL;
        }
        return $html;
    }

    public function render($output = true) {
        ob_start();
        include TMPL_PATH .'/movie.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'movie.id'        => $this->getId(),
            'movie.name'      => $this->getName(),
            'movie.public'    => $this->getPublic(),
            'movie.genre'     => $this->getGenre(),
            'movie.duration'  => $this->getDuration(),
            'movie.poster'    => $this->getPoster(),
            'movie.showtimes' => $this->getTimeline()
        );
        foreach ($data as $key => $value) {
            $rendering = preg_replace('/\{\{\s*'. $key .'\s*\}\}/', $value, $rendering);
        }

        if ($output) {
            print $rendering;
        } else {
            return $rendering;
        }
    }

}