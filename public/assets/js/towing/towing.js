(function($){
    $(document).ready(function() {
        $('.table_list tr').click(function(){
            window.location.href = $(this).find('a').attr('href');
        });
        $('.dossierbar__id').click(function(){
            window.location.href = $(this).find('a').attr('href');
        });

        $('.btn--dropdown').click(function(){
            $(this).find('.btn--dropdown--drop').toggle();
            $(this).toggleClass('active');
        });
    });
})(jQuery);