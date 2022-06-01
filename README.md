# Sistema de Tarefas
Sistema básico de gerenciamento de tarefas utilizando Vue , Quasar, Laravel.

# Instruções

Foi utilizado como ambiente de desenvolvimento do sistema o Laragon, na versão: 
Full 5.0.0 210553

Caso não esteja usando Windows e/ou deseje utilizar outro ambiente para rodar o projeto atente-se às versões:

- Apache 2.4.47
- MySQL 5.7.33
- Node v14
- PHP 7.4.19

Clone o projeto no git em sua pasta www (servidor apache):

> $ git clone https://github.com/brunocsouzasantos/sistema-de-tarefas.git

## Comandos de terminal
Na raiz do projeto rode os comandos: 
> $ npm install

Entre na pasta /Backend8 e digite os comandos:

> $ composer install

Gere o arquivo .env

> $ cp .env.example .env<br>
> $ php artisan key:generate<br>
> $ php artisan jwt:secret<br>

Adicione as configurações no seu .env:

- Bando de Dados:

>DB_CONNECTION=mysql<br>
>DB_HOST=127.0.0.1<br>
>DB_PORT=3306<br>
>DB_DATABASE=sistema-de-tarefas<br>
>DB_USERNAME=root<br>
>DB_PASSWORD=(Use sua senha de banco, caso tenha)

OBS: Crie um novo banco “sistema-de-tarefas” no seu SGBD.

- Conta SMTP (Recomendo usar o MailTrap para testes)

>MAIL_MAILER=smtp<br>
>MAIL_HOST=smtp.mailtrap.io<br>
>MAIL_PORT=2525<br>
>MAIL_USERNAME=Seu usuário no MailTrap<br>
>MAIL_PASSWORD=Sua senha no MailTrap<br>
>MAIL_ENCRYPTION=tls<br>

Atualize as configurações:

> $ php artisan config:clear<br>
> $ php artisan cache:clear<br>
> $ composer dumpautoload<br>


Ainda no terminal, na pasta /Backend8, rode as migrations para criação das tabelas no banco anteriormente criado.

> $ php artisan migrate

Crie o primeiro usuário de acesso ao sistema via Seeder:

> $ php artisan db:seed

A Seeder irar criar um usuário administrativo com as seguintes informações de acesso:

>Email: admin@admin.com <br>
>Senha: asdfg123

OBS: Nesse ponto, caso você tenha pulado a configuração de SMTP o comando acima irar gerar um erro. Siga todos os passos.

Para iniciar o projeto, via terminal, entre na pasta raiz (sistema-de-tarefas) e digite o comando:

> $ quasar d

Os sistema irá abrir em seu browser na url http://localhost:8080
