<?php

declare(strict_types=1);

namespace Esthetio\Tests\Dispatcher;

use Esthetio\Dispatcher\ResponseFactory;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseFactoryTest extends TestCase
{

    /**
     * @dataProvider creationProvider
     */
    public function testCreate($data, $expected): void
    {
        $responseFactory = new ResponseFactory($this->createMock(SerializerInterface::class));

        $this->assertEquals($expected, $responseFactory->create($data));
    }

    public function testSerializedCreate(): void
    {
        $data = $this->createMock(stdClass::class);

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($data, 'json')
            ->willReturn('["serialized"]');

        $responseFactory = new ResponseFactory($serializer);

        $this->assertEquals(new JsonResponse('["serialized"]', json: true), $responseFactory->create($data));
    }

    public function creationProvider(): array
    {
        $response = $this->createMock(Response::class);

        return [
            [$response, $response],
            ['str', new JsonResponse('str')],
            [['el1', 'el2'], new JsonResponse(['el1', 'el2'])],
        ];
    }
}
