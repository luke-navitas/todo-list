<?php

namespace Todo;

use SplSubject;

interface IItem extends Identifiable, SplSubject, Tickable
{
}
