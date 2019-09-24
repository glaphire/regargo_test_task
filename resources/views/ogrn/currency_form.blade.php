@extends('ogrn.page_layout')
@section('css-styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('main-content')
    <form id="ogrn-currency-form">
        <input type="text" name="ogrn_number" value="{{ $ogrn_number }}" readonly>
        <input type="text" name="date" id="datepicker" placeholder="Выберите дату">
        <input type="text" name="usd_currency" placeholder="Доллар на сегодня" readonly>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </form>
@endsection
@section('bottom-scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $( function() {
            $("#datepicker").datepicker( {
                onSelect: function(date) {
                    var url = '/ogrn/get-currency-by-date?date=' + date + '&currency=usd';
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });
                },
                startDate: '01/01/2010',
                firstDay: 1
            });
        } );
    </script>
@endsection