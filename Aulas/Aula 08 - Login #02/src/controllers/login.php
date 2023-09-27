<?php
//esse loadModel faz o require do login.php que está dentro de model
loadModel('Login');

//Aqui no controller é onde é feito a interação entre controller e view
//Toda vez que a tela de login for gerada, antes será feito o teste para verificar se algum dado foi enviado por POST, se não, é chamado o view(login)

//Se tiver algum dado dentro de POST é feito toda a verificação de login antes de ser passado para o view
if(count($_POST) > 0){
    //Gera um novo login, $_POST como é um array associativo, pode ser passado direto dentro do login como parâmetro
    $login = new Login($_POST);
    try{
        //Checa se o login é valido, se n for lança uma exception
        $login->checkLogin();
        echo "Usuário $user->name logado";
    }catch(Exception $e){
        echo "Falha no login :(";
    }
}

loadView('login', $_POST);