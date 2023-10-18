<?php

    include './../model/database.php';

    if ( isset($_REQUEST['index']) && $_REQUEST['index'] != '' ) {
        $sql = 'UPDATE `xrun_notice` SET `title` = ?, `content` = ? WHERE `index` = ?';
        $bind = array(
            $_REQUEST['title'],
            $_REQUEST['content'],
            $_REQUEST['index']
        );
    } else {
        $sql = 'INSERT INTO `xrun_notice` (`title`, `content`, `reg_date`) VALUES (?, ?, NOW())';
        $bind = array(
            $_REQUEST['title'],
            $_REQUEST['content']
        );
    }

    query($sql, $bind);
    exit($_REQUEST['index']);