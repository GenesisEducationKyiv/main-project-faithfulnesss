<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Services\Chain\CoinRateServicesHandlerInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use App\Services\Utilities\Currencies;
use App\Services\Mailing\MailingServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class MailingController extends Controller
{

    public function __construct(
        private CoinRateServicesHandlerInterface $coinRateServiceHandler,
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private MailingServiceInterface $mailingService,
    ) {
    }

    public function sendEmails(): JsonResponse
    {
        $rate = $this->coinRateServiceHandler->getRate(Currencies::BTC, Currencies::UAH);

        $subscriptions = $this->subscriptionRepository->all();

        $this->mailingService->sendEmail($subscriptions, $rate);

        return response()->json(['msg' => 'Emails have been successfully sent'], Response::HTTP_OK);
    }
}
