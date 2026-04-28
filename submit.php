<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$recipient = 'ivan.ttodorov1989@gmail.com';
$subject = 'DarkNightRP кандидатура';
$questions = [
    1 => 'Как се казваш?',
    2 => 'На колко години си?',
    3 => 'Какъв е Discord профилът ти?',
    4 => 'Имаш ли опит във FiveM?',
    5 => 'В кои сървъри си играл?',
    6 => 'Какво означава RDM?',
    7 => 'Какво означава VDM?',
    8 => 'Какво е Metagaming?',
    9 => 'Какво е Powergaming?',
    10 => 'Какво е FearRP?',
    11 => 'Какво би направил при отвличане?',
    12 => 'Какво правиш при проблем с играч?',
    13 => 'Как подаваш репорт?',
    14 => 'Можеш ли да спориш със staff?',
    15 => 'Какъв персонаж искаш да играеш?',
    16 => 'Каква е историята на героя ти?',
    17 => 'Защо искаш в DarkNightRP?',
    18 => 'Какво очакваш от community-то?',
    19 => 'Колко активен можеш да бъдеш?',
    20 => 'Съгласен ли си с правилата?'
];

$lines = [];
$lines[] = "DarkNightRP кандидатура";
$lines[] = "Подадена: " . date('c');
$lines[] = str_repeat('=', 40);

foreach ($questions as $number => $question) {
    $value = trim((string)($_POST['q' . $number] ?? ''));
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
$title = $sent ? 'Кандидатурата е изпратена' : 'Временен проблем';
$text = $sent
    ? 'Формата беше подадена успешно. Очаквай преглед от екипа на DarkNightRP.'
    : 'Кандидатурата не можа да се изпрати в този момент. Опитай отново след малко.';
$status = $sent ? 'Успешно изпратено' : 'Опитай отново';
$icon = $sent ? 'OK' : '!';
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DarkNightRP | Submit</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --text: #f6f1ea;
      --muted: #b9aea6;
      --red: #ff4343;
      --red-strong: #ff1e1e;
      --shadow: 0 28px 90px rgba(0, 0, 0, 0.55);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      min-height: 100vh;
      display: grid;
      place-items: center;
      font-family: "Manrope", sans-serif;
      color: var(--text);
      background:
        radial-gradient(circle at 18% 12%, rgba(255, 30, 30, 0.16), transparent 24%),
        radial-gradient(circle at 84% 18%, rgba(255, 67, 67, 0.08), transparent 20%),
        linear-gradient(180deg, #040404 0%, #0b0b0d 32%, #050505 100%);
      overflow: hidden;
    }
    .card {
      width: min(560px, calc(100% - 28px));
      padding: 38px 30px;
      border-radius: 30px;
      text-align: center;
      background: linear-gradient(180deg, rgba(18, 18, 18, 0.95), rgba(8, 8, 8, 0.98));
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: var(--shadow);
      position: relative;
      overflow: hidden;
    }
    .card::before {
      content: "";
      position: absolute;
      inset: -40% auto auto -20%;
      width: 180px;
      height: 220%;
      background: linear-gradient(180deg, transparent, rgba(255,255,255,0.08), transparent);
      transform: rotate(22deg) translateX(-220px);
      animation: lightSweep 2.1s ease-in-out infinite;
    }
    .ring {
      position: relative;
      width: 118px;
      height: 118px;
      margin: 0 auto 18px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      background:
        radial-gradient(circle at center, rgba(255, 67, 67, 0.18), transparent 56%),
        linear-gradient(180deg, rgba(255, 67, 67, 0.18), rgba(255, 30, 30, 0.32));
      border: 1px solid rgba(255, 67, 67, 0.24);
      overflow: hidden;
    }
    .ring::before,
    .ring::after {
      content: "";
      position: absolute;
      inset: 8px;
      border-radius: 50%;
      border: 1px solid rgba(255, 214, 214, 0.14);
      animation: pulseRing 1.6s ease-in-out infinite;
    }
    .ring::after { inset: -8px; animation-delay: 0.22s; }
    .icon {
      position: relative;
      font-size: 2rem;
      font-weight: 900;
      font-family: "Orbitron", sans-serif;
      color: white;
      animation: successPop 0.9s ease forwards;
    }
    h1, p { margin: 0; }
    p {
      margin-top: 12px;
      color: var(--muted);
      line-height: 1.75;
    }
    .status {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      margin-top: 18px;
      padding: 0 16px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,0.08);
      background: rgba(255,255,255,0.03);
      color: #ffe9e9;
      font-weight: 700;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 52px;
      margin-top: 22px;
      padding: 0 22px;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--red), var(--red-strong));
      color: white;
      font-weight: 800;
      text-decoration: none;
      box-shadow: 0 14px 38px rgba(255, 30, 30, 0.28);
    }
    @keyframes pulseRing {
      0% { transform: scale(0.84); opacity: 0.35; }
      70% { transform: scale(1.12); opacity: 1; }
      100% { transform: scale(1.2); opacity: 0; }
    }
    @keyframes lightSweep {
      0% { transform: rotate(22deg) translateX(-240px); opacity: 0; }
      18% { opacity: 1; }
      48% { transform: rotate(22deg) translateX(420px); opacity: 0.7; }
      100% { transform: rotate(22deg) translateX(420px); opacity: 0; }
    }
    @keyframes successPop {
      0% { transform: scale(0.7) rotate(-8deg); }
      45% { transform: scale(1.18) rotate(6deg); }
      100% { transform: scale(1) rotate(0deg); }
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="ring"><div class="icon"><?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?></div></div>
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
    <p><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?></p>
    <div class="status"><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></div>
    <a class="btn" href="application.html"><?= $sent ? 'Нова кандидатура' : 'Опитай отново' ?></a>
  </div>
</body>
</html>
