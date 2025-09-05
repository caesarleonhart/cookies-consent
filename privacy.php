<?php require_once __DIR__ . '/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Privacy Policy - Cookies Consent Demo</title>
	<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
	<script>window.BASE_URL = '<?= base_url() ?>';</script>
</head>
<body>
	<header>
		<div class="container">
			<nav class="nav">
				<a href="<?= base_url('index.php') ?>">Home</a>
				<a href="<?= base_url('about.php') ?>">About / Contact</a>
				<a class="active" href="<?= base_url('privacy.php') ?>">Privacy Policy</a>
				<a href="<?= base_url('terms.php') ?>">Terms & Conditions</a>
				<a href="<?= base_url('admin/login.php') ?>" class="ml-auto">Admin</a>
			</nav>
		</div>
	</header>
	<main class="container">
		<h1>Privacy Policy</h1>
		<p>This is a sample privacy policy. It describes how we collect, use, and protect your data. For demo purposes only.</p>
	</main>
	<footer>
		<div class="container">&copy; <?php echo date('Y'); ?> Cookies Consent Demo</div>
	</footer>
	<script src="<?= base_url('assets/consent.js') ?>"></script>
</body>
</html>
