<p>Querido/a <?= $mail_data['user']->name?></p>
<br>
<p>
    Has cambiado correctamente la contraseña. Aquí están tus nuevas credenciales de acceso:
    <br><br>
    <b>Login ID:</b> <?= $mail_data['user']->email?>
    <br>
    <b>Contraseña:</b> <?= $mail_data['new_password']?>
</p>
<br><br>
Por favor, conserva bien tus credenciales y no las compartas con nadie.
   
<p>
    Comic-shop no se hará responsable de ningún uso malintencionado de tu usuario o contraseña.
</p>
<br>
-------------------------------------------------------------
<p>
    Este email se ha enviado de manera automática a través del sistema de Comic-shop. No responda a este correo.
</p>