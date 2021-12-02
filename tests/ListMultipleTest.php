<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Todo\ItemText;
use Todo\ListComplete;
use Todo\ListGeneric;
use Todo\ListIncomplete;
use Todo\ListManager;

class ListMultipleTest extends TestCase
{
    public function setUp(): void
    {
        $this->listManager = new ListManager;
        $this->listComplete = $this->listManager->addList(new ListComplete);
        $this->listIncomplete = $this->listManager->addList(new ListIncomplete);
        $this->listGeneric = $this->listManager->addList(new ListGeneric);
    }

    public function testItemIsAdded()
    {
        $item = new ItemText;
        $this->listManager->addItem($item);
        $this->assertContains($item, $this->listGeneric->getItems());
        $this->assertContains($item, $this->listIncomplete->getItems());
        $this->assertNotContains($item, $this->listComplete->getItems());
        $item->tick(true);
        $this->assertContains($item, $this->listGeneric->getItems());
        $this->assertContains($item, $this->listComplete->getItems());
        $this->assertNotContains($item, $this->listIncomplete->getItems());
    }
}
