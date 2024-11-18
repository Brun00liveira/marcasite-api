<?php

namespace App\Repositories;


use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;
use Nette\Utils\Arrays;

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

    public function getAll(int $perPage = 6, $query = null): LengthAwarePaginator | Collection
    {
        // Start the query on subscriptions
        $dataQuery = $this->subscription->with('customer.user');

        // Check if we have a search query for the user name
        if ($query && isset($query['user_name'])) {
            // Filter subscriptions by user name
            $dataQuery->whereHas('customer.user', function ($userQuery) use ($query) {
                $userQuery->where('name', 'like', '%' . $query['user_name'] . '%');
            });
        }

        // If pagination is requested
        if (isset($query['page'])) {
            return $dataQuery->paginate($perPage); // Paginate results
        }

        // Otherwise, return all records (non-paginated)
        return $dataQuery->get();
    }




    public function getCountData(): array
    {
        $data =  $this->subscription->with('customer.user')->get();
        $paymentReceivedCount = $data->where('status', 'PAYMENT_RECEIVED')->count();
        $paymentPedentCount = $this->subscription->where('status', '!=', 'PAYMENT_RECEIVED')->count();


        return [
            'paymentReceivedCount' => $paymentReceivedCount,
            'paymentePedent' => $paymentPedentCount
        ];
    }
}
