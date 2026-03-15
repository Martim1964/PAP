<!-- compras-finalizar.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <div class="contenido-finalizar">
            <!-- COLUNA ESQUERDA - FORMULÁRIO -->
            <div class="coluna-formulario">
                <!-- DADOS PESSOAIS -->
                <div class="secao-formulario">
                    <h2 class="secao-titulo">👤 DADOS PESSOAIS</h2>
                    <form id="form-dados-pessoais">
                        <div class="form-grupo">
                            <label for="nome">Nome Completo *</label>
                            <input type="text" id="nome" name="nome" placeholder="Ex: João Silva" required>
                            <span class="erro-msg" id="erro-nome"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-grupo">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                                <span class="erro-msg" id="erro-email"></span>
                            </div>
                            <div class="form-grupo">
                                <label for="telefone">Telemóvel *</label>
                                <input type="tel" id="telefone" name="telefone" placeholder="+351 9XX XXX XXX" required>
                                <span class="erro-msg" id="erro-telefone"></span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- ENDEREÇO DE ENTREGA -->
                <div class="secao-formulario">
                    <h2 class="secao-titulo">📍 ENDEREÇO DE ENTREGA</h2>
                    <form id="form-endereco">
                        <div class="form-grupo">
                            <label for="endereco">Rua e Número *</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua das Flores, 123" required>
                            <span class="erro-msg" id="erro-endereco"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-grupo">
                                <label for="codigo-postal">Código Postal *</label>
                                <input type="text" id="codigo-postal" name="codigo-postal" placeholder="1200-000" required>
                                <span class="erro-msg" id="erro-cp"></span>
                            </div>
                            <div class="form-grupo">
                                <label for="cidade">Cidade *</label>
                                <input type="text" id="cidade" name="cidade" placeholder="Lisboa" required>
                                <span class="erro-msg" id="erro-cidade"></span>
                            </div>
                        </div>

                        <div class="form-grupo">
                            <label for="complemento">Complemento (Apto, Andar, etc)</label>
                            <input type="text" id="complemento" name="complemento" placeholder="Opcional">
                        </div>

                        <div class="checkbox-grupo">
                            <input type="checkbox" id="endereco-igual" checked>
                            <label for="endereco-igual">Endereço de faturação igual ao de entrega</label>
                        </div>
                    </form>
                </div>

                <!-- OBSERVAÇÕES -->
                <div class="secao-formulario">
                    <h2 class="secao-titulo">📝 OBSERVAÇÕES</h2>
                    <form id="form-observacoes">
                        <div class="form-grupo">
                            <label for="observacoes">Mensagem Especial (Opcional)</label>
                            <textarea id="observacoes" name="observacoes" rows="4" placeholder="Adiciona uma mensagem especial, instruções de entrega, restrições alimentares, etc..."></textarea>
                            <span class="char-count"><span id="chars-atual">0</span>/500</span>
                        </div>
                    </form>
                </div>

                <!-- OPÇÕES DE ENTREGA -->
                <div class="secao-formulario">
                    <h2 class="secao-titulo">🚚 OPÇÕES DE ENTREGA</h2>
                    <div class="opcoes-entrega">
                        <div class="opcao-entrega" onclick="selecionarEntrega('normal')">
                            <input type="radio" name="entrega" value="normal" id="entrega-normal" checked>
                            <label for="entrega-normal">
                                <div class="opcao-titulo">Entrega Normal</div>
                                <div class="opcao-descricao">5 - 7 dias úteis</div>
                                <div class="opcao-preco">€ 5,00</div>
                            </label>
                        </div>

                        <div class="opcao-entrega" onclick="selecionarEntrega('express')">
                            <input type="radio" name="entrega" value="express" id="entrega-express">
                            <label for="entrega-express">
                                <div class="opcao-titulo">Entrega Express</div>
                                <div class="opcao-descricao">2 - 3 dias úteis</div>
                                <div class="opcao-preco">€ 12,00</div>
                            </label>
                        </div>

                        <div class="opcao-entrega" onclick="selecionarEntrega('urgente')">
                            <input type="radio" name="entrega" value="urgente" id="entrega-urgente">
                            <label for="entrega-urgente">
                                <div class="opcao-titulo">Entrega Urgente</div>
                                <div class="opcao-descricao">Próximo dia útil (até 12h)</div>
                                <div class="opcao-preco">€ 25,00</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUNA DIREITA - RESUMO -->
            <div class="coluna-resumo">
                <!-- RESUMO DO PEDIDO -->
                <div class="resumo-pedido-sticky">
                    <h2 class="resumo-titulo">📦 RESUMO DO PEDIDO</h2>

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

                    <div class="resumo-linha">
                        <span>Entrega</span>
                        <span id="resumo-entrega">€ 5,00</span>
                    </div>

                    <div class="resumo-linha desconto-linha" id="resumo-desconto-container" style="display: none;">
                        <span>Desconto</span>
                        <span id="resumo-desconto" class="texto-verde">- € 0,00</span>
                    </div>

                    <div class="resumo-impostos">
                        <span>IVA (23%)</span>
                        <span id="resumo-iva">€ 0,00</span>
                    </div>

                    <div class="resumo-total">
                        <span class="total-label">TOTAL A PAGAR</span>
                        <span id="resumo-total-final" class="total-valor">€ 68,00</span>
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

<?php include '../includes/footer.php'; ?>

<script src="../js/compras-finalizar.js"></script>
</body>
</html>
