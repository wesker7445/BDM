<?php
// Incluimos tu archivo de conexión
require_once 'config.php'; 

try {
    // 1. Intentamos ejecutar una consulta simple (la que ya conoces)
    $query = $pdo->query("SELECT VERSION() AS version");
    $resultado = $query->fetch();

    // 2. Si llegamos aquí, la conexión es un éxito
    echo "<h1 style='color: green;'>✅ ¡Conexión Exitosa!</h1>";
    echo "<p>Estás conectado a la versión: <strong>" . $resultado['version'] . "</strong></p>";
    
    // 3. Probamos ver si ve tus tablas
    echo "<h3>Tus tablas actuales:</h3>";
    $tablas = $pdo->query("SHOW TABLES");
    echo "<ul>";
    while ($fila = $tablas->fetch(PDO::FETCH_NUM)) {
        echo "<li>" . $fila[0] . "</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    // 4. Si algo falla, aquí nos dirá EXACTAMENTE qué pasó
    echo "<h1 style='color: red;'>❌ Error de Conexión</h1>";
    echo "<p style='background: #fee; padding: 10px; border: 1px solid red;'>";
    echo "<strong>Mensaje de error:</strong> " . $e->getMessage();
    echo "</p>";
}
?>