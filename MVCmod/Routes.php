<?php

class Route{

    public function getView($route){
        require_once './views/' . $route . '.php';
    }

}

?>