<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class DeviceObject
{
    public ?string $deviceFingerprintId;
    public ?string $operatingSystem;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->deviceFingerprintId = $data['DeviceFingerprintId'] ?? null;
        $this->operatingSystem = $data['OperatingSystem'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
