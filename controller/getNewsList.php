<?php

// include './../model/database_n.php';
// $sql = '
//         SELECT
//             `Boards`.`board` as `index`,
//             `Boards`.`title` as `title`,
//             `Boards`.`contents` as `content`,
//             `Boards`.`datetime` as `reg_date`
//         FROM
//             `Boards`
//         WHERE
//             `type` = ? AND `status` = 9401

//         ORDER BY `datetime` DESC
//         LIMIT 5
//     ';
// $sql;
// $bind = array( $_GET['boardType'] );

// $data = resultAll($sql, $bind);


// exit(json_encode($data));

$conn = new mysqli("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "xrun");
// $conn = mysqli_connect("localhost", "root", "root", "xrun", 3306);

$boardType = $_GET['boardType'];

if(isset($_GET["exceptID"])) {
    $exceptID = $_GET["exceptID"];

    $sql = <<<SQL
        SELECT
            `publicannouncement`.`announcement` as `announcement`,
            `publicannouncement`.`title` as `title`,
            `publicannouncement`.`contents` as `contents`,
            `publicannouncement`.`writer` as `writer`,
            `publicannouncement`.`datetime` as `reg_date`
        FROM
            xrun.`publicannouncement`
        WHERE
            `publicannouncement`.`type` = $boardType 
        AND `publicannouncement`.`status` = 9401
        AND `publicannouncement`.`announcement` != $exceptID
        ORDER BY `publicannouncement`.`announcement` DESC
    SQL;
} else {
    // Kayak artikel
    $sql = <<<SQL
        SELECT
            `publicannouncement`.`announcement` as `announcement`,
            `publicannouncement`.`title` as `title`,
            `publicannouncement`.`contents` as `contents`,
            `publicannouncement`.`writer` as `writer`,
            `publicannouncement`.`datetime` as `reg_date`
        FROM
            xrun.`publicannouncement`
        WHERE
            `publicannouncement`.`type` = $boardType AND `publicannouncement`.`status` = 9401
        ORDER BY `publicannouncement`.`announcement` DESC
    SQL;

    // Dengan link ke website lain
    // $sql = <<<SQL
    //     SELECT
    //         `publicannouncement2`.`announcement` as `announcement`,
    //         `publicannouncement2`.`title` as `title`,
    //         `publicannouncement2`.`link` as `link`,
    //         `publicannouncement2`.`writer` as `writer`,
    //         `publicannouncement2`.`datetime` as `reg_date`
    //     FROM
    //         xrun.`publicannouncement2`
    //     WHERE
    //         `publicannouncement2`.`type` = $boardType AND `publicannouncement2`.`status` = 9401
    //     ORDER BY `publicannouncement2`.`announcement` DESC
    // SQL;
}



$result = $conn->query($sql);
$response = [];

// Kayak artikel
while ($data = mysqli_fetch_assoc($result)) {
    $response[] = array(
        "announcement" => $data["announcement"],
        "title" => $data["title"],
        "contents" => $data["contents"],
        "regDate" => $data["reg_date"],
        "writer" => $data["writer"],
    );
}

// Dengan link ke website lain
    // while ($data = mysqli_fetch_assoc($result)) {
    //     $response[] = array(
    //         "announcement" => $data["announcement"],
    //         "title" => $data["title"],
    //         "link" => $data["link"],
    //         "regDate" => $data["reg_date"],
    //         "writer" => $data["writer"],
    //     );
    // }

echo json_encode($response);
