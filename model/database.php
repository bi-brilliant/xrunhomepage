<?php

    $db;

    function query($sql, $arr=[]) {
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

    function result($sql, $arr=[]){
        return query($sql, $arr)->fetch(PDO::FETCH_ASSOC);
    }

    function resultAll($sql, $arr=[]){
        return query($sql, $arr)->fetchAll(PDO::FETCH_ASSOC);
    }