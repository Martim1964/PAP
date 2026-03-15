<!-- compras-pagamento.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/compras-pagamento.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <title>Pagamento - Doces Dias</title>
</head>
<body>
<?php include '../includes/header.php'; ?>

    <div class="pagamento-container">
        <!-- PROGRESSO -->
        <div class="progresso-secao">
            <div class="step" data-step="1">
                <div class="step-numero">1</div>
                <div class="step-label">Carrinho</div>
            </div>
            <div class="step-linha"></div>
            <div class="step" data-step="2">
                <div class="step-numero">2</div>
                <div class="step-label">Finalizar</div>
            </div>
            <div class="step-linha"></div>
            <div class="step active" data-step="3">
                <div class="step-numero">3</div>
                <div class="step-label">Pagamento</div>
            </div>
        </div>

        <div class="contenido-pagamento">
            <!-- COLUNA ESQUERDA - MÉTODOS PAGAMENTO -->
            <div class="coluna-metodos">
                <!-- ABAS DE PAGAMENTO -->
                <div class="tabs-pagamento">
                    <button class="tab-btn active" onclick="selecionarMetodo('cartao')">
                        💳 Cartão de Crédito
                    </button>
                    <button class="tab-btn" onclick="selecionarMetodo('mbway')">
                        📱 MBWay
                    </button>
                </div>

                <!-- MÉTODO 1: CARTÃO DE CRÉDITO -->
                <div class="metodo-pagamento active" id="metodo-cartao">
                    <h2 class="metodo-titulo">Cartão de Crédito / Débito</h2>
                    
                    <form id="form-cartao" class="form-pagamento">
                        <!-- Titular do Cartão -->
                        <div class="form-grupo">
                            <label for="titular">Nome do Titular *</label>
                            <input type="text" id="titular" name="titular" placeholder="João Silva" required>
                            <span class="erro-msg" id="erro-titular"></span>
                        </div>

                        <!-- Número do Cartão -->
                        <div class="form-grupo">
                            <label for="cartao">Número do Cartão *</label>
                            <div class="input-cartao">
                                <input type="text" id="cartao" name="cartao" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                <div class="logo-cartao" id="logo-cartao"></div>
                            </div>
                            <span class="erro-msg" id="erro-cartao"></span>
                        </div>

                        <!-- CVV e Data -->
                        <div class="form-row">
                            <div class="form-grupo">
                                <label for="data-expiracao">Data de Validade *</label>
                                <input type="text" id="data-expiracao" name="data-expiracao" placeholder="MM/AA" maxlength="5" required>
                                <span class="erro-msg" id="erro-data"></span>
                            </div>
                            <div class="form-grupo">
                                <label for="cvv">CVV *</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                                <span class="erro-msg" id="erro-cvv"></span>
                            </div>
                        </div>

                        <!-- Checkbox Guardar Cartão -->
                        <div class="checkbox-grupo">
                            <input type="checkbox" id="guardar-cartao">
                            <label for="guardar-cartao">Guardar este cartão para futuras compras</label>
                        </div>

                        <!-- Checkbox Termos -->
                        <div class="checkbox-grupo">
                            <input type="checkbox" id="termos-cartao" required>
                            <label for="termos-cartao">Autorizo o débito de € <span id="total-cartao">0,00</span> neste cartão</label>
                        </div>
                    </form>

                    <!-- Visualização do Cartão -->
                    <div class="cartao-preview">
                        <div class="cartao-frente">
                            <div class="cartao-banco">VISA</div>
                            <div class="cartao-chip">💳</div>
                            <div class="cartao-numero" id="preview-numero">1234 5678 9012 3456</div>
                            <div class="cartao-titular">
                                <span>TITULAR</span>
                                <div class="cartao-nome" id="preview-titular">JOÃO SILVA</div>
                            </div>
                            <div class="cartao-validade" id="preview-data">MM/AA</div>
                        </div>
                    </div>
                </div>

                <!-- MÉTODO 2: MBWAY -->
                <div class="metodo-pagamento" id="metodo-mbway">
                    <h2 class="metodo-titulo">MBWay</h2>
                    
                    <form id="form-mbway" class="form-pagamento">
                        <!-- Telemóvel -->
                        <div class="form-grupo">
                            <label for="telefone-mbway">Número de Telemóvel *</label>
                            <input type="tel" id="telefone-mbway" name="telefone-mbway" placeholder="+351 9XX XXX XXX" required>
                            <span class="erro-msg" id="erro-telefone-mbway"></span>
                        </div>

                        <!-- Instruções -->
                        <div class="info-mbway">
                            <h3>Como funciona:</h3>
                            <ol>
                                <li>Clica em "Confirmar Pagamento com MBWay"</li>
                                <li>Receberás uma notificação no teu smartphone</li>
                                <li>Abre a app MBWay e autoriza o pagamento</li>
                                <li>O pagamento será processado imediatamente</li>
                            </ol>
                        </div>

                        <!-- Checkbox Termos -->
                        <div class="checkbox-grupo">
                            <input type="checkbox" id="termos-mbway" required>
                            <label for="termos-mbway">Autorizo o débito de € <span id="total-mbway">0,00</span> via MBWay</label>
                        </div>
                    </form>

                    <!-- Telefone Preview -->
                    <div class="telefone-preview">
                        <div class="telefone-tela">
                            <div class="telefone-notificacao">
                                🔔 Notificação MBWay
                            </div>
                            <div class="telefone-mensagem">
                                Pagamento de € <span id="mbway-valor">0,00</span>
                            </div>
                            <div class="telefone-tempo">Enviado agora</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUNA DIREITA - RESUMO -->
            <div class="coluna-resumo-pagamento">
                <div class="resumo-pagamento-sticky">
                    <h2 class="resumo-titulo">📋 RESUMO DO PAGAMENTO</h2>

                    <!-- Dados do Pedido -->
                    <div class="resumo-secao">
                        <div class="resumo-secao-titulo">Dados do Pedido</div>
                        <div class="resumo-item">
                            <span>Cliente:</span>
                            <span id="resumo-cliente">-</span>
                        </div>
                        <div class="resumo-item">
                            <span>Email:</span>
                            <span id="resumo-email" style="font-size: 12px;">-</span>
                        </div>
                    </div>

                    <!-- Endereço de Entrega -->
                    <div class="resumo-secao">
                        <div class="resumo-secao-titulo">Entrega em</div>
                        <div class="resumo-item">
                            <span id="resumo-endereco">-</span>
                        </div>
                    </div>

                    <!-- Valores -->
                    <div class="resumo-valores">
                        <div class="resumo-linha-valor">
                            <span>Subtotal</span>
                            <span id="resumo-subtotal">€ 0,00</span>
                        </div>
                        <div class="resumo-linha-valor">
                            <span>Entrega</span>
                            <span id="resumo-entrega-valor">€ 0,00</span>
                        </div>
                        <div class="resumo-linha-valor" id="resumo-desconto-item" style="display: none;">
                            <span>Desconto</span>
                            <span id="resumo-desconto-valor" class="texto-verde">- € 0,00</span>
                        </div>
                        <div class="resumo-linha-valor">
                            <span>IVA (23%)</span>
                            <span id="resumo-iva-valor">€ 0,00</span>
                        </div>
                    </div>

                    <div class="resumo-total-grande">
                        <span>TOTAL A PAGAR</span>
                        <span id="resumo-total-grande">€ 0,00</span>
                    </div>

                    <!-- Botões -->
                    <button class="btn-confirmar" id="btn-confirmar" onclick="confirmarPagamento()">
                        ✓ Confirmar Pagamento
                    </button>

                    <button class="btn-voltar-pagamento" onclick="voltarFinalizacao()">
                        ← Voltar
                    </button>

                    <!-- Info Segurança -->
                    <div class="info-seguranca">
                        <div class="icone-seguranca">🔒</div>
                        <div class="texto-seguranca">
                            Pagamento 100% seguro com encriptação SSL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE PROCESSAMENTO -->
    <div class="modal-processamento" id="modal-processamento">
        <div class="modal-conteudo">
            <div class="processamento-spinner"></div>
            <h3 id="modal-titulo">A processar pagamento...</h3>
            <p id="modal-descricao">Por favor, aguarda</p>
        </div>
    </div>

    <!-- MODAL DE SUCESSO -->
    <div class="modal-sucesso" id="modal-sucesso">
        <div class="modal-conteudo-sucesso">
            <div class="icone-sucesso">✓</div>
            <h2>Pagamento Realizado com Sucesso!</h2>
            <p id="modal-sucesso-msg">Recebimento de encomenda: <strong id="numero-encomenda">#00000</strong></p>
            <p class="pequeno-texto">Verifique o seu email para mais detalhes</p>
            <button class="btn-ok" onclick="finalizarCompra()">Ir para Página Inicial</button>
        </div>
    </div>

    <!-- MODAL DE ERRO -->
    <div class="modal-erro" id="modal-erro">
        <div class="modal-conteudo-erro">
            <div class="icone-erro">✕</div>
            <h2>Erro no Pagamento</h2>
            <p id="modal-erro-msg">Ocorreu um erro. Por favor, tenta novamente.</p>
            <button class="btn-ok-erro" onclick="fecharErro()">Tentar Novamente</button>
        </div>
    </div>

<?php include '../includes/footer.php'; ?>

<script src="../js/compras-pagamento.js"></script>
</body>
</html>
