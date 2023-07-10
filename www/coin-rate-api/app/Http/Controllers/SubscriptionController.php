<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Repositories\SubscriptionRepositoryInterface;
use App\Entities\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;

use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{

    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository
    ) {
    }

    public function store(StoreSubscriptionRequest $request): JsonResponse
    {
        $subscriptions = $this->subscriptionRepository->all();

        $email = $request->input('email');

        if ($subscriptions->contains('email', $email)) {
            return response()->json(['msg' => 'Email is already present',], Response::HTTP_CONFLICT);
        };

        $subscription = new Subscription($email, date("Y-m-d"));

        $this->subscriptionRepository->save($subscriptions->push($subscription));

        return response()->json(['msg' => 'Email successfully created'], Response::HTTP_CREATED);
    }
}
