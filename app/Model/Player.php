<?php
/**
 * ::: PLayer Class :::
 * Represents one player
 */
class Player extends AppModel
{
    public $name = 'Player';
    public $hasMany = array('PlayerThrow');
    public $belongsTo = array('Games' => array('className' => 'Game', 'foreignKey' => 'game_id'));

    protected $playerName = "Unknown";
    protected $gameID = null;

    public function newPlayer($playerName = null, $gameId = null) {
        $this->setPlayerName($playerName);
        $this->gameID = $gameId;
        $this->save();
    }

    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;
    }

    public function getPlayerName()
    {
        return $this->playerName;
    }

    public function save($data = NULL, $validate = true, $fieldList = Array()) {
        $dataToSave = array('player_name' => $this->playerName, 'game_id' => $this->gameID);
        parent::save($dataToSave);
    }

    public function load($id, $gameID) {
        if(!is_numeric($id)) return false;
        $res = $this->find('first', array('conditions' => array('Player.id' => $id, 'Player.game_id' => $gameID)));
        if($res == false) return false;
        $this->playerName = $res['Player']['player_name'];
        $this->id = $id;
        return true;
    }

}
