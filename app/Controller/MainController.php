<?php

App::uses('AppController', 'Controller');

class MainController extends AppController
{
    public $name = 'main';
    public $uses = null;

    public function index($i = null) {
        $this->set("title_for_layout", " - Pushing your dart to the next level!");
    }
}
