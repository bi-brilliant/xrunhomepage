<?php

    include './../model/database.php';

    $sql = '
        SELECT
            `xrun_notice`.`title`,
            `xrun_notice`.`content`,
            `xrun_notice`.`reg_date`
        FROM
            `xrun_notice`
        WHERE
            `index` = ?
    ';
    $bind = array( $_GET['index'] );

    $data = result($sql, $bind);

    exit(json_encode(array(
        'title' => $data['title'],
        'content' => $data['content']
    )));