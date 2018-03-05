<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower;

use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\GroundControl\RampService\TowRequest;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Gate;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Location;

final class GroundController
{
    /**
     * @param Location $from
     * @param Location $to
     * @param Aircraft $aircraft
     * @return TowRequest
     * @throws \Exception
     */
    public function createTowRequest(Location $from, Location $to, Aircraft $aircraft) : TowRequest
    {
        return new TowRequest(
            $from,
            $to,
            $aircraft
        );
    }

    public function connectGateToAircraft(Gate $gate, Aircraft $aircraft)
    {
        $gate->connectAircraft($aircraft);
    }
}
