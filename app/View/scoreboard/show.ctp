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
                <td><?php echo (isset($player['score']['totalScore'][$round])) ? $player['score']['totalScore'][$round] : 'Not played'  ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php if(isset($gameID)) { ?>
    <script type="text/javascript">
        var conn = new ab.Session('ws://10.128.67.51:8000', function() {
            this.subscribe('gameid_<?php echo $gameID ?>', function(topic, data) {
                data = JSON.parse(data)
                console.log(data);
                var trCounter = 0;

                if(typeof data.newRound !== "undefined" && data.newRound == true) {
                    jQuery('table tbody').append('<tr><td>' + data.round + '</td><td>Not played</td><td>Not played</td></tr>');
                }

                if(typeof data.players !== "undefined") {
                    for(j in data.players.Player[0].score.totalScore) {
                        var tdCounter = 0;

                        var tr = jQuery('table tbody').children('tr').get(trCounter);

                        if(typeof tr === "undefined") {
                            console.log(trCounter);
                            jQuery('table tbody').append('<tr></tr>');
                            tr = jQuery('table tbody').children('tr').get(trCounter);
                            jQuery(tr).append('<td>' + data.round + '</td>');
                        }

                        for(i in data.players.Player) {
                            tdCounter += 1;
                            var td = jQuery(tr).children('td').get(tdCounter);
                            if(typeof td === "undefined") {
                                jQuery(tr).append('<td></td>');
                                td = jQuery(tr).children('td').get(tdCounter);
                            }

                            jQuery(td).html(data.players.Player[i].score.totalScore[j]);
                        }

                        trCounter += 1;
                    }
                }
            })
        }, function() {
            console.log('WebSocket connection closed');
        }, {
            'skipSubprotocolCheck' : true
        });
    </script>
<?php } ?>