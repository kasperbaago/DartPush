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
        $this->Game->load(1);
        var_dump($this->Game->getGameName());
        $this->Game->delete();
        var_dump($this->Game->getPlayers());
    }
}
