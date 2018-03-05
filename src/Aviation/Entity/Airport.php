<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity;

use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirControl\LandingClearance;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirController;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\GroundControl\RampService\TowRequest;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\GroundController;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Gate;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Runway;
use Ramsey\Uuid\Uuid;

class Airport
{
    const SHORTCODE_BERLIN_WILLY_BRANDT = 'BER';

    /** @var Uuid */
    private $id;

    /** @var string */
    private $shortCode;

    /** @var Runway[] */
    private $runways = [];

    /** @var Gate[] */
    private $gates = [];

    /** @var Passenger[] */
    private $arrivedPassengers = [];

    /** @var AirController */
    private $airController;

    /** @var GroundController */
    private $groundController;

    /**
     * Airport constructor.
     * @param string $shortCode
     */
    public function __construct(string $shortCode)
    {
        $this->id = Uuid::uuid4();
        $this->shortCode = $shortCode;
    }

    public function createRunway(string $name)
    {
        $this->runways[] = new Runway($name, $this);
    }

    public function addGate(Gate $gate)
    {
        $this->gates[] = $gate;
    }

    public function setAirController(AirController $airController)
    {
        $this->airController = $airController;
    }

    public function setGroundController(GroundController $groundControl)
    {
        $this->groundController = $groundControl;
    }

    /**
     * @param Aircraft $aircraft
     * @return LandingClearance
     * @throws \Exception
     */
    public function requestLandingClearance(Aircraft $aircraft): LandingClearance
    {
        return $this->airController->createLandingClearanceForAircraft($aircraft, $this);
    }

    /**
     * @param Aircraft $aircraft
     * @param Gate $gate
     * @return TowRequest
     * @throws \Exception
     */
    public function requestTowForAirCraftAndGate(Aircraft $aircraft, Gate $gate): TowRequest
    {
        return $this->groundController->createTowRequest(
            $aircraft->getCurrentLocation(),
            $gate,
            $aircraft
        );
    }

    /**
     * @return Runway[]
     */
    public function getRunways(): array
    {
        return $this->runways;
    }

    public function handlePassengerArrival(Passenger $passenger)
    {
        $this->arrivedPassengers[] = $passenger;
    }

    public function countArrivedPassengers(): int
    {
        return count($this->arrivedPassengers);
    }

    public function welcomeArrivedPassengers(): void
    {
        $this->arrivedPassengers = [];
    }

    public function connectAirCraftToGate(Aircraft $aircraft, Gate $gate)
    {
        $gate->connectAircraft($aircraft);
    }

    public function disconnectAirCraftFromGate(Gate $gate)
    {
        $gate->disconnectAircraft();
    }
}
