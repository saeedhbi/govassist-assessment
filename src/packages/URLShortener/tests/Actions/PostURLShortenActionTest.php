<?php

namespace Packages\URLShortener\tests\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Packages\URLShortener\Actions\PostURLShortenAction;
use Packages\URLShortener\DTOs\PostURLShortenDTO;
use Packages\URLShortener\Responders\PostURLShortenResponder;
use Packages\URLShortener\Services\PostURLShortenService;
use Tests\TestCase;

class PostURLShortenActionTest extends TestCase
{
    /** @test */
    public function it_can_shorten_url_and_respond_with_json(): void
    {
        // Mocking dependencies
        $serviceMock = $this->createMock(PostURLShortenService::class);
        $responderMock = $this->createMock(PostURLShortenResponder::class);

        $dto = new PostURLShortenDTO();
        $dto->destination = 'https://example.com';

        $serviceMock->expects($this->once())
            ->method('process')
            ->with($this->equalTo($dto))
            ->willReturn($dto);

        $slug = Str::random(5);

        $responderMock->expects($this->once())
            ->method('response')
            ->with($this->equalTo($dto))
            ->willReturn(new JsonResponse([
                'id' => 1,
                'destination' => $dto->destination,
                'slug' => $slug,
                'shortened_url' => URL::to($slug),
                'created_at' => Carbon::now()
            ]));

        // Creating action instance with mocked dependencies
        $action = new PostURLShortenAction($serviceMock, $responderMock);

        // Creating request mock with input data
        $request = Request::create('/shorten', 'POST', ['destination' => 'https://example.com']);

        $response = $action->__invoke($request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertObjectHasProperty('shortened_url', $response->getData());
        $this->assertEquals(URL::to($slug), $response->getData()->shortened_url);
    }

    /** @test */
    public function it_validates_request_data(): void
    {
        // Creating action instance
        $action = new PostURLShortenAction(
            $this->createMock(PostURLShortenService::class),
            $this->createMock(PostURLShortenResponder::class)
        );

        // Creating request mock with invalid input data
        $request = Request::create('/shorten', 'POST', ['destination' => 'invalid_url']);

        $this->expectException(ValidationException::class);

        // Triggering the action should throw a validation exception
        $action->__invoke($request);
    }
}
