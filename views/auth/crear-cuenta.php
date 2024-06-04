<h1 class="nobmre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" action="/crear-cuenta" method="POST" >
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre);?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido);?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu Telefono" value="<?php echo s($usuario->telefono);?>">
    </div>
    <div class="campo">
        <label for="email">email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo s($usuario->email);?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña" minlength="6">
    </div>

    <input class="boton" type="submit" value="Crear Cuenta">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>