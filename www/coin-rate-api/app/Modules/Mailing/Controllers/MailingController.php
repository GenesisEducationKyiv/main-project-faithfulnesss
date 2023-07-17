<?php

namespace App\Modules\Mailing\Controllers;

use Illuminate\Http\JsonResponse;

use App\Modules\CoinRate\Chain\CoinRateServicesHandlerInterface;
use App\Modules\Subscription\Repositories\SubscriptionRepositoryInterface;
use App\Modules\CoinRate\Utilities\Currencies;
use App\Modules\Mailing\Services\MailingServiceInterface;

use App\Http\Controllers\Controller;
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
