<?php
include 'connect.php';

function fetchData($type) {
    $serverIp = '';
    $conn = connectToDatabase($serverIp);

    if ($conn) {
        $dbname = "pruebas";
        if ($conn->select_db($dbname)) {
            if ($type === 'alumnos') {
                $sql = "SELECT * FROM alumnos";
            } elseif ($type === 'profesores') {
                $sql = "SELECT * FROM profesores";
            } else {
                $sql = "SELECT * FROM usuarios";
            }

            $resultado = mysqli_query($conn, $sql);

            if (mysqli_num_rows($resultado) > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th></tr>";
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr><td>" . $fila["id"] . "</td><td>" . $fila["nombre"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No se encontraron registros en MySQL.</p>";
            }
        } else {
            echo "<p>Error al seleccionar la base de datos.</p>";
        }

        mysqli_close($conn);
    } else {
        echo "<p>No se pudo establecer conexión con ninguno de los servidores MySQL.</p>";
        echo "<script>
            setTimeout(function() {
                location.reload();
            }, 5000);
        </script>";
    }

    // Añadir la IP del servidor en el encabezado HTTP
    if (!headers_sent()) {
        header('X-Server-IP: ' . $serverIp);
    }
}

if (isset($_GET['type'])) {
    fetchData($_GET['type']);
}
?>
