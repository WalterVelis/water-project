<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador AguaH2O</title>
</head>
<body>
    <div style="width:100%; text-align: center;">
        <img style="width:130px;" src="{{ url("material/img/licons/agua-logo-1.png") }}" alt="agua-logo">
    </div>
    <br>
    <div style="background: #dde9f2; padding:20px;    max-width: 600px; margin: 0 auto;border-radius:4px;">
        <span>{{ $data->user->name }} requiere asignación de un técnico para realizar un levantamiento técnico del proyecto <b>{{ $data->page }}</b>. Presione el siguiente botón para ingresar al proyecto.</span>
        <br>
        <a  href="{{ url("assignment/$data->id/edit") }}"><button style="padding: 10px 20px; background: #32526f; color: white; display: block; border-radius: 4px; margin: 0 auto; margin-top: 25px;">Ingresar</button></a>
        <br>
        <br>
        <span style="width:100%;">Gracias,</span>
        <br>
        <span>Cotizador AguaH2O</span>
    </div>
</body>
</html>
