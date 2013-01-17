<h1><?php echo $title_for_layout ?></h1>
<?php echo $this->Form->create('update', array('url' => array('controller' => 'client', 'action' => 'updatescore'))) ?>
<input type="number" id="score" name="score" tabindex="1" placeholder="Score"/>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
    window.onload = function() {
        document.getElementById('score').focus();
    }
</script>