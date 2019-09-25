@extends('ogrn.page_layout')
@section('css-styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('main-content')
    <form id="ogrn-currency-form">
        <span>Выберите дату для отображения курса доллара:</span>
        <label for="ogrn_number">ОГРН:</label>
        <input type="text" name="ogrn_number" value="{{ $ogrn_number }}" readonly>
        <label for="date">Дата курса валют:</label>
        <input type="text" name="date" id="datepicker" placeholder="Выберите дату">
        <label for="currency_code"></label>
        <select id="currency_codes">
            <option disabled>Выберите валюту</option>
            @foreach($currency_codes as $code)
            <option value="{{$code}}">{{$code}}</option>
            @endforeach
        </select>
        <label for="currency_value">Текущий курс:</label>
        <input type="text" name="currency_value" placeholder="Валюта на сегодня" readonly>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="error-messages"></div>
    </form>
@endsection
@section('bottom-scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $( function() {
            $("#datepicker").datepicker( {
                onSelect: function(date) {
                    var currency_code = $("#currency_codes option:selected").text();
                    var url = '/ogrn/get-currency-by-date?date=' + date + '&currency=' + currency_code;
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: 'json',
                        success: function(response) {
                            $("input[name=currency_value]").val(response.currency);
                        },
                        error: function (response) {
                            if(response.responseJSON.hasOwnProperty('errors')) {
                                $.each(response.responseJSON.errors, function(key, messages) {
                                    messagesJoined = messages.join("<br/>");
                                    $('.error-messages').html(messagesJoined).text();
                                });
                            } else {
                                $('.error-messages').html("Ошибка сервера").text();
                            }
                        }
                    });
                },
                startDate: '01/01/2010',
                dateFormat: 'dd/mm/yy',
                firstDay: 1
            });
        } );
    </script>
@endsection