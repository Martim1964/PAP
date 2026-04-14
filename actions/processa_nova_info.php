<?php

session_start();

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- GUARDAR NA BASE DE DADOS ---
    $sucesso = guardar_info($con, [
        'assunto' => $_POST['assunto'],
        'conteudo' => $_POST['conteudo'],
    ]);
}
    ?>

    <script>
        alert('Nova informação inserida com sucesso!');
        window.location.href = '../pages/data/admin-data.php';
    </script>;



