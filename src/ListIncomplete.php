<?php

namespace Todo;

use SplSubject;

class ListIncomplete extends ListGeneric
{
    public function update(SplSubject $subject): void
    {
        if ($subject instanceof IItem) {
            if ($subject->isTicked()) {
                unset($this->items[$subject->getUniqueIdentifier()]);
            } else {
                $this->items[$subject->getUniqueIdentifier()] = $subject;
            }
        }
    }
}
