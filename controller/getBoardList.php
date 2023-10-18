<?php

    include './../model/database.php';

    $sql = '
        SELECT
            `xrun_notice`.`index`,
            `xrun_notice`.`title`,
            `xrun_notice`.`reg_date`
        FROM
            `xrun_notice`
        ORDER BY `index` DESC
        LIMIT 5
    ';
    $bind = array( $_GET['index'] );

    $data = resultAll($sql, $bind);

    exit(json_encode($data));