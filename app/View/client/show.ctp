<h1><?php echo $title_for_layout ?></h1>
<?php echo $this->Form->create('update', array('url' => array('controller' => 'client', 'action' => 'updatescore'))) ?>
<div class="btn-group">
    <?php if(isset($players)) {
        foreach($players as $player) { ?>
            <button class="btn"><?php echo $player['player']['player_name']; ?></button>
   <?php }}?>
    <button class="btn">Tilføj ny spiller</button>
</div>
<div id="scoreinput">
    <input type="number" id="score" name="score" tabindex="1" placeholder="Score"/>
</div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
    window.onload = function() {
        document.getElementById('score').focus();
    }
</script>