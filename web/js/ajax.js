$('document').ready(function (){
    $("input[type = 'submit']").on('click', function(e){
        e.preventDefault()
        let url = '';
        if( $(this).parent('.form').parent('form')[0].id == 'login-form' ){
            url = '/site/login';
        } else if( $(this).parent('.form').parent('form')[0].id == 'reg-form' ){
            url = '/site/reg';
        }

        var $data
        $data = $(this).parent('.form').parent('form').serialize()
        $.ajax({
            url: url,
            type: 'post',
            data: $data,
        }).done(function () {
            window.location.href = '/site/index'
        })
    })

    $('#btn').on('click', function(){
        $.ajax({
            url: '/site/dataAll',
            type: 'post',
        }).done(function(data){
            $('.data').html(data)
        })
    })
    $('#btn-no').on('click', function(){
        $('.data').html('')
    })
})