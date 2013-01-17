<?php

App::uses('AppController', 'Controller');

class MainController extends AppController
{
    public $name = 'main';
    public $uses = array('Game');

    public function index($i = null) {
        $this->set("title_for_layout", " - Pushing your dart to the next level!");
    }

    public function test() {
        $this->Game->createGame('The new game', 'New dart game!');
        $this->Game->save();
    }
}
