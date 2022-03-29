<?php

namespace App\Managers\Twitch;

use DeGraciaMathieu\Manager\Manager;
use App\Managers\Twitch\Contracts\Driver;
use Illuminate\Config\Repository as Config;

class TwitchManager extends Manager
{
    public function __construct(
        protected Config $config,
    ){}

    public function createRawapiDriver(): Repository
    {
        $config = $this->config['manager.twitch.drivers.rawapi'];
        
        $driver = new Drivers\RawApi($config);

        return $this->getRepository($driver);
    }

    public function createMockDriver(): Repository
    {
        $driver = new Drivers\Mock();

        return $this->getRepository($driver);
    }
   
    public function getRepository(Driver $driver): Repository
    {
        return new Repository($driver);
    }

    public function getDefaultDriver(): string
    {
        return $this->config['manager.twitch.default_driver'];
    }
}
