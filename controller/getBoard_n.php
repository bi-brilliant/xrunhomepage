<?php

    include './../model/database_n.php';

    $sql = '
        SELECT b.`board` as `index`, b.`title` as `title`, b.`contents` as `content`, b.`datetime` as `reg_date`, to_base64(f.`attachments`) as `attachments` FROM `Boards` b LEFT JOIN Files f on f.file = b.file WHERE b.`board` = ? and b.`status` = 9401
    ';

    $bind = array( $_GET['index']);

    $data = result($sql, $bind);

    exit(json_encode(array(
        'title' => $data['title'],
        'content' => $data['content'],
        'file' => $data['attachments']

    )));