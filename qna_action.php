<?php

    $db;

    function query($sql, $arr = array()) {
        $db = new PDO('mysql:host=127.0.0.1; dbname=xrun; charset=utf8', 'root', 'bA4ahrzww');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($arr);
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function result($sql, $arr = array()) {
        return query($sql, $arr)->fetch(PDO::FETCH_ASSOC);
    }

    function resultAll($sql, $arr = array()) {
        return query($sql, $arr)->fetchAll(PDO::FETCH_ASSOC);
    }

    switch ( $_POST['type'] ) {
        case 'list':
            $getListQuery = '
                SELECT
                    `idx`       ,
                    `email`     ,
                    `subject`   ,
                    `regdate`
                FROM
                    `xrun_customer`
                ORDER BY `idx` DESC
            ';
            $getListParam = array();

            $data = resultAll($getListQuery, $getListParam);

            exit(json_encode($data));
            break;
        case 'detail':
            $getDetailQuery = '
                SELECT
                    `idx`       ,
                    `email`     ,
                    `subject`   ,
                    `content`   ,
                    `regdate`
                FROM
                    `xrun_customer`
                WHERE
                    `idx` = ?
            ';
            $getDetailQueryParam = array($_POST['idx']);

            $data = result($getDetailQuery, $getDetailQueryParam);

            exit(json_encode($data));
            break;
        case 'count':
            break;
    }

    exit();