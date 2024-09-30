// server.js

const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');
const app = express();
const port = 3306;

// Middleware
app.use(bodyParser.json());
app.use(cors());
app.use(express.static('public')); // Para servir archivos estáticos

// Configuración de la base de datos MySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root', // Cambia esto si tienes un usuario diferente
    password: '', // Cambia esto si tienes una contraseña
    database: 'voting_db'
});

// Conectar a la base de datos
db.connect((err) => {
    if (err) {
        console.error('Error connecting to database:', err);
        return;
    }
    console.log('Connected to database');
});

// Ruta para guardar el voto
app.post('/vote', (req, res) => {
    const { vote } = req.body;

    if (vote === 'bull' || vote === 'bear') {
        const sql = `UPDATE votes SET count = count + 1 WHERE vote_option = ?`;
        db.query(sql, [vote], (err, result) => {
            if (err) {
                console.error('Error saving vote:', err);
                return res.status(500).send({ message: 'Error saving vote. Please try again.' });
            }
            res.send({ message: `Thank you for voting ${vote}!` });
        });
    } else {
        res.status(400).send({ message: 'Invalid vote option' });
    }
});

// Ruta para obtener los resultados
app.get('/results', (req, res) => {
    const sql = `SELECT * FROM votes`;
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Error fetching results:', err);
            return res.status(500).send({ message: 'Error fetching results. Please try again.' });
        }
        res.send(results);
    });
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});
