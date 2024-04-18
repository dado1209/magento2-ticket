<?php

namespace Favicode\Sample02\Model;

class B
{
    protected $a;
    public function __construct(A $a)
    {
        $this->a = $a;
    }
}
