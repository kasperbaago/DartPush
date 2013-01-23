<h2 xmlns="http://www.w3.org/1999/html">Select a game or create a new one!</h2>
<?php echo $this->Form->create('action', array('url' => array('controller' => 'client', 'action' => 'createnewgame'))); ?>
<h3>Create a new game: </h3>
 <div class="row-fluid">
    <input type="text" name="gamename" placeholder="Gamename" required="true"/><br/>
    <button type="button" class="btn" data-target="#addNewPlayer" data-toggle="modal">Add players</button>
 </div>

<div class="modal hide fade" id='addNewPlayer'>
    <div class="modal-header">
        <h3>Add your players</h3>
    </div>
    <div class="modal-body">
        <input type="text" name="players[]" value="Player 1"  /><br/>
        <input type="text" name="players[]" value="Player 2" /><br/>
    </div>
    <div class="modal-footer">
        <button type="button" id='newPlayerInputField' class="btn">Add more players</button>
        <input type="submit" value="Start game" class="btn btn-primary btn-large" />
    </div>
</div>

<?php echo $this->Form->end() ; ?>
<h3>Select a current game: </h3>
<?php echo $this->element('gamelist', array('games' => $games, 'controller' => 'client', 'action' => 'show')); ?>

<script type="text/javascript">
    (function($) {
        jQuery('#newPlayerInputField').click(function() {
            var playerNumber = jQuery('#addNewPlayer').children('.modal-body').children('input').length + 1;
            jQuery('#addNewPlayer').children('.modal-body').append('<input type="text" name="players[]" value="Player ' + playerNumber + '" /><br/>');
        })
    })(jQuery)
</script>