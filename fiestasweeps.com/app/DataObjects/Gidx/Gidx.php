<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

/**
 * Main GIDX Response wrapper
 */
class GidxResponse
{
    public bool $isSuccess;
    public string $responseCode;
    public string $responseMessage;
    public ?string $merchantCustomerId;
    public array $watchChecks;
    public array $reasonCodes;
    public ?LocationDetailObject $locationDetail;
    public ?ProfileMatchObject $profileMatch;
    public ?string $customerRegistrationLink;
    public ?float $identityConfidenceScore;
    public ?float $fraudConfidenceScore;
    public array $rawResponse;
    public string $method;
    public ?int $httpStatus;

    // Profile-specific objects
    public ?AddressObject $addressObject;
    public ?CitizenshipObject $citizenshipObject;
    public ?DeviceObject $deviceObject;
    public ?EducationObject $educationObject;
    public ?EmailObject $emailObject;
    public ?IdentityDocumentObject $identityDocumentObject;
    public ?JobObject $jobObject;
    public ?NameObject $nameObject;
    public ?PhoneObject $phoneObject;
    public ?SocialMediaObject $socialMediaObject;
    public ?WatchObject $watchObject;

    public function __construct(array $responseData, bool $success = true, string $method = '', int $httpStatus = null)
    {
        $this->isSuccess = $success && ($responseData['ResponseCode'] ?? '') === 'SUCCESS';
        $this->responseCode = $responseData['ResponseCode'] ?? '';
        $this->responseMessage = $responseData['ResponseMessage'] ?? '';
        $this->merchantCustomerId = $responseData['MerchantCustomerID'] ?? null;
        $this->watchChecks = $responseData['WatchChecks'] ?? [];
        $this->reasonCodes = $responseData['ReasonCodes'] ?? [];
        $this->customerRegistrationLink = $responseData['CustomerRegistrationLink'] ?? null;
        $this->identityConfidenceScore = $responseData['IdentityConfidenceScore'] ?? null;
        $this->fraudConfidenceScore = $responseData['FraudConfidenceScore'] ?? null;
        $this->rawResponse = $responseData;
        $this->method = $method;
        $this->httpStatus = $httpStatus;

        // Parse complex objects
        $this->locationDetail = isset($responseData['LocationDetail'])
            ? new LocationDetailObject($responseData['LocationDetail'])
            : null;

        $this->profileMatch = isset($responseData['ProfileMatch'])
            ? new ProfileMatchObject($responseData['ProfileMatch'])
            : null;

        // Parse profile objects
        $this->addressObject = isset($responseData['AddressObject'])
            ? new AddressObject($responseData['AddressObject'])
            : null;

        $this->citizenshipObject = isset($responseData['CitizenshipObject'])
            ? new CitizenshipObject($responseData['CitizenshipObject'])
            : null;

        $this->deviceObject = isset($responseData['DeviceObject'])
            ? new DeviceObject($responseData['DeviceObject'])
            : null;

        $this->educationObject = isset($responseData['EducationObject'])
            ? new EducationObject($responseData['EducationObject'])
            : null;

        $this->emailObject = isset($responseData['EmailObject'])
            ? new EmailObject($responseData['EmailObject'])
            : null;

        $this->identityDocumentObject = isset($responseData['IdentityDocumentObject'])
            ? new IdentityDocumentObject($responseData['IdentityDocumentObject'])
            : null;

        $this->jobObject = isset($responseData['JobObject'])
            ? new JobObject($responseData['JobObject'])
            : null;

        $this->nameObject = isset($responseData['NameObject'])
            ? new NameObject($responseData['NameObject'])
            : null;

        $this->phoneObject = isset($responseData['PhoneObject'])
            ? new PhoneObject($responseData['PhoneObject'])
            : null;

        $this->socialMediaObject = isset($responseData['SocialMediaObject'])
            ? new SocialMediaObject($responseData['SocialMediaObject'])
            : null;

        $this->watchObject = isset($responseData['WatchObject'])
            ? new WatchObject($responseData['WatchObject'])
            : null;
    }

    public function toArray(): array
    {
        return [
            'is_success' => $this->isSuccess,
            'response_code' => $this->responseCode,
            'response_message' => $this->responseMessage,
            'merchant_customer_id' => $this->merchantCustomerId,
            'watch_checks' => $this->watchChecks,
            'reason_codes' => $this->reasonCodes,
            'location_detail' => $this->locationDetail?->toArray(),
            'profile_match' => $this->profileMatch?->toArray(),
            'customer_registration_link' => $this->customerRegistrationLink,
            'identity_confidence_score' => $this->identityConfidenceScore,
            'fraud_confidence_score' => $this->fraudConfidenceScore,
            'method' => $this->method,
            'http_status' => $this->httpStatus,
        ];
    }
}

/**
 * Address Object
 */
class AddressObject
{
    public ?string $addressType;
    public ?string $addressLine1;
    public ?string $addressLine2;
    public ?string $city;
    public ?string $stateCode;
    public ?string $county;
    public ?string $postalCode;
    public ?string $countryCode;
    public ?string $region;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->addressType = $data['AddressType'] ?? null;
        $this->addressLine1 = $data['AddressLine1'] ?? null;
        $this->addressLine2 = $data['AddressLine2'] ?? null;
        $this->city = $data['City'] ?? null;
        $this->stateCode = $data['StateCode'] ?? null;
        $this->county = $data['County'] ?? null;
        $this->postalCode = $data['PostalCode'] ?? null;
        $this->countryCode = $data['CountryCode'] ?? null;
        $this->region = $data['Region'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

/**
 * Citizenship Object
 */
class CitizenshipObject
{
    public ?string $citizenshipCountry;
    public ?string $dateOfBirth;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->citizenshipCountry = $data['CitizenshipCountry'] ?? null;
        $this->dateOfBirth = $data['DateOfBirth'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

/**
 * Device Object
 */
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

/**
 * Education Object
 */
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

/**
 * Email Object
 */
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

/**
 * Identity Document Object
 */
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

/**
 * Job Object
 */
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

/**
 * Name Object
 */
class NameObject
{
    public ?string $salutation;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $middleName;
    public ?string $suffix;
    public ?float $confidenceScore;
    public ?bool $verified;

    public function __construct(array $data)
    {
        $this->salutation = $data['Salutation'] ?? null;
        $this->firstName = $data['FirstName'] ?? null;
        $this->lastName = $data['LastName'] ?? null;
        $this->middleName = $data['MiddleName'] ?? null;
        $this->suffix = $data['Suffix'] ?? null;
        $this->confidenceScore = $data['ConfidenceScore'] ?? null;
        $this->verified = $data['Verified'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

/**
 * Phone Object
 */
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

/**
 * Profile Match Object
 */
class ProfileMatchObject
{
    public ?bool $firstNameMatch;
    public ?bool $lastNameMatch;
    public ?bool $addressMatch;
    public ?bool $cityMatch;
    public ?bool $stateMatch;
    public ?bool $postalCodeMatch;
    public ?bool $phoneMatch;
    public ?bool $emailMatch;

    public function __construct(array $data)
    {
        $this->firstNameMatch = $data['FirstNameMatch'] ?? null;
        $this->lastNameMatch = $data['LastNameMatch'] ?? null;
        $this->addressMatch = $data['AddressMatch'] ?? null;
        $this->cityMatch = $data['CityMatch'] ?? null;
        $this->stateMatch = $data['StateMatch'] ?? null;
        $this->postalCodeMatch = $data['PostalCodeMatch'] ?? null;
        $this->phoneMatch = $data['PhoneMatch'] ?? null;
        $this->emailMatch = $data['EmailMatch'] ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

/**
 * Social Media Object
 */
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

/**
 * Watch Object
 */
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

/**
 * Location Detail Object
 */
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

/**
 * Device GPS Object for location requests
 */
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
