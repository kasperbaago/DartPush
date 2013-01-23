<?php
namespace ServApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements \Ratchet\MessageComponentInterface
{

    protected $clients;

    function __construct() {
        $this->clients = new \SplObjectStorage();
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param Ratchet\Connection The socket/connection that just connected to your application
     * @throws Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param Ratchet\Connection The socket/connection that is closing/closed
     * @throws Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param Ratchet\Connection
     * @param \Exception
     * @throws Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    /**
     * Triggered when a client sends data through the socket
     * @param Ratchet\ConnectionInterface The socket/connection that sent the message to your application
     * @param string The message received
     * @throws Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        foreach($this->clients as $client) {
            $client->send($msg);
        }
    }
}
