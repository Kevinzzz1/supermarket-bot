<?php
// Obtener el contenido del webhook
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// Verificar si se recibió un mensaje
if(isset($update["message"]["text"])) {
    $chatId = $update["message"]["chat"]["id"];
    $messageText = strtolower(trim($update["message"]["text"]));
    
    // Respuestas por palabra clave
    $respuestas = [
        "inicio" => "¡Hola! Soy tu asistente del supermercado. Dime qué producto necesitas encontrar.",
        "frutas" => "Las frutas están en el pasillo 3.",
        "lácteos" => "Los lácteos están en el pasillo 2: leche, yogur, queso.",
        "carne" => "Las carnes están en el pasillo 1: pollo, carne de res, cerdo.",
        "bebidas" => "Las bebidas están en el pasillo 4: jugos, agua, gaseosas.",
        "panadería" => "La panadería está en el pasillo 5.",
        "limpieza" => "Los productos de limpieza están en el pasillo 5: detergente, lavaloza.",
        "congelados" => "Los productos congelados están en el pasillo 6."
    ];
    
    $respuesta = $respuestas[$messageText] ?? "No encuentro ese producto. Prueba con: frutas, lácteos, carnes, bebidas, panadería, limpieza o congelados.";
    
    // Enviar respuesta a Telegram
    $token = "TU_TOKEN_DE_TELEGRAM_AQUI";
    $url = "https://api.telegram.org/bot$token/sendMessage";
    
    $data = [
        'chat_id' => $chatId,
        'text' => $respuesta
    ];
    
    file_get_contents($url . '?' . http_build_query($data));
}
?>
