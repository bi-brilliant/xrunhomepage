<?php

    include './database.php';

    if ( $_POST['email'] == '' || $_POST['subject'] == '' || $_POST['content'] == '' ) {
        exit(json_encode(array(
            'code' => '1000',
            'message' => '필수 값 확인'
        )));
    }

    if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
        exit(json_encode(array(
            'code' => '2000',
            'message' => 'Email Validate Error'
        )));
    }

    $sql = '
        INSERT INTO `xrun_customer`
        (
            `email`     ,
            `subject`   ,
            `content`
        )
        VALUES
        (
            "' . $_POST['email'] . '"   ,
            "' . $_POST['subject'] . '" ,
            "' . $_POST['content'] . '"
        )
    ';
    
    $err = query($sql);

    if ( $err != '' ) {
        exit(json_encode(array(
            'code' => '9000',
            'message' => 'Database Error'
        )));
    }

    exit(json_encode(array(
        'code' => '200',
        'message' => 'Success'
    )));