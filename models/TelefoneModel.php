<?php
  class TelefoneModel extends DataBase{
    public function __construct(){
      parent::__construct();
    }

    public function adicionar($numero){
      $st = $this->db->prepare("INSERT INTO telefone (numero) VALUES (?)");
      $values = array($numero);
      $st->execute($values);
      $id = $this->db->lastInsertId();
      $this->listarTelefones($id);
    }

    public function listarTelefones($id = "*", $page = 0, $max = 0){
      if(($id=="*")
      && ($page==0)
      && ($max==0)){
        $st = $this->db->prepare("SELECT * FROM telefone");
        $st->execute();
      }
      if(($id!="*")
      && ($page==0)
      && ($max==0)){
        $st = $this->db->prepare("SELECT * FROM telefone WHERE idTelefone=?");
        $values = array($id);
        $st->execute($values);
      }
      if(($id=="*")
      && ($page>0)
      && ($max>0)){
        $st = $this->db->prepare("SELECT COUNT(*) FROM telefone");
        $st->execute();
        if($st->rowCount()>0){
          $dadosArray = $st->fetch();
          $quantidadeRegistros = $dadosArray[0];
          $totalPaginas = ceil($quantidadeRegistros/$max);

          while($page>$totalPaginas){
            $page--;
          }
          $offset = (($page-1)*$max);
          $st = $this->db->prepare("SELECT * FROM telefone LIMIT :valor1, :valor2");
          $offset = intval($offset);
          $max = intval($max);
          $st->bindParam(":valor1", $offset, PDO::PARAM_INT);
          $st->bindParam(":valor2", $max, PDO::PARAM_INT);
          $st->execute();
          if($st->rowCount()>0){
            /*
            *Criação da páginação
            *no array com os dados é criado novos indices
            da  PÁGINA ATUAL, PÁGINA ANTERIOR, PÁGINA POSTERIOR,
            TOTAL DE PÁGINAS e TORAL DE REGISTROS.
            */
            $json["paginaAtual"] = $page;
            if($page>1){
              $json["paginaAnterior"] = BASE_URL."telefone/page/".($page-1)."/max/".$max;
            }else{
              $json["paginaAnterior"] = null;
            }
            if($page<$totalPaginas){
              $json["paginaPosterior"] = BASE_URL."telefone/page/".($page+1)."/max/".$max;
            }else{
              $json["paginaPosterior"] = null;
            }
            $json["totalPaginas"] = $totalPaginas;
            $json["quantidadeRegistros"] = $quantidadeRegistros;
          }
        }
      }
      if(isset($st) && $st->rowCount()>0){
        if($st->rowCount()==1){
          $json["objetos"] = $st->fetch();
        }else{
          $json["objetos"] = $st->fetchAll();
        }
        header("Content-type: application/json");
        $json = json_encode($json);
        echo $json;
      }else{
        header("HTTP/1.1 404 Not Found");
      }
    }

    public function atualizarTelefone($id, $numero){
      $st = $this->db->prepare("UPDATE telefone SET numero=:numero WHERE idTelefone=:idTelefone");
      $st->bindParam(":numero", $numero);
      $st->bindParam(":idTelefone", $id);
      $st->execute();
      if(!$st->rowCount()==1){
        header("HTTP:1.1 404 Not Found");
        exit();
      }
    }

    public function deletarTelefone($id){
      $st = $this->db->prepare("DELETE FROM telefone WHERE idTelefone=:idTelefone");
      $st->bindParam(":idTelefone", $id);
      $st->execute();
      if(!$st->rowCount()==1){
        /*ou o id informado não existe ou o id informado está sendo usado
        em outra tabela.*/
        header("HTTP/1.1 404 Not Found");
        exit();
      }
    }
  }
 ?>
