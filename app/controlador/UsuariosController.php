<?php 

class UsuariosController{
    //Inicializamos las variables en blanco para que no den error al imprimirlos en los values
    //cuando cargamos la pagina la primera vez.

    function registrar(){
        $email = "";
        $password = "";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $usuario = new Usuario();
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $error = false;

            //Comprobamos si existe un usuarios con el mismo correo
            $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
            if($usuarioDAO->obtenerPorEmail($email)){
                MensajeFlash::guardarMensaje("Email Repetido");
                MensajeFlash::imprimirMensajes();
                $error = true;
            }

            if(!$error){
                //Encriptamos la contraseña
                $passwordCrypt = password_hash($password, PASSWORD_BCRYPT);
                $usuario->setEmail($email);
                $usuario->setPassword($passwordCrypt);
                $usuarioDAO->insertar($usuario);
                header('Location: pruebas.php');
                die();
            }
        }
        require 'app/vista/registrar.php';
    }

    function logout(){
        session_destroy();
        setcookie("uid", "", 0);
        header("Location: index.php");
    }
    
}
