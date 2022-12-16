<?php

namespace Game\Domain\Model\Player;

use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Strategy\Strategy;
use Game\Domain\Model\Strategy\StrategyInterface;

final class Player
{
    private PlayerName $name;
    private Dice $dice;
    private StrategyInterface $strategy;

    public function __construct(PlayerName $name, StrategyInterface $strategy, Dice $dice)
    {
        $this->name = $name;
        $this->strategy = $strategy;
        $this->dice = $dice;
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function strategy(): StrategyInterface
    {
        return $this->strategy;
    }

    public function roll(): int
    {
        return $this->dice->roll();
    }

    public function continueRoll(int $throws, int $scoreRound): bool
    {
        $strategy = $this->strategy->name();

        return match ($strategy) {
            Strategy::THROWS_STRATEGY => $throws < $this->strategy->limit(),
            Strategy::POINTS_STRATEGY => $scoreRound < $this->strategy->limit(),
            default => false
        };
    }


}