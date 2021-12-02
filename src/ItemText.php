<?php

namespace Todo;

class ItemText extends Item
{
    private $completed;
    private $text;
    private $id;

    public function __construct()
    {
        parent::__construct();
        $this->completed = false;
        $this->id = uniqid();
    }

    public function tick($completed): void
    {
        $this->completed = $completed;
        $this->notify();
    }

    public function isTicked(): bool
    {
        return $this->completed;
    }

    public function getUniqueIdentifier(): string
    {
        return $this->id;
    }

    public function setText(string $string)
    {
        $this->text = $string;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
