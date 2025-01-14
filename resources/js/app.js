require('./bootstrap');

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
