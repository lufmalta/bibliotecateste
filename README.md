Versão projeto: 
php 7.4.33 
laravel 8.83.29
node 18
Instalação do projeto:
- Primeiro deverá mudar o branch para o de desenvolvimento
$ git checkout develop
- Deverá instalar o projeto
$ composer install
$ npm install (antes deverá remover package-lock.json)

- Fazer a copia do arquivo .env.example para um novo arquivo chamado .env
- Colocar as credenciais do banco de dados mysql configurados na sua máquina, caso ainda não possua, instale o mysql e crie o usuário, exemplo criação usuário:
$ sudo mysql -u root -p
$ CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'senha_desejada';
$ GRANT ALL PRIVILEGES ON *.* TO 'usuario'@'localhost' WITH GRANT OPTION;
$ FLUSH PRIVILEGES;
$ EXIT;

- Popular o banco com as migrations e os seeders.
$ php artisan migrate --seed

- Subir aplicação (dentro da pasta do projeto):
$ php artisan serve (em um terminal)
$ gulp watch (em um terminal)

- Acessar a página localhost:8000 e realizar o login com algum dos usuários que estão dentro do UserSeeder.php
