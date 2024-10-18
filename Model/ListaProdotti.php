<?php
class ListaProdotti{

    // Proprieta
    const STATO_LISTA_PAGATA = 'PAGATA';
    const STATO_LISTA_NON_PAGATA = 'NON_PAGATA';
    const TIPO_LISTA_ACQUISTO = 'ACQUISTO';
    const TIPO_LISTA_DESIDERIO = 'DESIDERIO';

    private $nome;
    private $id;
    private $prodotti;

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProdotti() {
        return $this->prodotti;
    }

    public function setProdotti($prodotti) {
        $this->prodotti = $prodotti;
    }
}
