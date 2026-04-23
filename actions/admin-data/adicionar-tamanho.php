<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bolo_slug = trim($_POST['bolo_slug'] ?? '');
    $label = trim($_POST['label'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $ordem = (int)($_POST['ordem'] ?? 0);

    $stmt_check = $con->prepare("SELECT id FROM catalogo_bolos WHERE slug = ? LIMIT 1");
    $stmt_check->bind_param("s", $bolo_slug);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $bolo_existe = $result_check && $result_check->num_rows > 0;
    $stmt_check->close();

    if (!$bolo_existe) {
        $params = http_build_query([
            'tipo' => 'erro',
            'mensagem' => 'O tamanho nao foi guardado porque o slug do bolo nao existe no catalogo.',
            'abrir_modal' => 'tamanho',
            'erro_bolo_slug' => '1',
            'bolo_slug' => $bolo_slug,
            'label' => $label,
            'slug' => $slug,
            'preco' => $_POST['preco'] ?? '',
            'ordem' => $_POST['ordem'] ?? '',
        ]);

        header('Location: ../../pages/data/admin-data-bolos.php?' . $params);
        exit;
    }

    $stmt = $con->prepare("INSERT INTO tamanhos_produtos (bolo_slug, label, slug, preco, ordem, ativo) 
                       VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssdi", $bolo_slug, $label, $slug, $preco, $ordem);
    $stmt->execute();
    $stmt->close();

    header('Location: ../../pages/data/admin-data-bolos.php?tipo=sucesso&mensagem=Tamanho+adicionado+com+sucesso.');
    exit;
}
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
