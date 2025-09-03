<?php require_once __DIR__ . '/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home - Cookies Consent Demo</title>
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
	<header>
		<div class="container">
			<nav class="nav">
				<a class="active" href="/index.php">Home</a>
				<a href="/about.php">About / Contact</a>
				<a href="/privacy.php">Privacy Policy</a>
				<a href="/terms.php">Terms & Conditions</a>
				<a href="/admin/login.php" class="ml-auto">Admin</a>
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
	<script src="/assets/consent.js"></script>
</body>
</html>
