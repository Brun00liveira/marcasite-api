<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Relatório de Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>País</th>
                <th>CEP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->cpf }}</td>
                <td>{{ $item->birth_date }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->city }}</td>
                <td>{{ $item->state }}</td>
                <td>{{ $item->country }}</td>
                <td>{{ $item->cep }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
