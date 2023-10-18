
    <?php
        $title = 'CONTACT US';
    include './templates/header.php'
    ?>

    
    <!-- Header Start
    <header>
        <div class="sub_top team text-center">
        </div>
    </header> -->
    <!-- Header End -->

    <section id="sub" class="light-bg section-common">
        <div class="container contact">	
			<form id="requestForm" action="#">
				<input id="formEmail" name="email" type="text" placeholder="EMAIL">
				<input id="formSubject" name="subject" type="text" placeholder="SUBJECT">
				<textarea id="formContent" name="content" cols="30" rows="10" placeholder="MESSAGE"></textarea>
				<button>SEND</button>
			</form>
			<div class="social-wrap text-center">
				<a href=""><img src="./assets/images/icon_gmail.png" alt=""></a>
				<a href="http://pf.kakao.com/_QuLaj" target="_blank"><img src="./assets/images/icon_kakao.png" alt=""></a>
				<a href="https://t.me/joinchat/J96dxESl49DjghhZN60J3A" target="_blank"><img src="./assets/images/icon_telegram.png" alt=""></a>
			</div>
        </div>
    </section>

    
    <?php include './templates/footer.php' ?>