<?php

namespace Game\Domain\Model\Game;

use Game\Domain\Model\Dice\Dice;

final class GameSetup
{
    private Dice $dice;
    private GameMode $mode;
    private Rounds $rounds;
    private Players $players;

    public function __construct(Dice $dice, GameMode $mode, Rounds $rounds, Players $players)
    {
        $this->dice = $dice;
        $this->mode = $mode;
        $this->rounds = $rounds;
        $this->players = $players;
    }

    public function dice(): Dice
    {
        return $this->dice;
    }

    public function mode(): GameMode
    {
        return $this->mode;
    }

    public function rounds(): Rounds
    {
        return $this->rounds;
    }

    public function players(): Players
    {
        return $this->players;
    }


}