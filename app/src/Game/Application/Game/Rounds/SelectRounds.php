<?php

namespace Game\Application\Game\Rounds;

use Game\Domain\Model\Game\Rounds;
use Game\Infrastructure\GameTerminal;

final class SelectRounds
{
    private const MIN_ROUNDS = 1;
    private const MAX_ROUNDS = 100;
    private GameTerminal $terminal;

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): Rounds
    {
        $message = sprintf('<yellow>Select the number of rounds</yellow>, <blue>minimum <bold>%d</bold> and maximum <bold>%d</bold></blue>', self::MIN_ROUNDS, self::MAX_ROUNDS);
        $rounds = $this->terminal->inputIntegerRange($message,self::MIN_ROUNDS, self::MAX_ROUNDS);

        return new Rounds($rounds);
    }


}