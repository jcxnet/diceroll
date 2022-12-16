<?php

namespace Game\Domain\Model\Strategy;

class StrategyPoints extends Strategy implements StrategyInterface
{
    private LimitInterface $points;

    public function __construct(StrategyName $name, StrategyDetail $detail, LimitInterface $points)
    {
        $this->points = $points;
        parent::__construct($name, $detail);
    }

    public function points(): int
    {
        return $this->points->value();
    }

    public function limit(): int
    {
        return $this->points();
    }
}