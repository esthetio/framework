<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    /** @var \Symfony\Component\Serializer\SerializerInterface */
    private SerializerInterface $serializer;

    /**
     * @param  \Symfony\Component\Serializer\SerializerInterface  $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function create(mixed $data): Response
    {
        if ($data instanceof Response) {
            return $data;
        }

        if (is_scalar($data) || is_array($data)) {
            return new JsonResponse($data);
        }

        if (is_object($data)) {
            return new JsonResponse(data: $this->serializer->serialize($data, 'json'), json: true);
        }

        return new Response();
    }
}
