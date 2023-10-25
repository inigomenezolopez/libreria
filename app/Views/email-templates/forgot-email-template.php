
    <p>Querido/a <?= $mail_data['user']->name?></p>

<p>
    Hemos recibido una solicitud para restablecer la contraseña para la cuenta de <i><?= $mail_data['user']->email ?></i>.

    Puedes restablecer tu contraseña pinchando en el siguiente enlace:
    <br><br>
    <a href="<?= $mail_data['actionLink']?>" style="color:#fff; background-color: #22bc66; display:inline-block; text-decoration:none; border-radius:25px; padding:10px 20px; font-size:16px; font-weight:bold; box-shadow:0 2px 3px rgba(0,0,0,0.16); -webkit-text-size-adjust:none; box-sizing:border-box;" target="_blank">Restablecer contraseña</a>

    <br><br>
    <b>P.D:</b> Este enlace seguirá siendo válido durante 15 minutos.
    <br><br>
    Si no has solicitado restablecer tu contraseña, por favor ignora este email.
</p>

   
