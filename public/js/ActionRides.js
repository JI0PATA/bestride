function join(id) {
    $.ajax({
        url: '/profile/rides/join/' + id,
        type: 'get',
        success: _ => {
            let el = $('.rides__item[data-id='+id+']');
            el.addClass('hiddenRideItem');

            setTimeout(_ => {
                el.remove();
            }, 1000);
        }
    });
}

function unjoin(id) {
    $.ajax({
        url: '/profile/rides/unjoin/' + id,
        type: 'get',
        success: _ => {
            let el = $('.rides__item[data-id='+id+']');
            el.addClass('hiddenRideItem');

            setTimeout(_ => {
                el.remove();
            }, 1000);
        }
    });
}