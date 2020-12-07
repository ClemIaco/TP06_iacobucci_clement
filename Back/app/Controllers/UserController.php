<?php

namespace App\Controllers;
 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Customer;

class UserController {

    public function createJwt(Response $response): Response {
        $issuedAt = time();
        $payload = [
            "user" => [
                "id" => $_ENV["ADMIN_LOGIN"],
                "email" => $_ENV["ADMIN_EMAIL"],
            ],
            "iat" => $issuedAt,
            "exp" => $issuedAt + 60  // jwt valid for 60 seconds from the issued time
        ];
        $token_jwt = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");
        $response = $response->withHeader("Authorization", "Bearer {$token_jwt}");
        return $response;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $entityManager = DatabaseController::$entityManager;

        $user = $request->getParsedBody(); 
        $login = $user["login"] ?? "";
        $password = $user["password"] ?? "";

        $customerRepository = $entityManager->getRepository('Customer');
        $customer = $customerRepository->findOneBy(array('login' => $login, 'password' => $password));

        if (!$customer ||  $login != $customer->getLogin() and $password != $customer->getPassword()){
            $response->getBody()->write(json_encode(["success" => false]));
            return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(401);
        }

        if ($customer and $login == $customer->getLogin() and $password == $customer->getPassword()){
            $token_jwt = createJwt($response);
            $response->getBody()->write(json_encode([
                "success" => true,
                "user" => [
                    "id" =>  $_ENV["ADMIN_ID"],
                    "login" => $_ENV["ADMIN_LOGIN"]
                    
                ]
            ]));
            return $response
                ->withHeader("Authorization", $token_jwt)
                ->withHeader("Content-Type", "application/json");
        }


        /*$data = $request->getParsedBody();

        $login = $data["login"] ?? "";
        $password = $data["password"] ?? "";

        if ($login != $_ENV["ADMIN_LOGIN"] || $password != $_ENV["ADMIN_PASSWORD"]) {
            $response->getBody()->write(json_encode([
                "success" => false
            ]));
            return $response
                ->withHeader("Content-Type", "application/json");
        }
        
        $issuedAt = time();
        $payload = [
            "user" => [
                "id" => $_ENV["ADMIN_LOGIN"],
                "email" => $_ENV["ADMIN_EMAIL"],
            ],
            "iat" => $issuedAt,
            "exp" => $issuedAt + 60
        ];
        $token_jwt = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");

        $response->getBody()->write(json_encode([
            "success" => true,
            "user" => [
                "id" =>  $_ENV["ADMIN_ID"],
                "login" => $_ENV["ADMIN_LOGIN"]
                
            ]
        ]));
        return $response
            ->withHeader("Authorization", $token_jwt)
            ->withHeader("Content-Type", "application/json");*/
    }

    public function register(Request $request, Response $response, array $args): Response
    {
        //global $entityManager;
        $entityManager = DatabaseController::$entityManager;
        $user = $request->getParsedBody();

        $civility = $user["civility"] ?? "";
        $name = $user["name"] ?? "";
        $firstname = $user["firstname"] ?? "";
        $address = $user["address"] ?? "";
        $postalCode = $user["postalCode"] ?? "";
        $city = $user["city"] ?? "";
        $country = $user["country"] ?? "";
        $phoneNumber = $user["phoneNumber"] ?? "";
        $email = $user["email"] ?? "";
        $login = $user["login"] ?? "";
        $password = $user["password"] ?? "";

        /*if (!preg_match("/[a-zA-Z]{1,30}/",$civility)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,50}/",$name)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,50}/",$firstname)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9]{1,500}/",$address)) return $response->withStatus(400);
        if (!preg_match("/[0-9]{1,10}/",$postalCode)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,256}/",$city)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,50}/",$country)) return $response->withStatus(400);
        if (!preg_match("/[+0-9 ]{1,20}/",$phoneNumber)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9@.]{1,100}/",$email)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9]{1,256}/",$login)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9]{1,256}/",$password)) return $response->withStatus(400);*/

        $entityManager->getConnection()->beginTransaction();

        try{
            $customer = new Customer();
            $customer->setCivility($civility);
            $customer->setName($name);
            $customer->setFirstname($firstname);
            $customer->setAddress($address);
            $customer->setPostalCode($postalCode);
            $customer->setCity($city);
            $customer->setCountry($country);
            $customer->setPhoneNumber($phoneNumber);
            $customer->setEmail($email);
            $customer->setLogin($login);
            $customer->setPassword($password);

            $entityManager->persist($customer);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        }
        catch (Exception $e){
            $entityManager->getConnection()->rollback();
            throw $e;
        }
        
        $result = [
            "success" => true,
            "user" => $user
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");

        /*$user = $request->getParsedBody();
        //$user = json_decode($user["client"], true);
  
        $result = [
            "success" => true,
            "user" => $user
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader("Content-Type", "application/json");*/
    }

}

