<?php

$xrunConn = mysqli_connect("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "xrun");
$connection = mysqli_connect("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "tempxscan");
// $xrunConn = mysqli_connect("localhost", "root", "root", "xrun", 3306);
// $connection = mysqli_connect("localhost", "root", "", "tempxscan", 3307);

if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_REQUEST["action"];
if (!$action) {
    echo 'illegal access';
    return;
}

header('Content-Type: application/json');

switch ($action) {
    // Get Coin Market Cap Data
    case 'getCMCData':
        $query = mysqli_query($connection, "SELECT * FROM `cmcdata`");

        while ($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

    // Get Yesterday Price of Coin
    case 'getYesterdayData':
        $query = mysqli_query($connection, "SELECT * 
                                            FROM `cmcdata` 
                                            WHERE DATE_FORMAT(`timestamp`, '%Y-%m-%d') = DATE_SUB(CURDATE(), INTERVAL 1 DAY);");

        while ($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

    // Get Disclosure Data
    case 'getDisclosureData':
        $query = mysqli_query($xrunConn, "SELECT * FROM `disclosure`");

        while ($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

    // Get Disclosure Data
    case 'getLatestCMC':
        $query = mysqli_query($connection, "SELECT * FROM `cmcdata`  
        ORDER BY `cmcdata`.`cmc` DESC LIMIT 1");

        // while($data = mysqli_fetch_assoc($query)) {
        //     $result[] = $data;
        // }
        $data = mysqli_fetch_assoc($query);

        echo json_encode($data);
        break;

    // Get Disclosure Data
    case 'saveCMCData':
        $timestamp = $_GET['timestamp'];
        $id = $_GET['id'];
        $name = $_GET['name'];
        $cmc_rank = $_GET['cmc_rank'];
        $price = $_GET['price'];
        $volume_24h = $_GET['volume_24h'];
        $volume_change_24h = $_GET['volume_change_24h'];
        $percent_change_1h = $_GET['percent_change_1h'];
        $percent_change_24h = $_GET['percent_change_24h'];
        $percent_change_7d = $_GET['percent_change_7d'];
        $percent_change_30d = $_GET['percent_change_30d'];
        $percent_change_60d = $_GET['percent_change_60d'];
        $percent_change_90d = $_GET['percent_change_90d'];
        $fully_diluted_market_cap = $_GET['fully_diluted_market_cap'];
        $market_cap_dominance = $_GET['market_cap_dominance'];
        $self_reported_market_cap = $_GET['self_reported_market_cap'];
        $last_updated = $_GET['last_updated'];


        $query = "INSERT INTO cmcdata VALUES (
            NULL,
            '$timestamp',
            $id,
            '$name',
            $cmc_rank,
            '$price',
            '$volume_24h',
            '$volume_change_24h',
            '$percent_change_1h',
            '$percent_change_24h',
            '$percent_change_7d',
            '$percent_change_30d',
            '$percent_change_60d',
            '$percent_change_90d',
            '$fully_diluted_market_cap',
            '$market_cap_dominance',
            '$self_reported_market_cap',
            NULL,
            '$last_updated')";

        $query = mysqli_query($connection, $query);

        if ($query) {
            echo "success";
        } else {
            echo "no";
        }
        break;


    case "getXrunToken":
        $query = mysqli_query($xrunConn, "SELECT `xruntokens`.`xruntoken` as `xruntoken`, `xruntokens`.`title` as `title`, `xruntokens`.`market_listing` as `market_listing`, `xruntokens`.`datetime` as `regDate`, `xruntokens`.`file` as `file` FROM xrun.`xruntokens` LEFT JOIN xrun.`Files` ON
    `xruntokens`.`file` = `Files`.`file` WHERE `xruntokens`.`type` = 9301 AND `xruntokens`.`status` = 9401 ORDER BY `xruntokens`.`xruntoken` DESC");

        while ($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

        case "detailXrunToken":
            $xruntoken = $_GET['xruntoken'];
            $images = [];

            $query = mysqli_query($xrunConn, "SELECT `xruntoken`,`title`,`market_listing`,`file`, `datetime` FROM `xruntokens` WHERE `xruntokens`.`xruntoken` = $xruntoken");
            while ($data = mysqli_fetch_assoc($query)) {
                if($data['file'] != '' || $data['file'] != null) {
                    $files = explode(',', $data['file']);

                    foreach($files as $file) {
                        $queryImage = mysqli_query($xrunConn, "SELECT `attachments` FROM `files` WHERE `files`.`file` = $file");
                        $image = mysqli_fetch_assoc($queryImage);
                        $convertBase64 = base64_encode($image['attachments']);
                        $images[] = $convertBase64;
                    }
            }
                $result[] = array(
                    "data" => $data,
                    "images" => $images,
                );
            }

        echo json_encode($result);
            break;

    case "getMining":
        $query = mysqli_query($xrunConn, "SELECT `minings`.`mining` as `mining`, `minings`.`title` as `title`, `minings`.`market_listing` as `market_listing`, `minings`.`datetime` as `regDate`, `minings`.`file` as `file` FROM xrun.`minings` LEFT JOIN xrun.`Files` ON
    `minings`.`file` = `Files`.`file` WHERE `minings`.`type` = 9301 AND `minings`.`status` = 9401 ORDER BY `minings`.`mining` DESC");

        while ($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

        case "detailMining":
            $mining = $_GET['mining'];
            $images = [];

            $query = mysqli_query($xrunConn, "SELECT `mining`,`title`,`market_listing`,`file`, `datetime` FROM `minings` WHERE `minings`.`mining` = $mining");
            while ($data = mysqli_fetch_assoc($query)) {
                if($data['file'] != '' || $data['file'] != null) {
                    $files = explode(',', $data['file']);

                    foreach($files as $file) {
                        $queryImage = mysqli_query($xrunConn, "SELECT `attachments` FROM `files` WHERE `files`.`file` = $file");
                        $image = mysqli_fetch_assoc($queryImage);
                        $convertBase64 = base64_encode($image['attachments']);
                        $images[] = $convertBase64;
                    }


            }
                $result[] = array(
                    "data" => $data,
                    "images" => $images,
                );
            }

        echo json_encode($result);
            break;

}
