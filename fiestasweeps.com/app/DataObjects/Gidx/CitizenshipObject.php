<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class CitizenshipObject
{
    public ?string $citizenshipCountry;
    public ?string $dateOfBirth;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->citizenshipCountry = $data['CitizenshipCountry'] ?? null;
        $this->dateOfBirth = $data['DateOfBirth'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
