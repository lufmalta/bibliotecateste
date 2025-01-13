Versão projeto: php 7.4.33 e laravel 8.83.29
Instalação do projeto:
- Primeiro deverá mudar o branch para o de desenvolvimento
$ git checkout develop
- Deverá instalar o projeto
$ composer install

- Fazer a copia do arquivo .env.example para um novo arquivo chamado .env
Colocar as credenciais do banco de dados mysql configurados na sua máquina, caso ainda não possua, instale o mysql e crie o usuário, exemplo criação usuário:
$ sudo mysql -u root -p
$ CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'senha_desejada';
$ GRANT ALL PRIVILEGES ON *.* TO 'usuario'@'localhost' WITH GRANT OPTION;
$ FLUSH PRIVILEGES;
$ EXIT;

- Subir aplicação:
$ php artisan serve
