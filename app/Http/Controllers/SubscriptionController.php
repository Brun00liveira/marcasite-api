<?php

namespace App\Http\Controllers;

use App\Http\Resources\StandardResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SubscriptionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function asaasWebhook(Request $request): JsonResponse
    {
        $body = $request->all();

        // Verifica se o campo 'event' e 'payment' estão presentes
        if (!isset($body['event'], $body['payment'])) {
            Log::warning('Webhook recebido com dados incompletos', $body);
            return response()->json(['error' => 'Dados inválidos'], 400);
        }

        $event = $body['event'];
        $payment = $body['payment'];

        // Lista de eventos aceitos
        $acceptedEvents = [
            'PAYMENT_CREATED',
            'PAYMENT_RECEIVED',
            'PAYMENT_CONFIRMED',
        ];

        if (in_array($event, $acceptedEvents)) {
          
            $result = $this->subscriptionService->createOrUpdatePayment($payment, $event);
            if ($result) {
                return response()->json(['message' => 'Pagamento processado com sucesso'], 200);
            }
            return response()->json(['error' => 'Falha ao processar pagamento'], 500);
        }

        Log::info('Evento não aceito: ' . $event);
        return response()->json(['message' => 'Evento ignorado'], 200);
    }

    public function index(Request $request): StandardResource
    {
        $perPage = $request->query('perPage', 6);

        $subscription = $this->subscriptionService->getAllSubscriptions($perPage, $request->all());

        return new StandardResource($subscription);
    }

    public function findByUserId(): StandardResource
    {
        $courses = $this->subscriptionService->getByUserId();

        return new StandardResource($courses);
    }
}
