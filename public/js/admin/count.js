function send(url,fun){
    $.ajax({
        type: 'GET',
        url: url,
        dataType:'json',
        cache: false,
        success: fun
    });
}

function comment(){
    send('/admin/comment/count',function(data){
        let coment = document.querySelector('span[count-comments]');
        if(data.count > 0){
            coment.innerHTML = '('+data.count+')';
        }else{
            coment.innerHTML = '';
        }
    })
}
function order(){
    send('/admin/order/count',function(data){
        let coment = document.querySelector('span[count-orders]');
        if(data.count > 0){
            coment.innerHTML = '('+data.count+')';
        }
    });
}
comment();
order();
setInterval( function(){
    comment()},1000*60);
setInterval( function(){order()},1000*60);
