<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower;

use BreiteSeite\LidlDigital\Aviation\Entity\Aircraft;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport;
use BreiteSeite\LidlDigital\Aviation\Entity\Airport\AirTrafficControlTower\AirControl\LandingClearance;

final class AirController
{
    /**
     * @param Aircraft $aircraft
     * @param Airport $airport
     * @return LandingClearance
     * @throws \Exception
     */
    public function createLandingClearanceForAircraft(Aircraft $aircraft, Airport $airport): LandingClearance
    {
        $runways = $airport->getRunways();

        // an air controller might have a strategy to select the landing runway based on different parameters
        $landingRunway = reset($runways);

        return new LandingClearance($landingRunway, $aircraft, $this);
    }
}
