<?php
// ============================================================
// FICHEIRO: actions/adicionar_carrinho_cupcakes.php
// O QUE FAZ: Recebe o formulario de encomenda de cupcakes
// e doces, valida os dados, calcula o preco a partir da
// base de dados e adiciona ao carrinho na sessao.
// ============================================================

require_once __DIR__ . '/../includes/carrinho.php';
require_once __DIR__ . '/../includes/db.php';

dd_start_session();

// --- PROTECAO 1: So aceita pedidos POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/compras.php');
    exit;
}

// --- PROTECAO 2: O utilizador tem de estar autenticado ---
if (!isset($_SESSION['user'])) {
    dd_flash_set('danger', 'Precisa de iniciar sessao para adicionar produtos ao carrinho.');
    header('Location: ../pages/login.php');
    exit;
}

// --- PROTECAO 3: Verificar o token CSRF ---
if (!dd_verificar_csrf($_POST['csrf_token'] ?? '')) {
    dd_flash_set('danger', 'Pedido invalido. Atualiza a pagina e tenta novamente.');
    header('Location: ../pages/compras.php');
    exit;
}

// --- LER E LIMPAR OS DADOS DO FORMULARIO ---
$boloId      = dd_limpar_texto($_POST['bolo_id'] ?? '', 100);
$tamanho     = dd_limpar_texto($_POST['tamanho'] ?? '', 30);
$dataEvento  = dd_limpar_texto($_POST['birthday'] ?? '', 10);
$observacoes = dd_limpar_texto($_POST['observacoes'] ?? '', 500);
$quantidade  = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1, 'max_range' => 20]
]);

// --- BUSCAR DADOS DA BASE DE DADOS ---
$bolo     = buscar_bolo($con, $boloId);
$tamanhos = buscar_tamanhos($con, $boloId);

// --- VALIDACOES ---
$erros = [];

if (!$bolo) {
    $erros[] = 'O produto selecionado nao existe.';
}
if (!isset($tamanhos[$tamanho])) {
    $erros[] = 'Seleciona uma opcao valida.';
}
if (!dd_data_evento_valida($dataEvento)) {
    $erros[] = 'A data do evento deve ter pelo menos 7 dias de antecedencia.';
}

if (!empty($erros)) {
    dd_flash_set('danger', implode(' ', $erros));
    $urlVoltar = $boloId !== '' ? '../pages/bolos/encomenda-cupcakes.php?bolo=' . urlencode($boloId) : '../pages/encomende.php';
    header('Location: ' . $urlVoltar);
    exit;
}

// --- CALCULAR PRECO A PARTIR DA BASE DE DADOS ---
$precoUnitario = calcular_preco($tamanhos, [], [], $tamanho);

if ($precoUnitario === null) {
    dd_flash_set('danger', 'Nao foi possivel calcular o preco. Tenta novamente.');
    header('Location: ../pages/bolos/encomenda-cupcakes.php?bolo=' . urlencode($boloId));
    exit;
}

// --- ADICIONAR AO CARRINHO ---
dd_carrinho_adicionar([
    'bolo_id'        => $boloId,
    'nome'           => $bolo['nome'],
    'imagem'         => '../' . ltrim($bolo['imagem'], '/'),
    'descricao'      => $bolo['descricao'],
    'categoria'      => $bolo['categoria'],
    'tamanho'        => $tamanho,
    'tamanho_label'  => $tamanhos[$tamanho]['label'],
    'massa'          => '',
    'massa_label'    => '',
    'recheio'        => '',
    'recheio_label'  => '',
    'data_evento'    => $dataEvento,
    'observacoes'    => $observacoes,
    'quantidade'     => $quantidade,
    'preco_unitario' => $precoUnitario,
    'total_item'     => round($precoUnitario * $quantidade, 2),
]);

dd_flash_set('success', 'Produto adicionado ao carrinho com sucesso!');
header('Location: ../pages/compras.php');
exit;
