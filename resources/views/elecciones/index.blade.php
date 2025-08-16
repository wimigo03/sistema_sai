<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Elecciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #007BFF;
            --secondary-color: #6c757d;
            --accent-color: #FFC107;
            --background-color: #f8f9fa;
            --card-background: #ffffff;
            --text-color: #343a40;
            --light-text-color: #6c757d;
            --border-color: #ddd;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            gap: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            color: var(--primary-color);
            font-weight: 600;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .filters {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filters select {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        .filters button {
            padding: 0.75rem 2rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .data-table th, .data-table td {
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .data-table tr:hover {
            background-color: #f1f1f1;
        }

        .data-table td.sigla {
            text-align: center;
            font-weight: 600;
        }

        .data-table td.votos {
            text-align: right;
            font-weight: 600;
        }

        .data-table td.porcentaje {
            text-align: right;
            font-weight: 600;
        }

        .data-table tfoot {
            font-weight: 600;
            background-color: var(--secondary-color);
            color: white;
        }

        .chart-container {
            position: relative;
            height: 400px;
        }
    </style>
</head>
<body>

<div class="container">
    <header class="header">
        <h1>Resultados Elecciones Presidenciales 2025</h1>
    </header>

    <div class="filters">
        <form action="{{ route('elecciones.index') }}" method="GET">
            <select name="tipo" onchange="this.form.submit()">
                @foreach ($tiposGobernantes as $key => $value)
                    <option value="{{ $key }}" {{ $tipoSeleccionado == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <select name="zona" onchange="this.form.submit()">
                @foreach ($zonas as $key => $value)
                    <option value="{{ $key }}" {{ $zonaSeleccionada == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <noscript>
                <button type="submit">Aplicar Filtros</button>
            </noscript>
        </form>
    </div>

    <div class="grid-container">
        <div class="card chart-card">
            <h2>Distribución de Votos por Partido</h2>
            <div class="chart-container">
                <canvas id="votosChart"></canvas>
            </div>
        </div>

        <div class="card table-card">
            <h2>Detalle de Votos</h2>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Sigla</th>
                            <th>Total de Votos</th>
                            <th>Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($conteoVotaciones as $voto)
                        <tr>
                            <td class="sigla">{{ $voto->sigla }}</td>
                            <td class="votos">{{ number_format($voto->total_votos) }}</td>
                            @if ($totalVotosGeneral != 0)
                                <td class="porcentaje">{{ number_format(($voto->total_votos / $totalVotosGeneral) * 100, 2) }}%</td>
                            @else
                                <td class="porcentaje">0.00%</td>
                            @endif

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total General</td>
                            <td class="votos">{{ number_format($totalVotosGeneral) }}</td>
                            <td class="porcentaje">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conteoVotaciones = @json($conteoVotaciones);
        const totalVotosGeneral = {{ $totalVotosGeneral }};
        const labels = conteoVotaciones.map(voto => voto.sigla);
        const data = conteoVotaciones.map(voto => voto.total_votos);

        const backgroundColors = [
            '#007BFF', '#28a745', '#dc3545', '#fd7e14', '#6610f2',
            '#e83e8c', '#20c997', '#ffc107', '#17a2b8', '#6c757d',
            '#0056b3', '#1e7e34', '#c82333', '#c65300', '#5c00d6'
        ];

        const ctx = document.getElementById('votosChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Votos',
                    data: data,
                    backgroundColor: backgroundColors,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                                const value = context.parsed;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${context.label}: ${new Intl.NumberFormat('es-ES').format(value)} votos (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>
