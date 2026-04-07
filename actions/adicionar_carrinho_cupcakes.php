<?php
// ============================================================
// FICHEIRO: actions/adicionar_carrinho_cupcakes.php
// O QUE FAZ: Recebe o formulário de encomenda de cupcakes
// e doces, valida os dados, calcula o preço A PARTIR DA
// BASE DE DADOS e adiciona ao carrinho na sessão.
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
$dataEvento  = dd_limpar_texto($_POST['birthday']    ?? '', 10);
$observacoes = dd_limpar_texto($_POST['observacoes'] ?? '', 500);

// --- BUSCAR DADOS DA BASE DE DADOS ---
$bolo     = buscar_bolo($con, $boloId);
$tamanhos = buscar_tamanhos($con);

// --- VALIDAÇÕES ---
$erros = [];

if (!$bolo) {
    $erros[] = 'O produto selecionado não existe.';
}
if (!isset($tamanhos[$tamanho])) {
    $erros[] = 'Seleciona um pack válido.';
}
if (!dd_data_evento_valida($dataEvento)) {
    $erros[] = 'A data do evento deve ter pelo menos 7 dias de antecedência.';
}

if (!empty($erros)) {
    dd_flash_set('danger', implode(' ', $erros));
    $urlVoltar = $boloId !== '' ? '../pages/bolos/encomenda-cupcakes.php?bolo=' . urlencode($boloId) : '../pages/encomende.php';
    header('Location: ' . $urlVoltar);
    exit;
}

// Mapa de preços local para cupcakes/doces 
$mapaPrecos = [
    'bolachas-natal'        => ['pequeno' => 25, 'medio' => 35, 'grande' => 50, 'muito_grande' => 70],
    'bolachas-panda'        => ['pequeno' => 25, 'medio' => 35, 'grande' => 50, 'muito_grande' => 70],
    'mini-brigadeiros'      => ['pequeno' => 10, 'medio' => 20, 'grande' => 35, 'muito_grande' => 50],
    'brigadeiro-chocolate'  => ['pequeno' => 25, 'grande' => 40],
    'bolo-bolacha'          => ['pequeno' => 25, 'grande' => 40],
    'torta-chocolate'       => ['pequeno' => 25, 'grande' => 40],
    'torta-laranja'         => ['pequeno' => 25, 'grande' => 40],
    //'torre-choux'           => ['pequeno' => 25],
];

$mapaLabels = [
    'bolachas-natal'        => ['pequeno' => "Pack 6 unidades", 'medio' => "Pack 14 unidades", 'grande' => "Pack 28 unidades", 'muito_grande' => "Pack 50 unidades"],
    'bolachas-panda'        => ['pequeno' => "Pack 6 unidades", 'medio' => "Pack 14 unidades", 'grande' => "Pack 28 unidades", 'muito_grande' => "Pack 50 unidades"],
    'mini-brigadeiros'      => ['pequeno' => "Pack 6 unidades", 'medio' => "Pack 14 unidades", 'grande' => "Pack 28 unidades", 'muito_grande' => "Pack 50 unidades"],
    'brigadeiro-chocolate'  => ['pequeno' => "Tamanho Normal", 'grande' => "Tamanho Familiar"],
    'bolo-bolacha'          => ['pequeno' => "Tamanho Normal", 'grande' => "Tamanho Familiar"],
    'torta-chocolate'       => ['pequeno' => "Tamanho Normal", 'grande' => "Tamanho Familiar"],
    'torta-laranja'         => ['pequeno' => "Tamanho Normal", 'grande' => "Tamanho Familiar"],
];

$precoUnitario = $mapaPrecos[$boloId][$tamanho] ?? null;

if ($precoUnitario === null) {
    dd_flash_set('danger', 'Não foi possível calcular o preço. Tenta novamente.');
    header('Location: ../pages/bolos/encomenda-cupcakes.php?bolo=' . urlencode($boloId));
    exit;
}

// --- 5. ADICIONAR AO CARRINHO ---
$quantidade = (int)($_POST['quantidade'] ?? 1);
dd_carrinho_adicionar([
    'bolo_id'        => $boloId,
    'nome'           => $bolo['nome'],
    'imagem'         => '../' . ltrim($bolo['imagem'], '/'),
    'categoria'      => 'cupcakes',
    'tamanho'        => $tamanho,
    'tamanho_label'  => $mapaLabels[$boloId][$tamanho] ?? $tamanho,
    'massa'          => '',
    'massa_label'    => '',
    'recheio'        => '',
    'recheio_label'  => '',
    'data_evento'    => $dataEvento,
    'observacoes'    => $observacoes,
    'quantidade'     => $quantidade,
    'preco_unitario' => (float)$precoUnitario,
    'total_item'     => (float)$precoUnitario * $quantidade
]);

dd_flash_set('success', 'Produto adicionado ao carrinho com sucesso!');
header('Location: ../pages/compras.php');
exit;