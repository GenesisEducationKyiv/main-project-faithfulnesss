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

use Symfony\Component\HttpFoundation\Response;

/**
 * SubscriptionController
 */
class SubscriptionController extends Controller
{

    private $coinRateService;
    private $subscriptionRepository;

    public function __construct(
        CoinRateServiceInterface $coinRateService,
        SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->coinRateService = $coinRateService;
        $this->subscriptionRepository = $subscriptionRepository;
    }
    
    public function store(Request $request) : JsonResponse
    {    
        // Validate whether the email is valid
        $validator = Validator::make(
            $request->all(), [
            'email' => 'required|email',
            ]
        );

        // Return a conflict response if email is not valid
        if ($validator->fails()) {
            return response()->json(['msg' => 'Failed email validation',], Response::HTTP_CONFLICT);
        }

        // Load subscriptions from source
        $subscriptions = $this->subscriptionRepository->all();

        // Get the email from the request
        $email = $request->input('email');

        // Check if the email is already present in the source
        if ($subscriptions->contains('email', $email)) {
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
