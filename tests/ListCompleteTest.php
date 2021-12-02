<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Todo\ItemText;
use Todo\ListComplete;
use Todo\ListManager;

class ListCompleteTest extends TestCase
{
    public function setUp(): void
    {
        $this->listManager = new ListManager;
        $this->listComplete = $this->listManager->addList(new ListComplete);
    }

    public function testNewListIsEmpty()
    {
        $this->assertEmpty($this->listComplete);
    }

    public function testItDoesNotAddAnUntickedItem()
    {
        $this->listManager->addItem(new ItemText);
        $this->assertEmpty($this->listComplete);
    }

    public function testItAddsATickedItem()
    {
        $item = new ItemText;
        $item->tick(true);
        $this->listManager->addItem($item);
        $this->assertCount(1, $this->listComplete);
    }

    public function testItAddsMultipleTickedItems()
    {
        for ($i = 0; $i < 5; $i++) {
            $item = new ItemText;
            $item->tick(true);
            $this->listManager->addItem($item);
        }

        $this->assertCount(5, $this->listComplete);
    }

    public function testItRemovesItems()
    {
        $items = [];
        for ($i = 0; $i < 5; $i++) {
            $item = new ItemText;
            $items[$item->getUniqueIdentifier()] = $item;
            $item->tick(true);
            $this->listManager->addItem($item);
        }

        $this->assertCount(5, $this->listComplete);

        $this->listComplete->removeItem($items[array_rand($items, 1)]);

        $this->assertCount(4, $this->listComplete);
    }
}
