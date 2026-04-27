let tamanhoTexto = 100; //tamanho inicial de texto


//Vou buscar o id de cada funcionalidade
const btnOuvir = document.getElementById("btn-ouvir"); 
const btnParar = document.getElementById("btn-parar");
const btnAumentar = document.getElementById("btn-aumentar");
const btnDiminuir = document.getElementById("btn-diminuir");
const btnDark = document.getElementById("btn-dark");

// Função responsável por atualizar o botão de modo escuro
function atualizarBotaoDark() { 
    
    // Verifica se o botão existe na página
    if (!btnDark) {
        return; // Se não existir, sai da função
    }

    // Verifica se o modo escuro está ativo 
    const modoEscuroAtivo = document.body.classList.contains("dark-mode");

    // Indica se o botão está ativo (true) ou não (false)
    btnDark.setAttribute("aria-pressed", modoEscuroAtivo ? "true" : "false");

    // Atualiza o ícone do botão
    btnDark.innerHTML = modoEscuroAtivo
        ? '<i class="bi bi-sun-fill" aria-hidden="true"></i>' 
        : '<i class="bi bi-moon-fill" aria-hidden="true"></i>';
}

// Quando a página carrega, verifica se o utilizador já tinha escolhido modo escuro
if (localStorage.getItem("darkMode") === "on") {
    document.body.classList.add("dark-mode");
}

// Atualiza o estado do botão ao carregar a página
atualizarBotaoDark();


//no caso do btnOuvir
if (btnOuvir) {
    btnOuvir.addEventListener("click", function () {
        const conteudo = document.querySelector("main"); //Leio o conteúdo das páginas que estão dentro do <main>
        if (!conteudo) { //caso nao exista o <main> numa pagina
            alert("Não foi encontrado conteúdo principal para ler.");
            return;
        }

        speechSynthesis.cancel(); //cancela função de leitura automatica

        const texto = conteudo.innerText;  //vejo todo o texto inserido no main
        const leitura = new SpeechSynthesisUtterance(texto); //leio todo o texto 

        leitura.lang = "pt-PT"; //meto em pt-PT
        leitura.rate = 1;

        speechSynthesis.speak(leitura); //Comeca a ler todo o texto que está inserido na função main de cada page
    });
}

if (btnParar) { //no button de Parar
    btnParar.addEventListener("click", function () {
        speechSynthesis.cancel(); //cancelo a leitura do audio
    });
}

if (btnAumentar) { //button de aumentar texto
    btnAumentar.addEventListener("click", function () {
        if (tamanhoTexto < 200) { //defino limite maximo de 200
            tamanhoTexto += 10; // a cada toque aumenta 10
            document.documentElement.style.fontSize = tamanhoTexto + "%"; //atualiza o tamanho da fonte
        }
    });
}

if (btnDiminuir) { //button de diminuir texto
    btnDiminuir.addEventListener("click", function () {
        if (tamanhoTexto > 100) { //limite minimo de 100
            tamanhoTexto -= 10; //retira 10 a cada toque
            document.documentElement.style.fontSize = tamanhoTexto + "%"; //atualiza o tamanho da fonte
        }
    });
}

// Verifica se o botão de modo escuro existe na página
if (btnDark) {
    // Adiciona um evento de clique ao botão
    btnDark.addEventListener("click", function () {

        // Alterna (liga/desliga) a classe "dark-mode" no body
        document.body.classList.toggle("dark-mode");

        // Verifica se o modo escuro está ativo após o clique
        if (document.body.classList.contains("dark-mode")) {
            // Guarda no localStorage que o modo escuro está ativo
            localStorage.setItem("darkMode", "on");
        } else {
            localStorage.setItem("darkMode", "off");
        }
        atualizarBotaoDark();
    });
}
