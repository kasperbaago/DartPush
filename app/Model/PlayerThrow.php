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

    private $numberOfArrows = 3;

    /**
     * Adds a new score to the game
     * @param array $saveArray
     */
    public function addScore($game, $player, $score) {
        $this->data['score'] = $score;
        $this->data['player_id'] = (int) $player->id;
        $this->data['game_id'] = (int) $game->id;
        $this->data['round'] = (int) $game->getRound();
        $this->data['arrow'] = (int) $this->getArrow($game->id, $player->id, $game->getRound());
        $this->save($this->data);
    }

    /**
     * Get latest round added to round
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
    public function getArrow($gameID, $playerID, $round) {
        $res = $this->find('first', array(
            'conditions' => array('PlayerThrow.game_id' => $gameID, 'PlayerThrow.player_id' => $playerID, 'PlayerThrow.round' => $round),
            'order' => array('PlayerThrow.modified DESC')
        ));

        if($res == false) {
            $arrow = 0;
        } else {
            $arrow = $res['PlayerThrow']['arrow'];
        }

        if($arrow >= $this->numberOfArrows) {
            return (int) 0;
        }

        return (int) $arrow + 1;
    }
}
