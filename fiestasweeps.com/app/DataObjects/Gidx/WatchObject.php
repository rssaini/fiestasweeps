<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class WatchObject
{
    public ?string $watchListType;
    public ?float $confidenceScore;
    public ?bool $verified;
    public ?float $matchScore;

    public function __construct(array $data)
    {
        $this->watchListType = $data['WatchListType'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
        $this->matchScore = $data['MatchScore'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
