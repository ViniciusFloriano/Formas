<?php
    include_once '../conf/Conexao.php';
    require_once '../conf/conf.inc.php';
    require_once 'forma.class.php';
    class Tabuleiro extends Forma{
        private $idtabuleiro;
        private $lado;

        public function __construct($idtabuleiro, $lado) {
            $this->settabuleiro($idtabuleiro);
            $this->setlado($lado);
        }

        public function gettabuleiro() {
            return $this->idtabuleiro;
        }

        public function settabuleiro($idtabuleiro) {
            if ($idtabuleiro >  0)
                $this->idtabuleiro = $idtabuleiro;
        }     
        
        public function getlado() {
            return $this->lado;
        }

        public function setlado($lado) {
            if ($lado >  0)
                $this->lado = $lado;
        }

        public function __toString() {
            return  "[Tabuleiro]<br>Id do Tabuleiro: ".$this->gettabuleiro()."<br>".
                    "Lado: ".$this->getlado()."<br>".
                    "Área: ".round($this->Area(),2)."<br>".
                    "Perimetro: ".round($this->Perimetro(),2)."<br>".
                    "Diagonal: ".round($this->Diagonal(),2)."<br>";
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
            $sql = 'INSERT INTO recuperacao.tabuleiro (lado) 
            VALUES(:lado)';
            $parametros = array(":lado"=>$this->getLado());
            return parent::executaComando($sql,$parametros);
        }

        public function excluir(){
            $sql = 'DELETE FROM recuperacao.tabuleiro WHERE idtabuleiro = :idtabuleiro';
            $parametros = array(":idtabuleiro"=>$this->gettabuleiro());
            return parent::executaComando($sql,$parametros);
        }

        public function editar(){
            $sql = 'UPDATE recuperacao.tabuleiro 
            SET lado = :lado
            WHERE idtabuleiro = :idtabuleiro';
            $parametros = array(":lado"=>$this->getLado(),
                                ":idtabuleiro"=>$this->gettabuleiro());
            return parent::executaComando($sql,$parametros);
        }

        public static function listar($buscar = 0, $procurar = ""){
            $sql = "SELECT * FROM tabuleiro";
            if ($buscar > 0)
                switch($buscar){
                    case(1): $sql .= " WHERE idtabuleiro like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(2): $sql .= " WHERE lado like :procurar"; $procurar = "%".$procurar."%"; break;
                }
            if ($buscar > 0)
                $parametros = array(':procurar'=>$procurar);
            else 
                $parametros = array();
            return parent::buscar($sql, $parametros);
        }

        public function desenha(){
            $str = "<div style='width: ".$this->getlado()."vh;height: ".$this->getlado()."vh;border: 5px solid;'></div><br>";
            return $str;
        }

        public static function select($rows="*", $where = null, $search = null, $order = null, $group = null) {
            $pdo = Conexao::getInstance();
            $sql= "SELECT $rows FROM tabuleiro";
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