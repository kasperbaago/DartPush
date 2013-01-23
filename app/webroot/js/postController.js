/**
 * ::: POST CONTOLLER :::
 * Controls the post of scoreupdates from client view to the system
 *
 * @type {Object}
 */

var postContoller = {
    gameid: null,
    conf: {},

    init: function(gameid, conf) {
        this.gameid = gameid;
        this.conf = conf;

        jQuery('#score').focus();
        var item = $('#playerlist').children().get(0);
        $(item).button('toggle');
        this.setPostPlayerID(jQuery(item).data('playerid'));
        this.addListeners();
    },

    /**
     * Sets up listeners for postController
     */
    addListeners: function() {
        jQuery('#playerlist').children('button').on('click', function(e) {
            e.preventDefault();
            postContoller.setPostPlayerID(jQuery(this).data('playerid'));
        });

        jQuery('#updateScore').submit(function(e) {
            postContoller.onScoreSubmit(e);
        })

        jQuery('#startNextRound').click(function(e) {
            postContoller.nextRound();
        })

    },

    /**
     * Sets post player ID
     * @param id
     */
    setPostPlayerID: function(id) {
        jQuery('#playerid').val(id);
    },

    onScoreSubmit: function(e) {
        e.preventDefault();

        var serializedInput = jQuery('#updateScore').serialize();
        jQuery.post(postContoller.conf.updateScoreURL, serializedInput, function(d) {

            if(d.arrow == 0 || d.arrow == 3) {
                var playerId = $('#playerid').val();
                jQuery('[data-playerid=' + playerId + ']').addClass('btn-danger');
            }

            if(typeof d.error == "string") {
                postContoller.showAlert(d.error);
            }

        }, 'json');
    },

    nextRound: function() {
        jQuery.post(postContoller.conf.nextRoundURL, {
            game_id: postContoller.gameid
        }, function(d) {
            if(d.status == true) {
                jQuery('#round').html(d.round);
                postContoller.showAlert('Round ' + d.round);
                jQuery('#playerlist button').removeClass('btn-danger');
            }
        }, 'json');
    },

    showAlert: function(msg) {
        jQuery('#alertBox').find('p').html(msg);
        jQuery('#alertBox').modal();
    }
}









//On update score!
