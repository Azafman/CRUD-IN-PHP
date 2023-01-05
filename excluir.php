<?php
require 'config.php';
require './dao/UsuarioDaoMySql.php'; 

$DaoMySql = new UsuarioDaoMySql($pdo);

$id = filter_input(INPUT_GET, 'id');
if($id) {
    $DaoMySql->delete($id);
}

header("Location: index.php");
exit;