<?php

namespace Game\Domain\Model\Strategy;

class Strategy
{
    public const THROWS_STRATEGY = 'THROWS';
    public const POINTS_STRATEGY = 'POINTS';

    private StrategyName $name;
    private StrategyDetail $detail;

    public function __construct(StrategyName $name, StrategyDetail $detail)
    {
        $this->name = $name;
        $this->detail = $detail;
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function detail(): string
    {
        return $this->detail->value();
    }


}