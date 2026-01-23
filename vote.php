<?php
include 'db.php';

$event = $_POST['event'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];

if (!in_array($event, ['bedwars', 'openworld', 'hideandseek'])) {
    http_response_code(400);
    echo "Ungültiges Event";
    exit;
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE ip_address = ?");
$stmt->execute([$ip]);

if ($stmt->fetchColumn() > 0) {
    echo "Du hast bereits abgestimmt!";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO votes (event_name, ip_address) VALUES (?, ?)");
$stmt->execute([$event, $ip]);

echo "Danke für deine Stimme!";
?>
