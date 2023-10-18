<?php

$db;

function query($sql, $arr = [])
{
    // $db = new PDO("mysql:host=xrundbinstance.ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com; dbname=xrun; charset=utf8;", 'xrundb', 'xrundatA6a52!!');
    // $db = new PDO("mysql:host=db-main-master.ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com; dbname=xrun; charset=utf8;", 'xrundb', 'xrundatA6a52!!');
    $db = new PDO("mysql:host=database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com; dbname=xrun; charset=utf8;", 'xrundb', 'xrundatA6a52!!');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($arr);
        return $stmt;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function result($sql, $arr = [])
{
    return query($sql, $arr)->fetch(PDO::FETCH_ASSOC);
}

function resultAll($sql, $arr = [])
{
    return query($sql, $arr)->fetchAll(PDO::FETCH_ASSOC);
}
