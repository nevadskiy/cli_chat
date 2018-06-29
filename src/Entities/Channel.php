<?php

namespace Chat\Entities;

use Chat\Adapters\Adapter;
use Exception;

/**
 * Class Channel
 * @package Chat\Entities
 */
class Channel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Channel constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return iterable
     * @throws Exception
     */
    public function getUsers(): iterable
    {
        if ($this->adapter instanceof Adapter) {
            return $this->adapter->channelUsers($this);
        }

        throw new Exception("Adapter has not been set");
    }

    /**
     * @param Adapter $adapter
     * @return $this
     */
    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }
}