//Quando acionar o botão de logout.
$('.btn-logout').on('click', function(e) {

    var url = window.Laravel.url;
    var token = window.Laravel.token;

    //Cria o formulário e submita para realizar o logout.
    var $form = $(`<form method="POST" action="${url+'/logout'}">
                       <input type="hidden" name="_token" value="${token}"/>
                       <input type="hidden" name="_method" value="POST"/>
                   </form>`);

    $('body').append($form);
    $form.trigger('submit');

});

//Remove um registro do sistema.
$('.btn-delete').on('click', function() {

    var modalDeleteOpened = false;

    if (!modalDeleteOpened) {

        modalDeleteOpened = true;

        var $body = $(this).closest('body');

        var id = $(this).attr('data-id');

        var url = $(this).attr('data-url');

        var question = $(this).attr('data-question') || 'Esta ação ira excluir o registro do sistema,  <b>ação irreversível</b>, deseja continuar?';

        var token = window.Laravel.token;

        if (id && url) {

            var $form = $(`<form class="d-none" action="${url}" method="POST">
                            <input name="_method" value="DELETE"/>
                            <input name="_token" value="${token}"/>
                            <input name="id" value="${id}"/>
                         </form>`);

            var dialog = $dialog.confirm(question, function() {
                $body.append($form);
                $form.trigger('submit');
            });

            dialog.on("hidden.bs.modal", function() {
                modalDeleteOpened = false;
            });

        }
    }

});

$('.onchange-submit').on('change', function() {
    $(this).closest('form').trigger('submit');
});

$('.select2-select').each(function() {
    $(this).select2();
});
