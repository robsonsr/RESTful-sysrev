<?php
/*
*@author Robson Rodrigues
*/
  class TelefoneController{
    public function verificarMetodo($parametrosArray){
      $metodo = $_SERVER['REQUEST_METHOD'];
      switch($metodo){
        case 'POST':
              $this->adicionar();
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

    public function adicionar(){
      if(isset($_POST["numero"]) && !empty($_POST["numero"])){
        $numero = $_POST["numero"];
        $telefoneModel = new TelefoneModel();
        $telefoneModel->adicionar($numero);
      }
    }

    public function listar($parametrosArray){
      if(count($parametrosArray)==0){
        $telefoneModel = new TelefoneModel();
        $telefoneModel->listarTelefones();
      }elseif(count($parametrosArray)==1 && is_numeric($parametrosArray[0])){
            $telefoneModel = new TelefoneModel();
            $telefoneModel->listarTelefones($parametrosArray[0]);
      }elseif(count($parametrosArray)==4){
            if($parametrosArray[0]=="page" && is_numeric($parametrosArray[1])){
              $page = $parametrosArray[1];
            }else{
              header("HTTP/1.1 404 Not Found");
              exit();
            }
            if($parametrosArray[2]=="max" && is_numeric($parametrosArray[3])){
              $max = $parametrosArray[3];
            }else{
              header("HTTP/1.1 404 Not Found");
              exit();
            }
            $telefoneModel = new TelefoneModel();
            $telefoneModel->listarTelefones("*",$page, $max);
    }else{
      header("HTTP/1.1 404 Not Found");
      exit();
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
