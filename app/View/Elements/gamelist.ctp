<ul>
<?php if(is_array($games)) {
    foreach($games as $game) { ?>
     <li><?php echo $this->Html->link($game['Game']['GameName'], array('controller' => $controller, 'action' => $action, $game['Game']['id']), array('class' => 'btn btn-large btn-block btn-primary')) ?></li>
    <?php } ?>
<? } ?>
</ul>