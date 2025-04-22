<?php

namespace App\Http\Controllers\Api;

use App\Application\Client\DTO\CreateClientDto;
use App\Application\Client\Service\CreateClientService;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function __construct(
        private CreateClientService $service
    ) {}

    public function store(StoreClientRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $dto = new CreateClientDto(...$validated);

        $client = $this->service->create($dto);

        return response()->json(['message' => 'Client created', 'client' => [
            'name' => $client->getName(),
            'age' => $client->getAge(),
            'region' => $client->getRegion(),
        ]], 201);
    }
}
