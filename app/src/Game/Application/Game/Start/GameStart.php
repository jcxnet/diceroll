<?php

namespace Game\Application\Game\Start;

use Game\Application\Player\Create\CreatePlayer;
use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Game\GameSetup;
use Game\Domain\Model\Player\Player;
use Game\Infrastructure\GameTerminal;

final class GameStart
{
    private GameTerminal $terminal;

    private array $players = [];

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(GameSetup $gameSetup, CreatePlayer $createPlayer): void
    {
        $this->terminal->subtitle("Player strategy selection");
        $this->createPlayers($createPlayer, $gameSetup->dice(), $gameSetup->players()->value());
        $this->infoPlayers();
    }

    private function createPlayers(CreatePlayer $createPlayer, Dice $dice, int $total): void
    {
        for ($i = 0; $i < $total; $i++) {
            $this->terminal->output(sprintf('<background_blue><white>Player %d</white></background_blue>', $i+1));
            $this->players[] = $createPlayer->create($dice);
        }
    }

    private function infoPlayers(): void
    {
        $data = [];
        $item = 1;
        /* @var Player $player */
        foreach ($this->players as $player) {
            $data[] = [
                '#' => $item++,
                'Player' => $player->name(),
                'Strategy' => $player->strategy()->detail(),
            ];
        }
        $this->terminal->subtitle('Players');
        $this->terminal->info($data);
    }

}