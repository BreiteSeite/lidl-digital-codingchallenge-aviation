<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirControl;

use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirController;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Runway;
use Ramsey\Uuid\Uuid;

final class LandingClearance
{
    /** @var Uuid */
    private $id;

    /** @var \DateTimeImmutable */
    private $dateTime;

    /** @var Runway */
    private $runway;

    /** @var Aircraft */
    private $aircraft;

    /** @var AirController */
    private $issuer;

    /**
     * LandingClearance constructor.
     * @param Runway $runway
     * @param Aircraft $aircraft
     * @param AirController $issuer
     * @throws \Exception if DateTimeImmutable can not be created
     */
    public function __construct(Runway $runway, Aircraft $aircraft, AirController $issuer)
    {
        $this->id = Uuid::uuid4();
        $this->dateTime = new \DateTimeImmutable();
        $this->runway = $runway;
        $this->aircraft = $aircraft;
        $this->issuer = $issuer;
    }

    public function isValidForAircraft(Aircraft $aircraft) : bool
    {
        return $this->aircraft === $aircraft;
    }

    /**
     * @return Runway
     */
    public function getRunway(): Runway
    {
        return $this->runway;
    }

    /**
     * @return AirController
     */
    public function getIssuer(): AirController
    {
        return $this->issuer;
    }
}
