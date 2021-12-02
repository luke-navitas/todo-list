<?php

namespace Todo;

use Countable;
use SplObserver;
use SplSubject;

class ListGeneric implements SplObserver, Countable
{
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function update(SplSubject $subject): void
    {
        if ($subject instanceof IItem) {
            $this->items[$subject->getUniqueIdentifier()] = $subject;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function removeItem(IItem $item)
    {
        $item->detach($this);
        unset($this->items[$item->getUniqueIdentifier()]);
    }
}
