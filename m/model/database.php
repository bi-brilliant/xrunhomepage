<?php

    $db;

    function query($sql, $arr=[]) {
        $db = new PDO('mysql:host=127.0.0.1; dbname=xrun; charset=utf8', 'root', 'bA4ahrzww');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($arr);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }