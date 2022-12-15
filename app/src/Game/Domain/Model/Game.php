<?php

namespace App\Game\Domain\Model;

final class Game
{
    private GameRounds $gameRounds;

    public function __construct(GameRounds $gameRounds)
    {
        $this->gameRounds = $gameRounds;
    }


}