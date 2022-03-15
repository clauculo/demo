<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class UserCreateController
{
    #[Route(path: '/api/v1/users', name: 'users.create', methods: ['POST'])]
    public function createUser(EntityManagerInterface $em, Request $request)
    {
        $request = json_decode($request->getContent());

        $contact = new Contact();
        $contact->setFirstName('Aline');
        $contact->setLastName('Post');
        $em->persist($contact);

        $user = new User();
        $user->setFirstName($request->firstName);
        $user->setLastName($request->lastName);
        $user->addContact($contact);

        $em->persist($user);
        $em->flush();

        return new Response(json_encode($user), 200);
    }
}