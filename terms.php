<?php require_once __DIR__ . '/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Terms & Conditions - Cookies Consent Demo</title>
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
	<header>
		<div class="container">
			<nav class="nav">
				<a href="/index.php">Home</a>
				<a href="/about.php">About / Contact</a>
				<a href="/privacy.php">Privacy Policy</a>
				<a class="active" href="/terms.php">Terms & Conditions</a>
				<a href="/admin/login.php" class="ml-auto">Admin</a>
			</nav>
		</div>
	</header>
	<main class="container">
		<h1>Terms & Conditions</h1>
		<p>These are sample terms and conditions for demonstration. Please replace with your actual terms.</p>
	</main>
	<footer>
		<div class="container">&copy; <?php echo date('Y'); ?> Cookies Consent Demo</div>
	</footer>
	<script src="/assets/consent.js"></script>
</body>
</html>
