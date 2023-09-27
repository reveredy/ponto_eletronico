<?php
class Model{
    //Essas 2 funções vão nos ajudar a mapear o modelo com o banco de dados
    //Nese caso especificamente vamos querer saber o nome da tabela
    protected static $tableName = '';

    //Agora vamos saber quais colunas temo no nosso banco de dados, especificamente para aquele modelo
    protected static $columns = [];

    //Esse método não pode ser estático porque precisamos obter esses dados em cima de cada instância criada
    protected $values = [];

    //Model como é uma classe mais genérica, nos apenas definimos quais dados gostariamos de obter, mas deixamos para especificar o dado em si na classe mais especializada.
    //Nesse caso o model é generico e o User é especifico, ai passamos os dados lá

    function __construct($arr){
        //Chamando o método loadFromArray e passando para ele os valores recebidos pelo array
        //No nosso caso esses valores estão vindo da página index quando criamos um novo usuário
        //Os valores estão vindo como ['name' => 'Carlos', 'email' => 'carlos@hotmail.com'] e assim sendo passados direto para loadFromArray
        $this->loadFromArray($arr);
    }

    public function loadFromArray($arr){
        //Testando se o array está setado
        if($arr){
            //estando setado entra aqui e é feito um foreach
            //pegando cada chave e valor EX: $key = 'name', $value = 'Carlos'
            foreach($arr as $key => $value){
                $this->$key = $value;
            }
        }
    }

    //Método retorna os dados solicitados em forma de objeto
    public static function get($filters = [], $columns = '*'){
        //Criando um array, que depois será um array de objetos
        $objects = [];
        //Obtendo o resultado da query, o método getResultFromSelect já efetua a conexão com o banco de dados e retorna o resultado da query
        $result = static::getResultFromSelect($filters, $columns);
        if($result){
            //Com esse método do próprio PHP nós conseguimos ver qual classe que chamou esse método, nesse caso foi a classe (USER)
            $class = get_called_class();

            //$row recebe um array associativo, dentro dele
            //dentro de cada linha do array objects estamos instanciando uma classe do tipo (User) (new $class) e dentro da row temos um array com os dados que vai para dentro desse objeto
            while($row = $result->fetch_assoc()){
                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }

    //Método retorna os dados solicitados em forma de objeto
    public static function getOne($filters = [], $columns = '*'){
        //Com esse método do próprio PHP nós conseguimos ver qual classe que chamou esse método, nesse caso foi a classe (USER)
        $class = get_called_class();

        //Obtendo o resultado da query, o método getResultFromSelect já efetua a conexão com o banco de dados e retorna o resultado da query
        $result = static::getResultFromSelect($filters, $columns);
        
        return $result ? new $class($result->fetch_assoc()) : null;
    }

    //Método que cria o sql (select) e retorna o resultado do banco de dados
    public static function getResultFromSelect($filters = [], $columns = '*'){
        $sql = "SELECT $columns FROM " . static::$tableName //Como nossa classe já tem o nome da tabela, podemos usar isso para ser mais dinamico caso o nome da tabela mude em algum momento
        . static::getFilters($filters); //Chamando a função que retorna a outra parte do sql, com os filtros para o WHERE

        //Agora temos o resultado vindo do banco de dados
        $result = Database::getResultFromQuery($sql);

        if($result->num_rows === 0){
            return null;
        }else{
            return $result;
        }
    }

    //Função usada para criar o restante do sql, com o WHERE e AND
    private static function getFilters($filters){
        $sql = '';

        //Verificando se o filtro veio com algum argumento
        if(count($filters) > 0){
            //Adicionando o primeiro filtro do where como 1=1, para facilitar a nossa função
            $sql .= " WHERE 1 = 1";
            //foreach com cada filtro, sendo usado como um array associativo (chave e valor)
            foreach($filters as $column => $value){
                //Adiciona cada um dos filtros
                $sql .= " AND $column = " . static::getFormatedValue($value); // Chamando a função para editar os valores recebidos.
            }
        }
        return $sql;
    }

    // Função para editar os valores recebidos. Se for null retorna nulo, se for string retorna com as 'aspas' e se for outro valor retorna normal(cru)
    private static function getFormatedValue($value){
        if(is_null($value)){
            return 'null';
        }elseif(gettype($value) === 'string'){
            return "'$value'";
        }else{
            return $value;
        }
    }

    //Métodos mágicos
    public function __get($key){
        //O get somente retorna o dado solicitado atraves da key
        //EX: value['name'] retornará 'Carlos'
        return $this->values[$key];
    }

    //Métodos mágicos
    public function __set($key, $value){
        //Se precisarmos setar um usuário fora da classe podemos usar esse set, por ser publico
        //values vai ser um array associativo, passamos dentro do indexador, o nome da chave, ex: values[$key]
        //Depois com o nome da chave definido, setamos o valor para essa chave
        $this->values[$key] = $value;
    }
}