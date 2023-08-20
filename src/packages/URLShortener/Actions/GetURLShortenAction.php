<?php

namespace Packages\URLShortener\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Packages\URLShortener\DTOs\GetURLShortenDTO;
use Packages\URLShortener\Responders\GetURLShortenResponder;
use Packages\URLShortener\Services\GetURLShortenService;

class GetURLShortenAction
{
    public function __construct(
        public readonly GetURLShortenService   $getURLShortenService,
        public readonly GetURLShortenResponder $getURLShortenResponder
    )
    {
    }

    /**
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function __invoke(Request $request): RedirectResponse|JsonResponse
    {
        $dto = new GetURLShortenDTO();

        $dto->slug = $request->path();

        $dto = $this->getURLShortenService->process($dto);

        return $this->getURLShortenResponder->response($dto);
    }
}
