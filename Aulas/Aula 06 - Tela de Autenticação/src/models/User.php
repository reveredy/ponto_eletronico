<?php
require_once(realpath(MODEL_PATH . '/Model.php'));

class User extends Model{
    //Como User herdou de Model ele se torna uma classe especializada, e aqui informamos os parametros para os dados que queremos obter
    protected static $tableName = 'users';
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin',
    ];
}