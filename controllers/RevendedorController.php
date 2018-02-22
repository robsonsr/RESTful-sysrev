<?php
/*
*@author Robson Rodrigues
*/
  class RevendedorController{
    public function verificarMetodo($parametrosArray){
      $metodo = $_SERVER['REQUEST_METHOD'];
      switch($metodo){
        case 'POST':
              $this->adicionar($parametrosArray);
              break;
        case 'GET':
              $this->listar($parametrosArray);
              break;
        case 'PUT':;
              $this->atualizar();
              break;
        case 'DELETE':
              $this->deletar($parametrosArray);
              break;
      }
    }

    public function adicionar($parametrosArray){
      if(isset($parametrosArray[0])
      && $parametrosArray[0]=="telefone"
      && isset($_POST["id"])
      && !empty($_POST["id"])
      && is_numeric($_POST["id"])
      && isset($_POST["telefone"])
      && !empty($_POST["telefone"])){
        extract($_POST);
        $telefoneModel, = new TelefoneModel();
        $telefoneModel->adicionarNumero($id, $telefone);
      }
      if(isset($_POST["numero"])
      && !empty($_POST["numero"])){

      }
    }

    public function listar($parametrosArray){
      if(isset($parametrosArray[0])){
        if(is_numeric($parametrosArray[0])){
          $id = $parametrosArray[0];
          $this->listarRevendorEspecifico($id);
        }else{
          switch ($parametrosArray[0]) {
            case 'nome':
            case 'nascimento':
            case 'foto':
            case 'vip':
            case 'usuario':
            case 'senha':
            case 'telefone':
              if(isset($parametrosArray[1]) && is_numeric($parametrosArray[1])){
                $id = $parametrosArray[1];
                $atributo = $parametrosArray[0];
                $this->listarAtributoRevendedor($id, $atributo);
              }else{
                header("HTTP/1.1 404 Not Found");
                exit();
              }
              break;
          }
        }

      }else{
        $this->listarTodosRevendedores();
      }
  }
  public function atualizar(){
    parse_str(file_get_contents("php://input"),$_put);
    if(isset($_put["id"]) && !empty($_put["id"])){
      if(isset($_put["numero"]) && !empty($_put["numero"])){
        $id = $_put["id"];
        $numero = $_put["numero"];
        $telefoneModel = new TelefoneModel();
        $telefoneModel->atualizarTelefone($id, $numero);
      }
    }
  }
  public function deletar($parametrosArray){
    if(count($parametrosArray)==1 && is_numeric($parametrosArray[0])){
      $id = $parametrosArray[0];
      $telefoneModel = new TelefoneModel();
      $telefoneModel->deletarTelefone($id);
    }else{
      /*erro na passagem de parâmetro, url fora do padrão
      estabelecido ou o id não e um número.*/
      header("HTTP/1.1 404 Not Found");
      exit();
    }
  }


  }
 ?>
