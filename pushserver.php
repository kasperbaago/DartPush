<?php
require  __DIR__. '/vendor/autoload.php';
require __DIR__ . '/servapp/pusher.php';

$loop = React\EventLoop\Factory::create();
$pusher = new \ServApp\Pusher();

//Listen after incomming webserver requests
$context = new React\ZMQ\Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);
$pull->bind('tcp://0.0.0.0:5555');
$pull->on('message', array($pusher, 'onScoreUpdate'));

$websock = new \React\Socket\Server($loop);
$websock->listen(8080, '0.0.0.0');
$webserver = new \Ratchet\Server\IoServer(
    new \Ratchet\WebSocket\WsServer(
        new \Ratchet\Wamp\WampServer($pusher)
    )
    , $websock);

$loop->run();

?>