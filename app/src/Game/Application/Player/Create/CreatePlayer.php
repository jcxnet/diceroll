<?php

namespace App\Game\Application\Player\Create;

use App\Game\Domain\Model\Player;
use App\Game\Domain\Model\PlayerName;
use App\Shared\Domain\Contracts\UuidGenerator;

final class CreatePlayer
{
    private UuidGenerator $uuidGenerator;
    public function __construct(UuidGenerator $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function create(): Player
    {
        $uuid = $this->uuidGenerator->generate();

        return new Player(new PlayerName($uuid));
    }

}