<?php

if (!isset($_SERVER['PATH_INFO'])) {
  header('Location: ../');
}

$pageNotFound = false;

$pathAnnouncementID = $_SERVER['PATH_INFO'];
$announcementID = preg_replace('/\D/', '', $pathAnnouncementID);

if ($_SERVER['PATH_INFO'] === '/' || $announcementID === '') {
  $pageNotFound = true;
}

$conn = new mysqli("localhost", "root", "root", "xrun");
$sql = '
SELECT
    `publicannouncement`.`announcement` as `index`,
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
    `publicannouncement`.`type` = ' . 9301 . ' AND `publicannouncement`.`status` = 9401
ORDER BY `publicannouncement`.`datetime` DESC
LIMIT 5';

$result = $conn->query($sql);
$response = [];

while ($data = mysqli_fetch_assoc($result)) {
  $response[] = array(
    "announcement" => $data["index"],
    "title" => $data["title"],
    "content" => $data["content"],
    "regDate" => $data["reg_date"],
    "writer" => $data["writer"],
    "file" => base64_encode($data["file"]),
  );
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <!-- Title 16 -->
  <title>XRUN</title>
  <!-- Meta tags -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="XRUN, xrun, 엑스런, 액스런, XRUN코인, 코인, 암호화폐, 광고 플랫폼, 온라인 광고, 블럭체인, blockchain" />
  <meta name="description" content="누구나 참여할 수 있는 에어드랍 광고 플랫폼 XRUN" />
  <meta name="author" content="Jenn, ThemeForces.com" />
  <!-- 캐시를 바로 만료시킴. 
  <meta http-equiv="Expires" content="-1" />-->
  <link href="../../assets/images/logo_visual_black.png" rel="shortcut icon" />



  <!-- Stylesheets -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css" />
  <link rel="stylesheet" href="../../assets/css-bak/bootstrap_n.css" />
  <link rel="stylesheet" href="../../assets/css-bak/font-awesome.css" />
  <link rel="stylesheet" href="../../assets/css-bak/owl.carousel.css" />
  <link rel="stylesheet" href="../../assets/css-bak/owl.theme.default.min.css" />
  <link rel="stylesheet" href="../../assets/css-bak/animate.css" />
  <link rel="stylesheet" href="../../assets/css-bak/swiper.css" />
  <!-- <link rel="stylesheet" href="../../assets/css-bak/xrun_n.css" /> -->
  <link rel="stylesheet" href="../../assets/css-bak/xrun_nLagi.css" />
  <link rel="stylesheet" href="../../assets/css-bak/editor.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />

  <!-- Slick CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />

  <!-- Token Economy Style -->
  <link rel="stylesheet" href="../../assets/css-bak/xrun_tokenomic.css" />

  <script src="../../assets/scripts/swiper.min.js"></script>

  <meta name="naver-site-verification" content="a6fa221f401d72258fe210fc6adde8f0fc7e53d1" />
  <!-- Fa Icon Kit Awesome -->
  <script src="https://kit.fontawesome.com/f8206e5b51.js" crossorigin="anonymous"></script>
  <meta name="naver-site-verification" content="a6fa221f401d72258fe210fc6adde8f0fc7e53d1" />

  <!-- <link
      rel="stylesheet"
      href="https://code.highcharts.com/css/highcharts.css"
    /> -->
  <!-- Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css" />
</head>

<!-- Datatables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
</head>

<body class="en">
  <div class="loading-overlay">
    <div class="loading-logo"></div>
  </div>
  <div class="whitepaper-overlay">
    <div class="row">
      <div class="col-md-11"></div>
      <div class="col-md-1 rel">
        <a class="whiltepaper-btn-close" href=""></a>
      </div>
    </div>
  </div>
  <!-- Navigation Start -->
  <nav class="navbar navbar-default">
    <div class="container header-container">
      <div class="navbar-header page-scroll">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <i class="fas fa fa-bars"></i>
        </button>
        <a class="navbar-brand page-scroll" href="/">
          <img src="../../assets/images/logo-xrun-w-new.png" alt="logo-xrun" height="28" />
        </a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="hidden">
            <a href="#page-top"></a>
          </li>
          <li>
            <a class="page-scroll" id="navAbout" href="../../#introduction">About XRUN</a>
          </li>
          <!-- <li>
              <a class="page-scroll" href="../../#our-products">Products</a>
            </li> -->
          <li>
            <a class="page-scroll" id="navClubx" href="../../#clubx">CLUBX</a>
          </li>
          <li>
            <a class="page-scroll" id="navWallet" href="../../#dapp">Wallet</a>
          </li>
          <li>
            <a class="page-scroll" id="navToken" href="../../#economy">Token Economy</a>
          </li>
          <li>
            <a class="page-scroll" id="navToken" href="../../#disclosure">Disclosure</a>
          </li>
          <li>
            <a class="page-scroll" id="navRoadmap" href="../../#roadmap">Roadmap</a>
          </li>
          <li>
            <a class="page-scroll" id="navNotice" href="../../#notice">Notice/Event</a>
          </li>
          <li>
            <a class="page-scroll beforeNone" id="navContact" href="../../#contact">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation End -->

  <main>
    <?php if ($pageNotFound): ?>
      <p class="page-not-found">Page not found</p>
    <?php else: ?>

      <section class="container">
        <h1>Halo brader semua kenalin gue adalah bos besar yakuza</h1>
        <p class="writer">Write by Jajang</p>

        <div class="content-article">
          <img
            src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?auto=format&fit=crop&q=80&w=2070&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="thumbnail" class="thumbnail-article">
          <div class="main-content-article">
            <p>
              Dear users, DigiFinex will list XRUN at 11:00 (GMT+8), Nov 8th, 2021. The trading service of XRUN/USDT will
              be opened at 16:00 (GMT+8), Nov 8th, 2021. The specific schedule is as follows: Time of deposit opening:
              11:00 (GMT+8), Nov 8th, 2021 Time of trade opening: 16:00 (GMT+8), Nov 8th, 2021 Time of withdrawal opening:
              11:00 (GMT+8), Nov 8th, 2021 Trading pair: XRUN/BTC Project name: XRUN Official website: http://www.xrun.run
              Block explorer: https://etherscan.io/address/0x5833dbb0749887174b254ba4a5df747ff523a905 XRUN is a blockchain
              using XR (Extended Reality) + RUN.XCA (XRUN Consensus Algorithm) is an applied consensus algorithm of
              XRUN.PoD (Proof-of-Discovery) is mining through XRUN dApp and PoS (Proof-of-Stake) is rewarded with XRUN
              during the staking period.XRUN is location-based (GPS) and adopts the ERC-1155 protocol so that the
              replaceable item ERC-20 and the non-fungible item ERC-721 token (Non-Fungible Token: NFT) can be traded in
              one smart contract.As for the token acquisition method, tokens can be acquired by holding the augmented
              advertisement using the XRUN AR camera and performing the advertiser's mission.Tokens held are digital
              contents, real estate, paintings, jewelry, cultural assets, etc. Risk Alert: This is a new token project
              that poses higher risks than others, which will face potential high price volatility. Please ensure you have
              done your own research in regards to the fundamental concepts and fully understand this project before
              opting to trade. DigiFinex will make the best efforts to list high-quality token projects, but will not be
              responsible for any of your trading losses. Thank you for your support! DigiFinex Team Nov 5th, 2021
              DigiFinex communities: Telegram Official Community: https://t.me/DigiFinexEN Telegram AMA Community:
              https://t.me/DigiFinexAMA Official Facebook: https://www.facebook.com/digifinex.global Official Twitter:
              https://twitter.com/digifinex Official Instagram: https://www.instagram.com/digifinex.global Official
              Medium: https://medium.com/@digifinex Official Reddit: https://www.reddit.com/user/DigiFinex/ Official
              Kakao: https://open.kakao.com/o/giKpLDsb DigiFinex (digifinex.com)DIGIFINEX LIMITED. reserves all rights of
              this event, including but not limited to adjustment, explanation and termination at any time.
            </p>

            <div class="file-article">
              <img
                src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=2070&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="file">
              <img
                src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=2070&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="file">
              <img
                src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=2070&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="file">
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>
  </main>

  <!-- Footer -->
  <footer id="mainFooter">
    <!-- <div class="footer-head d-flex justify-content-center pt-5">
        <img src="../clubx_homepage/assets/images/logo_w.png" />
      </div> -->
    <div class="footer-content mt-4 pb-5">
      <div>
        <p class="mb-0 text-align-center f-desc text-white">
          FirstFloor, First St Vincent Bank Ltd Building, James Street,
          Kingstown. St. Vincent and the Grenadines. <br />
          Personal data privacy management : Hyukil-Kwon
          <br />
          © 2019 XRUN LLC. All Rights Reserved.
        </p>
        <br />
        <p class="mb-0 mt-3 text-align-center f-desc text-white">
          Private BugBounter Program Now Available (Post your resume to
          xrun@xrun.run for companion)
        </p>
      </div>
    </div>

    <div class="scrollToTop scroll-visible">
      <a href="javascript:;" onclick="$('html').animate({scrollTop : 0},500)"><i class="fas fa-chevron-up"></i></a>
    </div>
    <!-- <div class="scrollToTop scroll-visible"> -->
    <div class="paper-container">
      <a href="../../clubx_homepage/assets/files/XRUN_whitepaperv2023.pdf" download class="download-paper-wrapper">
        WP
      </a>
      <a href="../../clubx_homepage/assets/files/XRUN IR 2023.pdf" download class="download-paper-wrapper">
        IR
      </a>
    </div>
  </footer>
  <!-- End footer -->
</body>