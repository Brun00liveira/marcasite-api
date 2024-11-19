<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px; /* Diminui o tamanho da fonte para todo o corpo */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px 8px; /* Reduz o padding para economizar espaço */
            text-align: left;
            font-size: 12px; /* Tamanho de fonte reduzido para a tabela */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Relatório de Cursos</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Qte. inscritos</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $item)

            <tr>
                <td>{{ $item->title }}</td>
               <td>{{ $item->category ? $item->category->name : 'Sem categoria' }}</td>

                <td>{{ $item->enrollments_count}}</td>
              
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
