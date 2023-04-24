$('document').ready(function (){
    $("input[type = 'submit']").on('click', function(e){
        e.preventDefault()
        console.log($(this).parent('.form').parent('form').serializeArray())
        // $.ajax({
            
        // })
    })
})