<?php

namespace App\Controllers;
 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Customer;

class UserController {

    public function login(Request $request, Response $response, array $args): Response
    {
        $entityManager = DatabaseController::$entityManager;

        $user = $request->getParsedBody(); 
        $login = $user["login"] ?? "";
        $password = $user["password"] ?? "";

        $customerRepository = $entityManager->getRepository('Customer');
        $customer = $customerRepository->findOneBy(array('login' => $login, 'password' => $password));

        if ($customer == null ||  $login != $customer->getLogin() and $password != $customer->getPassword()){
            $response->getBody()->write(json_encode(["success" => false]));
            return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(401);
        }

        //if ($customer and $login == $customer->getLogin() and $password == $customer->getPassword()){
            $token_jwt = TokenController::createJwt($response);
            
            //$user = array('id' => $customer->getIdCustomer(), 'login' => $customer->getLogin());
            //$response->getBody()->write(json_encode($user));
            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(200);
        //}
    }

    public function register(Request $request, Response $response, array $args): Response
    {
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
    }
}

