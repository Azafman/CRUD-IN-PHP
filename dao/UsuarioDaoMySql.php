<?php 
//A expressão require_once é idêntica a require exceto que o PHP verificará se o arquivo já foi incluído, e em caso afirmativo, não o incluirá (exigirá) novamente.
require_once('models/Usuario.php');

class UsuarioDaoMySql implements UsuarioDAO {
    private $pdo;
    public function __construct(PDO $driver) {//PDO indica que é um objeto do tipo pdo.
        $this->pdo = $driver;
        //a conexão estabelecida com o banco de dados estará na variável pdo.
    }
    public function add(Usuario $user) {
        $sql = $this->pdo->prepare("INSERT INTO users (nome, email) VALUES (:nome, :email)");
        $sql->bindValue(':nome', $user->getNome());
        $sql->bindValue(':email', $user->getEmail());
        $sql->execute();

        $user->setId($this->pdo->lastInsertId());//pega o último id inserido no banco de dados.
        return $user;
    }
    public function getAll() {
        $result = [];
        $search = $this->pdo->query("SELECT * FROM  users");
        $arrayDeUsuarios = $search->fetchAll( PDO::FETCH_ASSOC);

        //criar um novo objeto, jogar nele as informações do usuário, e depois jogar todos objetos num array, para assim lista-lô.
        foreach($arrayDeUsuarios as $user) {
            $usuario = new Usuario();
            $usuario->setId($user['id']);
            $usuario->setNome($user['nome']);
            $usuario->setEmail($user['email']);

            array_push($result, $usuario);
        }

        return $result;
    }
    public function getById($id) {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id =:id");
        $sql->bindValue(':id', $id); 
        $sql->execute();
        if($sql->rowCount() > 0) {
            $data = $sql->fetch();//é só um objeto
            
            $u = new Usuario();
            $u->setNome($data['nome']);
            $u->setEmail($data['email']);
            $u->setId($data['id']);

            return $u;
        } else {
            return false;
        }
    }
    public function getByEmail($email) {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() === 1) {
            $data = $sql->fetch();//é só um objeto
            
            $u = new Usuario();
            $u->setNome($data['nome']);
            $u->setEmail($data['email']);
            $u->setId($data['id']);

            return $u;
        } else {

            return false;
        }
    }
    public function updateUser(Usuario $user) {
        $sql = $this->pdo->prepare("UPDATE users SET nome = :nome, email = :email WHERE id = :id");
        $sql->bindValue(':nome', $user->getNome());
        $sql->bindValue(':email', $user->getEmail());
        $sql->bindValue(':id', $user->getId());
        $sql->execute();
        
        return true;
    }
    public function delete($id) {
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

}
