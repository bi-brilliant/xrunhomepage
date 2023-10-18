<?php

function customQuery($getQuery)
{
    global $connection;
    $query = mysqli_query($connection, $getQuery);
    $results = [];
    while ($result = mysqli_fetch_assoc($query)) {
        $results[] = $result;
    }
    return $results;
}

function storeDataAPICMCToDatabase()
{
    global $connection;
    $maxDataRowAPICMC = customQuery("SELECT COUNT(cmc) FROM cmcdata")[0]["COUNT(cmc)"];

    if($maxDataRowAPICMC < 20) {
        // This API from https://pro.coinmarketcap.com/ and this using basic plan (For personal use)
        // This just sample data, get 20 data
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $APIKey = '9b12b985-f906-4084-a942-64fcfa00720f';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "$url?CMC_PRO_API_KEY=$APIKey&slug=xrun");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $results = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($results, true);
        $timestamp = $result["status"]["timestamp"];
        $self_reported_market_cap = $result['data']['19787']['self_reported_market_cap'];
        $cmc_rank = $result['data']['19787']['cmc_rank'];

        [
            'id' => $id,
            'name' => $name,
        ] = $result['data']['19787'];

        [
            'price' => $price,
            'volume_24h' => $volume_24h,
            'volume_change_24h' => $volume_change_24h,
            'percent_change_1h' => $percent_change_1h,
            'percent_change_24h' => $percent_change_24h,
            'percent_change_7d' => $percent_change_7d,
            'percent_change_30d' => $percent_change_30d,
            'percent_change_60d' => $percent_change_60d,
            'percent_change_90d' => $percent_change_90d,
            'market_cap_dominance' => $market_cap_dominance,
            'fully_diluted_market_cap' => $fully_diluted_market_cap,
            'tvl' => $tvl,
            'last_updated' => $last_updated,
        ] = $result['data']['19787']['quote']['USD'];

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

        mysqli_query($connection, $query);

    }
}

$url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
$APIKey = '9b12b985-f906-4084-a942-64fcfa00720f';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "$url?CMC_PRO_API_KEY=$APIKey&slug=xrun");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$results = curl_exec($curl);
curl_close($curl);

$result = json_decode($results, true);
echo json_encode($result);
// $timestamp = $result["status"]["timestamp"];
// $self_reported_market_cap = $result['data']['19787']['self_reported_market_cap'];
// $cmc_rank = $result['data']['19787']['cmc_rank'];

// [
//     'id' => $id,
//     'name' => $name,
// ] = $result['data']['19787'];

// [
//     'price' => $price,
//     'volume_24h' => $volume_24h,
//     'volume_change_24h' => $volume_change_24h,
//     'percent_change_1h' => $percent_change_1h,
//     'percent_change_24h' => $percent_change_24h,
//     'percent_change_7d' => $percent_change_7d,
//     'percent_change_30d' => $percent_change_30d,
//     'percent_change_60d' => $percent_change_60d,
//     'percent_change_90d' => $percent_change_90d,
//     'market_cap_dominance' => $market_cap_dominance,
//     'fully_diluted_market_cap' => $fully_diluted_market_cap,
//     'tvl' => $tvl,
//     'last_updated' => $last_updated,
// ] = $result['data']['19787']['quote']['USD'];
