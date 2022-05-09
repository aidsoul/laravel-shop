jQuery(document).ready(function($) {
    /*
     * Общие настройки ajax-запросов, отправка на сервер csrf-токена
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*
     * Раскрытие и скрытие пунктов меню каталога в левой колонке
     */
    $('#catalog-sidebar > ul ul').hide();
    $('#catalog-sidebar .badge').on('click', function () {
        var $badge = $(this);
        var closed = $badge.siblings('ul') && !$badge.siblings('ul').is(':visible');

        if (closed) {
            $badge.siblings('ul').slideDown('normal', function () {
                $badge.children('i').removeClass('fa-plus').addClass('fa-minus');
            });
        } else {
            $badge.siblings('ul').slideUp('normal', function () {
                $badge.children('i').removeClass('fa-minus').addClass('fa-plus');
            });
        }
    });
    /*
     * Получение данных профиля пользователя при оформлении заказа
     */
    $('form#profiles button[type="submit"]').hide();
    // при выборе профиля отправляем ajax-запрос, чтобы получить данные
    $('form#profiles select').change(function () {
        // если выбран элемент «Выберите профиль»
        if ($(this).val() == 0) {
            // очищаем все поля формы оформления заказа
            $('#checkout').trigger('reset');
            return;
        }
        var data = new FormData($('form#profiles')[0]);
        $.ajax({
            url: '/basket/profile',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                if (data.profile === undefined) {
                    console.log('data undefined');
                }
                $('input[name="first_name"]').val(data.profile.first_name);
                $('input[name="last_name"]').val(data.profile.last_name);
                $('input[name="middle_name"]').val(data.profile.middle_name);
                $('input[name="email"]').val(data.profile.email);
                $('input[name="phone"]').val(data.profile.phone);
                $('input[name="address"]').val(data.profile.address);
                $('textarea[name="comment"]').val(data.profile.comment);
            },
            error: function (reject) {
                alert(reject.responseJSON.error);
            }
        });
    });
    /*
     * Добавление товара в корзину с помощью ajax-запроса без перезагрузки
     */
    $('form.add-to-basket').submit(function (e) {
        // отменяем отправку формы стандартным способом
        e.preventDefault();
        // получаем данные этой формы добавления в корзину
        var $form = $(this);
        var data = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'),
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'HTML',
            beforeSend: function () {
                var spinner = ' <span class="spinner-border spinner-border-sm"></span>';
                $form.find('button').append(spinner);
            },
            success: function(html) {
                $form.find('.spinner-border').remove();
                $('#top-basket').html(html);
            }
        });
    });
});



document.addEventListener("DOMContentLoaded",function(){
    let show = '[show-content]';
    let div = '[div-product]';

    let showProduct = document.querySelectorAll(show);
    let divProduct = document.querySelectorAll(div);


    for(i = 0; i < showProduct.length; i++){
        $(showProduct[i]).hide();  
    }

    let onShow = function(e){
        let item = e.target;
        test = item.querySelector(show); 
        $(test).stop().fadeIn(600);
    }

    let onHide = function(e){
        let item = e.target;
        test = item.querySelector(show);
        $(test).stop().fadeOut(550);

    }

    for(i = 0; i < divProduct.length; i++){
            let item = divProduct[i];      

            item.addEventListener("mouseenter", onShow);
            item.addEventListener("mouseleave", onHide);
        }
});



