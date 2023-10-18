<?php

    $uploadDir = './upload';

    $error = $_FILES['upload']['error'];
    $name = $_FILES['upload']['name'];
    $ext = array_pop(explode('.', $name));

    if ( $error != UPLOAD_ERR_OK ) {

        switch ( $error ) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo 'File size is too big (' . $error . ')';
                break;
            case UPLOAD_ERR_NO_FILE:
                echo 'File is empty ('. $error . ')';
                break;
            default:
                echo 'There is problem to upload (' . $error . ')';
                break;
        }
    }

    $uploadName = time() . '.' . $ext;

    move_uploaded_file($_FILES['upload']['tmp_name'], "$uploadDir/$uploadName");

    exit(json_encode(array(
        'default' => 'http://xrun.run/controller/upload/' . $uploadName,
        'url' => 'http://xrun.run/controller/upload/' . $uploadName
    )));