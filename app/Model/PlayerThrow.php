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

    private $round = 0;
    private $score = 0;
}
