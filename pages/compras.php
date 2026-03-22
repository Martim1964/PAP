<?php
declare(strict_types=1);

// =========================================================
// PAGINA DO CARRINHO
// Lista os itens em sessao e trata atualizacao/remocao.
// =========================================================

require_once __DIR__ . '/../includes/carrinho.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!dd_verify_csrf($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        dd_flash_set('danger', 'Pedido invalido. Atualize a pagina e tente novamente.');
        header('Location: compras.php');
        exit;
    }

    $action = dd_limpar_texto($_POST['action'] ?? '', 20);
    $signature = dd_limpar_texto($_POST['item_id'] ?? '', 128);

    if ($action === 'update') {
        $quantity = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
            'options' => [
                'default' => 1,
                'min_range' => 1,
                'max_range' => 20,
            ],
        ]);

        if ($quantity === false || !dd_carrinho_atualizar_quantidade($signature, $quantity)) {
            dd_flash_set('danger', 'Nao foi possivel atualizar a quantidade do item.');
        } else {
            dd_flash_set('success', 'Quantidade atualizada com sucesso.');
        }
    } elseif ($action === 'remove') {
        dd_carrinho_remover($signature);
        dd_flash_set('success', 'Item removido do carrinho.');
    }

    header('Location: compras.php');
    exit;
}

$cartItems = dd_carrinho_get();
$totais = dd_carrinho_totais($cartItems);
$flash = dd_flash_get();
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

    <div class="carrinho-container">
        <div class="coluna-produtos">
            <div class="carrinho-header">
                <h1>O teu carrinho <span class="produto-count">(<?= (int) $totais['quantidade_total'] ?> produto<?= $totais['quantidade_total'] === 1 ? '' : 's' ?>)</span></h1>
            </div>

            <?php if ($flash): ?>
                <div class="alert alert-<?= htmlspecialchars($flash['type'] === 'danger' ? 'danger' : 'success') ?>" role="alert">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>
            
            <div id="lista-produtos">
                <?php if (!$cartItems): ?>
                    <div class="carrinho-vazio">
                        <h2>O teu carrinho esta vazio</h2>
                        <p>Escolhe um bolo personalizado para comecar a tua encomenda.</p>
                        <a href="../pages/encomende.php" class="btn-continuar">Continuar a comprar</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($cartItems as $item): ?>
                        <article class="produto-item" data-item-id="<?= htmlspecialchars((string) ($item['assinatura'] ?? '')) ?>">
                            <div class="produto-imagem">
                                <img src="<?= htmlspecialchars((string) ($item['imagem'] ?? '')) ?>" alt="<?= htmlspecialchars((string) ($item['nome'] ?? 'Produto')) ?>">
                            </div>

                            <div class="produto-info">
                                <div class="produto-detalhes">
                                    <h3 class="produto-nome"><?= htmlspecialchars((string) ($item['nome'] ?? 'Produto personalizado')) ?></h3>
                                    <p class="produto-desc"><?= htmlspecialchars((string) ($item['descricao'] ?? '')) ?></p>
                                    <div class="produto-specs">
                                        <span class="spec-tag">Tamanho: <?= htmlspecialchars((string) ($item['tamanho_label'] ?? '')) ?></span>
                                        <span class="spec-tag">Massa: <?= htmlspecialchars((string) ($item['massa_label'] ?? '')) ?></span>
                                        <span class="spec-tag">Recheio: <?= htmlspecialchars((string) ($item['recheio_label'] ?? '')) ?></span>
                                        <span class="spec-tag">Data: <?= htmlspecialchars(dd_formata_data((string) ($item['data_evento'] ?? ''))) ?></span>
                                    </div>
                                    <?php if (!empty($item['observacoes'])): ?>
                                        <p class="produto-desc mt-3"><strong>Observacoes:</strong> <?= htmlspecialchars((string) $item['observacoes']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <form class="produto-acoes js-quantity-form" method="post" action="compras.php">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="item_id" value="<?= htmlspecialchars((string) ($item['assinatura'] ?? '')) ?>">
                                    <label for="qtd-<?= htmlspecialchars((string) ($item['assinatura'] ?? '')) ?>">Quantidade:</label>
                                    <select class="qtd-selector js-quantity-select" id="qtd-<?= htmlspecialchars((string) ($item['assinatura'] ?? '')) ?>" name="quantidade">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i ?>" <?= (int) ($item['quantidade'] ?? 1) === $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </form>
                            </div>

                            <div class="produto-preco-secao">
                                <form method="post" action="compras.php" class="js-remove-form">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="item_id" value="<?= htmlspecialchars((string) ($item['assinatura'] ?? '')) ?>">
                                    <button class="btn-remover" type="submit" title="Remover">x</button>
                                </form>
                                <div class="preco-valor">€ <?= htmlspecialchars(dd_formata_preco((float) ($item['subtotal'] ?? 0))) ?></div>
                                <small class="text-muted">€ <?= htmlspecialchars(dd_formata_preco((float) ($item['preco_unitario'] ?? 0))) ?> / unidade</small>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="beneficios-secao">
                <div class="beneficio-item">
                    <span>Encomendas com configuracao guardada em sessao protegida no servidor.</span>
                </div>
                <div class="beneficio-item">
                    <span>Validacao de data minima de 7 dias para producao artesanal.</span>
                </div>
                <div class="beneficio-item">
                    <span>Preco calculado no backend para evitar manipulacao no browser.</span>
                </div>
            </div>
        </div>

        <aside class="coluna-resumo">
            <div class="resumo-sticky">
                <h2 class="resumo-titulo">Resumo da encomenda</h2>

                <div class="resumo-linha">
                    <span>Linhas no carrinho</span>
                    <span><?= (int) $totais['linhas'] ?></span>
                </div>

                <div class="resumo-linha">
                    <span>Total de unidades</span>
                    <span id="total-itens"><?= (int) $totais['quantidade_total'] ?> produto<?= $totais['quantidade_total'] === 1 ? '' : 's' ?></span>
                </div>

                <div class="resumo-linha">
                    <span>Subtotal</span>
                    <span id="subtotal">€ <?= htmlspecialchars(dd_formata_preco($totais['subtotal'])) ?></span>
                </div>

                <div class="resumo-linha">
                    <span>Total</span>
                    <span id="total-final">€ <?= htmlspecialchars(dd_formata_preco($totais['total'])) ?></span>
                </div>

                <p class="impostos-info">Os portes e ajustes finais de design podem ser confirmados mais tarde, sem alterar o preco base calculado para as opcoes escolhidas.</p>

                <button class="btn-checkout" type="button" <?= !$cartItems ? 'disabled' : '' ?> onclick="window.location.href='compras-finalizar.php'">
                    Finalizar compra →
                </button>

                <div class="info-entrega">
                    <p class="entrega-titulo">Sugestao futura</p>
                    <p class="entrega-data">Persistir carrinho e encomendas finais em MySQL para historico, checkout e recuperacao entre dispositivos.</p>
                </div>
            </div>
        </aside>
    </div>

    <script src="../js/compras.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
