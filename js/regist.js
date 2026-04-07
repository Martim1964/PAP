// Alternar visibilidade da senha
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const btn = field.nextElementSibling;
    
    if (field.type === 'password') {
        field.type = 'text';
        btn.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } else {
        field.type = 'password';
        btn.innerHTML = '<i class="bi bi-eye-fill"></i>';
    }
}

// Validação do formulário no cliente
document.getElementById('registForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirm_password = document.getElementById('confirm_password').value;

    // Validar username
    if (username.length < 3) {
        e.preventDefault();
        alert('O nome de utilizador deve ter pelo menos 3 caracteres.');
        document.getElementById('username').focus();
        return false;
    }

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

    // Validar confirmação de senha
    if (password !== confirm_password) {
        e.preventDefault();
        alert('As senhas não correspondem.');
        document.getElementById('confirm_password').focus();
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