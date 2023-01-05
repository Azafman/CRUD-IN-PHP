<?php 
require 'dao/UsuarioDaoMySql.php';
require_once 'models/Usuario.php';
require 'config.php';

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

function redirecionamentoToIndex() {
    header('location: index.php');
    exit;
}

if($nome && $email) {
    $DaoMySqlAdd = new UsuarioDaoMySql($pdo);
    if($DaoMySqlAdd->getByEmail($email) === false) {
        $userAdd = new Usuario();
        $userAdd->setNome($nome);
        $userAdd->setEmail($email);

        $DaoMySqlAdd->add($userAdd);
        redirecionamentoToIndex();
    } else {
        redirecionamentoToIndex();
    }
} else {
    //trate erro
    redirecionamentoToIndex();
}