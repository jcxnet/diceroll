<?php

namespace Game\Application\Player\Create;

use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Player\Player;
use Game\Domain\Model\Player\PlayerName;
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
use Shared\Domain\Contracts\UuidGenerator;

final class CreatePlayer
{
    private const MAX_THROWS = 3;
    private const THROWS = Strategy::THROWS_STRATEGY;
    private const POINTS = Strategy::POINTS_STRATEGY;
    private GameTerminal $terminal;
    private UuidGenerator $uuidGenerator;
    private Dice $dice;
    private array $strategies = [
        self::THROWS => 'Roll the dice a maximum of %d times',
        self::POINTS => 'Stop rolling the dice when I get %d points',
    ];

    public function __construct(UuidGenerator $uuidGenerator, GameTerminal $terminal)
    {
        $this->uuidGenerator = $uuidGenerator;
        $this->terminal = $terminal;
    }

    public function create(Dice $dice): Player
    {
        $this->dice = $dice;
        $uuid = $this->uuidGenerator->generate();
        $strategy = $this->selectStrategy();

        return new Player(new PlayerName($uuid), $strategy, $dice);
    }

    private function selectStrategy(): StrategyInterface
    {
        $options = [
            self::THROWS => sprintf($this->strategies[self::THROWS], self::MAX_THROWS),
            self::POINTS => sprintf($this->strategies[self::POINTS], $this->dice->scoreLimit()),
        ];

        $selectedStrategy = $this->terminal->choice('Select your game strategy', $options);

        return $this->createStrategy($selectedStrategy, $options);
    }

    private function createStrategy(string $selectedStrategy, array $options): StrategyInterface
    {
        $name = new StrategyName($selectedStrategy);
        $detail = new StrategyDetail($options[$selectedStrategy]);
        $limit = $this->newLimit($selectedStrategy);

        return match ($selectedStrategy) {
            self::THROWS => new StrategyThrows($name, $detail, $limit),
            self::POINTS => new StrategyPoints($name, $detail, $limit),
        };
    }

    private function newLimit(string $selectedStrategy): LimitInterface
    {
        return match ($selectedStrategy) {
            self::THROWS => new Throws(self::MAX_THROWS),
            self::POINTS => new Points($this->dice->scoreLimit()),
        };
    }

}