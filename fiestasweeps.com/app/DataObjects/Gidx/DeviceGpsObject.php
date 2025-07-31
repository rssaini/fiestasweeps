<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

class DeviceGpsObject
{
    public ?float $latitude;
    public ?float $longitude;
    public ?float $radius;
    public ?float $altitude;
    public ?float $speed;
    public ?string $dateTime;

    public function __construct(array $data)
    {
        $this->latitude = $data['Latitude'] ?? null;
        $this->longitude = $data['Longitude'] ?? null;
        $this->radius = $data['Radius'] ?? null;
        $this->altitude = $data['Altitude'] ?? null;
        $this->speed = $data['Speed'] ?? null;
        $this->dateTime = $data['DateTime'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}
