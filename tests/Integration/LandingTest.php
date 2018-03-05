<?php


namespace BreiteSeite\LidlDigitalTests\Integration;

use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirController;
use BreiteSeite\LidlDigital\Aviation\Entity\Passenger;
use PHPUnit\Framework\TestCase;

final class LandingTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testAirportOpeningLandingFlight()
    {
        $airport = new Airport(
            Airport::SHORTCODE_BERLIN_WILLY_BRANDT
        );
        $this->assertSame(0, $airport->countArrivedPassengers());

        $airController = new AirController();
        $groundController = new Airport\AirTrafficControlTower\GroundController();
        $gate = new Airport\Gate('1', $airport);

        $airport->createRunway('02');
        $airport->addGate($gate);
        $airport->setAirController($airController);
        $airport->setGroundController($groundController);

        $airCraft = new Aircraft('Airbus', 'A380');

        $airCraft->enplanePassengers($this->generateDummyPassengers(50));
        $this->assertSame(50, $airCraft->getPassengerCount());

        $landingClearance = $airport->requestLandingClearance($airCraft);
        $airCraft->land($landingClearance);
        $this->assertSame('Runway 02', $airCraft->getCurrentLocationName());

        $towRequest = $airport->requestTowForAirCraftAndGate($airCraft, $gate);
        $airCraft->towToGate($towRequest);
        $this->assertSame('Gate 1', $airCraft->getCurrentLocationName());

        $airport->connectAirCraftToGate($airCraft, $gate);

        $airCraft->deplanePassengers();
        $this->assertSame(0, $airCraft->getPassengerCount());
        $this->assertSame(50, $airport->countArrivedPassengers());

        $airport->disconnectAirCraftFromGate($gate);

        $airport->welcomeArrivedPassengers();
        $this->assertSame(0, $airport->countArrivedPassengers());
    }

    /**
     * @param int $count
     * @return array
     * @throws \Exception
     */
    private function generateDummyPassengers(int $count): array
    {
        $passengers = [];
        for ($i = 1; $i <= $count; $i++) {
            $passengers[] = new Passenger(
                'Phpunit',
                'Phpunit',
                'Test street 1',
                'Germany',
                new \DateTimeImmutable('1997-01-01'),
                'Berlin',
                'Germany'
            );
        }

        return $passengers;
    }
}
