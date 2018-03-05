<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity\Airport;

use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport;
use BreiteSeite\LidlDigital\Aviation\Entity\Passenger;
use Ramsey\Uuid\Uuid;

final class Gate implements Location
{
    /** @var Uuid */
    private $id;

    /** @var string */
    private $name;

    /** @var Airport */
    private $airport;

    /** @var Aircraft */
    private $connectedAircraft;

    /**
     * Gate constructor.
     * @param string $name
     * @param Airport $airport
     */
    public function __construct(string $name, Airport $airport)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->airport = $airport;
    }

    public function getLocationName(): string
    {
        return 'Gate ' . $this->name;
    }

    public function passPassengerToAirport(Passenger $passenger)
    {
        if (!$this->connectedAircraft instanceof Aircraft) {
            throw new \RuntimeException('Gate is not connected to the aircraft');
        }

        if (!$this->connectedAircraft->isPassengerOnBoard($passenger)) {
            throw new \RuntimeException('Passenger is not on board of the plane');
        }

        $this->airport->handlePassengerArrival($passenger);
    }

    public function connectAircraft(Aircraft $aircraft)
    {
        $this->connectedAircraft = $aircraft;
    }

    public function disconnectAircraft()
    {
        $this->connectedAircraft = null;
    }

    public function isAircraftConnected(Aircraft $aircraft) : bool
    {
        return $this->connectedAircraft === $aircraft;
    }
}
