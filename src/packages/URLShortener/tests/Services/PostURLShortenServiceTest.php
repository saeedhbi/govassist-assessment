<?php

namespace Packages\URLShortener\tests\Services;

use Illuminate\Support\Facades\URL as URLAlias;
use Illuminate\Support\Str;
use Packages\URLShortener\DTOs\PostURLShortenDTO;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;
use Packages\URLShortener\Models\URL;
use Packages\URLShortener\Services\PostURLShortenService;
use Tests\TestCase;

class PostURLShortenServiceTest extends TestCase
{
    /** @test */
    public function it_can_process_url_shortening(): void
    {
        // Mock the URLRepositoryInterface
        $repositoryMock = $this->createMock(URLRepositoryInterface::class);

        // Create an instance of the service with the mock
        $service = new PostURLShortenService($repositoryMock);

        // Create a DTO
        $dto = new PostURLShortenDTO();
        $dto->destination = 'https://example.com';

        $slug = Str::random(5);

        // Mock the createEntity method of the repository
        $repositoryMock->expects($this->once())
            ->method('createEntity')
            ->willReturn(new URL([
                'id' => 1,
                'destination' => $dto->destination,
                'slug' => $slug,
                'visits' => 0,
                'shortened_url' => URLAlias::to($slug)
            ]));

        // Process the DTO
        $resultDto = $service->process($dto);

        // Assertions
        $this->assertInstanceOf(PostURLShortenDTO::class, $resultDto);
        $this->assertEquals(URLAlias::to($slug), $resultDto->response->shortened_url);
    }
}
