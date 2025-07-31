<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class SocialMediaObject
{
    public ?string $socialMediaId;
    public ?string $socialMediaType;
    public ?float $confidenceScore;

    public function __construct(array $data)
    {
        $this->socialMediaId = $data['SocialMediaId'] ?? null;
        $this->socialMediaType = $data['SocialMediaType'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
