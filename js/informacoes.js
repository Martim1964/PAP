function mostrarMais() {
    // Select all hidden info sections (info5, info6, etc)
    const infosExtras = document.querySelectorAll('.info5, .info6'); // add other classes as needed
    const botao = document.getElementById('btnVerMais');

    // Check the state of the first extra info
    const primeiraInfo = document.getElementById('info5');
    
    if (primeiraInfo.style.display === 'none') {
        // Show all extra info sections
        infosExtras.forEach(info => {
            info.style.display = 'block';
        });
        botao.textContent = 'Ver menos';
    } else {
        // Hide all extra info sections
        infosExtras.forEach(info => {
            info.style.display = 'none';
        });
        botao.textContent = 'Ver mais informações';
        
        // Smooth scroll to the top of the info section
        document.querySelector('.Info-section').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }
}