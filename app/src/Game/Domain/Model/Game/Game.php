<?php

namespace Game\Domain\Model\Game;

final class Game
{
    private Rounds $rounds;

    public function __construct(Rounds $gameRounds)
    {
        $this->rounds = $gameRounds;
    }


}