<?php

require_once(dirname(__FILE__, 2) . '/src/config/config.php');

// Testando se a conexão funcionou
// $sql = 'SELECT * FROM users';
// $result = Database::getResultFromQuery($sql);

// //variável $row recebendo um array associativo de cada entrada no banco de dados
// while($row = $result->fetch_assoc()){
//     print_r($row);
//     echo '<br>';
// }

// //Testando se a classe User está funcionando
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

//A ideia é passar chave e valor dentro de cada a
$user = new User(['name' => 'Carlos', 'email' => 'carlos@hotmail.com']);

print_r(User::get(['id' => 1], 'id, name, email'));

echo "<br><br>";

foreach(User::get([], 'name') as $user){
    echo $user->name;
    echo "<br>";
}