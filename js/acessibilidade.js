let tamanhoTexto = 100; //tamanho inicial de texto


//Vou buscar o id de cada funcionalidade
const btnOuvir = document.getElementById("btn-ouvir"); 
const btnParar = document.getElementById("btn-parar");
const btnAumentar = document.getElementById("btn-aumentar");
const btnDiminuir = document.getElementById("btn-diminuir");

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
            document.body.style.fontSize = tamanhoTexto + "%"; //atualiza o tamanho da fonte 
        }
    });
}

if (btnDiminuir) { //button de diminuir texto
    btnDiminuir.addEventListener("click", function () {
        if (tamanhoTexto > 100) { //limite minimo de 100
            tamanhoTexto -= 10; //retira 10 a cada toque
            document.body.style.fontSize = tamanhoTexto + "%"; //atualiza o tamanho da fonte
        }
    });
}