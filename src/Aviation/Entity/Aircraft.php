<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity;

use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirControl\LandingClearance;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\GroundControl\RampService\TowRequest;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Gate;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Location;
use Ramsey\Uuid\Uuid;

final class Aircraft
{
    /** @var Uuid */
    private $id;

    /** @var string */
    private $manufacturer;

    /** @var string */
    private $model;

    /** @var Passenger[]  */
    private $passengers = [];

    /** @var Location */
    private $currentLocation;

    /**
     * Aircraft constructor.
     * @param string $manufacturer
     * @param string $model
     */
    public function __construct(string $manufacturer, string $model)
    {
        $this->id = Uuid::uuid4();
        $this->manufacturer = $manufacturer;
        $this->model = $model;
    }

    /**
     * @param Passenger[] $passengers
     */
    public function enplanePassengers(array $passengers)
    {
        $this->passengers = $passengers;
    }

    public function getPassengerCount() : int
    {
        return count($this->passengers);
    }

    public function land(LandingClearance $landingClearance)
    {
        if (!$landingClearance->isValidForAircraft($this)) {
            throw new \RuntimeException('Trying to land with landing-clearance for different aircraft');
        }

        $this->currentLocation = $landingClearance->getRunway();
    }

    public function towToGate(TowRequest $towRequest)
    {
        if (!$towRequest->isValidForAircraft($this)) {
            throw new \RuntimeException('Trying to tow with tow-request for different aircraft');
        }

        $this->currentLocation = $towRequest->getToLocation();
    }

    public function isPassengerOnBoard(Passenger $passenger) : bool
    {
        return array_search($passenger, $this->passengers, true) !== false;
    }

    public function deplanePassengers()
    {
        if (!$this->currentLocation instanceof Gate) {
            throw new \RuntimeException('Passengers can only be offboarded when aircraft is parked at a gate');
        }

        if (!$this->currentLocation->isAircraftConnected($this)) {
            throw new \RuntimeException('Gate must be connected to aircraft before passengers can deplane');
        }

        foreach ($this->passengers as $key => $passenger) {
            $passenger->enterAirportViaGate($this->currentLocation);
            unset($this->passengers[$key]);
        }
    }

    public function getCurrentLocation() : Location
    {
        return $this->currentLocation;
    }

    public function getCurrentLocationName() : string
    {
        return $this->currentLocation->getLocationName();
    }
}
