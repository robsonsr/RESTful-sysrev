<?php
class DataBase extends Environment{
  protected $db;
  public function __construct(){
    parent::__construct();
    try{
      $host = $this->getHost();
      $nome = $this->getDataBaseNome();
      $usuario = $this->getDataBaseUsuario();
      $senha = $this->getDataBaseSenha();
      
      $dsn = "mysql:dbname=".$nome.";host=".$host;
      $this->db = new PDO($dsn, $usuario, $senha);
    }catch(PDOException $exception){
      echo "Erro ocorrido:".$exception->getMessage();
    }
  }


}
?>
