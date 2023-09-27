<?php

require_once(dirname(__FILE__, 2) . '/src/config/database.php');

//SQL pedindo para pesquisar tudo que for da tabela users
$sql = 'SELECT * FROM users';

//Chamando o método da classe Database (getResultFromQuery) e passando a variável $sql como parâmetro
$result = Database::getResultFromQuery($sql);

//Enquanto a variável $row estiver recebendo algum dado ele retorna true e então efetua mais um loop
while($row = $result->fetch_assoc()){
    print_r($row);

    echo '<br>';
}