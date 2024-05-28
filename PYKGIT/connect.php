<?php
function connectToDatabase(&$serverIp) {
    // Configuración de los servidores MySQL
    $servers = array(
        array("ip" => "40.82.206.90", "username" => "root", "password" => "Paula_Katia"),
        array("ip" => "40.82.207.72", "username" => "root", "password" => "Paula_Katia")
    );

    shuffle($servers); // Barajar el array para obtener un orden aleatorio

    $conn = null;
    foreach ($servers as $server) {
        // Intentar hacer ping al servidor MySQL con un tiempo de espera de 2 segundos
        $fp = @fsockopen($server['ip'], 3306, $errno, $errstr, 2);

        if ($fp) {
            fclose($fp);
            // Intentar conectar a MySQL usando MySQLi
            $conn = @new mysqli($server['ip'], $server['username'], $server['password']);
            if (!$conn->connect_errno) {
                $serverIp = $server['ip'];
                return $conn;
            }
        }
    }

    return null;
}
?>
