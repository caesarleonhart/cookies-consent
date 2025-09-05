<?php require_once __DIR__ . '/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home - Cookies Consent Demo</title>
	<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
	<script>window.BASE_URL = '<?= base_url() ?>';</script>
</head>
<body>
	<header>
		<div class="container">
			<nav class="nav">
				<a class="active" href="<?= base_url('index.php') ?>">Home</a>
				<a href="<?= base_url('about.php') ?>">About / Contact</a>
				<a href="<?= base_url('privacy.php') ?>">Privacy Policy</a>
				<a href="<?= base_url('terms.php') ?>">Terms & Conditions</a>
				<a href="<?= base_url('admin/login.php') ?>" class="ml-auto">Admin</a>
			</nav>
		</div>
	</header>
	<main class="container">
		<section class="hero">
			<h1>Welcome</h1>
			<p>This is a simple PHP + MySQL site demonstrating privacy consent with logging.</p>
		</section>
		<section class="grid">
			<div>
				<h2>Why cookies?</h2>
				<p>We use cookies that are necessary for the site to function, to analyze performance, and to provide a better experience.</p>
			</div>
			<div>
				<h2>Your choices</h2>
				<p>You can accept or decline. If you decline, the banner will reappear after one day or sooner if you clear cookies.</p>
			</div>
		</section>
	</main>
	<footer>
		<div class="container">&copy; <?php echo date('Y'); ?> Cookies Consent Demo</div>
	</footer>
	<script src="<?= base_url('assets/consent.js') ?>"></script>
</body>
</html>
