<h2>Scoreboard - <?php if(isset($gameName)) echo $gameName; ?></h2>
<table class="table table-hover">
    <thead>
        <th>Round</th>
        <?php if(isset($scoredata)) foreach($scoredata['Player'] as $player) { ?>
        <th><?php echo $player['PlayerName'] ?></th>
        <? } ?>
    </thead>
    <tbody>
        <?php if(isset($scoredata)) foreach($scoredata['Player'][0]['score']['totalScore'] as $round => $row) {?>
        <tr>
            <td><?php echo $round ?></td>
            <?php foreach($scoredata['Player'] as $player) { ?>
                <td><?php echo $player['score']['totalScore'][$round] ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php if(isset($gameID)) { ?>
    <script type="text/javascript">
        var conn = new ab.Session('ws://10.128.67.51:8000', function() {
            this.subscribe('gameid_<?php echo $gameID ?>', function(topic, data) {
                console.log('New data from server ' + topic + data);
            })
        }, function() {
            console.log('WebSocket connection closed');
        }, {
            'skipSubprotocolCheck' : true
        });
    </script>
<?php } ?>