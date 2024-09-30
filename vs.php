<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Enlaza Bootstrap -->
    <link rel="stylesheet" href="skin.css"> <!-- Enlaza el archivo CSS -->
</head>

<body>
    <div class="container text-center d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
        <div id="poll">
            <h1>Are you Bull or Bear?</h1>
            <form action="vote.php" method="post">
                <label class="radio-container">
                    <input type="radio" name="vote" value="bull" required>
                    Bull 🐂
                </label>
                <label class="radio-container">
                    <input type="radio" name="vote" value="bear" required>
                    Bear 🐻
                </label>
                <button id="voteButton" type="submit">Vote</button>
            </form>

            <?php
            // Código para obtener votos de la base de datos
            $conn = new mysqli('localhost', 'root', '', 'voting_db');
            $result = $conn->query("SELECT count FROM votes WHERE vote_option = 'bull'");
            $bull_votes = $result->fetch_assoc()['count'];

            $result = $conn->query("SELECT count FROM votes WHERE vote_option = 'bear'");
            $bear_votes = $result->fetch_assoc()['count'];

            // Calcular porcentajes
            $total_votes = $bull_votes + $bear_votes;
            $bull_percentage = $total_votes > 0 ? ($bull_votes / $total_votes) * 100 : 0;
            $bear_percentage = $total_votes > 0 ? ($bear_votes / $total_votes) * 100 : 0;
            ?>

            <!-- Mostrar la barra de progreso total utilizando Bootstrap -->
            <div id="vote-results">
                <h5>Total Vote Distribution</h5>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= round($bull_percentage) ?>%;" aria-valuenow="<?= round($bull_percentage) ?>" aria-valuemin="0" aria-valuemax="100">
                        <?= round($bull_percentage) ?>% Bull
                    </div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= round($bear_percentage) ?>%;" aria-valuenow="<?= round($bear_percentage) ?>" aria-valuemin="0" aria-valuemax="100">
                        <?= round($bear_percentage) ?>% Bear
                    </div>
                </div>
                <p>Total votes: <?= $bull_votes + $bear_votes ?></p>
            </div>
            <p>1M Market Cap is programmed</p>
            <p style="font-weight: bold;">Let us cook</p>
        </div>
    </div>

    <footer>
        <p>© VS</p>
    </footer>

    <?php $conn->close(); ?>

    <script>
        // JavaScript para cambiar el color del botón al seleccionar "Bear"
        const voteButton = document.getElementById('voteButton');
        const radioButtons = document.querySelectorAll('input[name="vote"]');

        radioButtons.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'bear') {
                    voteButton.style.backgroundColor = '#f44336'; // Rojo para Bear
                } else {
                    voteButton.style.backgroundColor = '#4CAF50'; // Verde para Bull
                }
            });
        });
    </script>
</body>

</html>
