<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Notifications\CoinRateNotification;
use App\Services\CoinRateServiceInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use App\Entities\Subscription;
use App\Services\Utilities\Currencies;
use App\Http\Requests\StoreSubscriptionRequest;

use Symfony\Component\HttpFoundation\Response;

/**
 * SubscriptionController
 */
class SubscriptionController extends Controller
{

    public function __construct(
        private CoinRateServiceInterface $coinRateService,
        private SubscriptionRepositoryInterface $subscriptionRepository
    ) { }
    
    public function store(StoreSubscriptionRequest $request) : JsonResponse
    {    
        // Load subscriptions from source
        $subscriptions = $this->subscriptionRepository->all();

        // Get the email from the request
        $email = $request->input('email');

        // Check if the email is already present in the source
        if ($this->subscriptionRepository->exists($email)) {
            return response()->json(['msg' => 'Email is already present',], Response::HTTP_CONFLICT);
        }  

        // Create a new Subscription instance and push it in the source
        $subscription = new Subscription($email, date("Y-m-d"));
        
        $this->subscriptionRepository->save($subscriptions->push($subscription));

        return response()->json(['msg' => 'Email successfully created'], Response::HTTP_CREATED);
    }
    
    public function sendEmails() : JsonResponse
    {
        // Get the current rate from the service
        $rate = $this->coinRateService->getRate(Currencies::BTC, Currencies::UAH);

        // Load the subscriptions from storage
        $subscriptions = $this->subscriptionRepository->all();
        
        // Send notifications to all emails that are present inside the source
        // with the current coin rate using Notification facade    
        Notification::send($subscriptions, new CoinRateNotification($rate));

        return response()->json(['msg' => 'Emails have been successfully sent'], Response::HTTP_OK);
    }
}
