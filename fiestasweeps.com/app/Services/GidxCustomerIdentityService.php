<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\DataObjects\Gidx\GidxResponse;
use Exception;

class GidxCustomerIdentityService
{
    private $baseUrl;
    private $apiKey;
    private $merchantId;
    private $productId;
    private $deviceId;
    private $activityId;

    public function __construct()
    {
        $this->baseUrl = config('gidx.base_url');
        $this->apiKey = config('gidx.api_key');
        $this->merchantId = config('gidx.merchant_id');
        $this->productId = config('gidx.product_id');
        $this->deviceId = config('gidx.device_id');
        $this->activityId = config('gidx.activity_id');
    }



    /**
     * Register customer within GIDX system and verify identity
     */
    public function customerRegistration(array $customerData): GidxResponse
    {
        $url = $this->baseUrl . '/CustomerIdentity/CustomerRegistration';
        $requestData = $this->buildStandardizedRequest($customerData, [
            'MerchantCustomerID' => 'merchant_customer_id',
            'Salutation' => 'salutation',
            'FirstName' => 'first_name',
            'MiddleName' => 'middle_name',
            'LastName' => 'last_name',
            'Suffix' => 'suffix',
            'FullName' => 'full_name',
            'DateOfBirth' => 'date_of_birth',
            'EmailAddress' => 'email_address',
            'CitizenshipCountryCode' => 'citizenship_country_code',
            'IdentificationTypeCode' => 'identification_type_code',
            'IdentificationNumber' => 'identification_number',
            'MobilePhoneNumber' => 'mobile_phone_number',
            'PhoneNumber' => 'phone_number',
            'AddressLine1' => 'address_line_1',
            'AddressLine2' => 'address_line_2',
            'City' => 'city',
            'StateCode' => 'state_code',
            'PostalCode' => 'postal_code',
            'CountryCode' => 'country_code',
            'CustomerIpAddressCountryCode' => 'customer_ip_address_country_code',
        ]);

        return $this->makeRequest($url, $requestData, 'CustomerRegistration');
    }

    /**
     * Get profile information for verified customer
     */
    public function customerProfile(string $merchantCustomerId): GidxResponse
    {
        $url = $this->baseUrl . '/CustomerIdentity/CustomerProfile';
        $requestData = $this->buildStandardizedRequest([
            'merchant_customer_id' => $merchantCustomerId
        ], [
            'MerchantCustomerID' => 'merchant_customer_id'
        ]);

        return $this->makeRequest($url, $requestData, 'CustomerProfile');
    }

    /**
     * Get compliance status of customer profile
     */
    public function customerCompliance(string $merchantCustomerId, array $complianceFilters = []): GidxResponse
    {
        $url = $this->baseUrl . '/CustomerIdentity/CustomerCompliance';
        $requestData = $this->buildStandardizedRequest([
            'merchant_customer_id' => $merchantCustomerId,
            'compliance_filters' => $complianceFilters
        ], [
            'MerchantCustomerID' => 'merchant_customer_id',
            'ComplianceFilters' => 'compliance_filters'
        ]);

        return $this->makeRequest($url, $requestData, 'CustomerCompliance');
    }

    /**
     * Update customer information
     */
    public function customerUpdate(array $customerData): GidxResponse
    {
        $url = $this->baseUrl . '/CustomerIdentity/CustomerUpdate';
        $requestData = $this->buildStandardizedRequest($customerData, [
            'MerchantCustomerID' => 'merchant_customer_id',
            'ForceIDVerified' => 'force_id_verified',
            'ForceIDBlock' => 'force_id_block',
            'Salutation' => 'salutation',
            'FirstName' => 'first_name',
            'MiddleName' => 'middle_name',
            'LastName' => 'last_name',
            'Suffix' => 'suffix',
            'FullName' => 'full_name',
            'DateOfBirth' => 'date_of_birth',
            'EmailAddress' => 'email_address',
            'CitizenshipCountryCode' => 'citizenship_country_code',
            'IdentificationTypeCode' => 'identification_type_code',
            'IdentificationNumber' => 'identification_number',
            'MobilePhoneNumber' => 'mobile_phone_number',
            'PhoneNumber' => 'phone_number',
            'AddressLine1' => 'address_line_1',
            'AddressLine2' => 'address_line_2',
            'City' => 'city',
            'StateCode' => 'state_code',
            'PostalCode' => 'postal_code',
            'CountryCode' => 'country_code',
        ]);

        return $this->makeRequest($url, $requestData, 'CustomerUpdate');
    }

    /**
     * Remove customer from merchant account
     */
    public function customerRemove(string $merchantCustomerId): GidxResponse
    {
        $url = $this->baseUrl . '/CustomerIdentity/CustomerRemove';
        $requestData = $this->buildStandardizedRequest([
            'merchant_customer_id' => $merchantCustomerId
        ], [
            'MerchantCustomerID' => 'merchant_customer_id'
        ]);

        return $this->makeRequest($url, $requestData, 'CustomerRemove');
    }

    /**
     * Location lookup based on IP address/Device GPS
     */
    public function locationRequest(array $locationData): GidxResponse
    {
        $url = $this->baseUrl . '/CustomerIdentity/LocationRequest';
        $requestData = $this->buildStandardizedRequest($locationData, [
            'MerchantCustomerID' => 'merchant_customer_id',
            'DeviceGPS' => 'device_gps'
        ]);

        return $this->makeRequest($url, $requestData, 'LocationRequest');
    }

    /**
     * Build standardized request with common parameters
     */
    private function buildStandardizedRequest(array $data, array $fieldMapping): array
    {
        $request = [
            'ApiKey' => $this->apiKey,
            'MerchantID' => $this->merchantId,
            'ProductTypeID' => $this->productId,
            'DeviceTypeID' => $this->deviceId,
            'ActivityTypeID' => $this->activityId,
            'MerchantSessionID' => $data['merchant_session_id'] ?? $this->merchantSessionId ?? uniqid('gidx_'),
            'DeviceIpAddress' => $this->activityTypeId,
            'DeviceGPS' => [
                'Latitude' => 0,
                'Longitude' => 0,
                'Radius' => 0,
                'Altitude' => 0,
                'Speed' => 0,
                'DateTime' => '',
            ],
        ];

        foreach ($fieldMapping as $gidxField => $dataField) {
            if (isset($data[$dataField]) && $data[$dataField] !== null && $data[$dataField] !== '') {
                $request[$gidxField] = $data[$dataField];
            }
        }

        return $request;
    }

    /**
     * Make HTTP request to GIDX API
     */
    private function makeRequest(string $url, array $requestData, string $method): GidxResponse
    {
        try {
            if (config('gidx.log_requests', false)) {
                Log::info("GIDX {$method} Request", ['url' => $url, 'data' => $requestData]);
            }

            $response = Http::timeout(config('gidx.timeout', 30))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($url, $requestData);

            if (config('gidx.log_responses', false)) {
                Log::info("GIDX {$method} Response", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }

            if ($response->successful()) {
                return new GidxResponse($response->json(), true, $method);
            } else {
                Log::error("GIDX {$method} Failed", [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                return new GidxResponse(
                    json_decode($response->body(), true) ?: [],
                    false,
                    $method,
                    $response->status()
                );
            }
        } catch (Exception $e) {
            Log::error("GIDX {$method} Exception", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("GIDX {$method} request failed: " . $e->getMessage());
        }
    }


    /**
     * Handle profile notification webhook
     */
    public function handleProfileNotification(array $notificationData): array
    {
        try {
            // Log the notification
            Log::info('GIDX Profile Notification Received', $notificationData);

            // Validate notification structure
            if (!isset($notificationData['MerchantCustomerID']) || !isset($notificationData['NotificationType'])) {
                throw new Exception('Invalid notification structure');
            }

            // Process notification based on type
            $merchantCustomerId = $notificationData['MerchantCustomerID'];
            $notificationType = $notificationData['NotificationType'];

            // You can add custom logic here to handle different notification types
            // For example, update local database, trigger events, etc.

            return [
                'success' => true,
                'merchant_customer_id' => $merchantCustomerId,
                'notification_type' => $notificationType,
                'processed_at' => now()->toISOString()
            ];

        } catch (Exception $e) {
            Log::error('GIDX Profile Notification Error', [
                'message' => $e->getMessage(),
                'data' => $notificationData
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
