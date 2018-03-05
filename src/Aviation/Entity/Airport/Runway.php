<?php


namespace BreiteSeite\LidlDigital\Aviation\Entity\Airport;

use BreiteSeite\LidlDigital\Aviation\Entity\Airport;
use Ramsey\Uuid\Uuid;

final class Runway implements Location
{
    /** @var Uuid */
    private $id;

    /**
     * Runway name (for example: 02L)
     *
     * @var string
     */
    private $runwayName;

    /** @var Airport */
    private $airport;

    /**
     * Runway constructor.
     * @param string $runwayName
     * @param Airport $airport
     */
    public function __construct(string $runwayName, Airport $airport)
    {
        $this->id = Uuid::uuid4();
        $this->runwayName = $runwayName;
        $this->airport = $airport;
    }


    public function getLocationName(): string
    {
        return 'Runway ' . $this->runwayName;
    }
}
