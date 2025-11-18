<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Ejemplos/mvc/globals.php";
require_once MODEL_PATH."ResenhaModel.php";
class ResenhaController{

    public function listarResenhas(){
        $data = ResenhaModel::getResenhas();
        if(isset($data)){
            include_once VIEW_PATH."lista_resenhas-view.php";
        } else{ 
            include_once VIEW_PATH."error_lista-view.html";
        }
    }
}