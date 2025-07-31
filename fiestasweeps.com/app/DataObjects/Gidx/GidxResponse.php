<?php

namespace App\DataObjects\Gidx;

use Illuminate\Support\Collection;

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
