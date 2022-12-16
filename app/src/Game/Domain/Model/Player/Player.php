<?php

namespace Game\Domain\Model\Player;

use Game\Domain\Model\Strategy\StrategyInterface;

final class Player
{
    private PlayerName $name;
    private StrategyInterface $strategy;

    public function __construct(PlayerName $name, StrategyInterface $strategy)
    {
        $this->name = $name;
        $this->strategy = $strategy;
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function strategy(): StrategyInterface
    {
        return $this->strategy;
    }


}