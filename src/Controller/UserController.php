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
use \PDO;

class UserController
{
    #[Route(path: '/api/v1/users/{id}', name: 'users.get', methods: ['GET'])]
    public function getUser($id)
    {
        try {
            $dbh = new PDO('sqlite:../var/app.db');
            foreach($dbh->query('SELECT * FROM `users` WHERE id = ' . $id) as $row) {
                $arrData = $row;
            }
            $dbh = null;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        $arr_data = array (
            'id' => $arrData['id'],
            'first_name' => $arrData['firstname'],
            'account' => 'basic'
        );

        return new JsonResponse($arr_data, 200);
    }
}