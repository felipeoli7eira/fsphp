<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("06.08 - Camada de manipulação pt3");

require __DIR__ . "/../source/autoload.php";

/*
 * [ validate helpers ] Funções para sintetizar rotinas de validação
 */
fullStackPHPClassSession("validate", __LINE__);

$email = "felipe.oliveira@wapstore.com.br";
$password = "12345678123456781234567812345678123456780";

var_dump(
    is_email($email),

    is_password($password),

    mb_strlen($password)
);

/*
 * [ navigation helpers ] Funções para sintetizar rotinas de navegação
 */
fullStackPHPClassSession("navigation", __LINE__);


var_dump(
    [
        url('/blog/titulo-do-artigo'),
        url('blog/titulo-do-artigo'),
    ]
);

if (empty($_GET))
{
    redirect("?redirect=true");
}

/*
 * [ class triggers ] São gatilhos globais para criação de objetos
 */
fullStackPHPClassSession("triggers", __LINE__);


var_dump(
    user()->load(1)
);

echo message()->error('error');

session()->set('user', user()->load(1));

var_dump(session()->all()->user->data()->first_name);