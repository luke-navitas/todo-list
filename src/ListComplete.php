<?php

namespace Todo;

use SplSubject;

class ListComplete extends ListGeneric
{
    public function update(SplSubject $subject): void
    {
        if ($subject instanceof IItem) {
            if ($subject->isTicked()) {
                $this->items[$subject->getUniqueIdentifier()] = $subject;
            } else {
                unset($this->items[$subject->getUniqueIdentifier()]);
            }
        }
    }
}
