<?php
require 'config.php';
require './dao/UsuarioDaoMySql.php'; 

$DaoMySql = new UsuarioDaoMySql($pdo);

$id = filter_input(INPUT_POST, 'id');
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if($id && $name && $email) {
    $usuario = new Usuario();
    $usuario->setId($id);
    $usuario->setNome($name);
    $usuario->setEmail($email);
    $DaoMySql->updateUser($usuario);
    
    header("Location: index.php");
    exit;
    
} else {
    header("Location: adicionar.php");
    exit;
}