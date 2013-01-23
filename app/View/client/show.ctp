<h1><?php echo $title_for_layout ?> - Round: <?php echo $round ?></h1>
<form method="post" id="updateScore">
<p>Choose player and enter score: </p>
<div id="playerlist" class="btn-group" data-toggle="buttons-radio">
    <?php if(isset($players)) {
        foreach($players['Player'] as $player) { ?>
            <button class="btn" data-playerid='<?php echo $player['id'] ?>'><?php echo $player['PlayerName']; ?></button>
   <?php }}?>
    <input type="hidden" id="playerid" name="playerid" value="0" />
</div>
<div id="scoreinput">
            <input type="number" id="score" name="score" tabindex="1" placeholder="Enter player score here" required="true"/>
            <input type="submit" value="Submit score" class="btn btn-primary"/>
</div>
<input type="hidden" name="game_id" value="<?php echo $gameID ?>" />
</form>
<div class="row">
    <div class="span4">
        <button type="button" class="btn" data-toggle="modal" data-target="#newPlayerWindow">Add new player</button>
    </div>
    <div class="span4">
        <button type="button" class="btn" data-toggle="modal" data-target="#scoreboardWindow">Show scoreboard</button>
    </div>
    <div class="span4">
        <button type="button" class="btn" data-toogle="modal" data-target="#alertBox">Next round!</button>
    </div>
</div>

<div id="newPlayerWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="model-header">
        <h3>Add new player: </h3>
    </div>
    <div class="modal-body">
        <form method="post" id="addNewPlyer">
            <input type="text" placeholder="Player name" name="newplayername" required="true"/>
            <input type="submit" value="Add player" class="btn btn-block btn-primary" />
        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>

<div id="alertBox" class="modal hide fade" role='dialog' aria-hidden='true'>
    <div class="modal-header">
        <h3 class="alert">Holy snap - you got a error!</h3>
    </div>
    <div class="modal-body">
        <p>Loading...</p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        document.getElementById('score').focus();

        //Disable btn click
        $('#playerlist').children('button').on('click', function(e) {
            e.preventDefault();
            jQuery('#playerid').val(jQuery(this).data('playerid'));
        });

        var item = $('#playerlist').children().get(0);
        $(item).button('toggle');
        jQuery('#playerid').val(jQuery(item).data('playerid'));

        jQuery('#updateScore').submit(function(e) {
            e.preventDefault();

            var serilizedInput = jQuery(this).serialize();
            $.post('<?php echo $this->Html->url(array('controller' => 'client', 'action' => 'saveScore'), true); ?>', serilizedInput, function(d) {
                if(d.arrow == 0 || d.arrow == 3) {
                    var playerId = $('#playerid').val();
                    jQuery('[data-playerid=' + playerId + ']').addClass('btn-danger');
                }

                if(typeof d.error == "string") {
                    jQuery('#alertBox').find('p').html(d.error);
                    jQuery('#alertBox').modal();
                }

            }, 'json');

            console.log(serilizedInput);
        })
    })(jQuery)
</script>