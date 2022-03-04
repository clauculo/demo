<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    #[Route(path: '/api/v1/users/{id}', name: 'users.get', methods: ['GET'], requirements: ['id' => '\d+'], priority: 95)]
    public function getUser($id)
    {
        $user = (object)['id' => 1, 'name' => 'Wouter'];
        return new Response(json_encode($user), 200);
    }
}