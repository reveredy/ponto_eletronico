<?php

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

    public static function getActiveUsersCount(){
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

    public function insert(){
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;

        if(!$this->end_date) $this->end_date = NULL;

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::insert();
    }

    public function update(){
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;

        if(!$this->end_date) $this->end_date = NULL;

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::update();
    }

    private function validate(){
        $errors = [];

        if(!$this->name){
            $errors['name'] = "Nome é um campo obrigatório";
        }

        if(!$this->email){
            $errors['email'] = "E-mail é um campo obrigatório";
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'E-mail inválido.';
        }

        if(!$this->start_date){
            $errors['start_date'] = "Data de Admissão é um campo obrigatório";
        }elseif(!DateTime::createFromFormat('Y-m-d', $this->start_date)){
            $errors['start_date'] = "Data de Admissão deve seguir o padrão dd/mm/aa";
        }
        
        if($this->end_date && !DateTime::createFromFormat('Y-m-d', $this->end_date)){
            $errors['end_date'] = "Data de Desligamento deve seguir o padrão dd/mm/aa";
        }

        if(!$this->password){
            $errors['password'] = "Senha é um campo obrigatório";
        }

        if(!$this->confirm_password){
            $errors['confirm_password'] = "A confirmação  de senha é um campo obrigatório";
        }

        if($this->password && $this->confirm_password && $this->password !== $this->confirm_password){
            $errors['password'] = "Senhas não conferem";
            $errors['confirm_password'] = "Senhas não conferem";
        }
    
        if(count($errors) > 0){
            throw new ValidationException($errors);
        }
    }
}