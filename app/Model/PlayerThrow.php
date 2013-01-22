<?php
/**
 * ::: THROW CLASS :::
 * Represents one player throw
 */
class PlayerThrow extends AppModel
{
    public $name = "PlayerThrow";
    public $belongsTo = array('Player' => array(
        'className' => 'Player',
        'foreignKey' => 'player_id'
    ), 'Game' => array(
        'className' => 'Game',
        'foreignKey' => 'game_id'
    ));

    /**
     * Adds a new score to the game
     * @param array $saveArray
     */
    public function addScore(Array $saveArray) {
        $this->data['score'] = $saveArray['score'];
        $this->data['player_id'] = $saveArray['player_id'];
        $this->data['game_id'] = $saveArray['game_id'];
        $this->data['round'] = $saveArray['round'];
        $this->data['arrow'] = $saveArray['arrow'];
        $this->save($this->data);
    }

    /**
     * Get lates round added to round
     * @param int $gameID
     * @return int
     */
    public function getRound($gameID, $playerID) {
        $res = $this->find('first', array(
            'condition' => array('PlayerThrow.game_id' => $gameID, 'PlayerThrow.player_id' => $playerID),
            'order' => array('PlayerThrow.modified DESC')
        ));

        if($res == false) {
            $round = 0;
        } else {
            $round = $res['PlayerThrow']['round'];
        }

        if($this->getArrow($gameID, $playerID) == 0) {
            return $round + 1;
        } else {
            return $round;
        }
    }

    /**
     * Returns arrow there are thrown
     * @param $gameID
     * @param $playerID
     * @return int
     */
    public function getArrow($gameID, $playerID) {
        $res = $this->find('first', array(
            'condition' => array('PlayerThrow.game_id' => $gameID, 'PlayerThrow.player_id' => $playerID),
            'order' => array('PlayerThrow.modified DESC')
        ));

        if($res == false) {
            $arrow = 0;
        } else {
            $arrow = $res['PlayerThrow']['arrow'];
        }

        if($arrow >= 3) {
            return 0;
        }

        return $arrow + 1;
    }
}
