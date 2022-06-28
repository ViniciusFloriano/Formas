<?php
    include_once '../conf/Conexao.php';
    require_once '../conf/conf.inc.php';
    require_once "forma.class.php";
    class Circulo extends Forma{
        private $raio;
        private static $contador;

        public function __construct($id, $raio, $cor, $idtabuleiro) {
            parent::__construct($id, $cor, $idtabuleiro);
            $this->setraio($raio);
            self::$contador = self::$contador + 1;
        }

        public function getraio() {
            return $this->raio;
        }

        public function setraio($raio) {
            if ($raio >  0)
                $this->raio = $raio;
        }

        public function __toString() {
            return  "[Circulo]<br>Id do Circulo: ".$this->getId()."<br>".
                    "Raio: ".$this->getraio()."<br>".
                    "Cor: ".$this->getcor()."<br>".
                    "Área: ".round($this->Area(),2)."<br>".
                    "Circunferência: ".round($this->Circunferencia(),2)."<br>".
                    "Diâmetro: ".round($this->Diametro(),2)."<br>".
                    "Id do Tabuleiro: ".$this->gettabuleiro()."<br>".
                    "Contador: ".self::$contador."<br>";
        }

        public function Area() {
            $area = pi() * pow($this->raio, 2);
            return $area;
        }

        public function Circunferencia() {
            $circunferencia = 2 * pi() * $this->raio;
            return $circunferencia;
        }

        public function Diametro() {
            $diametro = 2 * $this->raio;
            return $diametro;
        }

        public function inserir(){
            $sql = 'INSERT INTO recuperacao.circulo (raio, cor, idtabuleiro) 
            VALUES(:raio, :cor, :idtabuleiro)';
            $parametros = array(":raio"=>$this->getraio(), 
                                ":cor"=>$this->getCor(), 
                                ":idtabuleiro"=>$this->getTabuleiro());
            return parent::executaComando($sql,$parametros);
        }

        public function excluir(){
            $sql = 'DELETE FROM recuperacao.circulo WHERE id = :id';
            $parametros = array(":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public function editar(){
            $sql = 'UPDATE recuperacao.circulo 
            SET raio = :raio, cor = :cor, idtabuleiro = :idtabuleiro
            WHERE id = :id';
            $parametros = array(":raio"=>$this->getraio(),
                                ":cor"=>$this->getCor(),
                                ":idtabuleiro"=>$this->getTabuleiro(),
                                ":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public static function listar($buscar = 0, $procurar = ""){
            $sql = "SELECT * FROM circulo";
            if ($buscar > 0)
                switch($buscar){
                    case(1): $sql .= " WHERE id like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(2): $sql .= " WHERE raio like :procurar"; $procurar .="%"; break;
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
            $str = "<div style='border-radius: 50%; display: inline-block; width: ".$this->Diametro()."px; height: ".$this->Diametro()."px; background: ".$this->getcor().";border: 5px solid;'></div><br>";
            return $str;
        }

        public static function select($rows="*", $where = null, $search = null, $order = null, $group = null) {
            $pdo = Conexao::getInstance();
            $sql= "SELECT $rows FROM circulo";
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