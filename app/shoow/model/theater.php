<?php

namespace shoow\model;

class Theater
{

    private static $counter = 1;

    private $key;
    private $id;
    private $name;
    private $address;

    function __construct($id, $name, $address) {
        $this->key     = self::$counter++;
        $this->id      = $id;
        $this->name    = $name;
        $this->address = $address;
    }

    public function getKey() {
        return $this->key;
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

    public function render($output = true) {
        ob_start();
        include TMPL_PATH .'theater.tmpl';
        $rendering = ob_get_contents();
        ob_end_clean();

        $data = array(
            'theater.key'  => $this->getKey(),
            'theater.name' => $this->getName()
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