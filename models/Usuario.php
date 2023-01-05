<?php 
//DAO => data acess object
class Usuario {
    private $id;
    private $nome;
    private $email;

    public function getId() {
        return $this->id;
    }
    public function getNome() {
        return $this->nome;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setId($new) {
        $this->id = trim($new);//remove espaços
    }
    public function setNome($new) {
        $this->nome = ucwords(trim($new));
    }
    public function setEmail($new) {
        $this->email = trim($new);
    }
}

interface UsuarioDAO { //pode ser mysql, oracle, postgree
    public function add(Usuario $user);
    public function getAll();
    public function getById($id);
    public function updateUser(Usuario $user);
    public function getByEmail($email);
    public function delete($id);
}
//a idéia é que pra facilitar o processo de iteração no bd, eu tenha que somente criar códigos diferentes para sgbds diferentes, mantendo o padrão de uma classe para armazernar os usuários.