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

    public function getShowtimes() {
        return $this->showtimes;
    }

    public function addShowtime($showtime) {
        if (!($showtime instanceof Showtime)) {
            throw new \InvalidArgumentException();
        }
        $this->showtimes[] = $showtime;
    }

    private function generateTimeline() {
        $html = '';
        foreach ($this->showtimes as $showtimes) {
            $html .= $showtimes->render(false) . PHP_EOL;
        }
        return $html;
    }

    public function render($output = true) {
        ob_start();
        include 'template/movie.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'movie.id'        => $this->id,
            'movie.name'      => $this->name,
            'movie.public'    => $this->public,
            'movie.genre'     => $this->genre,
            'movie.duration'  => $this->duration,
            'movie.showtimes' => $this->generateTimeline()
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