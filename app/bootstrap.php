<?php

use App\Game\Application\Game\Intro\GameIntro;
use App\Game\Application\Game\Setup\GameSetup;
use App\Game\Application\Game\Start\GameStart;
use App\Game\Application\Player\Create\CreatePlayer;
use App\Shared\Infrastructure\Terminal\Terminal;
use App\Shared\Infrastructure\Uuid\UuidGenerator;

set_time_limit(0);

require __DIR__.'/vendor/autoload.php';

$terminal = new Terminal();
$uuidGenerator = new UuidGenerator();

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    GameIntro::class => new GameIntro($terminal),
    GameSetup::class => new GameSetup($terminal),
    GameStart::class => new GameStart($terminal),
    CreatePlayer::class => new CreatePlayer($uuidGenerator),
]);
$container = $builder->build();