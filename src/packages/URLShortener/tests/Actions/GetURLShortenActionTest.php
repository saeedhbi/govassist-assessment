<?php

namespace Packages\URLShortener\tests\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Packages\URLShortener\Actions\GetURLShortenAction;
use Packages\URLShortener\DTOs\GetURLShortenDTO;
use Packages\URLShortener\Responders\GetURLShortenResponder;
use Packages\URLShortener\Services\GetURLShortenService;
use Tests\TestCase;

class GetURLShortenActionTest extends TestCase
{
    /** @test */
    public function it_can_redirect_on_valid_slug(): void
    {
        // Mocking dependencies
        $serviceMock = $this->createMock(GetURLShortenService::class);
        $responderMock = $this->createMock(GetURLShortenResponder::class);

        $dto = new GetURLShortenDTO();
        $dto->slug = '12345';
        $destination = 'https://example.com';

        $serviceMock->expects($this->once())
            ->method('process')
            ->with($this->equalTo($dto))
            ->willReturn($dto);

        $responderMock->expects($this->once())
            ->method('response')
            ->with($this->equalTo($dto))
            ->willReturn(redirect($destination));

        // Creating action instance with mocked dependencies
        $action = new GetURLShortenAction($serviceMock, $responderMock);

        // Creating request mock with input data
        $request = Request::create($dto->slug);

        $response = $action->__invoke($request);

        // Assertions
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals($destination, $response->getTargetUrl());
    }
}
