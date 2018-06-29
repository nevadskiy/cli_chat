<?php

namespace Chat;

use Chat\Adapters\PubnubAdapter;
use Chat\Entities\Channel;
use Chat\Entities\Message;

/**
 * Class Chat
 * @package Chat
 */
class Chat
{
    /**
     * @var Manager
     */
    protected $manager;
    /**
     * @var Console
     */
    protected $console;
    /**
     * @var
     */
    protected $channel;
    /**
     * @var
     */
    protected $user;

    /**
     * Chat constructor.
     * @param Manager $manager
     * @param Console $console
     */
    public function __construct(Manager $manager, Console $console)
    {
        $this->manager = $manager;
        $this->console = $console;

        $this->boot();
    }

    /**
     * @return Chat
     */
    public static function start()
    {
        return new self(
            new Manager(PubnubAdapter::create()),
            new Console()
        );
    }

    /**
     * Boot all modules method.
     */
    protected function boot()
    {
        $this->selectChannel();
        $this->createUser();
        $this->welcome();
        $this->core();
    }

    /**
     * Run the core application in split process mode
     */
    protected function core()
    {
        new ProcessSplitter(
            function() {
                while (true) {
                    $body = $this->console->input('> ');
                    $message = new Message($this->user, $body);
                    $this->manager->send($this->channel, $message);
                }
            }, function() {
                $this->manager->join($this->channel, $this->user, function(Message $message) {
                    $this->console->overwrite('> ', $message);
                });
            }
        );
    }

    /**
     * Create user
     */
    public function createUser()
    {
        $this->user = (new Registration($this->manager, $this->console, $this->channel))
            ->register();
    }

    /**
     * Show welcome message
     */
    protected function welcome()
    {
        $this->console->output("Connected to '{$this->channel->getName()}' as '{$this->user->getName()}'\n");
    }

    /**
     * Select channel
     */
    protected function selectChannel()
    {
        $channelName =  $this->console->input("Join to channel: ");
        $this->channel = new Channel($channelName);
    }
}