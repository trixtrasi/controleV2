# controleV2
  Segunda versão dos sistema de controle e gestão de visitas!

## Visão Geral
  Este projeto é uma aplicação web desenvolvida para manter controle e registro dos visistantes. O sistema possibilita cadastrar, excluír e editar as visitas e possuí um cadastro de tarefas diárias. Além de gestão completa de usuários.

## Funcionalidades Principais
A aplicacao conta com as seguintes funcionalidades:
1. visitantes
2. usuarios
3. tarefas
   
### Visitantes:
  - Cadastro de visitantes: Todos os usuários podem cadastrar novos visitantes no sistema, incluindo informações básicas como nome, RG, motivo da visita, foto, veículo, etc.
  - Encerrar visita: Quando um visitante é cadastrado, ele fica com status "1" enquanto estiver no local. Ao encerrar a visita, o status é alterado para "0".
  - Exclusão de visitantes: Usuários com privilégio de administrador podem "excluir" visitas já encerradas. As visitas permanecem no banco de dados, mas seu status é alterado para '-1'.
### Usuários:
  - Cadastro de usuários: Administradores `nível 5` podem adicionar novos usuários com informações básicas, como nome de usuário, login e senha. O nível padrão de novos usuários cadastrados é 1, usuário regular.
  - Edição de usuários: Administradores têm permissão para editar informações de outros usuários. Os usuários regulares podem alterar seus dados pessoais e senha.
  - Exclusão de usuários: Os usuários removidos inicialmente são desativados e podem ser expurgados posteriormente. Seus dados permanecem no banco de dados, mas seu status é alterado e seu login é cancelado.
#### Senha Padrão:
  - Senha padrão ao resetar: Ao resetar a senha de um usuário, a nova senha será automaticamente definida como `123456`.
#### Usuário Padrão:
  - Usuário administrador padrão: O sistema já possui um usuário administrador cadastrado. No primeiro login, utilize o login `4815162342` e a senha padrão `123456`.
### Tarefas:
  - Cadastro de tarefas: Na tela inicial, uma tabela exibe as tarefas para o dia. As tarefas podem ser criadas com um período de validade e permanecerão visíveis até o término desse período ou até serem excluídas por um usuário. As tarefas são visíveis para todos os usuários.
  - Exclusão de tarefas: Todos os usuários têm permissão para excluir tarefas. Assim como as outras funcionalidades, ao excluir uma tarefa, seu status é alterado para "0" e o registro permanece no banco de dados.

## Tecnologias Utilizadas
### Frontend:
  + Bootstrap 5.0.2: Framework de código aberto para desenvolvimento de interfaces web responsivas e estilização.
  + jQuery: Biblioteca JavaScript para simplificar a manipulação do HTML, eventos, animações e interações AJAX.
### Backend:
  + PHP: Linguagem de programação amplamente utilizada para o desenvolvimento de aplicações web do lado do servidor.
  + MySQL: Sistema de gerenciamento de banco de dados relacional de código aberto.
### Arquitetura:
  + One Page Application (SPA): O sistema é desenvolvido como uma página única, onde as funcionalidades são carregadas e 
atualizadas dinamicamente através de requisições AJAX, proporcionando uma experiência de navegação contínua e fluida 
para o usuário.

## Pré-requisitos
  + Servidor web com suporte a PHP (ex.: Apache, MariaDB)
  + MySQL instalado e configurado
  + Navegador atualizado (ex.: Chrome, Firefox)

## Instalação
  1. Clone ou baixe os arquivos do sistema para o diretório desejado em seu servidor web.
  2. Importe o arquivo `database/controleV2.sql` para o seu banco de dados MySQL. Este arquivo contém a estrutura do banco de dados necessária para o funcionamento do sistema.
  3. No arquivo `connect.php` na raiz do projeto, altere as variáveis de conexão para corresponder às configurações do seu   ambiente:
```PHP
$servername; // Endereço do servidor MySQL (geralmente "localhost")
$user; // Nome de usuário do MySQL (O padrão é `root`)
$password; // Senha do usuário do MySQL (O padrão é não ter senha)
$dbname; // Nome do banco de dados onde a estrutura foi importada (no caso, controleV2)
```
  4. Certifique-se de que o servidor web está configurado corretamente para executar arquivos PHP e tem acesso ao banco de dados MySQL.
  5. Se quiser o logo da sua empresa no topo da barra de navegação insira o arquivo tipo png dentro da pasta `public/img/png/` com o nome `logo.png`
## Uso
  1. Abra o navegador e acesse a URL do seu servidor onde o sistema está hospedado.
  2. Faça login com o usuário administrador padrão (login: `4815162342`, senha: `123456`).

## Sarabada
>Este sistema foi criado com o uso do chatgpt e muito café/monster.
  
