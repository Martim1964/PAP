<?php

declare(strict_types=1);

// =========================================================
// ENDPOINT: ADICIONAR AO CARRINHO
// Recebe o POST do formulario, valida os dados, calcula
// o preco no servidor e guarda o item em sessao.
// =========================================================

require_once __DIR__ . '/../includes/carrinho.php';

dd_start_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/compras.php');
    exit;
}

if (!isset($_SESSION['user'])) {
    dd_flash_set('danger', 'Precisa de iniciar sessao para adicionar produtos ao carrinho.');
    header('Location: ../pages/login.php?redirect=' . urlencode('bolos/encomenda.php'));
    exit;
}

if (!dd_verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    dd_flash_set('danger', 'Pedido invalido. Atualize a pagina e tente novamente.');
    header('Location: ../pages/compras.php');
    exit;
}

$catalogo = dd_catalogo_bolos();
$opcoes = dd_opcoes_encomenda();

$boloId = dd_limpar_texto($_POST['bolo_id'] ?? '', 100);
$tamanho = dd_limpar_texto($_POST['tamanho'] ?? '', 30);
$massa = dd_limpar_texto($_POST['massa'] ?? '', 30);
$recheio = dd_limpar_texto($_POST['recheio'] ?? '', 30);
$dataEvento = dd_limpar_texto($_POST['birthday'] ?? '', 10);
$observacoes = dd_limpar_texto($_POST['observacoes'] ?? '', 500);
$quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
    'options' => [
        'default' => 1,
        'min_range' => 1,
        'max_range' => 20,
    ],
]);

$errors = [];

if (!isset($catalogo[$boloId])) {
    $errors[] = 'O bolo selecionado nao existe no catalogo.';
}

if (!isset($opcoes['tamanho'][$tamanho])) {
    $errors[] = 'Selecione um tamanho valido.';
}

if (!isset($opcoes['massa'][$massa])) {
    $errors[] = 'Selecione uma massa valida.';
}

if (!isset($opcoes['recheio'][$recheio])) {
    $errors[] = 'Selecione um recheio valido.';
}

if (!dd_data_evento_valida($dataEvento)) {
    $errors[] = 'A data do evento deve ter pelo menos 7 dias de antecedencia.';
}

if ($quantidade === false || $quantidade < 1 || $quantidade > 20) {
    $errors[] = 'Quantidade invalida.';
}

$precoUnitario = dd_preco_encomenda($tamanho, $massa, $recheio);
if ($precoUnitario === null) {
    $errors[] = 'Nao foi possivel calcular o preco da configuracao escolhida.';
}

if ($errors) {
    dd_flash_set('danger', implode(' ', $errors));
    $fallback = $boloId !== '' ? '../pages/bolos/encomenda.php?bolo=' . urlencode($boloId) : '../pages/encomende.php';
    header('Location: ' . $fallback);
    exit;
}

$bolo = $catalogo[$boloId];

dd_carrinho_adicionar([
    'bolo_id' => $boloId,
    'nome' => $bolo['nome'],
    'imagem' => '../' . ltrim($bolo['img'], '/'),
    'descricao' => $bolo['desc'],
    'categoria' => $bolo['categoria'],
    'tamanho' => $tamanho,
    'tamanho_label' => $opcoes['tamanho'][$tamanho]['label'],
    'massa' => $massa,
    'massa_label' => $opcoes['massa'][$massa]['label'],
    'recheio' => $recheio,
    'recheio_label' => $opcoes['recheio'][$recheio]['label'],
    'data_evento' => $dataEvento,
    'observacoes' => $observacoes,
    'quantidade' => $quantidade,
    'preco_unitario' => $precoUnitario,
]);

dd_flash_set('success', 'Produto adicionado ao carrinho com sucesso.');
header('Location: ../pages/compras.php');
exit;
