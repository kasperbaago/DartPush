<?php
/*
 * Controller for client
 */

class ClientController extends AppController
{
    public $name = 'client';
    public $uses = array('Game');
    private $subprefix = 'gameid_';

    public function index() {
        $this->set("title_for_layout", "Select game or create new game");
        $this->set('games', $this->Game->find('all'));
    }

    public function createnewgame() {
        if(!$this->request->is('post')) {
            //TODO: Show some error informaiton!
        }

        $this->Game->createGame($this->request->data['gamename'], '');
        $this->Game->save();

        foreach($this->request->data['players'] as $playername) {
            $this->Game->addPlayer($playername);
        }

       $this->redirect(array('action' => 'show', $this->Game->id));
    }

    public function saveScore() {
        $this->response->header(array('Cache-controle' => 'no-cache'));
        $this->response->type('application/json');

        $dataToSend = array('status' => false);
        $sendToScoreBoard = true;

        if($this->request->is('post')) {
            if(!isset($this->request->data['game_id'])) {
                $this->set('dataToSend', $dataToSend);
                $this->render('saveScore', 'ajax');
                return;
            }

            $this->Game->create();
            $this->Game->load($this->request->data['game_id']);

            $dataToSend['subscription'] = $this->subprefix. $this->Game->id;
            $dataToSend['arrow'] = $this->Game->PlayerThrow->getArrow($this->Game->id, $this->request->data['playerid'], $this->Game->getRound());

            try {
                $this->Game->addScore($this->request->data['playerid'], $this->request->data['score']);
                $dataToSend['status'] = true;
            } catch(Exception $e) {
                $sendToScoreBoard = false;
                $dataToSend['error'] = $e->getMessage();
            }

            $dataToSend['round'] = $this->Game->getRound();
            $dataToSend['players'] = $this->Game->getPlayers();
        }

        //Push data to scoreboard
        if($sendToScoreBoard) {
            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'onScoreUpdate');
            $socket->connect('tcp://localhost:5555');
            $socket->send(json_encode($dataToSend));
        }

        $this->set('dataToSend', $dataToSend);
        $this->render('saveScore', 'ajax');
    }

    public function startNextRound() {
        $dataToSend = array();
        $dataToSend['status'] = false;
        if($this->request->is('post') && isset($this->request->data['game_id'])) {
            $this->Game->create();
            $this->Game->load($this->request->data['game_id']);
            $this->Game->nextRound();


            $dataToSend['newRound'] = true;
            $dataToSend['round'] = $this->Game->getRound();
            $dataToSend['status'] = true;
            $dataToSend['subscription'] = $this->subprefix. $this->Game->id;

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'onScoreUpdate');
            $socket->connect('tcp://localhost:5555');
            $socket->send(json_encode($dataToSend));
        }

        $this->set('dataToSend', $dataToSend);
        $this->render('saveScore', 'ajax');
    }

    public function show($id = null) {
        if($id == null) {
            die('ID not given!');
            //TODO: make a more appropriate error message!
        }

        $this->Game->load($id);
        $this->set("title_for_layout", $this->Game->getGameName());
        $this->set('players', $this->Game->getPlayers());
        $this->set('gameID', $this->Game->id);
        $this->set('round', $this->Game->getRound());
    }
}
