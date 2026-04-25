<?php
// ============================================================
// FICHEIRO: pages/contactos.php
// O QUE FAZ: Página de contactos com FAQ e formulário.
// O utilizador TEM de estar logado para enviar mensagem.
// ============================================================

session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/contactos.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Contactos - Doces Dias</title>
</head>

<body>
    <?php include '../includes/header.php'; ?>
        <main>
        <div class="title">
            <h1>Os Nossos Contactos</h1>
        </div>

        <div class="contact-info">
            <div class="contact-item">
            <i class="fas fa-phone" style="font-size:64px;color:#0066cc"></i>
                <a href="tel:+351913047889">+351 913 047 889</a>
            </div>

            <div class="contact-item">
            <i class="fab fa-whatsapp" style="font-size:64px;color:#25D366"></i>
                <a href="https://wa.me/351913047889">WhatsApp</a>
            </div>

            <div class="contact-item">
            <i class="fab fa-instagram" style="font-size:64px;color:#E1306C"></i>
                <a href="https://www.instagram.com/docesdias.pt">@docesdias.pt</a>
            </div>

            <div class="contact-item">
            <i class="fab fa-facebook" style="font-size:64px;color:#1877F2"></i>
                <a href="https://www.facebook.com/docessdias">Doces Dias</a>
            </div>

            <div class="contact-item">
            <i class="fas fa-envelope" style="font-size:64px;color:#666666"></i>
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=docessdias1@gmail.com" target="_blank">
                    docessdias1@gmail.com
                </a>
            </div>
        </div>

        <div class="faq-container">
            <h2>Perguntas Frequentes (FAQ)</h2>

            <div class="faq-item">
            <button class="faq-question">Qual o prazo mínimo para encomendas?</button>
            <div class="faq-answer" style="max-height: 0; overflow: hidden;">
                <p>Pedimos que realize a sua encomenda com pelo menos 7 dias de antecedência, para preparar o seu bolo
                    com a maior qualidade possível.
                </p>
                </div>
            </div>

            <div class="faq-item">
            <button class="faq-question">Fazem entregas ao domicílio?</button>
            <div class="faq-answer" style="max-height: 0; overflow: hidden;">
                <p>Não, os bolos são entregues na Rua Cidade Vila Cabral, Olivais, Lisboa!</p>
                </div>
            </div>

            <div class="faq-item">
            <button class="faq-question">Os vossos bolos são vendidos ao quilo?</button>
            <div class="faq-answer" style="max-height: 0; overflow: hidden;">
                <p>Não, os bolos são vendidos com base no número de pessoas. <br>
                Isto acontece porque como os nossos bolos são personalizados ao pormenor, a densidade dos ingredientes e o peso
                das decorações variam muito conforme o bolo. <br>
                Assim ao vendermos por número de fatias/pessoas garantimos que nenhum convidado fica sem a sua dose. <br>
                Com isto o preço ficará justo tanto pelo sabor como pelo trabalho artístico dedicada a cada detalhe.
            </p>
                </div>
            </div>
        </div>

    <!-- FORMULÁRIO DE CONTACTO -->
        <?php if (isset($_SESSION['user'])): ?>
        <!-- Utilizador está logado — mostra o formulário -->
        <form class="container my-5 p-5 bg-light rounded-4 shadow" style="max-width: 800px;"
              method="POST" action="../actions/processa_contacto.php">

                <h3 class="text-primary mb-3">Precisa de Ajuda?</h3>
                <h4 class="mb-4 text-dark fw-normal">Contacte-nos!</h4>

            <!-- Mensagens de erro ou sucesso -->
                <?php if (isset($_SESSION['contacto_erro'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['contacto_erro']) ?>
                    </div>
                    <?php unset($_SESSION['contacto_erro']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['contacto_sucesso'])): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($_SESSION['contacto_sucesso']) ?>
                    </div>
                    <?php unset($_SESSION['contacto_sucesso']); ?>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">Nome e apelido</label>
                <!-- Pré-preenche o nome com o do utilizador logado -->
                <input type="text" class="form-control" id="nome" name="nome"
                       value="<?= htmlspecialchars($_SESSION['nome'] ?? '') ?>"readonly>
                       
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Endereço de email</label>
                <!-- Pré-preenche o email com o do utilizador logado -->
                <input type="email" class="form-control" id="email" name="email" 
                value="<?= htmlspecialchars($_SESSION['user'] ?? '') ?>"readonly>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label fw-semibold">Telefone</label>
                <input type="tel" class="form-control" id="telefone" name="telefone"
                       value="<?= htmlspecialchars($_SESSION['telemovel'] ?? '') ?>"readonly>
                </div>

                <div class="mb-3">
                    <label for="assunto" class="form-label fw-semibold">Assunto</label>
                <input type="text" class="form-control" id="assunto" name="assunto"
                       placeholder="Assunto da mensagem" required>
                </div>

                <div class="mb-3">
                    <label for="mensagem" class="form-label fw-semibold">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="5"
                          placeholder="Escreva a sua mensagem aqui..." required></textarea>
                </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold"
                    style="background: linear-gradient(135deg,#e91e63,#c2185b); border:none;">
                    Enviar Mensagem
                </button>
            </form>

        <?php else: ?>
        <!-- Utilizador NÃO está logado — mostra aviso -->
            <div class="container my-5 p-5 bg-light rounded-4 shadow text-center" style="max-width: 800px;">
                <h3 class="text-primary mb-3">Precisa de Ajuda?</h3>
                <p class="mb-4">Para nos enviar uma mensagem, precisa de ter sessão iniciada.</p>
            <a href="login.php?redirect=contactos.php" class="btn btn-primary fw-bold"
               style="background: linear-gradient(135deg,#e91e63,#c2185b); border:none;">
                    Fazer Login para Contactar
                </a>
                <p class="mt-3">
                    Não tem conta? <a href="regist.php">Registe-se aqui</a>
                </p>
            </div>
        <?php endif; ?>

    </main>

    <script src="../js/contactos.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>