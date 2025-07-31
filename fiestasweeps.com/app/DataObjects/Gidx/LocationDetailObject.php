<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class LocationDetailObject
{
    public ?float $latitude;
    public ?float $longitude;
    public ?float $radius;
    public ?float $altitude;
    public ?float $speed;
    public ?string $dateTime;
    public ?int $deviceGpsAccuracy;
    public ?string $locationType;
    public array $reasonCodes;
    public ?bool $verified;
    public ?string $status;

    public function __construct(array $data)
    {
        $this->latitude = $data['Latitude'] ?? null;
        $this->longitude = $data['Longitude'] ?? null;
        $this->radius = $data['Radius'] ?? null;
        $this->altitude = $data['Altitude'] ?? null;
        $this->speed = $data['Speed'] ?? null;
        $this->dateTime = $data['DateTime'] ?? null;
        $this->deviceGpsAccuracy = $data['DeviceGpsAccuracy'] ?? null;
        $this->locationType = $data['LocationType'] ?? null;
        $this->reasonCodes = $data['ReasonCodes'] ?? [];
        $this->verified = $data['Verified'] ?? null;
        $this->status = $data['Status'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
