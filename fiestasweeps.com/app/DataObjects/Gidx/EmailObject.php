<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class EmailObject
{
    public ?string $emailAddress;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->emailAddress = $data['EmailAddress'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
