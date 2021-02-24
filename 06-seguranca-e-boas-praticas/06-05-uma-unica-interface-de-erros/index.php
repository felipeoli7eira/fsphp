<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("06.05 - Uma única interface de erros");

require __DIR__ . "/../source/autoload.php";

/*
 * [ message class ] Uma classe padrão para reportar ao usuário
 */
fullStackPHPClassSession("message class", __LINE__);

$message = new Source\Core\Message();

var_dump(
    $message,
    get_class_methods($message)
);


/*
 * [ message types ] Métodos para cada tipo de mensagem
 */
fullStackPHPClassSession("message types", __LINE__);

$error = $message->success('Uma mensagem de sucesso');

var_dump(
    [
        $message->getText(),
        $message->getType(),
        $message->render(),
    ]
);

echo $message->info('Essa é uma mensagem renderizada');
echo $message->success('Essa é uma mensagem renderizada');
echo $message->warning('Essa é uma mensagem renderizada');
echo $message->error('Essa é uma mensagem renderizada');

echo $message->error('Essa é uma mensagem renderizada')->json();
echo $message->error('Essa é uma mensagem renderizada')->json();

/*
 * [ json message ] Mudando o padrão de retorno
 */
fullStackPHPClassSession("json message", __LINE__);

echo $message->info(
    $message->error('errrou')->json()
);

/*
 * [ flash message ] Uma mensagem via sessão para refresh de navegação
 */
fullStackPHPClassSession("flash message", __LINE__);

// $message->success('flash success')->flash();
$session = new Source\Core\Session();

// var_dump(
//     $_SESSION,
//     $_SESSION['flash'],
//     $session->all()
// );

// echo $_SESSION['flash'];

if ($flashMessage = $session->flash())
{
    echo $flashMessage;
}