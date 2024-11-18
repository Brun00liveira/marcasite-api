<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;

class AsaasIntegration
{
    protected string $apiUrl;
    protected string $accessToken;

    public function __construct()
    {
        $this->apiUrl = env('ASAAS_URL', 'https://www.asaas.com/api/v3');
        $this->accessToken = env('ASAAS_ACCESS_TOKEN');
    }

    public function createCustomer(array $data): array
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'access_token' => $this->accessToken,
        ])->post("{$this->apiUrl}customers", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => $response->body(),
        ];
    }

    public function updateCustomer(string $asaasId, array $data): array
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'access_token' => $this->accessToken,
        ])->put("{$this->apiUrl}customers/" . $asaasId, $data);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => $response->body(),
        ];
    }
    //não vou usar, pois não sei o impacto que é deletar uma conta do asaas, não sei se é softdelete

    public function deleteCustomer(string $asaasId): array
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'access_token' => $this->accessToken,
        ])->delete("{$this->apiUrl}customers/" . $asaasId);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => $response->body(),
        ];
    }
}
