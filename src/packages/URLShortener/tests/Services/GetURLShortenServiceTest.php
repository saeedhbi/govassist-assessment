<?php

namespace Packages\URLShortener\tests\Services;

use Packages\URLShortener\DTOs\GetURLShortenDTO;
use Packages\URLShortener\Models\URL;
use Packages\URLShortener\Repositories\URLRepository;
use Packages\URLShortener\Services\GetURLShortenService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class GetURLShortenServiceTest extends TestCase
{
    /** @test */
    public function it_can_get_slug_destination(): void
    {
        // Mock the URLRepositoryInterface
        $repositoryMock = $this->createMock(URLRepository::class);

        // Create an instance of the service with the mock
        $service = new GetURLShortenService($repositoryMock);

        // Create a DTO
        $dto = new GetURLShortenDTO();
        $dto->slug = '12345';

        $destination = "https://example.com";

        $entity = new URL([
            'id' => 1,
            'destination' => $destination,
            'slug' => $destination,
            'visits' => 0,
        ]);

        // Mock the findFirstBy method of the repository
        $repositoryMock->expects($this->once())
            ->method('findFirstBy')
            ->willReturn($entity);

        $repositoryMock->expects($this->once())
            ->method('incrementVisits')
            ->willReturnCallback(function () use ($entity) {
                $entity->visits++;

                return $entity;
            });

        // Process the DTO
        $resultDto = $service->process($dto);

        // Assertions
        $this->assertInstanceOf(GetURLShortenDTO::class, $resultDto);
        $this->assertEquals($destination, $resultDto->response);
        $this->assertEquals(1, $entity->visits); // Visits should be incremented
    }

    /** @test */
    public function it_will_throw_error_on_invalid_slug(): void
    {
        // Mock the URLRepository
        $repositoryMock = $this->createMock(URLRepository::class);

        // Create an instance of the service with the mock
        $service = new GetURLShortenService($repositoryMock);

        // Create a DTO
        $dto = new GetURLShortenDTO();
        $dto->slug = '12345';

        // Mock the findFirstBy method of the repository
        $repositoryMock->expects($this->once())
            ->method('findFirstBy')
            ->willReturn(null);

        $repositoryMock->expects($this->never())
            ->method('incrementVisits');

        $this->expectException(NotFoundHttpException::class);

        // Process the DTO
        $service->process($dto);
    }
}
