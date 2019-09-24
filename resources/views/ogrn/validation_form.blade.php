@extends('ogrn.page_layout')
    @section('main-content')
    <form id="ogrn-validation-form">
        <input type="text" name="ogrn_number" value="" placeholder="Введите ОГРН">
        <span class="response-status"></span>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="submit" value="Проверить">
        <input class="search" type="button" value="Найти">
    </form>
    @endsection
    @section('bottom-scripts')
    <script type="text/javascript">
        $('#ogrn-validation-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '/ogrn/validate',
                dataType: 'json',
                data: $(this).serialize(),
                success: function()
                {
                    $('.response-status').html("&#10004; корректен").text();
                },
                error: function () {
                    $('.response-status').html("&#10008; некорректен").text();
                }
            });
        });

        $('.search').on('click', function(e) {
            var ogrn_number = $("input[name=ogrn_number]").val();
            window.location = '/show-currency-form?ogrn_number=' + ogrn_number;
        });
    </script>
@endsection