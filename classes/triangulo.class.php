<?php
    include_once '../conf/Conexao.php';
    require_once '../conf/conf.inc.php';
    require_once 'forma.class.php';
    class Triangulo extends Forma{
        private $lado1;
        private $lado2;
        private $lado3;
        private static $contador;

        public function __construct($id, $cor, $idtabuleiro, $lado1, $lado2, $lado3) {
            parent::__construct($id, $cor, $idtabuleiro);
            $this->setlado1($lado1);
            $this->setlado2($lado2);
            $this->setlado3($lado3);
            self::$contador = self::$contador + 1;
        }

        public function getlado1(){ 
            return $this->lado1; 
        }

        public function setlado1($lado1){ 
            $this->lado1 = $lado1;
        }      

        public function getlado2(){ 
            return $this->lado2; 
        }

        public function setlado2($lado2){ 
            $this->lado2 = $lado2;
        }      

        public function getlado3() {
            return $this->lado3;
        }

        public function setlado3($lado3) {
                $this->lado3 = $lado3;
        }

        public function Area() {
            $area = sqrt(($this->lado1+$this->lado2+$this->lado3)*(-$this->lado1+$this->lado2+$this->lado3)*($this->lado1-$this->lado2+$this->lado3)*($this->lado1+$this->lado2-$this->lado3))/4;
            return $area;
        }
        
        public function Perimetro() {
            $perimetro = $this->lado1 + $this->lado2 + $this->lado3;
            return $perimetro;
        }

        public function Alpha() {
            $alpha = acos((pow($this->lado2, 2)+pow($this->lado3, 2)-pow($this->lado1, 2))/(2*$this->lado2*$this->lado3));
            return $alpha;
        }

        public function Beta() {
            $beta = acos((pow($this->lado1, 2)+pow($this->lado3, 2)-pow($this->lado2, 2))/(2*$this->lado1*$this->lado3));
            return $beta;
        }

        public function Gamma() {
            $gamma = acos((pow($this->lado1, 2)+pow($this->lado2, 2)-pow($this->lado3, 2))/(2*$this->lado1*$this->lado2));
            return $gamma;
        }

        public function __toString() {
            return  "[Triangulo]<br>Id do Triangulo: ".$this->getid()."<br>".
                    "Lado1: ".$this->getlado1()."<br>".
                    "Lado2: ".$this->getlado2()."<br>".
                    "Lado3: ".$this->getlado3()."<br>".
                    "Cor: ".$this->getcor()."<br>".
                    "Área: ".$this->Area()."<br>".
                    "Perímetro: ".$this->Perimetro()."<br>".
                    "Ângulo Alpha: ".round(rad2deg($this->Alpha()),2)."°<br>".
                    "Ângulo Beta: ".round(rad2deg($this->Beta()),2)."°<br>".
                    "Ângulo Gamma: ".round(rad2deg($this->Gamma()),2)."°<br>".
                    "Id do Tabuleiro: ".$this->gettabuleiro()."<br>".
                    "Contador: ".self::$contador."<br>".
                    "Tipo: ".$this->tipo()."<br>";
        }
        
        public function tipo(){
            if($this->getlado1() == $this->getlado2() && $this->getlado2() == $this->getlado3()){
                return "equilátero";
            }elseif($this->getlado1() == $this->getlado2() || $this->getlado1() == $this->getlado3() || $this->getlado2() == $this->getlado3()){
                return "isóceles";
            }else{
                return "escaleno";
            }
        }

        public function inserir(){
            $sql = 'INSERT INTO recuperacao.triangulo (lado1, lado2, lado3, cor, idtabuleiro) 
            VALUES(:lado1, :lado2, :lado3, :cor, :idtabuleiro)';
            $parametros = array(":lado1"=>$this->getLado1(),
                                ":lado2"=>$this->getLado2(),
                                ":lado3"=>$this->getlado3(), 
                                ":cor"=>$this->getCor(), 
                                ":idtabuleiro"=>$this->getTabuleiro());
            return parent::executaComando($sql,$parametros);
        }

        public function excluir(){
            $sql = 'DELETE FROM recuperacao.triangulo WHERE id = :id';
            $parametros = array(":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public function editar(){
            $sql = 'UPDATE recuperacao.triangulo 
            SET lado1 = :lado1, lado2 = :lado2, lado3 = :lado3, cor = :cor, idtabuleiro = :idtabuleiro
            WHERE id = :id';
            $parametros = array(":lado1"=>$this->getLado1(),
                                ":lado2"=>$this->getLado2(),
                                ":lado3"=>$this->getlado3(),
                                ":cor"=>$this->getCor(),
                                ":idtabuleiro"=>$this->getTabuleiro(),
                                ":id"=>$this->getId());
            return parent::executaComando($sql,$parametros);
        }

        public static function listar($buscar = 0, $procurar = ""){
            $sql = "SELECT * FROM triangulo";
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
            $str = "<div style='width: 0px; height: 0px; border-left: ".$this->lado1."vh solid transparent; border-right: ".$this->lado2."vh solid transparent;border-bottom: ".$this->lado3."vh solid ".parent::getcor().";'></div><br>";
            return $str;
        }

        public static function select($rows="*", $where = null, $search = null, $order = null, $group = null) {
            $pdo = Conexao::getInstance();
            $sql= "SELECT $rows FROM triangulo";
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

    // testar depois
    // public function text(){
        //     $y = deg2rad(55);
        //     $c = "";
        //     return $c=sqrt(pow($this->getlado1(), 2)+pow($this->getlado2(), 2)-2*$this->getlado1()*$this->getlado2()*cos($y));
        // }

    //echo $tri->text() ."<br>";
?>



