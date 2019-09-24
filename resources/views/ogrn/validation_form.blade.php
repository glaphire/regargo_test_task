@extends('ogrn.page_layout')
    @section('main-content')
    <form id="ogrn-validation-form">
        <label for="ogrn_number">ОГРН:</label>
        <input type="text" name="ogrn_number" value="" placeholder="Введите ОГРН">
        <span class="response-status"></span>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input name="validate" id="validate" type="button" value="Проверить">
        <input name="search" id="search" type="button" value="Найти">
    </form>
    @endsection
    @section('bottom-scripts')
    <script type="text/javascript">
        $('#validate').on('click', function(e) {
            e.preventDefault();
            var ogrn_number = $("input[name=ogrn_number]").val();
            $.ajax({
                type: "POST",
                url: '/ogrn/validate',
                dataType: 'json',
                data: {'ogrn_number': ogrn_number},
                success: function()
                {
                    $('.response-status').html("&#10004; корректен").text();
                },
                error: function () {
                    $('.response-status').html("&#10008; некорректен").text();
                }
            });
        });

        $('#search').on('click', function(e) {
            var ogrn_number = $("input[name=ogrn_number]").val();
            window.location = '/ogrn/show-currency-form?ogrn_number=' + ogrn_number;
        });
    </script>
@endsection