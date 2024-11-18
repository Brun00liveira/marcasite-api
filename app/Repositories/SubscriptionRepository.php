<?php

namespace App\Repositories;


use App\Models\Subscription;

class SubscriptionRepository
{
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function create(array $data): Subscription
    {
        return $this->subscription->create($data);
    }

    public function findSubscriptionBypaymentId(string $paymentId): ?Subscription
    {
        return $this->subscription->where('payment_id', $paymentId)->first();
    }


    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update($data);
        return $subscription;
    }
}
