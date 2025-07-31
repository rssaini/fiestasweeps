<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class EducationObject
{
    public ?string $startDate;
    public ?string $endDate;
    public ?string $institution;
    public ?string $degree;
    public ?float $confidenceScore;

    public function __construct(array $data)
    {
        $this->startDate = $data['StartDate'] ?? null;
        $this->endDate = $data['EndDate'] ?? null;
        $this->institution = $data['Institution'] ?? null;
        $this->degree = $data['Degree'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
