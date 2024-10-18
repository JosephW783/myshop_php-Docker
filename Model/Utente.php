<?php

class Utente {
    
    // Proprietà
    private $Id;
    private $username;
    private $password;
    public $nome;
    public $cognome;
    private $email;
    private $eta;
    private $birthDate;

    // Costruttori
    public function __construct(){
        $this->nome = "  ";
        $this->cognome=" ";
    }

    public function __constructWtihParam($username, $password, $nome, $cognome, $email, $eta){
        $this->username= $username;
        $this->password = $password;
        $this->nome= $nome;
        $this->cognome= $cognome;
        $this->email= $email;
        $this->eta= $eta;

    
    }
    public function __constructWithName($nome, $cognome, $email, $eta) {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->eta = $eta;
    
    }

    public function getUsername(){
        return $this->username;
    }
    public function setUsername($username){
         $this->username;
    }

    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate($birthDate)
    {
        $this->birthDate;

       
    }

    public function getEmail()
    {
        return $this->email;
    }

 
    public function setEmail($email)
    {
        $this->email;

    }
    
    public function getEta()
    {
        return $this->eta;
    }

    public function setEta($eta)
    {
        $this->eta = $eta;

        return $this;
    }
   
    public function getId()
    {
        return $this->Id;
    }

    
    public function setId($Id)
    {
        $this->Id = $Id;

        return $this;
    }
    }