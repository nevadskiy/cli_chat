<?php

namespace Chat\Adapters;

use Chat\Entities\Channel;
use Chat\Entities\User;
use Chat\Entities\Message;

/**
 * Class Adapter
 * @package Chat\Adapters
 */
abstract class Adapter
{
    /**
     * @var
     */
    protected $client;

    /**
     * @param Channel $channel
     * @param User $user
     * @param callable $onMessageReceived
     * @return mixed
     */
    abstract public function join(Channel $channel, User $user, callable $onMessageReceived);

    /**
     * @param Channel $channel
     * @return mixed
     */
    abstract public function channelUsers(Channel $channel);

    /**
     * @param Channel $channel
     * @param Message $message
     * @return mixed
     */
    abstract public function send(Channel $channel, Message $message);
}