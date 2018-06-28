<?php

namespace Chat;

/**
 * Class ProcessSplitter
 * @package Chat
 */
/**
 * Class ProcessSplitter
 * @package Chat
 */
class ProcessSplitter
{
    /**
     * @var
     */
    protected $pid;
    /**
     * @var callable
     */
    protected $core;
    /**
     * @var callable
     */
    protected $subcore;

    /**
     * ProcessSplitter constructor.
     * @param callable $core
     * @param callable $subcore
     */
    public function __construct(callable $core, callable $subcore)
    {
        $this->core = $core;
        $this->subcore = $subcore;

        $this->fork();
    }

    /**
     * Fork process
     */
    protected function fork()
    {
        $this->pid = pcntl_fork();

        if ($this->pid === -1) {
            throw new Exception("Process can not be forked");
        }

        if ($this->pid) {
            ($this->core)();
            pcntl_wait($status);
        } else {
            ($this->subcore)();
        }
    }
}