<?php
    require_once __DIR__ . '/../includes/carrinho.php';
    dd_carrinho_limpar();

    echo "Pode acompanhar a sua compra na página destinada a si!
    Qualquer dúvida disponha na página de contactos!"
?>
    <script>
        alert('Obrigado pela sua compra. Os dados serão enviados por email.');
        window.location.href = "../index.php";
    </script>
