<h3>Select a current game: </h3>
<?php echo $this->element('gamelist', array('games' => $games, 'controller' => 'scoreboard', 'action' => 'show')); ?>