<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class NameObject
{
    public ?string $salutation;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $middleName;
    public ?string $suffix;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->salutation = $data['Salutation'] ?? null;
        $this->firstName = $data['FirstName'] ?? null;
        $this->lastName = $data['LastName'] ?? null;
        $this->middleName = $data['MiddleName'] ?? null;
        $this->suffix = $data['Suffix'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
