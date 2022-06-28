<?php
    include_once '../conf/Conexao.php';
    require_once '../conf/conf.inc.php';
    require_once "forma.class.php";
    class Quadrado extends Forma{
        private $lado;
        private static $contador;

        public function __construct($id, $lado, $cor, $idtabuleiro) {
            parent::__construct($id, $cor, $idtabuleiro);
            $this->setlado($lado);
            self::$contador = self::$contador + 1;
        }

        public function getlado() {
            return $this->lado;
        }

        public function setlado($lado) {
            if ($lado >  0)
                $this->lado = $lado;
        }

        public function __toString() {
            return  "[Quadrado]<br>Id do Quadrado: ".$this->getid()."<br>".
                    "Lado: ".$this->getlado()."<br>".
                    "Cor: ".$this->getcor()."<br>".
                    "Área: ".round($this->Area(),2)."<br>".
                    "Perimetro: ".round($this->Perimetro(),2)."<br>".
                    "Diagonal: ".round($this->Diagonal(),2)."<br>".
                    "Id do Tabuleiro: ".$this->gettabuleiro()."<br>".
                    "Contador: ".self::$contador."<br>";
        }

        public function Area() {
            $area = $this->lado * $this->lado;
            return $area;
        }

        public function Perimetro() {
            $perimetro = $this->lado * 4;
            return $perimetro;
        }

        public function Diagonal() {
            $diagonal = $this->lado * sqrt(2);
            return $diagonal;
        }

        public function inserir(){
            $sql = 'INSERT INTO recuperacao.quadrado (lado, cor, idtabuleiro) 
            VALUES(:lado, :cor, :idtabuleiro)';
            $parametros = array(":lado"=>$this->getLado(), 
                                ":cor"=>$this->getCor(), 
                                ":idtabuleiro"=>$this->getTabuleiro());
            return parent::executaComando($sql,$parametros);
        }

        public function excluir(){
            $sql = 'DELETE FROM recuperacao.quadrado WHERE id = :id';
            $parametros = array(":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public function editar(){
            $sql = 'UPDATE recuperacao.quadrado 
            SET lado = :lado, cor = :cor, idtabuleiro = :idtabuleiro
            WHERE id = :id';
            $parametros = array(":lado"=>$this->getLado(),
                                ":cor"=>$this->getCor(),
                                ":idtabuleiro"=>$this->getTabuleiro(),
                                ":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public static function listar($buscar = 0, $procurar = ""){
            $sql = "SELECT * FROM quadrado";
            if ($buscar > 0)
                switch($buscar){
                    case(1): $sql .= " WHERE id like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(2): $sql .= " WHERE lado like :procurar"; $procurar .="%"; break;
                    case(3): $sql .= " WHERE cor like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(4): $sql .= " WHERE idtabuleiro like :procurar"; $procurar = "%".$procurar."%"; break;
                }
            if ($buscar > 0)
                $parametros = array(':procurar'=>$procurar);
            else 
                $parametros = array();
            return parent::buscar($sql, $parametros);
        }
        
        public function desenha(){
            $str = "<div style='width: ".$this->getlado()."vh; height: ".$this->getlado()."vh; background: ".$this->getcor().";border: 5px solid;'></div><br>";
            return $str;
        }

        public static function select($rows="*", $where = null, $search = null, $order = null, $group = null) {
            $pdo = Conexao::getInstance();
            $sql= "SELECT $rows FROM quadrado";
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
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>