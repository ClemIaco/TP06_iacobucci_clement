<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
date_default_timezone_set('Europe/Paris');
require_once "vendor/autoload.php";
$isDevMode = true;
$config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/config/yaml"), $isDevMode);
$conn = array(
'host' => 'ec2-54-75-248-49.eu-west-1.compute.amazonaws.com',
'driver' => 'pdo_pgsql',
'user' => 'jqpmazbnthdlos',
'password' => '289aad4eb636a944c36842d9a823f9185e72ef9dc8bd1c45a5ae2c87d86c50cb',
'dbname' => 'd5kptskho1u01',
'port' => '5432'
);
$entityManager = EntityManager::create($conn, $config);