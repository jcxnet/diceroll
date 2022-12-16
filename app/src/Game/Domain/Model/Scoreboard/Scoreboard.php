<?php

namespace Game\Domain\Model\Scoreboard;

use Game\Domain\Model\Player\Player;

final class Scoreboard
{
    private const SCORE = 'SCORE';
    private const ROUND = 'ROUND';
    private const THROWS = 'THROWS';
    private const POINTS = 'POINTS';

    private array $players = [];

    public function addScore(Player $player, int $round, int $throws, int $roundScore, int $points): void
    {
        $this->players[$player->name()][self::ROUND][$round] = [self::THROWS => $throws, self::SCORE => $roundScore, self::POINTS => $points];
        $score = $this->players[$player->name()][self::SCORE] ?? 0;
        $this->players[$player->name()][self::SCORE] = $score + $points;
    }

    public function info(): array
    {
        $data = [];
        $item = 1;
        /* @var Player $player */
        foreach ($this->players as $id => $info) {
            $data[] = [
                '#' => $item++,
                'Player' => $id,
                'Score' => sprintf('%d points', $info[self::SCORE]),
            ];
        }

        return $data;
    }

    public function playerPoints(string $player): int
    {
        return $this->players[$player][self::SCORE] ?? 0;
    }
    public function winner(): array
    {
        $winner = [];
        $max = $this->getMaxScore();
        foreach ($this->players as $name => $info) {
            if ($max === $info[self::SCORE]) {
                $winner[] = $name;
            }
        }

        return $winner;
    }

    private function getMaxScore(): int
    {
        $max = 0;
        foreach ($this->players as $id => $info) {
            if ($max < $info[self::SCORE]) {
                $max = $info[self::SCORE];
            }
        }

        return $max;
    }


}