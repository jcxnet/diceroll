<?php

namespace Game\Application\Game\Players;

use Game\Domain\Model\Game\Players;
use Game\Infrastructure\GameTerminal;

final class SelectPlayers
{
    private const MIN_PLAYERS = 2;
    private const MAX_PLAYERS = 5;
    private GameTerminal $terminal;

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): Players
    {
        $message = sprintf('<yellow>Select the number of players</yellow>, <blue>minimum <bold>%d</bold> and maximum <bold>%d</bold></blue>', self::MIN_PLAYERS, self::MAX_PLAYERS);
        $players = $this->terminal->inputIntegerRange($message,self::MIN_PLAYERS, self::MAX_PLAYERS);

        return new Players($players);
    }


}