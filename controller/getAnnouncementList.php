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

$boardType = $_GET['boardType'];

$sql = <<<SQL
SELECT
    `publicannouncement`.`announcement` as `announcement`,
    `publicannouncement`.`title` as `title`,
    `publicannouncement`.`contents` as `content`,
    `publicannouncement`.`writer` as `writer`,
    `publicannouncement`.`datetime` as `reg_date`,
    `Files`.`attachments` as `file`
FROM
    xrun.`publicannouncement`
LEFT JOIN
    xrun.`Files`
ON
    `publicannouncement`.`thumbnail` = `Files`.`file`
WHERE
    `publicannouncement`.`type` = $boardType AND `publicannouncement`.`status` = 9401
ORDER BY `publicannouncement`.`datetime` DESC
LIMIT 5
SQL;

$result = $conn->query($sql);
$response = [];

while ($data = mysqli_fetch_assoc($result)) {
    $response[] = array(
        "announcement" => $data["announcement"],
        "title" => $data["title"],
        "content" => $data["content"],
        "regDate" => $data["reg_date"],
        "writer" => $data["writer"],
        "file" => base64_encode($data["file"]),
    );
}

echo json_encode($response);