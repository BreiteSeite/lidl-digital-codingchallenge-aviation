<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\GroundControl\RampService;

use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Location;
use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use Ramsey\Uuid\Uuid;

final class TowRequest
{
    /** @var Uuid */
    private $id;

    /** @var Location */
    private $fromLocation;

    /** @var Location */
    private $toLocation;

    /** @var Aircraft */
    private $aircraft;

    /** @var \DateTime */
    private $dateTime;

    /**
     * TowRequest constructor.
     * @param Location $fromLocation
     * @param Location $toLocation
     * @param Aircraft $aircraft
     * @throws \Exception
     */
    public function __construct(Location $fromLocation, Location $toLocation, Aircraft $aircraft)
    {
        $this->id = Uuid::uuid4();
        $this->dateTime = new \DateTimeImmutable();

        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->aircraft = $aircraft;
    }

    public function isValidForAircraft(Aircraft $aircraft) : bool
    {
        return $this->aircraft === $aircraft;
    }

    /**
     * @return Location
     */
    public function getToLocation(): Location
    {
        return $this->toLocation;
    }
}
