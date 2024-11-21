## MarcaSite Curso
Cada processo que eu fiz foi feito em Branchs diferentes e quando finalizava eu mergei com a Main,para o caso queira ver algo especifico.</br>

## Link do video Fiz um video Rapido sem som só pra caso queira ver o funcionamento

Login com Usuário https://www.youtube.com/watch?v=a7BuVqGdX6M

Login com Admin https://www.youtube.com/watch?v=NYUKBFWkD60

A API do projeto Marcasite Cursos é um sistema de gerenciamento de inscrições para cursos, desenvolvido em Laravel 11. O objetivo deste projeto é criar uma plataforma que permite gerenciar inscrições de alunos, integrar pagamentos online e fornecer um painel administrativo para controle e gestão de inscritos.

## Visão Geral do Projeto

- Inscrição de Alunos: </br>
Informações dos alunos no momento da inscrição, com diferenciação de valores por curso.
- Integração com Gateway de Pagamento: </br>
 Implementação de um gateway de pagamento do Asaas com SandBox
- Área Administrativa: </br>
&nbsp; &nbsp; Listagem de Inscritos, </br>
&nbsp; &nbsp; Filtragem de dados e paginação, </br>
&nbsp; &nbsp; Edição e Exclusão de Registros, </br>
&nbsp; &nbsp; Exportação de Dados (Laravel Excel)</br>

- Segurança e Controle de Acesso:</br>
&nbsp; &nbsp; Spatie Laravel Permission </br>
&nbsp; &nbsp; Laravel Sanctum  </br></br>

## Tecnologias Utilizadas

- <strong>Framework:</strong> Laravel 11 </br>
- <strong>Linguagem:</strong> PHP 8.2 </br>
- <strong>Banco de Dados:</strong> MySQL </br>
- <strong>Pagamentos:</strong> Asaas </br>
- <strong>Relatórios:</strong> Maatwebsite Excel, Laravel DomPDF </br>
- <strong>Controle de Acesso:</strong>Spatie Laravel Permission</br>
- <strong>Autenticação:</strong> Laravel Sanctum </br></br>

## Instalação e Configuração

<strong><h3>1. Clone o repositório</h3></strong>

git clone https://github.com/seu-usuario/marcasite-cursos.git </br>
cd marcasite-cursos

<strong><h3>2. Instale as dependências:</h3></strong>

<strong>versão do PHP:</strong> PHP 8.2.12 (cli)<br/>
<strong>versão do npm:</strong>PHP 10.8.1<br/>
<strong>versão do node:</strong> v20.15.0<br/>
composer install </br>
se der erro na instalação , verifique o alerta , deve ser algo do php.ini (extension:zip, gd, mysql , etc)</br>
npm install

<strong><h3>3. Configure o arquivo .env</h3></strong>

Conexão com banco Mysql </br>
Ferramenta de teste de envio de e-mails (Se não tiver uma configurada eu mando os dados do meu STMP do Gmail, mas com Mailtrap é bem traquilo de configurar)</br>
As demais alterações fiz direto nos diretórios da Config como por exemplo: FILESYSTEM_DISK</br>

<strong><h3>4. Migrations e seeders </h3></strong>
php artisan migrate </br>
php artisan db:seed </br>

Após rodar o seed, um usuário administrador, cursos e categorias será criado! <br/>

<strong>Login:</strong> admin@marcacurso.com <br/>
<strong>Senha:</strong> SenhaForte123

<strong><h3>4. Asaas</h3></strong>

Para Utilizando os serviços do Asaas é necessario https, assim utilizei o ngrok. <br/>
<br/>

Variaveis do Env
<strong>ASAAS_ENV:</strong> sandbox <br/>
<strong>ASAAS_URL:</strong> https://sandbox.asaas.com/api/v3/













