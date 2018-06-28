<?php

namespace Chat;

use Chat\Adapters\Adapter;
use Chat\Entities\Channel;
use Chat\Entities\Message;
use Chat\Entities\User;

/**
 * Class Manager
 * @package Chat
 */
class Manager
{
    /**
     * @var Adapter
     */
    public $adapter;

    /**
     * Manager constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param Channel $channel
     * @param User $user
     * @param callable $onMessageReceived
     */
    public function join(Channel $channel, User $user, callable $onMessageReceived)
    {
        $this->adapter->join($channel, $user, $onMessageReceived);
    }

    /**
     * @param Channel $channel
     * @param Message $message
     */
    public function send(Channel $channel, Message $message)
    {
        $this->adapter->send($channel, $message);
    }

    /**
     * @param Channel $channel
     * @return mixed
     */
    public function channelUsers(Channel $channel)
    {
        return $this->adapter->channelUsers($channel);
    }
}