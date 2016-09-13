<?php

namespace shoow\model;

class Movie
{

    private $id;
    private $name;
    private $info;
    private $showtimes;

    function __construct($id, $name, $info, $showtimes) {
        $this->id        = $id;
        $this->name      = $name;
        $this->info      = $info;
        $this->showtimes = $showtimes;
    }

    public function getId() {
        return $id;
    }

    public function getName() {
        return $name;
    }

    public function getInfo() {
        return $info;
    }

    public function getShowtimes() {
        return $showtimes;
    }

    public function render($output = true) {
        ob_start();
        include 'template/movie.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'movie.id'        => $this->id,
            'movie.name'      => $this->name,
            'movie.info'      => $this->info,
            'movie.showtimes' => $this->showtimes
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