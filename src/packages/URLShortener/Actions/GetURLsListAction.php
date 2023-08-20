<?php

namespace Packages\URLShortener\Actions;

use Illuminate\Http\JsonResponse;
use Inertia\Response;
use Illuminate\Http\Request;
use Packages\URLShortener\DTOs\GetURLsListDTO;
use Packages\URLShortener\Responders\GetURLsListResponder;
use Packages\URLShortener\Services\GetURLsListService;

class GetURLsListAction
{
    public function __construct(
        public readonly GetURLsListService   $getURLsListService,
        public readonly GetURLsListResponder $getURLsListResponder
    )
    {
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function __invoke(Request $request): Response|JsonResponse
    {
        $dto = new GetURLsListDTO();

        $dto = $this->getURLsListService->process($dto);

        return $this->getURLsListResponder->response($dto);
    }
}
