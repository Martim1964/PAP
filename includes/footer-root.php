<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="img-pap/logotipo-docesdias.jpg">
    <title>Footer - Doces Dias</title>
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

<div class="footer-wrapper">
    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h3>🍰 Mantenha-se atualizado</h3>
                <p>Subscreva a nossa newsletter e receba as últimas novidades e promoções!</p>
                
                <form class="form-newsletter">
                    <input type="email" placeholder="Seu endereço de email" required>
                    <button type="submit" class="btn-primario">Subscrever</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main footer with information -->
    <section class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Company logo -->
                <img src="img-pap/logotipo-docesdias.jpg" alt="Logotipo Doces Dias" class="footer-logo">
                
                <!-- Important links -->
                <div class="footer-links">
                    <button><a href="pages/politica.php">Política de Privacidade</a></button>
                    <button><a href="pages/termos.php">Termos e Condições</a></button>
                    <button><a href="pages/cookies.php">Cookies</a></button>
                    <button><a href="pages/contactos.php">Contacte-nos</a></button>
                </div>
                <!-- Copyright and Social Media -->
                <div class="footer-bottom">
                    
                    <p>&copy; 2026 Doces Dias. Todos os direitos reservados.</p>
                    
                    <div class="social-media">
                        <a href="https://wa.me/351913047889" target="_blank" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/docessdias" target="_blank" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/doces__dias" target="_blank" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Floating Buttons -->
<a href="https://wa.me/351913047889" target="_blank" id="whatsappBtn" class="whatsapp-float" style="display: none;"></a>
<button onclick="topFunction()" id="myBtn" title="Voltar ao topo" style="display: none;">↑</button>

<script>
    // Function to show/hide buttons on scroll
    window.addEventListener('scroll', function() {
        const mybutton = document.getElementById("myBtn");
        const whatsappBtn = document.getElementById("whatsappBtn");
        
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
            whatsappBtn.style.display = "flex";
        } else {
            mybutton.style.display = "none";
            whatsappBtn.style.display = "none";
        }
    });

    function topFunction() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
</body>
</html>