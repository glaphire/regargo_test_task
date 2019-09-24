@extends('ogrn.page_layout')
    @section('main-content')
    <form id="ogrn-validation-form">
        <label for="ogrn_number">ОГРН:</label>
        <input type="text" name="ogrn_number" value="" placeholder="Введите ОГРН">
        <span class="response-status"></span>
        <div class="error-messages"></div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input name="validate" id="validate" type="button" value="Проверить">
        <input name="search" id="search" type="button" value="Найти" disabled="true">
    </form>
    @endsection
    @section('bottom-scripts')
    <script type="text/javascript">
        $('#validate').on('click', function() {
            var ogrn_number = $("input[name=ogrn_number]").val();
            validateOgrn(ogrn_number);
        });

        $('#search').on('click', function() {
            var ogrn_number = $("input[name=ogrn_number]").val();
            window.location = '/ogrn/show-currency-form?ogrn_number=' + ogrn_number;
        });

        function validateOgrn(ogrn_number) {
            $.ajax({
                type: "POST",
                url: '/ogrn/validate',
                dataType: 'json',
                data: {'ogrn_number': ogrn_number},
                success: function()
                {
                    $('.response-status').html("&#10004; корректен").text();
                    $('#search').prop('disabled', false);
                    return true;
                },
                error: function (response) {
                    $('.response-status').html("&#10008; некорректен").text();
                    console.log((response.responseJSON.errors));
                    $.each(response.responseJSON.errors, function(key, messages) {
                        messagesJoined = messages.join("<br/>");
                        $('.error-messages').html(messagesJoined).text();

                    });
                    $('#search').prop('disabled', true);
                    return false;
                }
            });
        }
    </script>
@endsection