<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar Dados</title>
</head>
<body>
    <button id="exportBtn">Exportar Dados</button>

    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            this.textContent = 'Exportando...';  // Modifica o texto do botão
            this.disabled = true;  // Desabilita o botão enquanto o download está em andamento

            fetch('http://127.0.0.1:8000/api/export')  // Faz a requisição para a API de exportação
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Falha ao exportar dados');
                    }
                    return response.blob();  // Converte a resposta em um Blob (arquivo binário)
                })
                .then(blob => {
                    const link = document.createElement('a');  // Cria um link de download temporário
                    link.href = URL.createObjectURL(blob);  // Cria um URL para o Blob
                    link.download = 'dados.xlsx';  // Define o nome do arquivo a ser baixado
                    link.click();  // Simula o clique no link para iniciar o download

                    // Restaura o botão após o download
                    this.textContent = 'Exportar Dados';
                    this.disabled = false;
                })
                .catch(error => {
                    alert('Ocorreu um erro ao exportar os dados: ' + error.message);  // Exibe um erro se algo falhar
                    this.textContent = 'Exportar Dados';
                    this.disabled = false;
                });
        });
    </script>
</body>
</html>
