<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Todo\Item;
use Todo\ItemAlreadyExistsException;
use Todo\ItemText;
use Todo\ListComplete;
use Todo\ListManager;

class ListManagerTest extends TestCase
{
    public function setUp(): void
    {
        $this->listManager = new ListManager();
    }

    public function testIsTrue()
    {
        $this->assertTrue(true);
    }

    public function testItAddsAnItem()
    {
        $this->listManager->addItem(new ItemText);
        $this->assertCount(1, $this->listManager->getItems());
    }

    public function testItCannotAddTheSameItemTwice()
    {
        $itemText = new ItemText;
        $this->listManager->addItem($itemText);
        $this->expectException(ItemAlreadyExistsException::class);
        $this->listManager->addItem($itemText);
    }

    public function testItAddsAndRemovesAnItem()
    {
        $itemText = new ItemText;
        $this->listManager->addItem($itemText);
        $this->assertCount(1, $this->listManager->getItems());
        $this->listManager->removeItem($itemText);
        $this->assertCount(0, $this->listManager->getItems());
    }
    public function testItAddsAList()
    {
        $listComplete = new ListComplete;
        $this->listManager->addList($listComplete);
        $this->assertContains($listComplete, $this->listManager->getLists());
    }
}
