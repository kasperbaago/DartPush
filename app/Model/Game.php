<?php
/**
 * ::: GAME CLASS :::
 * Represents one game
 */
class Game extends AppModel
{
    public $name = 'Game';
    public $hasMany = array('Player', 'PlayerThrow');

    private $gameName;
    private $gameDesc;
    private $players;
    private $throws;
    private $round = 0;

    public function load($id = null) {
        if(!is_numeric($id)) return false;
        $res = $this->find('first', array('conditions' => array('Game.id' => $id)));
        if($res == false) return false;
        $this->id = $id;
        $this->gameName = $res['Game']['GameName'];
        $this->gameDesc = $res['Game']['Description'];
        $this->round = $res['Game']['Round'];
        $this->players = $res['Player'];
        $this->throws = $res['PlayerThrow'];
        return true;
    }

    public function createGame($name = null, $description = null) {
        $this->setGameName($name);
        $this->setGameDesc($description);
    }

    public function setGameDesc($gameDesc)
    {
        $this->gameDesc = $gameDesc;
    }

    public function getGameDesc()
    {
        return $this->gameDesc;
    }

    public function setGameName($gameName)
    {
        $this->gameName = $gameName;
    }

    public function getGameName()
    {
        return $this->gameName;
    }

    public function getPlayers()
    {
        $output = array();
        foreach($this->players as $k => $player) {
            $this->Player->create();
            $this->Player->load($player['id'], $this->id);

            $output['Player'][$k]['PlayerName'] = $this->Player->getPlayerName();
            $output['Player'][$k]['active'] = $this->Player->getActive();
            $output['Player'][$k]['score'] = $this->Player->calcScore();
        }

        return $output;
    }

    public function addPlayer($playerName = null) {
        $this->Player->newPlayer($playerName, $this->id);
    }

    public function deletePlayer($playerId = null) {
        $this->Player->load($playerId, $this->id);
        $this->Player->delete();
    }

    public function deleteAllPlayers() {
        foreach($this->players as $player) {
            $this->deletePlayer($player['id']);
        }
    }

    public function beforeDelete($cascade = false) {
        $this->deleteAllPlayers();
    }

    public function save($data = NULL, $validate = true, $fieldList = Array()) {
        $dataToSave = array('GameName' => $this->gameName, 'Description' => $this->gameDesc, 'Round' => $this->round);
        parent::save($dataToSave);
    }

    /**
     * Adds a specific score to a specific player
     * @param int $playerID
     */
    public function addScore($playerID, $score) {
        $this->Player->create();
        $this->Player->load($playerID, $this->id);

        $this->PlayerThrow->create();
        if($this->PlayerThrow->getArrow($this->id, $playerID, $this->round) === 0) {
            $this->Player->setActive(0);
            $this->Player->save($this->Player->data);
        } else {
            $this->PlayerThrow->addScore($this, $this->Player, $score);
        }

        if($this->Player->getActive() == 0) {
            throw new Exception('Player have no more arrows in this round!');
        }
    }

    public function nextRound() {
        $this->activatePlayers();
        $this->round +=1;
        $this->save();
    }

    public function activatePlayers() {
        foreach($this->players as $player) {
            $this->Player->create();
            $this->Player->load($player['id'], $this->id);
            $this->Player->setActive(1);
            $this->Player->save($this->Player->data);
        }
    }

    public function getRound()
    {
        return $this->round;
    }

}
