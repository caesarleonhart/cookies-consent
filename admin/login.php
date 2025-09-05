<?php
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
	$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
	session_set_cookie_params([
		'lifetime' => 0,
		'path' => '/',
		'domain' => '',
		'secure' => $secure,
		'httponly' => true,
		'samesite' => 'Lax',
	]);
	session_start();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim($_POST['username'] ?? '');
	$password = $_POST['password'] ?? '';
	if ($username !== '' && $password !== '') {
		$stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = ? LIMIT 1');
		$stmt->execute([$username]);
		$user = $stmt->fetch();
		if ($user && password_verify($password, $user['password_hash'])) {
			$_SESSION['admin_user_id'] = $user['id'];
			$_SESSION['admin_username'] = $user['username'];
			header('Location: ' . base_url('admin/dashboard.php'));
			exit;
		} else {
			$error = 'Invalid username or password';
		}
	} else {
		$error = 'Please enter username and password';
	}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
	<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
	<script>window.BASE_URL = '<?= base_url() ?>';</script>
</head>
<body>
	<header>
		<div class="container">
			<nav class="nav">
				<a href="<?= base_url('index.php') ?>">Home</a>
				<a href="<?= base_url('about.php') ?>">About / Contact</a>
				<a href="<?= base_url('privacy.php') ?>">Privacy Policy</a>
				<a href="<?= base_url('terms.php') ?>">Terms & Conditions</a>
			</nav>
		</div>
	</header>
	<main class="container">
		<h1>Admin Login</h1>
		<?php if ($error): ?>
			<p class="text-error"><?php echo htmlspecialchars($error); ?></p>
		<?php endif; ?>
		<form method="post" action="<?= base_url('admin/login.php') ?>" class="form-card">
			<label>Username<br>
				<input type="text" name="username" required class="input">
			</label>
			<br><br>
			<label>Password<br>
				<input type="password" name="password" required class="input">
			</label>
			<br><br>
			<button class="btn btn-primary" type="submit">Login</button>
		</form>
	</main>
	<footer>
		<div class="container">&copy; <?php echo date('Y'); ?> Cookies Consent Demo</div>
	</footer>
</body>
</html>
