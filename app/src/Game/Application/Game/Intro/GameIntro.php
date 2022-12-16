<?php

namespace Game\Application\Game\Intro;

use Game\Infrastructure\GameTerminal;

final class GameIntro
{
    private GameTerminal $terminal;

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): void
    {
        $this->terminal->clear();
        $this->terminal->title("Dice Roll Game");
    }

}