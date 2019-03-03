<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <style>
        .form-gap {
            padding-top: 70px;
        }
    </style>

    <title>Şifrənin dəyişdirilməsi</title>
</head>
<body>
<div class="form-gap"></div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Şifrənin dəyişdirilməsi</h2>
                        <p>Hörmətli istifadəçi sistemə daxil olmaq üçün yeni şifrə təyin edin.</p>
                        <p>Yeni şifrənizi heç kəslə bölüşməməyinizi tövsiyyə edirik.</p>
                        @if(session('display') == 'block')
                            <div class="alert alert-{{session('class')}}" role="alert">
                                {{session('message')}}
                            </div>
                        @endif
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post"
                                  action="">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input disabled type="text" class="form-control" value="{{Auth::user()->name}}">
                                </div>
                                <div class="form-group">
                                    <input disabled type="text" class="form-control" value="{{Auth::user()->surname}}">
                                </div>
                                <div class="form-group">
                                    <input disabled type="text" class="form-control" value="{{Auth::user()->email}}">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Yeni şifrənizi daxil edin" oninput="confirmpassord()" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Yeni şifrəni təkrar daxil edin" oninput="confirmpassord()" required>
                                    <small id="confirm-message"></small>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-lg btn-primary btn-block" value="Təsdiqlə" type="submit">
                                </div>
                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    function confirmpassord() {
        var password = $('#password').val();
        var confirm_pasword = $('#confirm_password').val();

        if (password === confirm_pasword) {
            $('#confirm-message').html('Şifrələr eynidir').css('color', 'green');
        } else {
            $('#confirm-message').html('Şifrələr eyni deyil').css('color', 'red');
        }
    }
</script>

</body>
</html>