<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("05.08 - Regra de negócio e modelo");

require __DIR__ . "/../source/autoload.php";

/*
 * [ layer ] Uma classe base que implementa os métodos de persitência e serve a todos os modelos.
 * essa é uma layer supertype.
 */
fullStackPHPClassSession("layer", __LINE__);

$layer = new ReflectionClass(Source\Models\Model::class);

var_dump(
    $layer,
    $layer->getDefaultProperties(),
    $layer->getMethods()
);

/*
 * [ model ] Cada rotina em um sistema tem uma regra de negócio. Um model serve para abstrair
 * essas rotinas se reponsabilizando pelas regras.
 */
fullStackPHPClassSession("model", __LINE__);

$user = new Source\Models\User();

var_dump(
    $user, get_class_methods($user)
);