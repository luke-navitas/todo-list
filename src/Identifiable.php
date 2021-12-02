<?php

namespace Todo;

interface Identifiable
{
    public function getUniqueIdentifier(): string;
}