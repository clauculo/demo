<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController
{
    #[Route(path: '/api/v1/users/{id}', name: 'users.get', methods: ['GET'])]
    public function getUser($id, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $em->getRepository(User::class)->find($id);

        $arr_data = array (
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'account' => 'basic'
        );

        return new JsonResponse($arr_data, 200);
    }



    #[Route(path: '/api/v1/users', name: 'users.create', methods: ['POST'])]
    public function createUser(EntityManagerInterface $em)
    {
        $user = new User();
        $user->setFirstName('Wouter');
        $em->persist($user);
        $em->flush();

        return new Response(json_encode($user), 200);
    }
}