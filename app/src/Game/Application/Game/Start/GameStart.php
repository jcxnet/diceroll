<?php

namespace Game\Application\Game\Start;

use Game\Application\Player\Create\CreatePlayer;
use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Game\GameMode;
use Game\Domain\Model\Game\GameSetup;
use Game\Domain\Model\Player\Player;
use Game\Domain\Model\Scoreboard\Scoreboard;
use Game\Infrastructure\GameTerminal;

final class GameStart
{
    private GameTerminal $terminal;
    private Scoreboard $scoreboard;

    private array $players = [];

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
        $this->scoreboard = new Scoreboard();
    }

    public function __invoke(GameSetup $gameSetup, CreatePlayer $createPlayer): void
    {
        $this->terminal->subtitle("Player strategy selection");
        $this->createPlayers($createPlayer, $gameSetup->dice(), $gameSetup->players()->value());
        $this->gameDetails($gameSetup);
        $this->rollDice($gameSetup);
        $this->results();
        $this->winner();
    }

    private function createPlayers(CreatePlayer $createPlayer, Dice $dice, int $total): void
    {
        for ($i = 0; $i < $total; $i++) {
            $this->terminal->output(sprintf('<background_blue><white>Player %d</white></background_blue>', $i + 1));
            $this->players[] = $createPlayer->create($dice);
        }
    }

    private function gameDetails(GameSetup $gameSetup): void
    {
        $this->terminal->clear();
        $this->infoGame($gameSetup);
        $this->infoPlayers();
    }

    private function infoGame(GameSetup $gameSetup): void
    {
        $this->terminal->subtitle('Game options');
        $this->terminal->info($gameSetup->info());
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

    private function rollDice(GameSetup $gameSetup): void
    {
        $this->terminal->title('Rolling the dice...');
        $mode = $gameSetup->mode()->mode();
        match ($mode) {
            GameMode::MODE_COMPLETE_ROUNDS => $this->playByPlayer($gameSetup),
            GameMode::MODE_ALTERNATE_ROUNDS => $this->playByRound($gameSetup),
        };
    }

    private function playByPlayer(GameSetup $gameSetup): void
    {
        $rounds = $gameSetup->rounds()->value();
        $dice = $gameSetup->dice();
        /* @var Player $player */
        foreach ($this->players as $player) {
            for ($i = 0; $i < $rounds; $i++) {
                $this->playRound($player, $dice, $i + 1);
            }
        }
    }

    private function playRound(Player $player, Dice $dice, int $round): void
    {
        $roundScore = 0;
        $throws = 0;
        do {
            $roundScore += $player->roll();
            $continue = $player->continueRoll(++$throws, $roundScore);
        } while ($continue);

        $points = ($roundScore > $dice->scoreLimit()) ? 0 : $roundScore;

        $this->scoreboard->addScore($player, $round, $throws, $roundScore, $points);
    }

    private function playByRound(GameSetup $gameSetup): void
    {
        $rounds = $gameSetup->rounds()->value();
        $dice = $gameSetup->dice();
        /* @var Player $player */
        for ($i = 0; $i < $rounds; $i++) {
            foreach ($this->players as $player) {
                $this->playRound($player, $dice, $i + 1);
            }
        }
    }

    private function results(): void
    {
        $this->terminal->title('Results');
        $info = $this->scoreboard->info();
        $this->terminal->info($info);
    }

    private function winner(): void
    {
        $winner = $this->scoreboard->winner();
        $title = (count($winner) > 1) ? 'Winners' : 'Winner';
        $this->terminal->title($title);
        foreach ($winner as $name){
            $points = $this->scoreboard->playerPoints($name);
            $message = sprintf('<background_green><white>The player %s win the game with %d points !!!</white></background_green>', $name, $points);
            $this->terminal->output($message);
        }
    }

}