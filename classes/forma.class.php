<?php
    require_once "database.class.php";
    abstract class Forma extends Database{
        private $id;
        private $cor;
        private $idtabuleiro;
        private static $contador = 0;

        public function __construct($id, $cor, $idtabuleiro) {
            $this->setid($id);
            $this->setcor($cor);
            $this->settabuleiro($idtabuleiro);
            self::$contador = self::$contador + 1;
        }

        public function getid(){ 
            return $this->id; 
        }

        public function setid($id){ 
            $this->id = $id;
        }      

        public function getcor() {
            return $this->cor;
        }

        public function setcor($cor) {
            if (strlen($cor) > 0)    
                $this->cor = $cor;
        }

        public function gettabuleiro() {
            return $this->idtabuleiro;
        }

        public function settabuleiro($idtabuleiro) {
            if ($idtabuleiro >  0)
                $this->idtabuleiro = $idtabuleiro;
        }

        public function __toString() {
            return  "[Forma]<br>id: ".$this->getid()."<br>".
                    "Cor: ".$this->getcor()."<br>".
                    "Id do Tabuleiro: ".$this->gettabuleiro()."<br>".
                    "Contador: ".self::$contador."<br>";
        }

        public abstract function inserir();
        public abstract function excluir();
        public abstract function editar();
        public abstract static function listar($buscar = 0, $procurar = "");
        public abstract function desenha();
        public abstract function Area();
    }
?>