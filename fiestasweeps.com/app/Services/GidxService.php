<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\DataObjects\Gidx\GidxResponse;
use Exception;

class GidxService
{
    private $baseUrl;
    private $apiKey;
    private $merchantId;
    private $productId;
    private $deviceId;
    private $activityId;
    private $timeout;

    public function __construct() {
        $this->baseUrl = config('gidx.base_url');
        $this->apiKey = config('gidx.api_key');
        $this->merchantId = config('gidx.merchant_id');
        $this->productId = config('gidx.product_id');
        $this->deviceId = config('gidx.device_id');
        $this->activityId = config('gidx.activity_id');
        $this->timeout = config('gidx.timeout', 30);
    }

    public function customerRegistration(array $customerData) {
        $url = '/CustomerIdentity/CustomerRegistration';
        return $this->requestToGidx($url, $customerData, 'post');
    }

    public function customerProfile(array $customerData) {
        $url = '/CustomerIdentity/CustomerProfile';
        return $this->requestToGidx($url, $customerData, 'get');
    }

    public function customerMonitor(string $merchantCustomerId, array $complianceFilters = []) {
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

    public function customerUpdate(array $customerData){
        $url = '/CustomerIdentity/CustomerUpdate';
        return $this->requestToGidx($url, $customerData, 'post');
    }

    public function removeCustomer(){}

    public function documentRegistration(){}

    public function customerDocuments(){}

    public function downloadDocument(){}

    public function createSession($data){
        $url = '/DirectCashier/CreateSession';
        return $this->requestToGidx($url, $data, 'post');
    }

    public function completeSession($data){
        $url = '/DirectCashier/CompleteSession';
        return $this->requestToGidx($url, $data, 'post');
    }

    public function sessionCallback(){}

    public function paymentDetail(){}

    public function paymentUpdate(){}

    public function savePaymentMethod(){}

    private function requestToGidx(string $url, array $data, string $method){
        try{
            $http = Http::timeout($this->timeout)->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);
            $url = $this->baseUrl . $url;
            $request = [
                'ApiKey' => $this->apiKey,
                'MerchantID' => $this->merchantId,
                'ProductTypeID' => $this->productId,
                'DeviceTypeID' => $this->deviceId,
                'ActivityTypeID' => $this->activityId
            ];

            $requestData = array_merge($request, $data);

            $response = null;
            if($method == 'post'){
                $response = $http->post($url, $requestData);
            } else {
                if($method == 'get'){
                    $response = $http->get($url, $requestData);
                }
            }
            if($response != null){
                if($response->successful()){
                    return $response->json();
                } else {
                    Log::error("GIDX Request Failed", [
                        'status' => $response->status(),
                        'response' => $response->body()
                    ]);
                    return null;
                }
            }
        }catch(Exception $e){
            Log::error("GIDX Exception", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
}
