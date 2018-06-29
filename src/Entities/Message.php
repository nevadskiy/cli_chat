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
    protected $timestamp;

    /**
     * Message constructor.
     * @param User $author
     * @param string $body
     * @param null $timestamp
     */
    public function __construct(User $author, string $body, $timestamp = null)
    {
        $this->author = $author;
        $this->body = $body;
        $this->timestamp = $timestamp ?: date('d-m-y H:i:s');
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
    public function getTimestamp()
    {
        return $this->timestamp;
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
        return "[{$this->getTimestamp()}] <{$this->getAuthor()->getName()}> {$this->getBody()}";
    }
}