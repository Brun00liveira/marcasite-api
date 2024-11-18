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

    public function createPayment(array $data): array
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'access_token' => $this->accessToken,
        ])->post("{$this->apiUrl}/payments", $data);

        if ($response->successful()) {
            return $response->json();  // Retorna o pagamento criado com sucesso
        }

        // Caso haja erro
        return [
            'error' => true,
            'message' => $response->body(),
        ];
    }
}
