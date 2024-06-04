<h1 class="nombre-pagina">Restablecer contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php
    if($error) return;
?>

<?php if($espera){ ?>
    <meta http-equiv="refresh" content="5;url=/" />
<?php }else{?>

<form class="formulario" method="POST">
    <div class="campo">

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Nueva Contraseña">
    </div>

    <div class="campo">   
        <label for="confirmar-password">Confirma la Contraseña</label>
        <input type="password" id="confirmar-password" name="confirmar-password" placeholder="Confirma nueva tu Contraseña">
    </div>
        <input type="submit" value="Restablecer Contraseña" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes cuenta? Crear una</a>
</div>
<?php }; ?>