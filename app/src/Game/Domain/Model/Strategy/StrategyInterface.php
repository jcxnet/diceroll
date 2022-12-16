<?php

namespace Game\Domain\Model\Strategy;

interface StrategyInterface
{
    public function name(): string;

    public function detail(): string;

    public function limit(): int;

}