<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class IdentityDocumentObject
{
    public ?string $identificationTypeCode;
    public ?string $identificationNumber;
    public ?string $issuingLocation;
    public ?string $expirationDate;
    public ?string $fullName;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->identificationTypeCode = $data['IdentificationTypeCode'] ?? null;
        $this->identificationNumber = $data['IdentificationNumber'] ?? null;
        $this->issuingLocation = $data['IssuingLocation'] ?? null;
        $this->expirationDate = $data['ExpirationDate'] ?? null;
        $this->fullName = $data['FullName'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
