<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuadrante de Reservas</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Cuadrante de Pistas - Cerro Muriano</h2>
    <p>Fecha de generación: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Pista</th>
                <th>Usuario (Reserva)</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $res)
            <tr>
                <td>{{ $res->court->name }}</td>
                <td>{{ $res->user->name }}</td>
                <td>{{ $res->start_time->format('d/m/Y H:i') }}</td>
                <td>{{ $res->end_time->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>