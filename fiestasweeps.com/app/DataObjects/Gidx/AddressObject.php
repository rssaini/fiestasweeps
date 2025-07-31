<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class AddressObject
{
    public ?string $addressType;
    public ?string $addressLine1;
    public ?string $addressLine2;
    public ?string $city;
    public ?string $stateCode;
    public ?string $county;
    public ?string $postalCode;
    public ?string $countryCode;
    public ?string $region;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->addressType = $data['AddressType'] ?? null;
        $this->addressLine1 = $data['AddressLine1'] ?? null;
        $this->addressLine2 = $data['AddressLine2'] ?? null;
        $this->city = $data['City'] ?? null;
        $this->stateCode = $data['StateCode'] ?? null;
        $this->county = $data['County'] ?? null;
        $this->postalCode = $data['PostalCode'] ?? null;
        $this->countryCode = $data['CountryCode'] ?? null;
        $this->region = $data['Region'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
