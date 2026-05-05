<?php
// ============================================================
// FICHEIRO: pages/compras.php
// O QUE FAZ: Mostra o carrinho de compras do utilizador.
// Permite atualizar quantidades e remover itens.
//
// AÇÕES POSSÍVEIS (via formulário POST):
//   - action=update → atualiza a quantidade de um item
//   - action=remove → remove um item do carrinho
// ============================================================

require_once __DIR__ . '/../includes/carrinho.php';

// --- PROCESSAR AÇÕES DO FORMULÁRIO (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar token CSRF (segurança)
    if (!dd_verificar_csrf($_POST['csrf_token'] ?? '')) {
        dd_flash_set('danger', 'Pedido inválido. Atualiza a página e tenta novamente.');
        header('Location: compras.php');
        exit;
    }

    $acao      = dd_limpar_texto($_POST['action']  ?? '', 20);
    $assinatura = dd_limpar_texto($_POST['item_id'] ?? '', 128);

    // ATUALIZAR QUANTIDADE
    if ($acao === 'update') {
        $novaQuantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
            'options' => ['default' => 1, 'min_range' => 1, 'max_range' => 20]
        ]);

        if (!dd_carrinho_atualizar_quantidade($assinatura, $novaQuantidade)) {
            dd_flash_set('danger', 'Não foi possível atualizar a quantidade.');
        } else {
            dd_flash_set('success', 'Quantidade atualizada!');
        }
    }

    // REMOVER ITEM
    if ($acao === 'remove') {
        dd_carrinho_remover($assinatura);
        dd_flash_set('success', 'Item removido do carrinho.');
    }

    // Redireciona para evitar reenvio do formulário (padrão PRG)
    header('Location: compras.php');
    exit;
}

// --- LER DADOS PARA MOSTRAR NA PÁGINA ---
$itensCarrinho = dd_carrinho_get();
$totais        = dd_carrinho_totais($itensCarrinho);
$flash         = dd_flash_get(); // Mensagem flash (se existir)
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/compras.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <title>Carrinho de Compras - Doces Dias</title>
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>

<div class="carrinho-container">

    <!-- COLUNA ESQUERDA: lista de produtos -->
    <div class="coluna-produtos">
        <div class="carrinho-header">
            <h1>
                O teu carrinho
                <span class="produto-count">
                    (<?= (int)$totais['quantidade_total'] ?> produto<?= $totais['quantidade_total'] !== 1 ? 's' : '' ?>)
                </span>
            </h1>
        </div>

        <!-- Mensagem flash (sucesso ou erro) -->
        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['tipo'] === 'danger' ? 'danger' : 'success' ?>" role="alert">
                <?= htmlspecialchars($flash['mensagem']) ?>
            </div>
        <?php endif; ?>

        <div id="lista-produtos">

            <!-- CARRINHO VAZIO -->
            <?php if (empty($itensCarrinho)): ?>
                <div class="carrinho-vazio">
                    <h2>O teu carrinho está vazio</h2>
                    <p>Escolhe um bolo personalizado para começar a tua encomenda.</p>
                    <a href="../pages/encomende.php" class="btn-continuar">Continuar a comprar</a>
                </div>

            <!-- LISTA DE ITENS -->
            <?php else: ?>
                <?php foreach ($itensCarrinho as $item): ?>
                    <article class="produto-item">

                        <!-- Imagem do bolo -->
                        <div class="produto-imagem">
                            <img src="<?= htmlspecialchars($item['imagem'] ?? '') ?>"
                                 alt="<?= htmlspecialchars($item['nome'] ?? 'Bolo') ?>">
                        </div>

                        <!-- Detalhes do bolo -->
                        <div class="produto-info">
                            <div class="produto-detalhes">
                                <h2 class="produto-nome"><?= htmlspecialchars($item['nome'] ?? '') ?></h2>
                                <p class="produto-desc"><?= htmlspecialchars($item['descricao'] ?? '') ?></p>

                                <!-- Etiquetas com as opções escolhidas -->
                                <div class="produto-specs">
                                    <span class="spec-tag">Tamanho: <?= htmlspecialchars($item['tamanho_label'] ?? '') ?></span>
                                    <?php if (!empty($item['massa_label'])): ?>
                                        <span class="spec-tag">Massa: <?= htmlspecialchars($item['massa_label']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($item['recheio_label'])): ?>
                                        <span class="spec-tag">Recheio: <?= htmlspecialchars($item['recheio_label']) ?></span>
                                    <?php endif; ?>
                                    <span class="spec-tag">Data: <?= htmlspecialchars(dd_formata_data($item['data_evento'] ?? '')) ?></span>
                                </div>

                                <?php if (!empty($item['observacoes'])): ?>
                                    <p class="produto-desc mt-3">
                                        <strong>Observações:</strong> <?= htmlspecialchars($item['observacoes']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Formulário para ATUALIZAR QUANTIDADE -->
                            <form class="produto-acoes js-quantity-form" method="post" action="compras.php">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
                                <input type="hidden" name="action"     value="update">
                                <input type="hidden" name="item_id"    value="<?= htmlspecialchars($item['assinatura'] ?? '') ?>">

                                <label>Quantidade:</label>
                                <select class="qtd-selector js-quantity-select" name="quantidade">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= (int)($item['quantidade'] ?? 1) === $i ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </form>
                        </div>

                        <!-- Preço e botão de remover -->
                        <div class="produto-preco-secao">

                            <!-- Formulário para REMOVER item -->
                            <form method="post" action="compras.php" class="js-remove-form">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
                                <input type="hidden" name="action"     value="remove">
                                <input type="hidden" name="item_id"    value="<?= htmlspecialchars($item['assinatura'] ?? '') ?>">
                                <button class="btn-remover" type="submit" title="Remover">✕</button>
                            </form>

                            <div class="preco-valor">
                                € <?= htmlspecialchars(dd_formata_preco((float)($item['subtotal'] ?? 0))) ?>
                            </div>
                            <small class="text-muted">
                                € <?= htmlspecialchars(dd_formata_preco((float)($item['preco_unitario'] ?? 0))) ?> / unidade
                            </small>
                        </div>

                    </article>
                <?php endforeach; ?>
            <?php endif; ?>

        </div><!-- fim lista-produtos -->
    </div><!-- fim coluna-produtos -->

    <!-- COLUNA DIREITA: resumo e totais -->
    <aside class="coluna-resumo">
        <div class="resumo-sticky">
            <h2 class="resumo-titulo">Resumo da encomenda</h2>

            <div class="resumo-linha">
                <span>Total de produtos</span>
                <span><?= (int)$totais['quantidade_total'] ?></span>
            </div>

            <div class="resumo-linha">
                <span>Subtotal</span>
                <span>€ <?= htmlspecialchars(dd_formata_preco($totais['subtotal'])) ?></span>
            </div>

            <div class="resumo-linha">
                <span><strong>Total</strong></span>
                <span><strong>€ <?= htmlspecialchars(dd_formata_preco($totais['total'])) ?></strong></span>
            </div>

            <!-- Botão de finalizar (desativado se o carrinho estiver vazio) -->
            <button class="btn-checkout" aria-label="Finalizar Compra"
                    <?= empty($itensCarrinho) ? 'disabled' : '' ?>
                    onclick="window.location.href='compras-finalizar.php'">
                Finalizar compra →
            </button>
        </div>
    </aside>

</div><!-- fim carrinho-container -->

</main>

<script src="../js/compras.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>