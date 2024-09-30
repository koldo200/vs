<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'voting_db');

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener la dirección IP del usuario
$user_ip = $_SERVER['REMOTE_ADDR'];

// Verificar si la IP ya ha votado
$sql = "SELECT * FROM vote_ips WHERE ip_address = '$user_ip'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // El usuario ya ha votado, actualizar su voto

    // Obtener el voto anterior
    $row = $result->fetch_assoc();
    $previous_vote = $row['last_vote'];

    // Obtener el nuevo voto
    if (isset($_POST['vote'])) {
        $new_vote = $_POST['vote'];

        // Validar el nuevo voto
        if ($new_vote === 'bull' || $new_vote === 'bear') {

            // Reducir el voto anterior en la tabla `votes`
            $sql = "UPDATE votes SET count = count - 1 WHERE vote_option = '$previous_vote'";
            $conn->query($sql);

            // Incrementar el nuevo voto en la tabla `votes`
            $sql = "UPDATE votes SET count = count + 1 WHERE vote_option = '$new_vote'";
            $conn->query($sql);

            // Actualizar el voto en `vote_ips` para la dirección IP
            $sql = "UPDATE vote_ips SET last_vote = '$new_vote' WHERE ip_address = '$user_ip'";
            $conn->query($sql);

            // Redirigir a la página de resultados
            header('Location: vs.php');
            exit(); // Detener el script
        } else {
            echo "Invalid vote option.";
        }
    } else {
        echo "No vote submitted.";
    }
} else {
    // El usuario no ha votado, procesar su voto normalmente

    // Obtener el voto
    if (isset($_POST['vote'])) {
        $vote = $_POST['vote'];

        // Validar el voto
        if ($vote === 'bull' || $vote === 'bear') {
            // Incrementar la cuenta de votos
            $sql = "UPDATE votes SET count = count + 1 WHERE vote_option = '$vote'";
            $conn->query($sql);

            // Insertar la IP y el voto en la tabla `vote_ips`
            $sql = "INSERT INTO vote_ips (ip_address, last_vote) VALUES ('$user_ip', '$vote')";
            $conn->query($sql);

            // Redirigir a la página de resultados
            header('Location: vs.php');
            exit();
        } else {
            echo "Invalid vote option.";
        }
    } else {
        echo "No vote submitted.";
    }
}

// Cerrar la conexión
$conn->close();
?>
