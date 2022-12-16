<?php

namespace Game\Domain\Model\Strategy;

interface LimitInterface
{
    public function value(): int;
}