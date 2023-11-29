<?php
namespace PHPMaker2020\sistema;

// Autoload
include_once "autoload.php";

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	\Delight\Cookie\Session::start(Config("COOKIE_SAMESITE")); // Init session data

// Output buffering
ob_start();
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$home = new home();

// Run the page
$home->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>FitHome Studio - Bem-Vindo</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			padding-top: 56px; /* Ajuste para a altura da barra de navegação */
		}

		/* Estilo para garantir que todas as imagens do carousel tenham o mesmo tamanho */
		.carousel-inner img {
			width: 100%;
			height: 300px; /* Altura desejada */
			object-fit: cover; /* Manter a proporção da imagem */
		}
	</style>
</head>
<body>

<div class="container mt-5">

	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<div class="carousel-indicators">
			<button type="button" data-target="#carouselExampleIndicators" data-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-target="#carouselExampleIndicators" data-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-target="#carouselExampleIndicators" data-slide-to="2" aria-label="Slide 3"></button>
		</div>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="/img/banner.jpg" class="d-block w-100" alt="Banner 1">
			</div>
			<div class="carousel-item">
				<img src="/img/banner1.jpg" class="d-block w-100" alt="Banner 2">
			</div>
			<div class="carousel-item">
				<img src="/img/banner2.jpg" class="d-block w-100" alt="Banner 3">
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>

	<h1 class="mt-5">Bem-Vindo ao FitHome Studio</h1>
	<p class="lead">Transforme sua casa em seu próprio estúdio de fitness! No FitHome Studio, oferecemos uma variedade de treinos virtuais para você se manter ativo e saudável no conforto da sua casa.</p>
	<p>Descubra uma nova maneira de se exercitar, mantenha-se motivado e alcance seus objetivos de condicionamento físico.</p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php if (Config("DEBUG")) echo GetDebugMessage(); ?>
<?php include_once "footer.php"; ?>
<?php
$home->terminate();
?>