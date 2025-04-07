<?php
// Guardar el mensaje recibido por Telegram
file_put_contents("log.txt", file_get_contents("php://input") . PHP_EOL, FILE_APPEND);

// Leer mensaje
$update = json_decode(file_get_contents("php://input"), TRUE);

$chat_id = $update["message"]["chat"]["id"] ?? null;
$message = strtolower(trim($update["message"]["text"] ?? ""));

$token = "8078739628:AAHLtWk951pUsCsaJOpayZN30X70EBaeGY8";
$api_url = "https://api.telegram.org/bot$token/sendMessage";

// Respuestas por palabra clave
$respuestas = [
    "/start" => "¡Hola! Soy tu asistente del supermercado 🛒. Dime qué producto buscas.",
    "frutas" => "🍎 Las frutas están en el pasillo 1.",
    "lácteos" => "🧀 Pasillo 2: leche, yogurt, mantequilla.",
    "carnes" => "🥩 Pasillo 3: pollo, carne de res, cerdo.",
    "bebidas" => "🥤 Pasillo 4: jugos, aguas, gaseosas.",
    "panadería" => "🥖 Panadería al fondo, pasillo 5.",
    "limpieza" => "🧼 Pasillo 6: detergente, cloro.",
    "congelados" => "🧊 Pasillo 7: helados, pizzas, verduras.",
];

$response = $respuestas[$message] ?? "No encontré ese producto. Prueba con frutas, carnes, lácteos, etc.";

if ($chat_id) {
    file_get_contents($api_url . "?chat_id=$chat_id&text=" . urlencode($response));
}
