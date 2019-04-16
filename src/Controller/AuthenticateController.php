<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use GuzzleHttp\Client;

class AuthenticateController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $data = json_decode($request->getContent(), true);
        // Faire toutes les vérifications
        $user = new User($data['username']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        // $user->setPhone($data['']);
        $user->setPassword($encoder->encodePassword($user, $data['password']));
        try{

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $responseObject = array(
                "response" => "success",
                "message" => sprintf('User %s successfully created', $user->getUsername())
            );

            return new JsonResponse($responseObject);
        }
        catch(Exception $e){
            
            $responseObject = array(
                "response" => "success",
                "message" => sprintf('User %s successfully created', $user->getUsername()),
                "techMessage" => $e->getMessage()  // For admin
            );

            return new JsonResponse($responseObject);
        }
    }

    public function auth(Request $request)
    {
        /*
        $responseObject = array(
            "response" => "success",
            "message" => 'User type successfully created',
            "techMessage" => 'daccord'  // For admin
        );

        return new JsonResponse($responseObject);
        */
        $client = new \GuzzleHttp\Client();
        $headers = ['Content-Type' => 'application/json'];
        $response = $client->request('GET', 'localhost:8000/api/users/106', $headers);
        var_dump($response->getBody());
        exit;

        // echo $response->getStatusCode(); # 200
        // echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        return new JsonResponse($response->getBody());

        // $client   = $this->get('eight_points_guzzle.clients.my_client');
        // $response = $client->get('localhost:8000/api/books?page=1&itemsPerPage=5');
        // $response = $client->request('GET', 'localhost:8000/api/users/106');
        $client = new Client(['base_uri' => 'localhost:8000/api/']);
        // $headers = ['Content-Type' => 'application/json'];
        $response = $client->request('GET', 'users/106');
        dump($response);

        // echo $response->getStatusCode(); # 200
        // echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        // echo $response->getBody();
        exit;
        
        // var_dump($response->getContent());
        return new JsonResponse($responseObject);
        // $client = new \GuzzleHttp\Client();
        // $res = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
        // echo $res->getStatusCode();
        // exit;

    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
}
