<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDeDatos = "ejemplo";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tortillas D'Cesar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Tortillas D'Cesar</h1>
    <form action="#" method="post" name="ejemplo">
        <label for="name">A nombre de quien está el pedido:</label>
        <input type="text" name="nombre" id="name" placeholder="Escribe tu nombre" required>
        
        <label for="individualTortillas">Tortillas individuales ($1.80 cada una):</label>
        <input type="number" name="TI" id="individualTortillas" min="0" placeholder="Cantidad de tortillas">

        <label for="packages">Paquetes de tortillas (10 tortillas, $18.00):</label>
        <input type="number" name="Paq" id="packages" min="0" placeholder="Cantidad de paquetes">

        <!-- Campo oculto para enviar el precio total -->
        <input type="hidden" name="Total" id="totalHidden">

        <button type="button" onclick="calculateOrder()">Calcular pedido</button>
        <div id="result"></div>
        <button type="submit" name="registro">Pagar en Efectivo</button>
    </form>

    <script>
        const TORTILLA_PRICE = 1.80;
        const PACKAGE_PRICE = 18.00;
        const WAIT_TIME_PER_ITEM = 1.2; // Tiempo en minutos por tortilla

        function calculateOrder() {
            const name = document.getElementById('name').value.trim(); 
            if (name === "") {
                alert("Por favor, ingresa tu nombre y cantidad de tortillas o paquetes antes de calcular el pedido."); 
                return; 
            }
            const individualTortillas = parseInt(document.getElementById('individualTortillas').value) || 0;
            const packages = parseInt(document.getElementById('packages').value) || 0;

            const totalTortillasPrice = individualTortillas * TORTILLA_PRICE;
            const totalPackagesPrice = packages * PACKAGE_PRICE;
            const totalPrice = totalTortillasPrice + totalPackagesPrice;

            const totalItems = individualTortillas + (packages * 10);
            const waitTime = totalItems * WAIT_TIME_PER_ITEM; // Tiempo de espera total en minutos

            // Asignar valores al campo oculto del precio total
            document.getElementById('totalHidden').value = totalPrice.toFixed(2);

            // Mostrar el resultado en la página
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `
                <p><strong>Nombre del cliente:</strong> ${name}</p>
                <p><strong>Precio total:</strong> $${totalPrice.toFixed(2)}</p>
                <p><strong>Tiempo de espera aproximado:</strong> ${waitTime.toFixed(2)} minutos</p>
            `;
        }
    </script>
</body>
<?php
if (isset($_POST['registro'])) {
    $nombre = $_POST['nombre'];
    $Tindividuales = $_POST['TI'];
    $Paquetes = $_POST['Paq'];
    $Total = $_POST['Total'];

    // Eliminamos la columna TiempoEspera de la consulta
    $insertarDatos = "INSERT INTO datos (nombre, Tindividuales, Paquetes, Total) VALUES ('$nombre', '$Tindividuales', '$Paquetes', '$Total')";
    
    $ejecutarInsertar = mysqli_query($enlace, $insertarDatos);

    if ($ejecutarInsertar) {
        echo "<script>alert('Pedido registrado con éxito');</script>";
    } else {
        echo "<script>alert('Error al registrar el pedido');</script>";
    }
}
?>
</html>
