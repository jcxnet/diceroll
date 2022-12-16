<?php

namespace Game\Domain\Model\Dice;

final class Dice
{
    private DiceName $name;
    private DiceSides $sides;
    private DiceMinNumber $min;
    private DiceMaxNumber $max;
    private DiceScoreLimit $scoreLimit;

    public function __construct(DiceName $name, DiceSides $sides, DiceMinNumber $min, DiceMaxNumber $max)
    {
        $this->name = $name;
        $this->sides = $sides;
        $this->min = $min;
        $this->max = $max;
        $this->scoreLimit = $this->calculateScoreLimit();
    }

    private function calculateScoreLimit(): DiceScoreLimit
    {
        $sides = $this->sides->value();
        $limit = $sides + $sides / 2;
        if ($limit % 2 === 0) {
            return new DiceScoreLimit($limit);
        }

        return new DiceScoreLimit(++$limit);
    }

    public function roll(): int
    {
        mt_srand();

        return random_int($this->min->value(), $this->max->value());
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function sides(): int
    {
        return $this->sides->value();
    }

    public function min(): int
    {
        return $this->min->value();
    }

    public function max(): int
    {
        return $this->max->value();
    }

    public function scoreLimit(): int
    {
        return $this->scoreLimit->value();
    }


}