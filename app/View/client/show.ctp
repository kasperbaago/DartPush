<h1><?php echo $title_for_layout ?></h1>
<form method="post">
<p>Choose player and enter score: </p>
<div id="playerlist" class="btn-group" data-toggle="buttons-radio">
    <?php if(isset($players)) {
        foreach($players as $player) { ?>
            <button class="btn" data-playerid='<?php echo $player['id'] ?>'><?php echo $player['player_name']; ?></button>
   <?php }}?>
    <input type="hidden" id="playerid" name="playerid" value="0" />
</div>
<div id="scoreinput" class="row">
    <input type="number" id="score" name="score" tabindex="1" placeholder="Enter player score here" class="span9" required="true"/>
    <input type="submit" value="Submit score" class="btn btn-primary span2"/>
    <button type="button" class="btn btn-small span5" data-toggle="modal" data-target="#newPlayerWindow">Add new player</button>
    <button type="button" class="btn btn-small span5" data-toggle="modal" data-target="#scoreboardWindow">Show scoreboard</button>
</div>
</form>
<div id="newPlayerWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="model-header">
        <h3>Add new player: </h3>
    </div>
    <div class="modal-body">
        <form method="post">
            <input type="text" placeholder="Player name" name="newplayername" class="span6" required="true"/>
            <input type="submit" value="Add player" class="btn btn-block btn-primary" />
        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        document.getElementById('score').focus();

        //Disable btn click
        $('#playerlist').children('button').on('click', function(e) {
            e.preventDefault();
            jQuery('#playerid').val(jQuery(this).data('playerid'));
        });

        var item = $('#playerlist').children().get(0);
        $(item).button('toggle');
        jQuery('#playerid').val(jQuery(item).data('playerid'));
    }
</script>