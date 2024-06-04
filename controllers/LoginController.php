<?php

namespace Controllers;

use Clases\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth= new Usuario($_POST);

            $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    //Verificar el password
                    if($usuario->comprobarPassAndConfirmado($auth->password)){
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento

                        if($usuario->admin === '1'){
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                    }
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas'=>$alertas
        ]);
    }

    public static function logout(){
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
    
    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarCorreo();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === '1'){

                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar Email

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Comprueba tu email');

                }else{
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                }

            }
        }
        $alertas=Usuario::getAlertas();       

        $router->render('auth/olvide-password', [
            'alertas'=>$alertas
        ]);
        
    }
    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $espera=false;

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if($_POST['password'] !== $_POST['confirmar-password']){
                Usuario::setAlerta('error', 'Las contraseñas no coinciden');
            }

            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if(empty($alertas)){

                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();

                $usuario->token = 'null';
                $usuario->guardar();

                Usuario::setAlerta('exito', 'Contraseña Restablecida Correctamente');
                
                //Variable para dar 5 segundos de espera después de mostrar el mensaje de éxito
                $espera=true;
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error,
            'espera' =>$espera
        ]);
    }

    public static function crear(Router $router){
        
        $usuario = new Usuario;

        //Alertas vacías
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario->sincronizar($_POST);
            $alertas= $usuario->validarNuevaCuenta();

            //Revisar que alertas esté vacio

            if(empty($alertas)){
                
                //Se comprueba que el email no esté registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else {
                    //hash contraseña
                    $usuario->hashPassword();

                    //generar un token único
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }           
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas=[];

        $token= s($_GET['token']);

        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        }else{
            //Modificar valor confirmado
           
           $usuario->token = 'null';
           $usuario->guardar();
           Usuario::setAlerta('exito', 'Cuenta Activada Correctamente');
        }
        //obtener alertas
        $alertas = Usuario::getAlertas();
        //renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas'=> $alertas
        ]);
    }

}