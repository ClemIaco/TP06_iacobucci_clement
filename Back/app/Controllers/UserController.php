<?php

namespace App\Controllers;
 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

require_once "bootstrap.php";

class UserController {

    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

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
            ->withHeader("Content-Type", "application/json");
    }

    public function register(Request $request, Response $response, array $args): Response
    {
        $entityManager;
        $body = $request->getParsedBody();

        $civility = $body["civility"] ?? "";
        $name = $body["name"] ?? "";
        $firstname = $body["firstname"] ?? "";
        $address = $body["address"] ?? "";
        $postalCode = $body["postalCode"] ?? "";
        $city = $body["city"] ?? "";
        $country = $body["country"] ?? "";
        $phoneNumber = $body["phoneNumber"] ?? "";
        $email = $body["email"] ?? "";
        $login = $body["login"] ?? "";
        $password = $body["password"] ?? "";

        if (!preg_match("/[a-zA-Z]{1,30}/",$civility)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,50}/",$name)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,50}/",$firstname)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9]{1,500}/",$address)) return $response->withStatus(400);
        if (!preg_match("/[0-9]{1,10}/",$postalCode)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,256}/",$city)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z]{1,50}/",$country)) return $response->withStatus(400);
        if (!preg_match("/[+0-9 ]{1,20}/",$phoneNumber)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9@.]{1,100}/",$email)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9]{1,256}/",$login)) return $response->withStatus(400);
        if (!preg_match("/[a-zA-Z0-9]{1,256}/",$password)) return $response->withStatus(400);

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

