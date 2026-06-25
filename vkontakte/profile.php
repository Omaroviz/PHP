<?php

include_once 'login.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['city_btn'])) {
	echo codetext('ws', "ww"); 
	echo $_POST['city'];
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vkontaktestyle.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="profile.css" type="text/css" media="all"/>
	<title>Моя страница</title>
</head>

<body>
<header style="">
	<div class="vkontakte-main-panel">
		<a href="vkontakte.html" class="vkontakte-text">
			<span class="vkontakte-main-text-B">В</span>контакте
		</a>
		<div class="vk-left">
			<a href="profile.html" class="vk-button">Моя страница</a>
			<a href="friends.html" class="vk-button">Друзья</a>
		</div>

		<div class="vk-right" id="vk-right">
			<a href="https://vkontakte.ucoz.site/online-1/messages.html" class="vk-button">Сообщения</a>
			<a href="#" class="vk-button">Поиск</a>
			<a href="login.html" class="vk-button" id="userStatus">Вход</a>
		</div>
	</div>

</header>

<main class="profile-main">
	<div class="page-container">
		<div class="page-wrapper">
			<div class="profile-row">
				<div class="page-layout">
					<div class="profile-info">
						<img src="media/Pavel_Durov_logo.jpg" alt="Фото профиля" class="profile-logo">
						<h1 class="profileName"><span><?php echo $_SESSION['name']?></span></h1>
						<h3>Личная информация:</h3>
						<ul>
						<li>Никнейм: <span id="profile-info-userName"><?php echo $_SESSION['username']?></span></li>
							<li>Возраст: <span id="profile-info-age">21</span>
								<button class="vk-button-btn"
								        style="max-width: 100px; text-align: center; padding: 1px; font-size: 10px"
								        onclick="prompt('Введите Ваш возраст:')">Изменить
								</button>
							</li>
							<li>
								<form method="POST">
								<label for="city-select">Город:</label>
								<select id="city-select" class="vk-button-btn" style="max-width: 120px; padding: 1px; font-size: 10px" name="city">
									<option value="vladivostok">Владивосток</option>
									<option value="khabarovsk">Хабаровск</option>
									<option value="izhevsk">Ижевск</option>
									<option value="makhachkala">Махачкала</option>
									<option value="tolyatti">Тольятти</option>
									<option value="tumen">Тюмень</option>
									<option value="saratov">Саратов</option>
									<option value="krasnodar">Краснодар</option>
									<option value="volgograd">Волгоград</option>
									<option value="perm">Пермь</option>
									<option value="voronezh">Воронеж</option>
									<option value="krasnoyarsk">Красноярск</option>
									<option value="omsk">Омск</option>
									<option value="rostov">Ростов-на-Дону</option>
									<option value="ufa">Уфа</option>
									<option value="samara">Самара</option>
									<option value="che">Челябинск</option>
									<option value="nn">Нижний Новгород</option>
									<option value="kazan">Казань</option>
									<option value="ekb">Екатеринбург</option>
									<option value="nsk">Новосибирск</option>
									<option value="spb">Санкт-Петербург</option>
									<option value="msk">Москва</option>
									<option value="other" selected>Другой город</option>
								</select>
							<button type="submit" name="city_btn">Enter</button>
							</form>
							</li>
							<li>О себе:
								<button class="vk-button-btn"
								        style="max-width: 100px; text-align: center; padding: 1px; font-size: 10px"
								        onclick="prompt('Введите текст:')">Изменить
								</button>
							</li>
						</ul>
					</div>
					<div class="profile-post-container">
						<div class="post">
							Нашел сайт Беларусии <a href="https://www.belarus.by/ru">belarus.by/ru</a>
						</div>
						<div class="post">
							<p class="postmain">Самый первый сайт</p>
							Еще до Вконтакте Druza была сеть сайтов R.E.A.C.T. Она включала в себя главную страницу, литернет,
							WebDonwloads и т.д. Первая версия Вконтакте Druza тоже входила в этот список, но была удален из-за слишкой
							разницы между Сетью R.E.A.C.T и Вконтакте. Сейчас проект заброшен, но все равно его моно найти по это
							ссылке:
							<a href="https://kazah.ucoz.net/Browser_Main/Browser.html">https://kazah.ucoz.net/Browser_Main/Browser.html</a>
						</div>
						<div class="post">
							<p class="postmain">Lorem ipsum.</p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid animi aspernatur at cum cumque
							deleniti dicta, dignissimos dolore dolorem doloribus eius enim error est, eum facere facilis hic illo
							illum in
							ipsum minima modi molestiae necessitatibus nesciunt non odio omnis quos repellat repellendus rerum
							sapiente
							tempora vero? Beatae excepturi laboriosam laborum, officia quia quisquam repellendus. Ad aliquam amet,
							blanditiis consequuntur doloribus, eligendi enim eos est et eveniet hic, impedit ipsam laborum minima
							nesciunt
							non obcaecati odio omnis quae rem similique sit sunt suscipit. Aliquid, aspernatur consequuntur ea
							excepturi
							expedita facere, id ipsa maiores modi non odio perspiciatis possimus quae similique tempora ullam vitae
							voluptas voluptate! Aliquid aperiam blanditiis consectetur cum cumque debitis, deserunt distinctio
							doloremque
							dolorum enim fuga hic incidunt magni necessitatibus, nesciunt odit quia rem repellat saepe veritatis.
							Impedit,
							nihil, nostrum? Aliquam autem consequatur debitis delectus dicta doloremque eaque earum ex hic ipsa ipsam
							itaque iusto necessitatibus nemo neque obcaecati, officiis placeat praesentium quo similique sit sunt
							vitae
							voluptas. Amet, consequatur deserunt dolorem doloremque et facilis ipsum labore maiores minima, nisi
							pariatur
							porro quasi quia quis recusandae rerum ullam veritatis. Animi consequuntur deserunt dolore facilis harum
							in
							inventore iste, laborum natus obcaecati quam quidem quis quo sunt, voluptates?
						</div>
						<!--				<div class="post">-->
						<!--					<p class="postmain">Тест Видео</p>-->
						<!--					<video controls style="max-width: 300px; width: 100%; aspect-ratio: 9 / 16; object-fit: cover;">-->
						<!--						<source src="video-real.mp4" type="video/mp4">-->
						<!--					</video>-->
						<!--				</div>-->
						<div class="post">
							Мы здесь не для того, чтобы подстраиваться под реальность. Мы здесь для того, чтобы заставить реальность
							подстроиться под нас
						</div>
						<div class="post">
							<p class="postmain">Привет.</p>
							<img src="media/IMG_0490.PNG" alt="Собака Вконтакте" width="300px">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script src="main.js"></script>
<script src="profile.js"></script>
</body>

</html>
































