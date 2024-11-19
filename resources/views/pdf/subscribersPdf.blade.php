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
    <h1>Relatório de Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Pagamento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
      
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>R$ 
                    {{ $item->customer ? $item->customer->subscription->value ?? '0' : '0' }}
                </td>
                <td>
                    {{ $item->customer ? $item->customer->subscription->status ?? '' : '' }}
                </td>
                <td>
                    {{ $item->customer ? $item->customer->subscription->due_date ?? '' : '' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
