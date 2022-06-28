<?php
    include_once '../conf/Conexao.php';
    require_once '../conf/conf.inc.php';
    require_once '../classes/database.class.php';
    class Usuario extends Database{
        private $id;
        private $nome;
        private $login;
        private $senha;

        public function __construct($id, $nome, $login, $senha) {
            $this->setid($id);
            $this->setnome($nome);
            $this->setlogin($login);
            $this->setsenha($senha);
        }  

        public function getid() {
            return $this->id;
        }

        public function setid($id) {
            if (strlen($id) > 0)
                $this->id = $id;
        }

        public function getnome() {
            return $this->nome;
        }

        public function setnome($nome) {
            if (strlen($nome) > 0)
                $this->nome = $nome;
        }

        public function getlogin() {
            return $this->login;
        }

        public function setlogin($login) {
            if (strlen($login) > 0)    
                $this->login = $login;
        }

        public function getsenha() {
            return $this->senha;
        }

        public function setsenha($senha) {
            if (strlen($senha) > 0)
                $this->senha = $senha;
        }

        public function __toString() {
            return  "[Usuário]<br>Id do Usuário: ".$this->getId()."<br>".
                    "nome: ".$this->getnome()."<br>".
                    "login: ".$this->getlogin()."<br>".
                    "senha: ".$this->getsenha()."<br>";
        }

        public function inserir(){
            $sql = 'INSERT INTO recuperacao.usuario (nome, login, senha) 
            VALUES(:nome, :login, :senha)';
            $parametros = array(":nome"=>$this->getnome(), 
                                ":login"=>$this->getlogin(), 
                                ":senha"=>$this->getsenha());
            return parent::executaComando($sql,$parametros);
        }

        public function excluir(){
            $sql = 'DELETE FROM recuperacao.usuario WHERE id = :id';
            $parametros = array(":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public function editar(){
            $sql = 'UPDATE recuperacao.usuario
            SET nome = :nome, login = :login, senha = :senha
            WHERE id = :id';
            $parametros = array(":nome"=>$this->getnome(), 
                                ":login"=>$this->getlogin(), 
                                ":senha"=>$this->getsenha(),
                                ":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public static function listar($buscar = 0, $procurar = ""){
            $sql = "SELECT * FROM usuario";
            if ($buscar > 0)
                switch($buscar){
                    case(1): $sql .= " WHERE id like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(2): $sql .= " WHERE nome like :procurar"; $procurar = "%".$procurar."%"; break;
                }
            if ($buscar > 0)
                $parametros = array(':procurar'=>$procurar);
            else 
                $parametros = array();
            return parent::buscar($sql, $parametros);
        }

        public static function select($rows="*", $where = null, $search = null, $order = null, $group = null) {
            $sql= "SELECT $rows FROM usuario";
            if($where != null) {
                $sql .= " WHERE $where";
                if($search != null) {
                    if(is_numeric($search) == false) {
                        $sql .= " LIKE '%". trim($search) ."%'";
                    } else if(is_numeric($search) == true) {
                        $sql .= " <= '". trim($search) ."'";
                    }
                }
            }
            if($order != null) {
                $sql .= " ORDER BY $order";
            }
            if($group != null) {
                $sql .= " GROUP BY $group";
            }
            $sql .= ";";
            $pdo = Conexao::getInstance();
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        public function efetuarLogin($login, $senha) {
            $pdo = Conexao::getInstance();
            $verificacao = $this->select('nome', "login = '$login' AND senha = '$senha'");
            if($verificacao){
                $_SESSION["nome"] = $verificacao[0]['nome'];
                return true;
            }else{
                return false;
            }
        }
    }
?>