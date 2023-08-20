<?php

namespace Packages\URLShortener\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Packages\URLShortener\DTOs\PostURLShortenDTO;
use Packages\URLShortener\Responders\PostURLShortenResponder;
use Packages\URLShortener\Services\PostURLShortenService;

class PostURLShortenAction
{
    public function __construct(
        public readonly PostURLShortenService   $postURLShortenService,
        public readonly PostURLShortenResponder $postURLShortenResponder
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->_validate($request);

            $dto = new PostURLShortenDTO();

            $dto->destination = $request->input('destination');

            $dto = $this->postURLShortenService->process($dto);

            return $this->postURLShortenResponder->response($dto);
        } catch (\Exception $exception) {
            return $this->postURLShortenResponder->error($exception);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    protected function _validate(Request $request): void
    {
        $request->validate([
            'destination' => ['required', 'url'],
        ]);
    }
}
