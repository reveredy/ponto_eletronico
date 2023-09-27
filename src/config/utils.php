<?php

function addSuccesssMsg($msg){
    $_SESSION['message'] = [
        'type' => 'success',
        'message' => $msg
    ];
}

function addErrorMsg($msg){
    $_SESSION['message'] = [
        'type' => 'error',
        'message' => $msg
    ];
}