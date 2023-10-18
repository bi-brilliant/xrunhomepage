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

$sql = '
SELECT
    `Boards`.`board` as `index`,
    `Boards`.`title` as `title`,
    `Boards`.`contents` as `content`,
    `Boards`.`datetime` as `reg_date`,
    `Files`.`attachments` as `file`
FROM
    xrun.`Boards`
LEFT JOIN
    xrun.`Files`
ON
    `Boards`.`thumbnail` = `Files`.`file`
WHERE
    `Boards`.`type` = ' . $boardType . ' AND `Boards`.`status` = 9401
ORDER BY `Boards`.`datetime` DESC
LIMIT 5
    ';

$result = $conn->query($sql);

while($data = mysqli_fetch_assoc($result)) {
    $jams[] = array(
        "title" => $data["title"],
        "content" => $data["content"] ,
        "regDate" => $data["reg_date"],
        "file" => base64_encode($data["file"]),
    );
}

echo json_encode($jams);
