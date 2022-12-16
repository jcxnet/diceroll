<?php

namespace Game\Application\Dice\Select;

use Game\Application\Dice\Exceptions\DiceNotExists;
use Game\Domain\Model\Dice\Dice;
use Game\Domain\Model\Dice\DiceMaxNumber;
use Game\Domain\Model\Dice\DiceMinNumber;
use Game\Domain\Model\Dice\DiceName;
use Game\Domain\Model\Dice\DiceSides;
use Game\Infrastructure\GameTerminal;

class SelectDice
{

    private const DICES_NAMES = [
        'D6' => 'D6: Six sides',
        'D8' => 'D8: Eight sides',
        'D10' => 'D10: Ten sides',
        'D12' => 'D12: Twelve sides',
        'D20' => 'D20: Twenty sides',
    ];

    private const DICES_NUMBERS = [
        'D6' => ['sides' => 6, 'min' => 1, 'max' => 6],
        'D8' => ['sides' => 8, 'min' => 1, 'max' => 8],
        'D10' => ['sides' => 10, 'min' => 0, 'max' => 10],
        'D12' => ['sides' => 12, 'min' => 1, 'max' => 12],
        'D20' => ['sides' => 20, 'min' => 0, 'max' => 20],
    ];

    private GameTerminal $terminal;

    public function __construct(GameTerminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function __invoke(): Dice
    {
        $options = self::DICES_NAMES;
        $selected = $this->terminal->choice('<yellow>Select the dice to play:</yellow>', $options);

        return $this->createDice($selected);
    }

    private function createDice(string $diceName): Dice
    {
        if (!array_key_exists($diceName, self::DICES_NAMES) || !array_key_exists($diceName, self::DICES_NUMBERS)) {
            $this->terminal->exception(new DiceNotExists());
        }

        return $this->newSelectedDice(
            $diceName,
            self::DICES_NUMBERS[$diceName]['sides'],
            self::DICES_NUMBERS[$diceName]['min'],
            self::DICES_NUMBERS[$diceName]['max'],
        );
    }

    private function newSelectedDice(string $name, int $sides, int $min, int $max): Dice
    {
        $diceName = new DiceName($name);
        $diceSides = new DiceSides($sides);
        $diceMinNum = new DiceMinNumber($min);
        $diceMaxNum = new DiceMaxNumber($max);

        return new Dice($diceName, $diceSides, $diceMinNum, $diceMaxNum);
    }


}