<?php
spl_autoload_register(function($class){
  if(file_exists("controllers/".$class.".php")){
    require "controllers/".$class.".php";
  }elseif(file_exists("core/".$class.".php")){
    require "core/".$class.".php";
  }elseif(file_exists("models/".$class.".php")){
    require "models/".$class.".php";
  }elseif(file_exists($class.".php")){
    require $class.".php";
  }
});
 ?>
