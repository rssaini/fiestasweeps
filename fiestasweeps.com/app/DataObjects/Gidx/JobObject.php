<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class JobObject
{
    public ?string $startDate;
    public ?string $endDate;
    public ?string $employer;
    public ?string $position;
    public ?string $industry;
    public ?float $confidenceScore;

    public function __construct(array $data)
    {
        $this->startDate = $data['StartDate'] ?? null;
        $this->endDate = $data['EndDate'] ?? null;
        $this->employer = $data['Employer'] ?? null;
        $this->position = $data['Position'] ?? null;
        $this->industry = $data['Industry'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
