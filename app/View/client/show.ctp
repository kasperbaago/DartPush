<h1><?php echo $title_for_layout ?></h1>
<?php echo $this->Form->create('update', array('url' => array('controller' => 'client', 'action' => 'updatescore'))) ?>
<div class="btn-group" data-toggle="buttons-radio">
    <?php if(isset($players)) {
        foreach($players as $player) { ?>
            <button class="btn"><?php echo $player['player']['player_name']; ?></button>
   <?php }}?>
</div>
<div id="scoreinput" class="row-fluid">
    <input type="number" id="score" name="score" tabindex="1" placeholder="Enter player score here" class="span"/>
    <input type="submit" value="Submit score" class="btn btn-primary"/>
    <button type="button" class="btn span" data-toggle="modal" data-target="#newPlayerWindow">Tilføj ny spiller</button>
</div>
<?php echo $this->Form->end(); ?>
<div id="newPlayerWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="model-header">
        <h3>Add new player: </h3>
    </div>
    <div class="modal-body">
        <form method="post">
            <input type="text" placeholder="Player name" name="newplayername" class="span6" />
            <input type="submit" value="Add player" class="btn btn-block btn-primary" />
        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        document.getElementById('score').focus();
    }
</script>