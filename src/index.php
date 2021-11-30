<?php

namespace Todo;

use Countable;
use SplObjectStorage;
use SplObserver;
use SplSubject;

abstract class Item implements Tickable, Identifiable, SplSubject
{
    private SplObjectStorage $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
        $this->notify();
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
    {
        foreach($this->observers as $observer) {
            $observer->update($this);
        }
    }
}

interface Tickable
{
    public function tick(bool $completed): void;
    public function isTicked(): bool;
}

interface Identifiable
{
    public function getUniqueIdentifier(): string;
}

class ItemText extends Item
{
    private bool $completed;
    private string $text;
    private string $id;

    public function __construct(string $text)
    {
        parent::__construct();
        $this->completed = false;
        $this->text = $text;
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

    public function getText(): string
    {
        return $this->text;
    }
}

class GenericList implements SplObserver, Countable
{
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function count()
    {
        return count($this->items);
    }

    public function update(SplSubject $subject)
    {
        $this->items[$subject->getUniqueIdentifier()] = $subject;
    }

    public function getItems()
    {
        return $this->items;
    }

    protected function interested($subject)
    {
        return $subject instanceof Item;
    }
}

class IncompleteList extends GenericList
{
    public function update(SplSubject $subject)
    {
        if($subject->isTicked()) {
            unset($this->items[$subject->getUniqueIdentifier()]);
        } else {
            $this->items[$subject->getUniqueIdentifier()] = $subject;
        }
    }
}

class CompleteList extends GenericList
{
    public function update(SplSubject $subject)
    {
        if($subject->isTicked()) {
            $this->items[$subject->getUniqueIdentifier()] = $subject;
        } else {
            unset($this->items[$subject->getUniqueIdentifier()]);
        }
    }
}

class ListManager
{
     
}

$item = new ItemText("Clean the kitchen");

$completed = new CompleteList();
$todo = new IncompleteList();
$generic = new GenericList();

$lists = [$completed, $todo, $generic];

foreach($lists as $list) {
    print sprintf("%s %d\n", get_class($list), count($list));
}

$item->attach($completed);
$item->attach($todo);
$item->attach($list);

$item->tick(true);
$item->tick(false);

foreach($lists as $list) {
    print sprintf("%s %d\n", get_class($list), count($list));
}

$item->tick(true);

foreach($lists as $list) {
    print sprintf("%s %d\n", get_class($list), count($list));
}



