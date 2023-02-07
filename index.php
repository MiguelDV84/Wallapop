<?php 

//Para utilizar variables de sesion
session_start();

/////////// CONTROLADOR FRONTAL //////////////

/* REQUIRES MODELOS, CONTROLADORES Y CONFIG */

require 'app/config.php';
require 'app/controlador/UsuariosController.php';
require 'app/modelo/ConexionBD.php';
require 'app/modelo/Usuario.php';
require 'app/modelo/UsuarioDAO.php';

require 'app/utlidades/MensajeFlash.php';

$map = array(
    "login" => array("controller" =>  "UsuariosController.php", "method" => "login", "publica" => true),
    "logout" => array("controller" => "UsuariosController", "method" => "logout", "publica" => false),
    "registrar" => array("controller" => "UsuariosController", "method" => "registrar", "publica" => true)

);

/* PARSEO DE LA RUTA */
if(!isset($_GET['action'])){
    $action = 'inicio';
} else {
    if (!isset($map[$_GET['action']])) {  //Si no existe la acción en el mapa
        print "La acción indicada no existe.";
        header('Status: 404 Not Found');
        die();
    } else {
        $action = filter_var($_GET['action'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
}

/* EJECUTAMOS EL CONTROLADOR NECESARIO */
$controller = $map[$action]['controller'];
$method = $map[$action]['method'];

if(method_exists($controller, $method)){
    $obj_controller = new $controller();
    $obj_controller->$method();
}else{
    header('Status: 404 Not Found');
    echo "El metodo $method del controlador $controller no existe.";
}