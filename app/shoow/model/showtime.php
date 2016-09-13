<?php

namespace shoow\model;

class Showtime
{

    private $movie   = null;
    private $version = '';
    private $time    = '';

    function __construct($movie, $version, $time) {
        if ($movie !instanceof Movie) {
            throw new \InvalidArgumentException();
        }
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
            'showtime.movie'   => $this->movie->getName()
            'showtime.version' => $this->version
            'showtime.time'    => $this->time
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