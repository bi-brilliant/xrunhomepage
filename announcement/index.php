<?php

if (!isset($_SERVER['PATH_INFO'])) {
  header('Location: ../');
}

$pageNotFound = false;
$existFiles = false;

$pathAnnouncementID = $_SERVER['PATH_INFO'];
$announcementID = preg_replace('/\D/', '', $pathAnnouncementID);
if ($_SERVER['PATH_INFO'] === '/' || $announcementID === '') {
  $pageNotFound = true;
} else {
  $conn = new mysqli("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "xrun");
  $sql = <<<SQL
SELECT
    `publicannouncement`.`announcement` as `index`,
    `publicannouncement`.`title` as `title`,
    `publicannouncement`.`contents` as `content`,
    `publicannouncement`.`writer` as `writer`,
    `publicannouncement`.`datetime` as `reg_date`,
    `publicannouncement`.`file` as `file`,
    `Files`.`attachments` as `thumbnail`
FROM
    xrun.`publicannouncement`
LEFT JOIN
    xrun.`Files`
ON
    `publicannouncement`.`thumbnail` = `Files`.`file`
WHERE
    `publicannouncement`.`type` =  9301  AND `publicannouncement`.`status` = 9401 
    AND `publicannouncement`.`announcement` =  $announcementID ORDER BY `publicannouncement`.`datetime` DESC
LIMIT 5  
SQL;

  $result = $conn->query($sql);

  $response = [];

  while ($data = mysqli_fetch_assoc($result)) {
    $response[] = array(
      "announcement" => $data["index"],
      "title" => $data["title"],
      "content" => $data["content"],
      "regDate" => $data["reg_date"],
      "writer" => $data["writer"],
      "thumbnail" => base64_encode($data["thumbnail"]),
      "file" => $data['file'],
    );
  }

  if (count($response) === 0) {
    $pageNotFound = true;
  }

  if ($response[0]['file'] !== NULL) {
    $files = [];

    $numberFiles = $response[0]['file'];
    $numberFilesArr = explode(',', $numberFiles);

    foreach ($numberFilesArr as $numberFile) {
      $file = intval($numberFile);
      $conn = new mysqli("database-80-xrun.cluster-ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!", "xrun");

      $sql = <<<SQL
          SELECT `attachments` as `file` FROM `Files` WHERE file = $file
          SQL;

      $result = $conn->query($sql);

      while ($data = mysqli_fetch_assoc($result)) {
        $files[] = array(
          "file" => base64_encode($data["file"]),
        );
      }
    }

    $existFiles = true;
  }
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

  <meta name="naver-site-verification" content="a6fa221f401d72258fe210fc6adde8f0fc7e53d1" />
  <!-- Fa Icon Kit Awesome -->
  <script src="https://kit.fontawesome.com/f8206e5b51.js" crossorigin="anonymous"></script>
  <meta name="naver-site-verification" content="a6fa221f401d72258fe210fc6adde8f0fc7e53d1" />

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
        <?php foreach ($response as $data): ?>
          <h1>
            <?= $data['title'] ?>
          </h1>
          <p class="date-article">
            <?= $data['regDate'] ?>
          </p>
          <p class="writer">Write by
            <?= $data['writer'] ?>
          </p>

          <div class="content-article">
            <img src="data:image/jpeg;base64,<?= $data['thumbnail'] ?>" alt="thumbnail" class="thumbnail-article">
            <div class="main-content-article">
              <p>
                <?= $data['content'] ?>
              </p>

              <?php if ($existFiles): ?>
                <div class="file-article">
                  <?php foreach ($files as $file): ?>
                    <img src="data:image/jpeg;base64,<?= $file['file'] ?>" alt="file">
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

            </div>
          </div>
        <?php endforeach; ?>


      </section>
    <?php endif; ?>
  </main>

  <!-- Footer -->
  <footer id="mainFooter" style="<?= $pageNotFound === true ? 'position: fixed; left: 0; right:0; bottom: 0;' : '' ?>">
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

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="../../assets/scripts/bootstrap.min.js"></script>
</body>