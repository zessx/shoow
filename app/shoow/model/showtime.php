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
        $this->theater   = $theater;
        $this->movie   = $movie;
        $this->version = $version;
        $this->time    = $time;
    }

    public function getContent() {
        return $content;
    }

    public function render($output = true) {
        ob_start();
        include 'template/showtime.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'showtime.theater.key'  => $this->theater->getKey(),
            'showtime.theater.name' => $this->theater->getName(),
            'showtime.version'      => $this->version,
            'showtime.time'         => $this->time
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