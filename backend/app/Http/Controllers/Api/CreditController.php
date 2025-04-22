<?php

namespace App\Http\Controllers\Api;

use App\Application\Credit\DTO\IssueCreditDto;
use App\Application\Credit\Service\CreditIssuerService;
use App\Application\Credit\Service\CreditService;
use App\Domain\Client\Repository\ClientRepositoryInterface;
use App\Http\Requests\CheckCreditRequest;
use App\Http\Requests\IssueCreditRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CreditController extends Controller
{
    public function __construct(
        private ClientRepositoryInterface $clientRepo,
        private CreditService $creditService
    ) {}

    public function check(CheckCreditRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $client = $this->clientRepo->findByPin($validated['pin']);

        if (! $client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $result = $this->creditService->check($client);

        return response()->json([
            'approved' => $result->approved,
            'rate' => $result->rate,
            'reasons' => $result->reasons,
        ]);
    }

    public function issue(IssueCreditRequest $request, CreditIssuerService $issuer): JsonResponse
    {
        $validated = $request->validated();

        $dto = new IssueCreditDto(...array_values($validated));
        $credit = $issuer->issue($dto);

        if (! $credit) {
            return response()->json(['approved' => false, 'message' => 'Credit denied.'], 422);
        }

        return response()->json([
            'approved' => true,
            'credit' => [
                'name' => $credit->getName(),
                'amount' => $credit->getAmount(),
                'rate' => round($credit->getRate() * 100, 2).'%',
                'start' => $credit->getStartDate()->format('Y-m-d'),
                'end' => $credit->getEndDate()->format('Y-m-d'),
            ],
        ]);
    }
}
