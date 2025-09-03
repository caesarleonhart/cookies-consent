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

if (!isset($_SESSION['admin_user_id'])) {
	header('Location: /admin/login.php');
	exit;
}

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$total = (int)$pdo->query('SELECT COUNT(*) AS c FROM consent_log')->fetch()['c'];
$stmt = $pdo->prepare('SELECT guid, consent_time, version FROM consent_log ORDER BY consent_time DESC LIMIT ? OFFSET ?');
$stmt->bindValue(1, $perPage, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$pages = (int)ceil($total / $perPage);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
	<header>
		<div class="container">
			<nav class="nav">
				<a href="/index.php">Home</a>
				<span class="ml-auto">Logged in as <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
				<a href="/admin/logout.php">Logout</a>
			</nav>
		</div>
	</header>
	<main class="container">
		<h1>Consent Acceptances</h1>
		<p>Total records: <?php echo $total; ?></p>
		<div style="overflow:auto">
			<table>
				<thead>
					<tr><th>GUID</th><th>Consent Time (GMT+8)</th><th>Version</th></tr>
				</thead>
				<tbody>
					<?php foreach($rows as $r): ?>
						<tr>
							<td style="font-family:monospace"><?php echo htmlspecialchars($r['guid']); ?></td>
							<td><?php
								$dt = new DateTime($r['consent_time'], new DateTimeZone('UTC'));
								$dt->setTimezone(new DateTimeZone('Asia/Singapore')); // GMT+8
								echo htmlspecialchars($dt->format('Y-m-d H:i:s'));
							?></td>
							<td><?php echo (int)$r['version']; ?></td>
						</tr>
					<?php endforeach; ?>
					<?php if (!$rows): ?>
						<tr><td colspan="3">No records found.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php if ($pages > 1): ?>
			<nav class="nav mt-12">
				<?php for($p=1;$p<=$pages;$p++): ?>
					<a href="?page=<?php echo $p; ?>" class="<?php echo $p===$page?'active':''; ?>"><?php echo $p; ?></a>
				<?php endfor; ?>
			</nav>
		<?php endif; ?>
	</main>
	<footer>
		<div class="container">&copy; <?php echo date('Y'); ?> Cookies Consent Demo</div>
	</footer>
</body>
</html>
