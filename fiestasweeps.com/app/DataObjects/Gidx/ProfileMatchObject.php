<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class ProfileMatchObject
{
    public ?bool $firstNameMatch;
    public ?bool $lastNameMatch;
    public ?bool $addressMatch;
    public ?bool $cityMatch;
    public ?bool $stateMatch;
    public ?bool $postalCodeMatch;
    public ?bool $phoneMatch;
    public ?bool $emailMatch;

    public function __construct(array $data)
    {
        $this->firstNameMatch = $data['FirstNameMatch'] ?? null;
        $this->lastNameMatch = $data['LastNameMatch'] ?? null;
        $this->addressMatch = $data['AddressMatch'] ?? null;
        $this->cityMatch = $data['CityMatch'] ?? null;
        $this->stateMatch = $data['StateMatch'] ?? null;
        $this->postalCodeMatch = $data['PostalCodeMatch'] ?? null;
        $this->phoneMatch = $data['PhoneMatch'] ?? null;
        $this->emailMatch = $data['EmailMatch'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
