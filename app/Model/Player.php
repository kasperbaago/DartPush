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


    public function newPlayer($playerName = null, $gameId = null) {
        $this->setPlayerName($playerName);
        $this->data['game_id'] = $gameId;
        $this->save($this->data);
    }

    public function setPlayerName($playerName)
    {
        $this->data['player_name'] = $playerName;
    }

    public function getPlayerName()
    {
        return $this->data['player_name'];
    }

    public function setActive($active = 1) {
        $this->data['active'] = $active;
    }

    public function getActive() {
        return $this->data['active'];
    }

    /**
     * Calculates score for individual player
     * @return array
     */
    public function calcScore() {
        $res = $this->PlayerThrow->find('all', array(
           'conditions' => array('PlayerThrow.player_id' => $this->id)
        ));

        $output = array();

        foreach($res as $score) {
            $round = $score['PlayerThrow']['round'];
            if(!isset($output['totalScore'][$round])) {
                $output['totalScore'][$round] = 501;
            }

            $output['totalScore'][$round] -= $score['PlayerThrow']['score'];
            $output['arrowScore'][$score['PlayerThrow']['arrow']] = $score['PlayerThrow']['score'];
        }

        return $output;
    }

    public function load($id, $gameID) {
        if(!is_numeric($id)) return false;
        $res = $this->find('first', array('conditions' => array('Player.id' => $id, 'Player.game_id' => $gameID)));
        if($res == false) return false;
        $this->data = $res['Player'];
        $this->id = $id;
        return true;
    }
}
