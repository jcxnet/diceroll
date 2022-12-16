<?php

namespace Game\Application\Player\Strategy;

use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Strategy\LimitInterface;
use Game\Domain\Model\Strategy\Points;
use Game\Domain\Model\Strategy\Strategy;
use Game\Domain\Model\Strategy\StrategyDetail;
use Game\Domain\Model\Strategy\StrategyInterface;
use Game\Domain\Model\Strategy\StrategyName;
use Game\Domain\Model\Strategy\StrategyPoints;
use Game\Domain\Model\Strategy\StrategyThrows;
use Game\Domain\Model\Strategy\Throws;
use Game\Infrastructure\GameTerminal;

final class SelectStrategy
{
    private const MAX_THROWS = 3;
    private const THROWS = Strategy::THROWS_STRATEGY;
    private const POINTS = Strategy::POINTS_STRATEGY;
    private array $strategies = [
        self::THROWS => 'Roll the dice a maximum of %d times',
        self::POINTS => 'Stop rolling the dice if the round results is greater than %d points',
    ];
    private GameTerminal $terminal;

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(Dice $dice): StrategyInterface
    {
        $points = $dice->sides() - 1;
        $options = [
            self::THROWS => sprintf($this->strategies[self::THROWS], self::MAX_THROWS),
            self::POINTS => sprintf($this->strategies[self::POINTS], $points),
        ];

        $selectedStrategy = $this->terminal->choice('Select your game strategy', $options);

        return $this->createStrategy($selectedStrategy, $options, $points);
    }

    private function createStrategy(string $selectedStrategy, array $options, int $points): StrategyInterface
    {
        $name = new StrategyName($selectedStrategy);
        $detail = new StrategyDetail($options[$selectedStrategy]);
        $limit = $this->newLimit($selectedStrategy, $points);

        return match ($selectedStrategy) {
            self::THROWS => new StrategyThrows($name, $detail, $limit),
            self::POINTS => new StrategyPoints($name, $detail, $limit),
        };
    }

    private function newLimit(string $selectedStrategy, int $points): LimitInterface
    {
        return match ($selectedStrategy) {
            self::THROWS => new Throws(self::MAX_THROWS),
            self::POINTS => new Points($points),
        };
    }
}