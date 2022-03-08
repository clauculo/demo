<?php

namespace App\Controller;

use App\Entity\User;
use App\Transformer\UserTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UserNewController
{
    #[Route(path: '/api/v2/users/{user}', name: 'users.get_new', methods: ['GET'])]
    public function getUser(User $user, UserTransformer $transformer)
    {
        return new JsonResponse($transformer->transform($user), 200, []);
    }
}