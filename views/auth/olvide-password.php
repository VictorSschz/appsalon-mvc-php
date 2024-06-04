<h1 class="nombre-pagina">Olvide Contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuacion</p>

<?php 

include_once __DIR__ . '/../templates/alertas.php';

?>

<form class="formulario" action="/olvide" method="POST">
<div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email" >
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
</div>