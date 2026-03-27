<?php
// ============================================================
// FICHEIRO: actions/adicionar_carrinho.php
// O QUE FAZ: Recebe o formulário de encomenda de bolos
// normais (aniversário, casamento, batizado), valida os dados,
// calcula o preço A PARTIR DA BASE DE DADOS e adiciona ao
// carrinho guardado na sessão.
// ============================================================

require_once __DIR__ . '/../includes/carrinho.php';
require_once __DIR__ . '/../includes/db.php';

dd_start_session();

// --- PROTEÇÃO 1: Só aceita pedidos POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/compras.php');
    exit;
}

// --- PROTEÇÃO 2: O utilizador tem de estar autenticado ---
if (!isset($_SESSION['user'])) {
    dd_flash_set('danger', 'Precisa de iniciar sessão para adicionar produtos ao carrinho.');
    header('Location: ../pages/login.php');
    exit;
}

// --- PROTEÇÃO 3: Verificar o token CSRF ---
if (!dd_verificar_csrf($_POST['csrf_token'] ?? '')) {
    dd_flash_set('danger', 'Pedido inválido. Atualiza a página e tenta novamente.');
    header('Location: ../pages/compras.php');
    exit;
}

// --- LER E LIMPAR OS DADOS DO FORMULÁRIO ---
$boloId      = dd_limpar_texto($_POST['bolo_id']     ?? '', 100);
$tamanho     = dd_limpar_texto($_POST['tamanho']     ?? '', 30);
$massa       = dd_limpar_texto($_POST['massa']       ?? '', 30);
$recheio     = dd_limpar_texto($_POST['recheio']     ?? '', 30);
$dataEvento  = dd_limpar_texto($_POST['birthday']    ?? '', 10);
$observacoes = dd_limpar_texto($_POST['observacoes'] ?? '', 500);

$quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1, 'max_range' => 20]
]);

// --- BUSCAR DADOS DA BASE DE DADOS ---
// Em vez de arrays hardcoded, os dados vêm agora do MySQL
$bolo     = buscar_bolo($con, $boloId);
$tamanhos = buscar_tamanhos($con);
$massas   = buscar_massas($con);
$recheios = buscar_recheios($con);

// --- VALIDAÇÕES ---
$erros = [];

if (!$bolo) {
    $erros[] = 'O bolo selecionado não existe.';
}
if (!isset($tamanhos[$tamanho])) {
    $erros[] = 'Seleciona um tamanho válido.';
}
if (!isset($massas[$massa])) {
    $erros[] = 'Seleciona uma massa válida.';
}
if (!isset($recheios[$recheio])) {
    $erros[] = 'Seleciona um recheio válido.';
}
if (!dd_data_evento_valida($dataEvento)) {
    $erros[] = 'A data do evento deve ter pelo menos 7 dias de antecedência.';
}

if (!empty($erros)) {
    dd_flash_set('danger', implode(' ', $erros));
    $urlVoltar = $boloId !== '' ? '../pages/bolos/encomenda.php?bolo=' . urlencode($boloId) : '../pages/encomende.php';
    header('Location: ' . $urlVoltar);
    exit;
}

// --- CALCULAR PREÇO A PARTIR DA BASE DE DADOS ---
// Os preços vêm do MySQL — ninguém consegue manipulá-los no browser
$precoUnitario = calcular_preco($tamanhos, $massas, $recheios, $tamanho, $massa, $recheio);

if ($precoUnitario === null) {
    dd_flash_set('danger', 'Não foi possível calcular o preço. Tenta novamente.');
    header('Location: ../pages/bolos/encomenda.php?bolo=' . urlencode($boloId));
    exit;
}

// --- ADICIONAR AO CARRINHO (sessão) ---
dd_carrinho_adicionar([
    'bolo_id'       => $boloId,
    'nome'          => $bolo['nome'],
    'imagem'        => '../' . ltrim($bolo['imagem'], '/'),
    'descricao'     => $bolo['descricao'],
    'categoria'     => $bolo['categoria'],
    'tamanho'       => $tamanho,
    'tamanho_label' => $tamanhos[$tamanho]['label'],
    'massa'         => $massa,
    'massa_label'   => $massas[$massa]['label'],
    'recheio'       => $recheio,
    'recheio_label' => $recheios[$recheio]['label'],
    'data_evento'   => $dataEvento,
    'observacoes'   => $observacoes,
    'quantidade'    => $quantidade,
    'preco_unitario'=> $precoUnitario,
]);

dd_flash_set('success', 'Bolo adicionado ao carrinho com sucesso!');
header('Location: ../pages/compras.php');
exit;