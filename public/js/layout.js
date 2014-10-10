//	The menu on the left
$(function() {
    $('nav#menu-search').mmenu({
        position: 'left',
        classes: 'mm-light',
        dragOpen: true,
        counters: true,
        searchfield: false,
        labels: {
            fixed: !$.mmenu.support.touch
        },
        header: {
            add: false,
            update: false,
            title: 'Search Box'
        }
    });
});


//  The menu on the top
$(function() {
    $('nav#menu-top').mmenu({
        position: 'top',
        classes: 'mm-dark',
        dragOpen: true,
        counters: true,
        searchfield: false,
        labels: {
            fixed: !$.mmenu.support.touch
        },
        header: {
            add: false,
            update: false,
            title: 'Search Box'
        }
    });
});








//	The menu on the right
$(function() {

    var $menu = $('nav#menu-right');

    $menu.mmenu({
        position: 'right',
        classes: 'mm-light',
        dragOpen: true,
        counters: true,
        searchfield: false,
        labels: {
            fixed: !$.mmenu.support.touch
        }
        
    });





    //	Click a menu-item
    var $confirm = $('#confirmation');
    $menu.find('li a').not('.mm-subopen').not('.mm-subclose').bind(
        'click.example',
        function(e)
        {
            e.preventDefault();
            $confirm.show().text('You clicked "' + $.trim($(this).text()) + '"');
            $('#menu-right').trigger('close');
        }
        );
});