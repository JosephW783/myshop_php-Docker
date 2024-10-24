<?php
class Cliente extends Utente{

    private $liste = [];
    private $acquisti;
    private $canalePreferito;
    
    public function __construct() {
        $this->acquisti = new ListaProdotti();
    }
    
    public function getListe() {
        return $this->liste;
    }
    
    public function setListe($liste) {
        $this->liste = $liste;
    }
    
    public function getCanalePreferito() {
        return $this->canalePreferito;
    }
    
    public function setCanalePreferito($canalePreferito) {
        $this->canalePreferito = $canalePreferito;
    }
}
