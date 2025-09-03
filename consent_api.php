<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['error' => 'Method Not Allowed']);
	exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? ($_POST['action'] ?? '');

if ($action === 'accept') {
	$version = 1;
	$guid = generate_uuid_v4();
	$now = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

	try {
		$stmt = $pdo->prepare('INSERT INTO consent_log (guid, consent_time, version) VALUES (?, ?, ?)');
		$stmt->execute([$guid, $now, $version]);
		echo json_encode(['status' => 'ok', 'guid' => $guid, 'consent_time' => $now, 'version' => $version]);
		exit;
	} catch (Throwable $e) {
		http_response_code(500);
		echo json_encode(['error' => 'Failed to record consent']);
		exit;
	}
}

http_response_code(400);
echo json_encode(['error' => 'Invalid action']);

function generate_uuid_v4(): string {
	$data = random_bytes(16);
	$data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
	$data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
	return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
