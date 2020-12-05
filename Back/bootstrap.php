<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
date_default_timezone_set('Europe/Paris');
require_once "vendor/autoload.php";
$isDevMode = true;
$config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/config/yaml"), $isDevMode);
$conn = array(
'host' => 'ec2-3-248-4-172.eu-west-1.compute.amazonaws.com',
'driver' => 'pdo_pgsql',
'user' => 'xqcmspzrocvvtt',
'password' => 'a6479131a452d0da96fe9ae196d0993d3e9ac92e79d663702f46271d5ebff331',
'dbname' => 'd8jrr50unmfhsl',
'port' => '5432'
);
$entityManager = EntityManager::create($conn, $config);