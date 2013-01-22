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

    /**
     * Adds a specific score to a specific player
     * @param int $playerID
     */
    public function addScore($playerID, $score) {
        $this->Player->create();
        $this->Player->load($playerID, $this->id);

        if($this->Player->getActve == 0) {
            throw new Exception('Player have no more arrows in this round!');
        }

        $this->PlayerThrow->create();
        $this->PlayerThrow->addScore($this, $this->Player, $score);

        if($this->getGameRound() == $this->PlayerThrow->getRound($this->id, $playerID) && $this->PlayerThrow->getArrow($this->id, $playerID) == 0) {
            $this->Player->setActive(0);
            $this->Player->save($this->Player->data);
        }

        if($this->ifAllHasThrown()) {
            $this->round += 1;
            $this->save();
        }
    }

    public function ifAllHasThrown() {
        $throwers = 0;
        $players = count($this->players);

        foreach($this->players as $player) {
            if($player['active'] == 0) {
                $throwers += 1;
            }
        }

        return ($throwers >= $players);
    }

    public function getGameRound() {
        return $this->round;
    }
}
