<!-- carrinho.php -->
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
        <!-- COLUNA ESQUERDA - PRODUTOS -->
        <div class="coluna-produtos">
            <div class="carrinho-header">
                <h1>O TEU SACO DE COMPRAS <span class="produto-count">(2 produtos)</span></h1>
            </div>
            <!-- LISTA DE PRODUTOS -->
            <div id="lista-produtos">
                
                <!-- Produto 1 - Bolo Personalizado -->
                <div class="produto-item" data-id="1" data-preco="45.00">
                    <div class="produto-imagem">
                        <img src="../img-pap/bolo-exemplo.jpg" alt="Bolo Personalizado">
                    </div>

                    <div class="produto-info">
                        <div class="produto-detalhes">
                            <h3 class="produto-nome">BOLO PERSONALIZADO</h3>
                            <p class="produto-desc">Red Velvet / Mascarpone</p>
                            <div class="produto-specs">
                                <span class="spec-tag">🎂 Médio (13-16 pessoas)</span>
                                <span class="spec-tag">💗 Aniversário - 25 anos</span>
                                <span class="spec-tag">📅 15/02/2026</span>
                            </div>
                        </div>

                        <div class="produto-acoes">
                            <label for="qtd-1">Quantidade:</label>
                            <select class="qtd-selector" id="qtd-1" onchange="atualizarQuantidade(1, this.value)">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>

                    <div class="produto-preco-secao">
                        <button class="btn-remover" onclick="removerItem(1)" title="Remover">✕</button>
                        <button class="btn-favorito" title="Adicionar aos favoritos">♡</button>
                        <div class="preco-valor">€ 45,00</div>
                    </div>
                </div>

                <!-- Produto 2 - Cupcakes -->
                <div class="produto-item" data-id="2" data-preco="18.00">
                    <div class="produto-imagem">
                        <img src="../img-pap/cupcakes-exemplo.jpg" alt="Cupcakes">
                    </div>

                    <div class="produto-info">
                        <div class="produto-detalhes">
                            <h3 class="produto-nome">CUPCAKES ARTESANAIS</h3>
                            <p class="produto-desc">Chocolate / Brigadeiro</p>
                            <div class="produto-specs">
                                <span class="spec-tag">🧁 Pack 6 unidades</span>
                                <span class="spec-tag">🍫 Premium</span>
                            </div>
                        </div>

                        <div class="produto-acoes">
                            <label for="qtd-2">Quantidade:</label>
                            <select class="qtd-selector" id="qtd-2" onchange="atualizarQuantidade(2, this.value)">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="produto-preco-secao">
                        <button class="btn-remover" onclick="removerItem(2)" title="Remover">✕</button>
                        <button class="btn-favorito" title="Adicionar aos favoritos">♡</button>
                        <div class="preco-valor">€ 18,00</div>
                    </div>
                </div>

            </div>

            <!-- Benefícios -->
            <div class="beneficios-secao">
                <div class="beneficio-item">
                    <span class="beneficio-icon">🚚</span>
                    <span>Entregas em Lisboa e arredores</span>
                </div>
                <div class="beneficio-item">
                    <span class="beneficio-icon">🎂</span>
                    <span>Bolos feitos no próprio dia</span>
                </div>
                <div class="beneficio-item">
                    <span class="beneficio-icon">💝</span>
                    <span>Embalagem especial incluída</span>
                </div>
            </div>
        </div>

        <!-- COLUNA DIREITA - RESUMO -->
        <div class="coluna-resumo">
            <div class="resumo-sticky">
                <h2 class="resumo-titulo">RESUMO DA ENCOMENDA</h2>

                <div class="resumo-linha">
                    <span id="total-itens">2 produtos</span>
                    <span id="subtotal">€ 63,00</span>
                </div>

                <div class="resumo-linha">
                    <span>Entrega</span>
                    <span id="entrega-valor">€ 5,00</span>
                </div>

                <div class="resumo-linha desconto-linha">
                    <span>Desconto</span>
                    <span id="desconto-valor" class="texto-verde">- € 0,00</span>
                </div>

                <div class="resumo-total">
                    <span class="total-label">Total</span>
                    <span id="total-final" class="total-valor">€ 68,00</span>
                </div>
                <p class="impostos-info">(Com impostos incluídos € <span id="impostos">12,74</span>)</p>

                <!-- Código Promocional -->
                <div class="codigo-promo" onclick="togglePromoCode()">
                    <span class="promo-icon">🏷️</span>
                    <span>Utiliza um código promocional</span>
                    <span class="seta">▼</span>
                </div>

                <div class="promo-input-container" id="promo-container" style="display: none;">
                    <input type="text" id="codigo-promo" placeholder="Inserir código">
                    <button onclick="aplicarCodigo()" class="btn-aplicar">Aplicar</button>
                </div>

                <!-- Botões de Pagamento -->
                <button class="btn-checkout" onclick="irParaFinalizacao()">
                    Finalizar Compra →
                </button>

                <button class="btn-alternativo">
                    <img src="https://www.gstatic.com/instantbuy/svg/dark_gpay.svg" alt="Google Pay" style="height: 20px;">
                </button>

                <div class="divisor-ou">
                    <span>OU</span>
                </div>

                <!-- Métodos de Pagamento -->
                <div class="metodos-pagamento">
                    <p class="metodos-titulo">MÉTODOS DE PAGAMENTO ACEITES</p>
                    <div class="icones-pagamento">
                        <div class="icone-pag">VISA</div>
                        <div class="icone-pag">MC</div>
                        <div class="icone-pag">AMEX</div>
                        <div class="icone-pag">MB</div>
                        <div class="icone-pag">PayPal</div>
                    </div>
                </div>

                <!-- Entrega Estimada -->
                <div class="info-entrega">
                    <p class="entrega-titulo">📦 Entrega Estimada</p>
                    <p class="entrega-data">15 - 20 Fevereiro 2026</p>
                    <p class="entrega-nota">* Bolos personalizados: mínimo 7 dias</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/compras.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>