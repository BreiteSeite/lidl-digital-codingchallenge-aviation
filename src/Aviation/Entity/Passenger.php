<?php

namespace BreiteSeite\LidlDigital\Aviation\Entity;

use BreiteSeite\LidlDigital\Aviation\Entity\Airport\Gate;
use Ramsey\Uuid\Uuid;

class Passenger
{
    /** @var Uuid */
    private $id;

    /** @var string */
    private $lastName;

    /** @var string */
    private $firstName;

    /** @var string */
    private $address;

    /** @var string */
    private $country;

    /** @var \DateTimeImmutable */
    private $dateOfBirth;

    /** @var string */
    private $placeOfBirth;

    /** @var string */
    private $countryOfBirth;

    /**
     * Passenger constructor.
     * @param string $lastName
     * @param string $firstName
     * @param string $address
     * @param string $country
     * @param \DateTimeImmutable $dateOfBirth
     * @param string $placeOfBirth
     * @param string $countryOfBirth
     */
    public function __construct(
        string $lastName,
        string $firstName,
        string $address,
        string $country,
        \DateTimeImmutable $dateOfBirth,
        string $placeOfBirth,
        string $countryOfBirth
    ) {
        $this->id = Uuid::uuid4();
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->address = $address;
        $this->country = $country;
        $this->dateOfBirth = $dateOfBirth;
        $this->placeOfBirth = $placeOfBirth;
        $this->countryOfBirth = $countryOfBirth;
    }

    public function enterAirportViaGate(Gate $gate)
    {
        $gate->passPassengerToAirport($this);
    }
}
