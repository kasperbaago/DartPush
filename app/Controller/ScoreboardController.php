<?php
/**
 * Controller that shows scoreboard
 */
class ScoreboardController extends AppController
{
    public $uses = array('Game');
    public $name = "scoreboard";

    public function index() {
        $games = $this->Game->find('all');
        $this->set('games', $games);
    }

    public function show($id = 0) {
        $this->Game->load($id);
        $scores = $this->Game->getPlayers();
        $this->set('scoredata', $scores);
        $this->set('gameName', $this->Game->getGameName());
        $this->set('gameID', $this->Game->id);

    }
}
