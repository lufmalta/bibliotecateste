$(function() {

    $('.page.page-lending-book.create').each(function() {

        var $page = $(this);
        var $selectUsers = $page.find('.select-user');
        var $selectBooks = $page.find('.select-book');

        var url = window.Laravel.url;

        //Pesquisa de usuários no select2.
        $selectUsers.select2({
            language: 'pt-BR',
            ajax: {
                url: url+'/emprestimos/usuarios/obter',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    
                    $selectUsers.empty();

                    var users = [];
                    
                    data.forEach(data => {
                        users.push({id: data.id, text: (data.name+' | '+data.email) });
                    });

                    return {
                        results: users
                    };

                }

            },
            minimumInputLength: 2,
            maximumSelectionLength: 10,
            placeholder: {
                id: '',
                text: 'Pesquise os usuários'
            }
        });

        //Pesquisa de livros no select2.
        $selectBooks.select2({
            language: 'pt-BR',
            ajax: {
                url: url+'/emprestimos/livros/obter',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    
                    $selectBooks.empty();

                    var books = [];
                    
                    data.forEach(data => {
                        books.push({id: data.id, text: (data.name+' | '+data.author+' | '+data.nr_serial) });
                    });

                    return {
                        results: books
                    };

                }

            },
            minimumInputLength: 2,
            maximumSelectionLength: 10,
            placeholder: {
                id: '',
                text: 'Pesquise os livros'
            }
        });

    });

    $('.page.page-lending-book.index').each(function() {

        var $page = $(this);
        var $btnDelayed = $page.find('.btn-delayed');
        var $btnReturn = $page.find('.btn-return');

        $btnDelayed.on('click', function() {
            console.log('clicou no atrasado');
            sendAjax($(this));
        });

        $btnReturn.on('click', function() {
            console.log('clicou no devolvido');
            sendAjax($(this));
        });

        //Envia o ajax para marcar como atrasado ou devolvido.
        function sendAjax($btn) {

            var url = $btn.attr('data-url');
            var id = $btn.attr('data-id');
            var message = $btn.attr('data-message');

            if (url && id && message) {

                $dialog.confirm(message, function() {
    
                    var $form = $(`<form action="${url}" method="POST">
                                    <input type="hidden" name="id" value="${id}"/>
                                    <input type="_token" name="_token" value="${window.Laravel.token}"/>
                                   </form>`);

                    $('body').append($form);

                    $form.trigger('submit');
    
                });

            }

        }

    });

});