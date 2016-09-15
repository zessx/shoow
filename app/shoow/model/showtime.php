<?php

namespace shoow\model;

class Showtime
{

    private $theater;
    private $movie;
    private $version;
    private $time;

    function __construct($theater, $movie, $version, $time) {
        if (!($theater instanceof Theater)) {
            throw new \InvalidArgumentException();
        }
        if (!($movie instanceof Movie)) {
            throw new \InvalidArgumentException();
        }
        $this->theater = $theater;
        $this->movie   = $movie;
        $this->version = $version;
        $this->time    = $time;
    }

    public function getTheater() {
        return $this->theater;
    }

    public function getMovie() {
        return $this->movie;
    }

    public function getVersion() {
        return $this->version;
    }

    public function getTime() {
        return $this->time;
    }

    public function render($output = true) {
        ob_start();
        include TMPL_PATH .'/showtime.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'showtime.theater.key'  => $this->getTheater()->getKey(),
            'showtime.theater.name' => $this->getTheater()->getName(),
            'showtime.version'      => $this->getVersion(),
            'showtime.time'         => $this->getTime()
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