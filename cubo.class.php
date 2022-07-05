<?php
    require_once "quadrado.class.php";
    class Cubo extends Quadrado{
        private $idcubo;
        private $cor;
        private static $contador;

        public function __construct($idcubo, $id, $lado, $cor) {
            parent::__construct($id, $lado, '', '');
            $this->setidcubo($idcubo);
            $this->setcor($cor);
            self::$contador = self::$contador + 1;
        }

        public function getidcubo(){ 
            return $this->idcubo; 
        }

        public function setidcubo($idcubo){ 
            $this->idcubo = $idcubo;
        }      

        public function getcor() {
            return $this->cor;
        }

        public function setcor($cor) {
            if (strlen($cor) > 0)    
                $this->cor = $cor;
        }

        public function __toString() {
            return  "[Cubo]<br>Id do Quadrado: ".$this->getid()."<br>".
                    "Id do Cubo: ".$this->getidcubo()."<br>".
                    "Cor: ".$this->getcor()."<br>".
                    "Área do cubo: ".round($this->Areacubo(),2)." metros²<br>".
                    "Perimetro do cubo: ".round($this->Perimetrocubo(),2)."<br>".
                    "Diagonal do cubo: ".round($this->Diagonalcubo(),2)."<br>".
                    "Volume do cubo: ".round($this->Volumecubo(),2)."<br>".
                    "Contador: ".self::$contador."<br>";
        }

        public function Areacubo() {
            $area = 6 * pow($this->getLado(),2);
            return $area;
        }

        public function Perimetrocubo() {
            $perimetro = $this->getLado() * 12;
            return $perimetro;
        }

        public function Diagonalcubo() {
            $diagonal = $this->getLado() * sqrt(3);
            return $diagonal;
        }

        public function Volumecubo() {
            $volume = pow($this->getLado(),3);
            return $volume;
        }
        
        public function inserir(){
            $sql = 'INSERT INTO recuperacao.cubo (cor, idquadrado) 
            VALUES(:cor, :idquadrado)';
            $parametros = array(":cor"=>$this->getCor(), 
                                ":idquadrado"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public function excluir(){
            $sql = 'DELETE FROM recuperacao.cubo WHERE idcubo = :idcubo';
            $parametros = array(":idcubo"=>$this->getidcubo());
            return parent::executaComando($sql,$parametros);
        }

        public function editar(){
            $sql = 'UPDATE recuperacao.cubo 
            SET cor = :cor, idquadrado = :idquadrado
            WHERE idcubo = :idcubo';
            $parametros = array(":cor"=>$this->getCor(),
                                ":idquadrado"=>$this->getId(),
                                ":idcubo"=>$this->getidcubo());
            return parent::executaComando($sql,$parametros);
        }

        public static function listar($buscar = 0, $procurar = ""){
            $sql = "SELECT * FROM cubo";
            if ($buscar > 0)
                switch($buscar){
                    case(1): $sql .= " WHERE idcubo like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(2): $sql .= " WHERE cor like :procurar"; $procurar = "%".$procurar."%"; break;
                    case(3): $sql .= " WHERE idquadrado like :procurar"; $procurar = "%".$procurar."%"; break;
                }
            if ($buscar > 0)
                $parametros = array(':procurar'=>$procurar);
            else 
                $parametros = array();
            return parent::buscar($sql, $parametros);
        }

        public function divisao(){
            return $this->getlado() / 2;
        }

        public function desenha(){
            $str = "<div style='width: ".$this->getlado()."px; height: ".$this->getlado()."px; animation: rotate 10s infinite alternate; transform-style: preserve-3d;'>
                        <div style='background: linear-gradient(45deg, ".$this->getcor().", ".$this->getcor()."); border: 2px solid black; display: flex; width: ".$this->getlado()."px; height: ".$this->getlado()."px; 
                            position: absolute; transform: translateZ(".$this->divisao()."px);'></div>
                        <div style='background: linear-gradient(45deg, ".$this->getcor().", ".$this->getcor()."); border: 2px solid black; display: flex; width: ".$this->getlado()."px; height: ".$this->getlado()."px; 
                            position: absolute; transform: rotateY(90deg) translateZ(".$this->divisao()."px);'></div>
                        <div style='background: linear-gradient(45deg, ".$this->getcor().", ".$this->getcor()."); border: 2px solid black; display: flex; width: ".$this->getlado()."px; height: ".$this->getlado()."px; 
                            position: absolute; transform: rotateY(180deg) translateZ(".$this->divisao()."px);'></div>
                        <div style='background: linear-gradient(45deg, ".$this->getcor().", ".$this->getcor()."); border: 2px solid black; display: flex; width: ".$this->getlado()."px; height: ".$this->getlado()."px; 
                            position: absolute; transform: rotateY(-90deg) translateZ(".$this->divisao()."px);'></div>
                        <div style='background: linear-gradient(45deg, ".$this->getcor().", ".$this->getcor()."); border: 2px solid black; display: flex; width: ".$this->getlado()."px; height: ".$this->getlado()."px; 
                            position: absolute; transform: rotateX(90deg) translateZ(".$this->divisao()."px);'></div>
                        <div style='background: linear-gradient(45deg, ".$this->getcor().", ".$this->getcor()."); border: 2px solid black; display: flex; width: ".$this->getlado()."px; height: ".$this->getlado()."px; 
                            position: absolute; transform: rotateX(-90deg) translateZ(".$this->divisao()."px);'></div>
                    </div><br><br><br>";
            return $str;
        }

        public static function select($rows="*", $where = null, $search = null, $order = null, $group = null) {
            $pdo = Conexao::getInstance();
            $sql= "SELECT $rows FROM cubo";
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