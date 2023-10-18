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

    // if ( $err != '' ) {
    //     exit(json_encode(array(
    //         'code' => '9000',
    //         'message' => 'Database Error'
    //     )));
    // }
    // 명확하게 에러가 아닌경우에도 에러가 나타나면 정상 입력된 경우.
    // 확인 후에 다시 지정해 볼것. 에러는 뜨지 않게 지정함 
    // 2022-01-16

    exit(json_encode(array(
        'code' => '200',
        'message' => 'Success'
    )));