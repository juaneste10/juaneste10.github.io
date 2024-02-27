<?php
// Establecer conexión a la base de datos
$servername = "localhost";
$username = "root";
$dbname = "inmobiliaria";

$conn = new mysqli($servername, $username, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $precio = $_POST["precio"];
    $habitaciones = $_POST["habitaciones"];
    $fecha_construccion = $_POST["fecha_construccion"];

    // Consulta SQL para buscar viviendas que coincidan con los criterios de búsqueda
    $sql = "SELECT * FROM viviendas WHERE precio <= $precio AND habitaciones >= $habitaciones AND fecha_construccion >= '$fecha_construccion'";
    $result = $conn->query($sql);

    // Crear un array para almacenar los resultados
    $response = array();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array de respuesta
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    // Si no se encontraron resultados, agregar un mensaje de error al array de respuesta
    $response['error'] = "No se encontraron viviendas que coincidan con los criterios de búsqueda.";
}
    // Convertir el array de respuesta a formato JSON y enviarlo
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Cerrar conexión a la base de datos
$conn->close();
?>

