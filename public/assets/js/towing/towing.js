(function($){
    $(document).ready(function() {
        $('.table_list tr').click(function(){
            window.location.href = $(this).find('a').attr('href');
        });
        /*
        $('.dossierbar__id').click(function(){
            window.location.href = $(this).find('a').attr('href');
        });
        */

        $('.btn--dropdown').click(function(){
            $('.btn--dropdown--drop').hide('fast');
            $('.btn--dropdown--drop').removeClass('active');

            $(this).find('.btn--dropdown--drop').toggle();
            $(this).toggleClass('active');
        });


        //INIT DATETIMEPICKERS
        var times = [
            '06:00', '06:15', '06:30', '06:45',
            '07:00', '07:15', '07:30', '07:45',
            '08:00', '08:15', '08:30', '08:45',
            '09:00', '09:15', '09:30', '09:45',
            '10:00', '10:15', '10:30', '10:45',
            '11:00', '11:15', '11:30', '11:45',
            '12:00', '12:15', '12:30', '12:45',
            '13:00', '13:15', '13:30', '13:45',
            '14:00', '14:15', '14:30', '14:45',
            '15:00', '15:15', '15:30', '15:45',
            '16:00', '16:15', '16:30', '16:45',
            '17:00', '17:15', '17:30', '17:45',
            '18:00', '18:15', '18:30', '18:45',
            '19:00', '19:15', '19:30', '19:45',
            '20:00', '20:15', '20:30', '20:45',
            '21:00', '21:15', '21:30', '21:45',
        ];


        $('.datetimepicker').datetimepicker({
            format:'d/m/Y H:i',
            allowTimes: times,
            step: 15
        });

        $('.datepicker').datetimepicker({
            timepicker:false,
            format:'d/m/Y'
        });

        $('.timepicker').datetimepicker({
            datepicker:false,
            format:'H:i',
            allowTimes: times,
            step: 15
        });


    });
})(jQuery);