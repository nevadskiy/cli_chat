<?php

namespace Chat\Entities;

/**
 * Class Message
 * @package Chat\Entities
 */
class Message
{
    /**
     * @var User
     */
    protected $author;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var false|string
     */
    protected $timestapm;

    /**
     * Message constructor.
     * @param User $author
     * @param string $body
     * @param null $timestapm
     */
    public function __construct(User $author, string $body, $timestapm = null)
    {
        $this->author = $author;
        $this->body = $body;
        $this->timestapm = $timestapm ?: date('d-m-y H:i:s');
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return false|string
     */
    public function getTimestapm()
    {
        return $this->timestapm;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "[{$this->getTimestapm()}] <{$this->getAuthor()->getName()}> {$this->getBody()}";
    }
}