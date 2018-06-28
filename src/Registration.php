<?php

namespace Chat;

use Chat\Entities\User;
use Chat\Entities\Channel;

/**
 * Class Registration
 * @package Chat
 */
class Registration
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
     * @var Channel
     */
    protected $channel;

    /**
     * Registration constructor.
     * @param Manager $manager
     * @param Console $console
     * @param Channel $channel
     */
    public function __construct(Manager $manager, Console $console, Channel $channel)
    {
        $this->manager = $manager;
        $this->console = $console;
        $this->channel = $channel;
    }

    /**
     * @return User
     */
    public function register()
    {
        $user = $this->attempt();

        while ($this->isUserExists($user)) {
            $this->console->output("Username already taken\n");
            $user = $this->attempt();
        }

        return $user;
    }

    /**
     * @return User
     */
    protected function attempt()
    {
        return new User($this->console->input("Enter username: "));
    }

    /**
     * @param User $user
     * @return bool
     */
    protected function isUserExists(User $user)
    {
        $users = $this->manager->channelUsers($this->channel);

        foreach ($users as $presenceUser) {
            if ($user->getName() === $presenceUser->getName()) {
                return true;
            }
        }

        return false;
    }
}