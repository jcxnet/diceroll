<?php

namespace Game\Application\Player\Create;

use Game\Application\Player\Strategy\SelectStrategy;
use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Player\Player;
use Game\Domain\Model\Player\PlayerName;
use Game\Domain\Model\Strategy\StrategyInterface;
use Game\Infrastructure\GameTerminal;
use Shared\Domain\Contracts\UuidGenerator;

final class CreatePlayer
{

    private GameTerminal $terminal;
    private UuidGenerator $uuidGenerator;


    public function __construct(UuidGenerator $uuidGenerator, GameTerminal $terminal)
    {
        $this->uuidGenerator = $uuidGenerator;
        $this->terminal = $terminal;
    }

    public function create(Dice $dice): Player
    {
        $uuid = $this->uuidGenerator->generate();
        $strategy = $this->selectStrategy($dice);

        return new Player(new PlayerName($uuid), $strategy, $dice);
    }

    private function selectStrategy(Dice $dice): StrategyInterface
    {
        $strategy = new SelectStrategy($this->terminal);

        return $strategy($dice);
    }


}