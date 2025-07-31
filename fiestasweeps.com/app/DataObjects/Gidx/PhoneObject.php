<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class PhoneObject
{
    public ?string $phoneNumber;
    public ?string $phoneType;
    public ?string $carrier;
    public ?string $lineType;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->phoneNumber = $data['PhoneNumber'] ?? null;
        $this->phoneType = $data['PhoneType'] ?? null;
        $this->carrier = $data['Carrier'] ?? null;
        $this->lineType = $data['LineType'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
