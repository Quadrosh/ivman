Здравствуйте, <?= $oUser->first_name ?>!<br />
<br />
Мы рады приветствовать Вас на ivmanufaktura.ru!<br />
<br />
Для того чтобы начать работу выполните 2 простых шага:<br />
1) Нажмите на кнопку ниже или пройдите по ссылке  <br />
http://<?= Yii::$app->params['site'] ?>/user/verification/<?= $oUser->verification_code ?> <br />
<center>
    <a style="box-shadow: rgb(109, 179, 230) 0px 1px 0px inset, rgb(72, 161, 226) 1px 0px 0px inset; color: white; padding: 14px 7px; max-width: 210px; font-family: proxima_nova, 'Open Sans', 'lucida grande', 'Segoe UI', arial, verdana, 'lucida sans unicode', tahoma, sans-serif; border: 1px solid rgb(19, 115, 181); border-top-left-radius: 3px; border-top-right-radius: 3px; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px; text-decoration: none; width: 210px; margin: 6px auto; display: block; background-color: rgb(0, 126, 230);" href="http://<?= Yii::$app->params['site'] ?>/user/verification/<?= $oUser->verification_code ?>">Вперед!</a>
</center> <br />
2) Авторизуйтесь на сайте используя Ваш email и пароль<br />

<br />
