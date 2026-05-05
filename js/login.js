// Alternar visibilidade da senha
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.querySelector('.btn-toggle-password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
        toggleBtn.setAttribute('aria-label', 'Ocultar palavra-passe');
        toggleBtn.setAttribute('aria-pressed', 'true');
    } else {
        passwordInput.type = 'password';
        toggleBtn.innerHTML = '<i class="bi bi-eye-fill"></i>';
        toggleBtn.setAttribute('aria-label', 'Mostrar palavra-passe');
        toggleBtn.setAttribute('aria-pressed', 'false');
    }
}

// Validação do formulário no cliente
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Por favor, introduza um email válido.');
        document.getElementById('email').focus();
        return false;
    }

    // Validar senha
    if (password.length < 8) {
        e.preventDefault();
        alert('A senha deve ter pelo menos 8 caracteres.');
        document.getElementById('password').focus();
        return false;
    }

    return true;
});

// Adicionar classe ao focar nos campos
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});
