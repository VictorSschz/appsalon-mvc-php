<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Comprueba que el usuario esté autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
        exit();
    }
}

function eresAdmin() : void{

    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }

}

function esUltimo(string $actual,string $proximo):bool{

    if($actual!==$proximo){
        return true;
    }
    return false;

}