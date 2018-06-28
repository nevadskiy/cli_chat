<?php

namespace Chat\Adapters;

use Chat\ConnectionException;
use Chat\Entities\Message;
use Pubnub\Pubnub;
use Chat\Entities\Channel;
use Chat\Entities\User;
use Pubnub\PubnubException;

/**
 * Class PubnubAdapter
 * @package Chat\Adapters
 */
class PubnubAdapter extends Adapter
{
    /**
     * @var Pubnub
     */
    public $pubnub;

    /**
     * @return PubnubAdapter
     */
    public static function create()
    {
        $config = require __DIR__.'/../../config.php';

        return new self($config);
    }

    /**
     * PubnubAdapter constructor.
     * @param $config
     */
    public function __construct($config)
    {
        try {
            $this->pubnub = new Pubnub(
                $config['publish-key'],
                $config['subscribe-key'],
                $config['secret-key'],
                $config['ssl']
            );
        } catch (PubnubException $exception) {
            throw new ConnectionException("Can not connect to the server");
        }
    }

    /**
     * @param Channel $channel
     * @param User $user
     * @param callable $onMessageReceived
     * @throws PubnubException
     */
    public function join(Channel $channel, User $user, callable $onMessageReceived)
    {
        $this->pubnub->setState($channel->getName(), [
            'username' => $user->getName()
        ]);

        $this->pubnub->subscribe($channel->getName(), function($payload) use ($onMessageReceived) {
            $message = new Message(
                new User($payload['message']['username']),
                $payload['message']['body']
            );

            $onMessageReceived($message);

            return true;
        });
    }

    /**
     * @param Channel $channel
     * @return array
     * @throws PubnubException
     */
    public function channelUsers(Channel $channel)
    {
        $hereNow = $this->pubnub->hereNow($channel->getName(), false, true);

        return array_map(function($user) {
            return new User($user['state']['username']);
        }, $hereNow['uuids']);
    }

    /**
     * @param Channel $channel
     * @param Message $message
     * @throws PubnubException
     */
    public function send(Channel $channel, Message $message)
    {
        $this->pubnub->publish($channel->getName(), [
            'body' => $message->getBody(),
            'username' => $message->getAuthor()->getName()
        ]);
    }
}