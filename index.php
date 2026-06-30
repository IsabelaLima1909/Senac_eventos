<?php

include 'conexao.php';

// Mês e ano atuais ou recebidos pela URL

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : date("m");

$ano = isset($_GET['ano']) ? intval($_GET['ano']) : date("Y");

// Evita meses inválidos

if ($mes < 1) {

    $mes = 12;

    $ano--;

}

if ($mes > 12) {

    $mes = 1;

    $ano++;

}

// Primeiro dia do mês

$primeiroDia = mktime(0,0,0,$mes,1,$ano);

// Quantidade de dias

$diasNoMes = date("t",$primeiroDia);

// Dia da semana que começa

$diaSemana = date("w",$primeiroDia);

// Nome do mês

$meses = [

    1=>"Janeiro",

    "Fevereiro",

    "Março",

    "Abril",

    "Maio",

    "Junho",

    "Julho",

    "Agosto",

    "Setembro",

    "Outubro",

    "Novembro",

    "Dezembro"

];

$nomeMes = $meses[$mes];

// Buscar eventos do mês

$sql = "SELECT * FROM eventos

WHERE MONTH(data_evento)='$mes'

AND YEAR(data_evento)='$ano'

ORDER BY data_evento";

$resultado = mysqli_query($conexao,$sql);

$eventos = [];

while($evento = mysqli_fetch_assoc($resultado)){

    $dia = date("j",strtotime($evento['data_evento']));

    $eventos[$dia][] = $evento;

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Agenda de Eventos</title>
<link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.css">

</head>

<body>

 <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <img src="./img/logo_senac_default.png" alt="Logo Senac">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Senac Eventos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.html">Agenda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Curso</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Edição</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>








<div class="container">
<div class="topo">
<?php

$mesAnterior = $mes-1;

$anoAnterior = $ano;

if($mesAnterior==0){

    $mesAnterior=12;

    $anoAnterior--;

}

$mesProximo = $mes+1;

$anoProximo = $ano;

if($mesProximo==13){

    $mesProximo=1;

    $anoProximo++;

}

?>
<a class="seta" href="?mes=<?=$mesAnterior?>&ano=<?=$anoAnterior?>">

◀
</a>
<h1><?=$nomeMes?> <?=$ano?></h1>
<a class="seta" href="?mes=<?=$mesProximo?>&ano=<?=$anoProximo?>">

▶
</a>
</div>
<table>
<tr>
<th>Dom</th>
<th>Seg</th>
<th>Ter</th>
<th>Qua</th>
<th>Qui</th>
<th>Sex</th>
<th>Sáb</th>
</tr>
<tr>
<?php

for($i=0;$i<$diaSemana;$i++){

    echo "<td></td>";

}

$contador = $diaSemana;
 
for($dia = 1; $dia <= $diasNoMes; $dia++){

    if(isset($eventos[$dia])){

        $titulo = htmlspecialchars($eventos[$dia][0]['titulo'], ENT_QUOTES);

        $descricao = htmlspecialchars($eventos[$dia][0]['descricao'], ENT_QUOTES);

        $data = date("d/m/Y", strtotime($eventos[$dia][0]['data_evento']));

        $horario = substr($eventos[$dia][0]['horario'],0,5);

        $local = htmlspecialchars($eventos[$dia][0]['local'], ENT_QUOTES);

        echo "<td class='evento'

                onclick=\"mostrarEvento('$titulo','$descricao','$data','$horario','$local')\">
<div class='numero'>$dia</div>
<span class='bolinha'></span>
</td>";

    }else{

        echo "<td>
<div class='numero'>$dia</div>
</td>";

    }

    $contador++;

    if($contador == 7){

        echo "</tr><tr>";

        $contador = 0;

    }

}

while($contador != 0 && $contador < 7){

    echo "<td></td>";

    $contador++;

}

?>
</tr>
</table>
<div class="painel">
<h2>Detalhes do Evento</h2>
<div id="evento">
<p>Selecione um dia com evento.</p>
</div>
</div>
</div>
<script src="script.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>


</body>
</html>
 