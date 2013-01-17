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
        return $this->players;
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
        $dataToSave = array('GameName' => $this->gameName, 'Description' => $this->gameDesc);
        parent::save($dataToSave);
    }

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

}
