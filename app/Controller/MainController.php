<?php

App::uses('AppController', 'Controller');

class MainController extends AppController
{
    public $name = 'main';
    public $uses = null;

    public function index($i = null) {
        echo "HEJ!";
        $this->set('page_title', 'TEST!');
    }
}
