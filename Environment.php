<?php
class Environment{
  //define("ENVIRONMENT",'development');
  //define("ENVIRONMENT",'production');
  const ENVIRONMENT = "development";
  //const ENVIRONMENT = "production";
  private $host = null;
  private $dataBaseNome = null;
  private $dataBaseUsuario = null;
  private $dataBaseSenha = null;

  public function __construct(){
    if(self::ENVIRONMENT=="development"){
      define("BASE_URL", "http://localhost/sysrev/");
      $this->host = "localhost";
      $this->dataBaseNome = "sysrevdb";
      $this->dataBaseUsuario = "root";
      $this->dataBaseSenha = "";
    }else{
      define("BASE_URL","http://www.robsondeveloper.com.br/");
      $this->host = "localhost";
      $this->dataBaseNome = "";
      $this->dataBaseUsuario = "";
      $this->dataBaseSenha = "";
    }
  }
  protected function getHost(){
    return $this->host;
  }
  protected function getDataBaseNome(){
    return $this->dataBaseNome;
  }
  protected function getDataBaseUsuario(){
    return $this->dataBaseUsuario;
  }
  protected function getDataBaseSenha(){
    return $this->dataBaseSenha;
  }
}

 ?>
