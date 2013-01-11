<?php
namespace MyApp;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\ConnectionInterface;

class Pusher implements WampServerInterface
{

    protected $subscriptions = array();

    public function onScoreUpdate($data) {
        $entryData = json_decode($data);
        if(!array_key_exists($entryData['subscription'], $this->subscriptions)) {
            return;
        }

        $topic = $this->subscriptions[$entryData['subscription']];
        $topic->broadcast($data);
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param Ratchet\Connection The socket/connection that just connected to your application
     * @throws Exception
     */
    function onOpen(ConnectionInterface $conn)
    {

    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param Ratchet\Connection The socket/connection that is closing/closed
     * @throws Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
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
     * An RPC call has been received
     * @param Ratchet\ConnectionInterface
     * @param string The unique ID of the RPC, required to respond to
     * @param string|Topic The topic to execute the call against
     * @param array Call parameters received from the client
     */
    function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $conn->callError($id, $topic, 'You are not allowed to make calls!')->close();
    }

    /**
     * A request to subscribe to a topic has been made
     * @param Ratchet\ConnectionInterface
     * @param string|Topic The topic to subscribe to
     */
    function onSubscribe(ConnectionInterface $conn, $topic)
    {
        if(!array_key_exists($topic->getId(), $this->subscriptions)) {
            $this->subscriptions[$topic->getId()] = $topic;
        }

        error_log('New subscription made'. $topic);
    }

    /**
     * A request to unsubscribe from a topic has been made
     * @param Ratchet\ConnectionInterface
     * @param string|Topic The topic to unsubscribe from
     */
    function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        if(array_key_exists($topic->getId(), $this->subscriptions)) {
            unset($this->subscriptions[$topic->getId]);
        }
    }

    /**
     * A client is attempting to publish content to a subscribed connections on a URI
     * @param Ratchet\ConnectionInterface
     * @param string|Topic The topic the user has attempted to publish to
     * @param string Payload of the publish
     * @param array A list of session IDs the message should be excluded from (blacklist)
     * @param array A list of session Ids the message should be send to (whitelist)
     */
    function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        $conn->close();
    }
}
