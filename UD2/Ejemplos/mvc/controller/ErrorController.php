<?php

class ErrorController{
    public function pageNotFound(){
        include_once $_SERVER['DOCUMENT_ROOT']."/Ejemplos/mvc/view/page_not_found-view.html";
        header("HTTP/1.1 404 Page not found");
        exit;
    }
}