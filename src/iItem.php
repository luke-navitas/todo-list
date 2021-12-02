<?php

namespace Todo;

use SplSubject;

interface iItem extends Identifiable, SplSubject, Tickable {
    
}