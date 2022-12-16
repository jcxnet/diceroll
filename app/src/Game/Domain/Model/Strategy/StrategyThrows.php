<?php

namespace Game\Domain\Model\Strategy;

final class StrategyThrows extends Strategy implements StrategyInterface
{
    private LimitInterface $throws;

    public function __construct(StrategyName $name, StrategyDetail $detail, LimitInterface $throws)
    {
        $this->throws = $throws;
        parent::__construct($name, $detail);
    }

    public function throws(): int
    {
        return $this->throws->value();
    }

    public function limit(): int
    {
        return $this->throws();
    }
}