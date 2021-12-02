<?php

namespace Todo;

class ListManager
{

    private $lists = [];
    private $items = [];

    public function addList($list)
    {

        // Store the new list so we can manage it later
        $this->lists[] = $list;

        // Add the new list as an observer to each item
        foreach ($this->items as $item) {
            $item->attach($list);
        }

        // Run each item through each list so it can decide what to do with the existing item
        foreach ($this->items as $item) {
            $item->notify();
        }

        return $list;
    }

    public function addItem(iItem $item)
    {

        // Ensure the item doesn't already exist
        if (isset($this->items[$item->getUniqueIdentifier()])) {
            throw new ItemAlreadyExistsException('Item already exists: ' . $item->getUniqueIdentifier());
        }

        // Keep track of it globally within the ListManager
        $this->items[$item->getUniqueIdentifier()] = $item;

        // Loop through lists and attach each list to the item
        foreach ($this->lists as $list) {
            $item->attach($list);
        }

        // Let all subscribed lists learn of the new item.
        $item->notify();
    }

    public function removeItem(iItem $item)
    {

        // Loop through lists and detach the item if exists
        foreach ($this->lists as $list) {
            $list->removeItem($item); // This will also detach the list from observing the item
        }

        // Remove from the list manager
        unset($this->items[$item->getUniqueIdentifier()]);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getLists(): array
    {
        return $this->lists;
    }
}
