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
    
    public function info(): array
    {
        return [
            ['Dice', sprintf('%s, %d sides, low number is %s, max number is %d', $this->dice()->name(), $this->dice()->sides(), $this->dice()->min(), $this->dice()->max())],
            ['Game mode', $this->mode()->detail()],
            ['Rounds', $this->rounds()->value()],
            ['Points', sprintf('Player sum points if the round score is lower or equal to %d, otherwise is 0', $this->dice->scoreLimit())],
            ['Players', $this->players()->value()],
        ];
    }


}