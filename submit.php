<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$rawInput = file_get_contents('php://input');
$payload = json_decode($rawInput, true);

if (!$payload || !isset($payload['answers']) || !is_array($payload['answers'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
    exit;
}

$recipient = 'ivan.ttodorov1989@gmail.com';
$subject = 'DarkNightRP кандидатура';

$lines = [];
$lines[] = "DarkNightRP кандидатура";
$lines[] = "Подадена: " . ($payload['submittedAt'] ?? date('c'));
$lines[] = str_repeat('=', 40);

foreach ($payload['answers'] as $answer) {
    $number = isset($answer['number']) ? (int)$answer['number'] : 0;
    $question = trim((string)($answer['question'] ?? ''));
    $value = trim((string)($answer['answer'] ?? ''));

    $lines[] = $number . '. ' . $question;
    $lines[] = $value !== '' ? $value : '-';
    $lines[] = '';
}

$message = implode("\r\n", $lines);
$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'From: DarkNightRP <no-reply@darknightrp.local>',
    'Reply-To: no-reply@darknightrp.local'
];

$sent = @mail($recipient, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, implode("\r\n", $headers));

if (!$sent) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Mail transport failed']);
    exit;
}

echo json_encode(['ok' => true]);
