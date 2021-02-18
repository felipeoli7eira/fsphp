<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("05.09 - Métodos de busca e leitura");

require __DIR__ . "/../source/autoload.php";

/*
 * [ load ] Por primary key (id)
 */
fullStackPHPClassSession("load", __LINE__);

$load = new Source\Models\User();

$user = $load->load(1);

var_dump($user, "{$user->first_name} {$user->last_name}");

/*
 * [ find ] Por indexes da tabela (email)
 */
fullStackPHPClassSession("find", __LINE__);

$find = new Source\Models\User();

$email = $find->find('alexandre27@email.com.br');

var_dump($email);


/*
 * [ all ] Retorna diversos registros
 */
fullStackPHPClassSession("all", __LINE__);

$model = new Source\Models\User();

$all = $model->all(3, 1, 'first_name');

foreach($all as $index => $data)
{
    var_dump($data->first_name);
}
