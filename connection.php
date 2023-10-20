<?php

$xrunConn = mysqli_connect("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "xrun");
$connection = mysqli_connect("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "tempxscan");
// $xrunConn = mysqli_connect("localhost", "root", "", "xrun", 3307);
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

        while($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

        // Get Yesterday Price of Coin
    case 'getYesterdayData':
        $query = mysqli_query($connection, "SELECT * 
                                            FROM `cmcdata` 
                                            WHERE DATE_FORMAT(`timestamp`, '%Y-%m-%d') = DATE_SUB(CURDATE(), INTERVAL 1 DAY);");

        while($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

        // Get Disclosure Data
    case 'getDisclosureData':
        $query = mysqli_query($xrunConn, "SELECT * FROM `disclosure`");

        while($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
        break;

        // Get Disclosure Data
    case 'getLatestCMC':
        $query = mysqli_query($connection, "SELECT * FROM `cmcdata`  
        ORDER BY `cmcdata`.`cmc` DESC LIMIT 1");

        while($data = mysqli_fetch_assoc($query)) {
            $result[] = $data;
        }

        echo json_encode($result);
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

        if($query) {
            echo "success";
        } else {
            echo "no";
        }
        break;


        // ----- Sign Up
    case 'signup':
        $username = htmlspecialchars($_GET["username"], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_GET["password"], ENT_QUOTES, 'UTF-8');
        $region = $_GET["codeRegion"];
        $country = $_GET["country"];
        $countryCode = $_GET['countryCode'];
        $mobile = $_GET["mobile"];
        $gender = $_GET["gender"];
        $age = $_GET["age"];
        $encryptPassword = password_hash($password, PASSWORD_DEFAULT);
        $nickname = htmlspecialchars($_GET["nickname"], ENT_QUOTES, 'UTF-8');

        $query = mysqli_query($conn, "INSERT INTO `members` 
                                                    (`member`, `uuid`, `type`, 
                                                     `email`, `pin`, 
                                                     `username`, `nickname`, `mobilecode`, 
                                                     `mobile`, `ages`, 
                                                     `gender`, `country`, 
                                                     `countrycode`, `region`, 
                                                     `status`, `datechanged`, 
                                                     `wallet`, `datejoin`, 
                                                     `datepinchanged`, `isLockable`) 
                                            VALUES (NULL, '', '1001', 
                                                    '$email', '$encryptPassword', 
                                                    '$username', '$nickname', '$country', 
                                                    '$mobile', '$age',
                                                    '$gender', $country, 
                                                    '$countryCode', $region, 
                                                    '1001', current_timestamp(), 
                                                    '0', current_timestamp(), 
                                                    current_timestamp(), b'0'
                                                    )");

        if ($query) {
            $newID = mysqli_insert_id($conn);

            $hash = md5($newID);
            $uuid = substr($hash, 0, 6);

            $addUUID = mysqli_query($conn, "UPDATE `members` SET `uuid` = '$uuid' WHERE `members`.`member` = $newID;");

            if ($addUUID) {
                $hairInventory = $gender == 1101 ? '1,2,3,4,5,6' : '1,2,3,4,5,6,7,8,9,10,11';
                // Insert Character Setting for New Member with Default Data
                $createCharacter = mysqli_query($conn, "INSERT INTO `character` (`char_ID`, `member`, 
                                                                                 `head_face`, `head_eye`, 
                                                                                 `head_ear`, `head_mouth`, 
                                                                                 `head_nose`, `hair_style`,
                                                                                 `hair_inventory`, 
                                                                                 `body_height`, `body_fat`, 
                                                                                 `skin_color`, `skin_saturation`, 
                                                                                 `skin_hue`, `clothes_inventory`, 
                                                                                 `clothes_current`, `datecreate`, 
                                                                                 `dateupdate`) 
                                                                        VALUES (NULL, '$newID', 
                                                                                '0.0000000000000000000000000', '0.0000000000000000000000000', 
                                                                                '0.0000000000000000000000000', '0.0000000000000000000000000', 
                                                                                '0.0000000000000000000000000', '1', 
                                                                                '$hairInventory',
                                                                                '1.0000000000000000000000000', '1.0000000000000000000000000', 
                                                                                '(R=1.000000,G=1.000000,B=1.000000,A=1.000000)', '0.0000000000000000000000000', 
                                                                                '1.0000000000000000000000000', '4', 
                                                                                '4', current_timestamp(), 
                                                                                current_timestamp());");


                if ($createCharacter) {
                    $createWallet = mysqli_query($conn, "INSERT INTO `wallet` (`wallet`, `member`, 
                                                                               `point`, `coin`, 
                                                                               `currency`, `timestamp`, 
                                                                               `timeUpdate`) 
                                                                       VALUES (NULL, '$newID', 
                                                                               '25000', '0', 
                                                                               '1', NOW(), 
                                                                               NOW())");

                    if($createWallet) {
                        $response = array(
                            "status" => 1,
                            "message" => "Success",
                            "data" => [
                                [
                                    "statusDesc" => "success"
                                ]
                            ]
                        );
                    } else {
                        $response = array(
                            "status" => 1,
                            "message" => "Character Failed Insert",
                            "data" => [
                                [
                                    "statusDesc" => "failInsert"
                                ]
                            ]
                        );
                    }
                } else {
                    $response = array(
                        "status" => 1,
                        "message" => "Character Failed Insert",
                        "data" => [
                            [
                                "statusDesc" => "failInsert"
                            ]
                        ]
                    );
                }
            }
        } else {
            $response = array(
                "status" => 0,
                "message" => "Fail",
                "data" => [
                    [
                        "statusDesc" => "fail"
                    ]
                ]
            );
        }

        echo json_encode($response);
        break;

}
