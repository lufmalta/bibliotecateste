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
- Caso não possua instalado o gulp na máquina, deverá instala-lo com o comando a seguir:
$ npm install --global gulp-cli@2.3.0 (a versão que estou utilizando é a 2.3.0)

- Fazer a copia do arquivo .env.example para um novo arquivo chamado .env
- Colocar as credenciais do banco de dados mysql configurados na sua máquina, caso ainda não possua, instale o mysql e crie o usuário, lembrar de criar também o banco de dados, exemplo criação usuário:
$ sudo mysql -u root -p
$ CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'senha_desejada';
$ GRANT ALL PRIVILEGES ON *.* TO 'usuario'@'localhost' WITH GRANT OPTION;
$ FLUSH PRIVILEGES;
$ EXIT;

- Criar a chave
$ php artisan key:generate

- Popular o banco com as migrations e os seeders.
$ php artisan migrate --seed

- Subir aplicação (dentro da pasta do projeto):
$ php artisan serve (em um terminal)
$ gulp watch (em um terminal)

- Acessar a página localhost:8000 e realizar o login com algum dos usuários que estão dentro do UserSeeder.php

- Ao acessar ira cair na página de login, realize o login com suas credenciais encontradas no UserSeeder.
- Acesse a página de livros no menu acima para criar livros.
- Na tela haverá um botão para novo livro no rodapé do card.
- Depois de criar o livro, será redirecionado para a tela de livros novamente, listando os livros cadastrados, com a opção
de editar/excluir e uma aba de pesquisa para caso deseje buscar algum livro.
- Acesse a página de emprestimos no menu acima para criar emprestimos.
- Na tela haverá um botão para novo emprestimo no rodapé do card.
- Ao acessar a tela de criação de empréstimo, haverá um campo para pesquisar usuários, que é realizado uma pesquisa em ajax
E também um campo para buscar livros, por enquanto, apenas é possível pesquisar usuários biblioteca, ate mesmo porque no teste
aparentou que somente usuários biblioteca poderiam realizar empréstimos. Existe também um seletor de data para selecionar a data de
devolução.
- Após criar o empréstimo, acessando a tela index de emprestimos, será possível acessar a info do empréstimo, nela terá acesso as informações do empréstimo, assim como o histórico de status, criei este histórico, para poderem acompanhar quando foi realizado o empréstimo, o atrasado(caso exista) e a devolução, pensando em futuros relatórios para a aplicação.
- Ainda na tela index de empréstimos, na lista de empréstimo, existe um botão(relogio) para marcar como atrasado o empréstimo, e também o botão(check) para marcar como devolvido e também o botão para remover um empréstimo, somente é permitido remover o empréstimo se o mesmo estiver ja sido devolvido.  
- Criei também uma tela para acessar "meus empréstimos", esta tela somente é acessada pelo usuário biblioteca, caso faça login com ele, ira acessar esta tela e visualizar os seus empréstimos realizados.
PS: Tanto na tela de livros, quanto na de usuários o número cadastro e número de registro não são inseridos pelo usuário e sim pelo backend, criei um gerador de códigos, ate mesmo porque
isso evita que tentem repetir o mesmo código quando for cadastrar algum livro, mas também poderia ter feito o campo para digitar, apenas pensei que seria mais ideal para facilidade
aos usuários atendentes/administradores.
Foi criado várias validações para não permitir por exemplo, emprestar um livro que ja esta emprestado, permitir remover um livro
que ainda não foi devolvido, entre várias outras validações de segurança. Também foi criado os grupos de usuário, e na model de Group.php
existe as permissões para cada grupo de usuário, para não permitir um usuário que não tem acesso a tela acessa-la. Também pensei em criar um command para ser chamado no kernel.php para quando chegar no tempo da devolução, caso o mesmo não tivesse sido devolvido, iria fazer ele ficar como atrasado, mas como foi solicitado para criar o botão de marcar, então descartei essa possibilidade.
- Caso fique alguma dúvida de como funciona ou não conseguir fazer funcionar algo, pode me contactar no meu email que estou te enviando.

