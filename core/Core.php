<?php
class Core{

  public function run(){
    $url = "/";
    if(isset($_GET["url"])){
      $url .= $_GET["url"];
    }

    $controllerAtual = "homeController";
    $metodoAtual = "verificarMetodo";
    $parametros = array();

    if($url!="/"){

      $url = explode("/", $url);
      array_shift($url);//remove o primeiro elemento do vetor
      $controllerAtual = ucfirst($url[0])."Controller";
      array_shift($url);
      if(isset($url[0]) && !empty($url[0])){
        $parametros = $url;
      }
    }else{
      $controllerAtual = "homeController";
      $metodoAtual = "verificarMetodo";
      $parametros= array();
    }

    $controller = new $controllerAtual();
    call_user_func_array(array($controller, $metodoAtual), array($parametros));
  }
}
 ?>
