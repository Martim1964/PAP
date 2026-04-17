<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $categoria_id = (int)($_POST['categoria_id'] ?? 0);
    
    if ($_FILES['imagem']['size'] > 0) {
        $imagem_nome = basename($_FILES['imagem']['name']);
        $imagem_dir = __DIR__ . '/../../img-pap/nossos-bolos/';
        $imagem_path = $imagem_dir . $imagem_nome;
        
        $caminho_relativo = 'img-pap/nossos-bolos/' . $imagem_nome;
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)) {
            $stmt = $con->prepare("INSERT INTO catalogo_bolos (nome, slug, descricao, imagem, categoria_id, ativo) 
                               VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("ssssi", $nome, $slug, $descricao, $caminho_relativo, $categoria_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
