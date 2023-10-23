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

$sql = <<<SQL
SELECT
    `minings`.`mining` as `mining`,
    `minings`.`title` as `title`,
    `minings`.`link` as `link`,
    `minings`.`writer` as `writer`,
    `minings`.`datetime` as `reg_date`
FROM
    xrun.`minings`
WHERE
    `minings`.`type` = $boardType AND `minings`.`status` = 9401
ORDER BY `minings`.`mining` DESC
SQL;

$result = $conn->query($sql);
$response = [];

while ($data = mysqli_fetch_assoc($result)) {
    $response[] = array(
        "mining" => $data["mining"],
        "title" => $data["title"],
        "link" => $data["link"],
        "regDate" => $data["reg_date"],
        "writer" => $data["writer"],
    );
}

echo json_encode($response);
