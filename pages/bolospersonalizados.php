<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bolospersonalizados.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Personalize o seu bolo - Doces Dias</title>
</head>
<body>
<?php include '../includes/header.php'; ?>

    <div class="bcontainer">
        <div class="title">
            <h1>Personalize o seu bolo de sonhos!</h1>
            <p class="subtitle">📧 Após o pedido, entraremos em contacto por email ou telefone para confirmar todos os detalhes</p>
        </div>
        
        <div class="personalize-form">
            <form method="post" action="processar_personalizacao.php">
                
                <!-- GRID LAYOUT - 2 COLUNAS -->
                <div class="grid-container">
                    
                    <!-- ========== COLUNA ESQUERDA - PERSONALIZAÇÃO ========== -->
                    <div class="coluna-esquerda">
                        
                        <!-- Tamanho do Bolo -->
                        <section class="form-section">
                            <h2>1. Tamanho do Bolo</h2>
                            <label for="tamanho">Selecione o tamanho:</label>
                            <select id="tamanho" name="tamanho" required>
                                <option value="">Escolha um tamanho...</option>
                                <option value="pequeno">Pequeno (10-12 pessoas) - €25</option>
                                <option value="medio">Médio (13-16 pessoas) - €35</option>
                                <option value="grande">Grande (17-20 pessoas) - €50</option>
                                <option value="muito_grande">Muito Grande (20+ pessoas) - €70</option>
                            </select>
                        </section>

                        <!-- Tipo de Massa -->
                        <section class="form-section">
                            <h2>2. Tipo de Massa</h2>
                            <label for="massa">Selecione a massa:</label>
                            <select id="massa" name="massa" required>
                                <option value="">Escolha uma massa...</option>
                                <optgroup label="Massas Standard">
                                    <option value="baunilha">🧁 Baunilha</option>
                                    <option value="laranja_canela">🍊 Laranja e Canela</option>
                                    <option value="papoila_limao">🍋 Papoila e Limão</option>
                                </optgroup>
                                <optgroup label="Massas Premium (+)">
                                    <option value="chocolate">🍫 Chocolate Negro (+€10)</option>
                                    <option value="red_velvet">💗 Red Velvet (+€12)</option>
                                    <option value="cenoura">🧡 Laranja e Amêndoa (+€8)</option>
                                </optgroup>
                            </select>
                        </section>

                        <!-- Tipo de Recheio -->
                        <section class="form-section">
                            <h2>3. Tipo de Recheio</h2>
                            <label for="recheio">Selecione o recheio:</label>
                            <select name="recheio" id="recheio" required>
                                <option value="">Escolha um recheio...</option>
                                <optgroup label="Recheios Standard">
                                    <option value="caramelo">🍯 Caramelo Salgado</option>
                                    <option value="morango">🍓 Curd de Morango</option>
                                    <option value="limao">🍋 Curd de Limão</option>
                                    <option value="creamcheese">🧀 Cream Cheese Laranja</option>
                                </optgroup>
                                <optgroup label="Recheios Premium (+)">
                                    <option value="brigadeiro">🍫 Brigadeiro Negro (+€8)</option>
                                    <option value="mascarpone">☁️ Mascarpone (+€10)</option>
                                    <option value="framboesa">🫐 Ganache Framboesa (+€12)</option>
                                    <option value="maracuja">💛 Ganache Maracujá (+€12)</option>
                                </optgroup>
                            </select>
                        </section>

                        <!-- Sugestões -->
                        <section class="form-section suggestions-box">
                            <h2>💡 Sugestões de Combinações</h2>
                            <div class="suggestions-grid">
                                <div class="suggestion-card">
                                    <h3>Standard</h3>
                                    <ul>
                                        <li>Baunilha + Caramelo</li>
                                        <li>Papoila + Limão</li>
                                    </ul>
                                </div>
                                <div class="suggestion-card">
                                    <h3>Premium</h3>
                                    <ul>
                                        <li>Chocolate + Brigadeiro</li>
                                        <li>Red Velvet + Mascarpone</li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- Data do Evento -->
                        <section class="form-section">
                            <h2>4. Data do Evento</h2>
                            <label for="birthday">Data do evento (mín. 7 dias):</label>
                            <input type="date" id="birthday" name="birthday" required>
                        </section>

                        <!-- Tipo de Evento -->
                        <section class="form-section">
                            <h2>5. Tipo de Evento</h2>
                            <label for="tema-festa">Selecione o tipo de evento:</label>
                            <select id="tema-festa" name="tema" required>
                                <option value="">Escolha um evento...</option>
                                <option value="casamento">💍 Casamento</option>
                                <option value="aniversario">🎂 Aniversário</option>
                                <option value="batizado">👶 Batizado</option>
                                <option value="outro">✨ Outra Ocasião</option>
                            </select>
                        </section>

                        <!-- Decoração Casamento -->
                        <section class="form-section conditional" id="decoracao-casamento" style="display: none;">
                            <h3>Decoração - Casamento</h3>
                            <select id="decoracao-select-casamento" name="decoracao-casamento">
                                <option value="">Escolha o estilo...</option>
                                <option value="classico">👑 Clássico Elegante</option>
                                <option value="moderno">✨ Moderno Minimalista</option>
                                <option value="romantico">💕 Romântico Floral</option>
                                <option value="vintage">🎭 Vintage</option>
                            </select>
                        </section>

                        <!-- Decoração Aniversário -->
                        <section class="form-section conditional" id="decoracao-aniversario" style="display: none;">
                            <h3>Decoração - Aniversário</h3>
                            <select id="decoracao-select-aniversario" name="decoracao-aniversario">
                                <option value="">Escolha o estilo...</option>
                                <option value="colorido">🎉 Colorido Divertido</option>
                                <option value="tematico">🦄 Temático Infantil</option>
                                <option value="elegante">💎 Elegante</option>
                                <option value="personalizado">🎨 Personalizado</option>
                            </select>
                            <div class="idade-box">
                                <label for="idade">Idade do aniversariante:</label>
                                <input type="number" id="idade" name="idade" min="1" max="150" placeholder="Ex: 25">
                            </div>
                        </section>

                        <!-- Decoração Batizado -->
                        <section class="form-section conditional" id="decoracao-batizado" style="display: none;">
                            <h3>Decoração - Batizado</h3>
                            <select id="decoracao-select-batizado" name="decoracao-batizado">
                                <option value="">Escolha o estilo...</option>
                                <option value="suave_feminino">💗 Suave Feminino (Rosa)</option>
                                <option value="suave_masculino">💙 Suave Masculino (Azul)</option>
                                <option value="neutro">💚 Neutro (Verde/Branco)</option>
                                <option value="elegante">👼 Elegante Clássico</option>
                            </select>
                        </section>

                        <!-- Outras Ocasiões -->
                        <section class="form-section conditional" id="outras-ocasioes" style="display: none;">
                            <label for="ocasiao">Descreva a ocasião:</label>
                            <input type="text" id="ocasiao" name="ocasiao" placeholder="Ex: Confraternização...">
                        </section>

                        <!-- Observações -->
                        <section class="form-section">
                            <h2>6. Observações Especiais</h2>
                            <label for="observacoes">Informações adicionais (alergias, preferências, etc.):</label>
                            <textarea id="observacoes" name="observacoes" rows="4" placeholder="Descreva detalhes importantes..."></textarea>
                        </section>

                        <!-- Notas Importantes -->
                        <div class="notas">
                            <h3>ℹ️ Informações Importantes</h3>
                            <ul>
                                <li>Recheio tipo <strong>buttercream</strong></li>
                                <li>Camadas conforme tamanho do bolo</li>
                                <li>Mínimo: <strong>3 camadas massa</strong> + <strong>2 recheio</strong></li>
                                <li>Prazo mínimo: <strong>7 dias</strong></li>
                            </ul>
                        </div>

                    </div>

                    <!-- ========== COLUNA DIREITA - IMAGEM + RESUMO ========== -->
                    <div class="coluna-direita">
                        
                        <!-- Upload de Imagem -->
                        <section class="form-section imagem-section">
                            <h2>7. Imagem de Referência</h2>
                            <div class="foto-info">
                                <p>🎨 Tem um bolo em mente? Envie uma foto!</p>
                                <p class="small-text">Formato PNG (máx. 5MB)</p>
                            </div>
                            
                            <input type="file" id="imagem" name="imagem" accept="image/png" required>
                            
                            <p class="erro" id="mensagemErro"></p>
                            <p class="sucesso" id="mensagemSucesso"></p>
                            
                            <!-- Preview da Imagem -->
                            <div class="preview" id="preview">
                                <div class="preview-header">
                                    <h4>✓ Pré-visualização</h4>
                                    <button type="button" class="btn-limpar-img" id="btn-limpar-img">🗑️ Limpar</button>
                                </div>
                                <img id="imagemPreview" src="" alt="Preview">
                                <div class="preview-info">
                                    <p>📧 <strong>Importante:</strong> A imagem será analisada pela nossa equipa.</p>
                                    <p>Enviaremos por <strong>email</strong> a confirmação se é possível reproduzir o design e o <strong>orçamento final</strong>.</p>
                                </div>
                            </div>
                        </section>

                        <!-- Resumo do Pedido -->
                        <section class="form-section resumo-section" id="resumo-pedido-box">
                            <h2>📋 Resumo do Pedido</h2>
                            
                            <div id="resumo-content">
                                <p class="resumo-vazio">Preencha os campos para ver o resumo...</p>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="button-group">
                                <button type="button" class="btn-secondary" id="btn-limpar-pedido">🗑️ Limpar Pedido</button>
                                <button type="submit" class="btn-primary">🛒 Adicionar ao Carrinho</button>
                            </div>

                            <p class="disclaimer">* Preço indicativo. O orçamento final será confirmado por email após análise do pedido.</p>
                        </section>

                    </div>

                </div>

            </form>
        </div>
    </div>

    <script src="../js/bolospersonalizados.js"></script>

<?php include '../includes/footer.php'; ?>
</body>
</html>