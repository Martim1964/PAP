<?php
declare(strict_types=1);

// =========================================================
// PAGINA DE FINALIZACAO DO CHECKOUT
// Recolhe dados de cliente, entrega e observacoes antes
// de avancar para a fase de pagamento.
// =========================================================

require_once __DIR__ . '/../includes/carrinho.php';

dd_start_session();

$cartItems = dd_carrinho_get();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/compras-finalizar.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <title>Finalizar Compra - Doces Dias</title>
</head>
<body>
<?php include '../includes/header.php'; ?>

    <div class="finalizar-container">
        <!-- PROGRESSO -->
        <div class="progresso-secao">
            <div class="step active" data-step="1">
                <div class="step-numero">1</div>
                <div class="step-label">Carrinho</div>
            </div>
            <div class="step-linha"></div>
            <div class="step active" data-step="2">
                <div class="step-numero">2</div>
                <div class="step-label">Finalizar</div>
            </div>
            <div class="step-linha"></div>
            <div class="step" data-step="3">
                <div class="step-numero">3</div>
                <div class="step-label">Pagamento</div>
            </div>
        </div>

        <form method = "POST" action="compras-pagamento.php">
        <div class="contenido-finalizar">
            <!-- COLUNA ESQUERDA - FORMULÁRIO -->
            <div class="coluna-formulario">
                <!-- DADOS PESSOAIS -->
                <div class="secao-formulario">
                    <h2 class="secao-titulo">DADOS PESSOAIS</h2>
                    <form id="form-dados-pessoais">
                        <div class="form-grupo">
                            <label for="nome">Nome Completo *</label>
                            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($_SESSION['nome'] ?? '') ?>"readonly>
                            <span class="erro-msg" id="erro-nome"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-grupo">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user'] ?? '') ?>"readonly>
                                <span class="erro-msg" id="erro-email"></span>
                            </div>
                            <div class="form-grupo">
                                <label for="telefone">Telemóvel *</label>
                                <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($_SESSION['telemovel'] ?? '') ?>"readonly>
                                <span class="erro-msg" id="erro-telefone"></span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- OBSERVAÇÕES -->
                <div class="secao-formulario">
                    <h2 class="secao-titulo">OBSERVAÇÕES</h2>
                    <form id="form-observacoes">
                        <div class="form-grupo">
                            <label for="observacoes">Mensagem Especial (Opcional)</label>
                            <textarea id="observacoes" name="observacoes" rows="4" placeholder="Adiciona uma mensagem especial, instruções de entrega, restrições alimentares, etc..."></textarea>
                            <span class="char-count"><span id="chars-atual">0</span>/500</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- COLUNA DIREITA - RESUMO -->
            <div class="coluna-resumo">
                <!-- RESUMO DO PEDIDO -->
                <div class="resumo-pedido-sticky">
                    <h2 class="resumo-titulo">RESUMO DO PEDIDO</h2>

                    <!-- Produtos -->
                    <div class="resumo-produtos">
                        <div id="lista-resumo-produtos">
                            <!-- Produtos carregados dinamicamente -->
                        </div>
                    </div>

                    <!-- Linhas de Resumo -->
                    <div class="resumo-linha">
                        <span>Subtotal</span>
                        <span id="resumo-subtotal">€ 63,00</span>
                    </div>

                    <div class="resumo-impostos">
                        <span>IVA (23%)</span>
                        <span id="resumo-iva">€ 0,00</span>
                    </div>

                    <div class="resumo-total">
                        <span class="total-label">TOTAL A PAGAR</span>
                        <span id="resumo-total-final" class="total-valor">€ 0,00</span>
                    </div>

                    <!-- Termos e Condições -->
                    <div class="termos-checkbox">
                        <input type="checkbox" id="termos" required>
                        <label for="termos">
                            Concordo com os <a href="#" class="link-termos">Termos e Condições</a> e <a href="#" class="link-termos">Política de Privacidade</a>
                        </label>
                    </div>

                    <!-- Botões -->
                    <button class="btn-pagar" onclick="avancarPagamento()" id="btn-pagar">
                        Avançar para Pagamento →
                    </button>

                    <button class="btn-voltar" onclick="voltarCarrinho()">
                        ← Voltar ao Carrinho
                    </button>
                </div>
            </div>
        </div>
    </div>
    </form>

<?php include '../includes/footer.php'; ?>

<script>
    window.carrinhoSessao = <?= json_encode($cartItems, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<script src="../js/compras-finalizar.js"></script>
</body>
</html>
