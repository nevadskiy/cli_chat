<?php

namespace Chat\Entities;

/**
 * Class User
 * @package Chat\Entities
 */
class User
{
    /**
     * @var string
     */
    protected $name;

    /**
     * User constructor.
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
}