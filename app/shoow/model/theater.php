<?php

namespace shoow\model;

class Theater
{

    private $id;
    private $name;
    private $address;
    private $movies = array();

    function __construct($id, $name, $address, $movies) {
        $this->id      = $id;
        $this->name    = $name;
        $this->address = $address;
        $this->movies  = $movies;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getMovies() {
        return $this->movies;
    }

    private function generateTimeline() {
        $html = '';
        foreach ($this->movies as $movie) {
            $html .= $movie->render(false) . PHP_EOL;
        }
        return $html;
    }

    public function render($output = true) {
        ob_start();
        include 'template/theater.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'theater.id'       => $this->id,
            'theater.name'     => $this->name,
            'theater.address'  => $this->address,
            'theater.timeline' => $this->generateTimeline()
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