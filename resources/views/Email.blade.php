<html>
<head><title>Correo de recuperacion</title></head>
<body>
<h1>Estimado(a) {{$user->name}}</h1>
<br>
<p>Se solicito un cambio de contraseña para su cuenta, en caso de no haber realizado esta
    solicitud, solo ignore este mensaje, de lo contrario acceda al siguiente enlace para continuar</p>
<a href='http://app.so-politica.online/cambiar-contrasena/{{$user->pass_token}}'>http://app.so-politica.online/cambiar-contrasena/{{$user->pass_token}}</a>
</body>
</html>;
