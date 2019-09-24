<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="orgn-validation-form">
        <input type="text" name="ogrn_number" value="" placeholder="Введите ОГРН">
        <span class="response-status"></span>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="submit" value="Проверить">
    </form>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#orgn-validation-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '/ogrn/validate',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response)
                {
                    $('.response-status').html("&#10004; корректен").text();
                },
                error: function (response) {
                    $('.response-status').html("&#10008; некорректен").text();
                }
            });
        });
    </script>
</body>
</html>