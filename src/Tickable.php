<?php

namespace Todo;

interface Tickable
{
    public function tick(bool $completed): void;
    public function isTicked(): bool;
}
