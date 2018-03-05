<?php

namespace BreiteSeite\LidlDigitalTests\Unit;

use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Gate;
use BreiteSeite\LidlDigital\Aviation\Entity\Passenger;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class GateTest extends TestCase
{
    /** @var Gate */
    private $gate;

    /** @var ObjectProphecy */
    private $airportProphecy;

    protected function setUp()
    {
        parent::setUp();

        $this->airportProphecy = $this->prophesize(Airport::class);
        $this->gate = new Gate('PHPUnit', $this->airportProphecy->reveal());
    }

    public function testCanNotMovePassengerWhenNoAirplaneIsConnected()
    {
        $passengerProphecy = $this->prophesize(Passenger::class);

        $this->expectExceptionMessage('Gate is not connected to the aircraft');
        $this->gate->passPassengerToAirport($passengerProphecy->reveal());
    }

    public function testCanNotMovePassengerIfPassengerIsNotOnTheConnectedPlane()
    {
        $passengerProphecy = $this->prophesize(Passenger::class);
        $aircraftProphecy = $this->prophesize(Aircraft::class);
        $aircraftProphecy->isPassengerOnBoard($passengerProphecy->reveal())->willReturn(false);

        $this->gate->connectAircraft($aircraftProphecy->reveal());
        
        $this->expectExceptionMessage('Passenger is not on board of the plane');
        $this->gate->passPassengerToAirport($passengerProphecy->reveal());
    }

    public function testPassengerCanPassTheGateFromAircraftToAirport()
    {
        $passengerProphecy = $this->prophesize(Passenger::class);
        $aircraftProphecy = $this->prophesize(Aircraft::class);
        $aircraftProphecy->isPassengerOnBoard($passengerProphecy->reveal())->willReturn(true);

        $this->airportProphecy->handlePassengerArrival($passengerProphecy->reveal())->shouldBeCalled();

        $this->gate->connectAircraft($aircraftProphecy->reveal());

        $this->gate->passPassengerToAirport($passengerProphecy->reveal());
    }
}
