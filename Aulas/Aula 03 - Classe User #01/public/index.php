<?php

require_once(dirname(__FILE__, 2) . '/src/config/config.php');

//Testando se a classe User está funcionando
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

$user = new User(['name' => 'Carlos', 'email' => 'carlos@hotmail.com']);
print_r($user);
echo 'FIM';

//Fim do teste