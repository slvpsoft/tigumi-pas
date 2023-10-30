$('#monthName').on('click',function(e){
    // Hide amount
    if(!$('.hiddenExp').length){
        $('.expenses').hide().after('<p class="hiddenExp h-auto">***</p>');
    }else{
        $('.hiddenExp').remove();
        $('.expenses').show();
    }
});
