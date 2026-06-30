function mostrarEvento(titulo, descricao, local, horario){
document.getElementById("titulo").innerHTML=titulo;
document.getElementById("descricao").innerHTML="<b>Descrição:</b> "+descricao;
document.getElementById("local").innerHTML="<b>Local:</b> "+local;
document.getElementById("horario").innerHTML="<b>Horário:</b> "+horario;
}