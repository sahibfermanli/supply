<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GHC | Sellers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/seller.css"/>
</head>
<body class="form-v10">
<div class="page-content">
    <div class="form-v10-content">
        @if(isset($seller->id))
            <form class="form-detail" action="" method="post" id="myform">
                {{csrf_field()}}
                <div class="form-left">
                    @if(session('display') == 'block')
                        <div class="alert alert-{{session('class')}}" role="alert">
                            {{session('message')}}
                        </div>
                    @endif
                    <h2>Satıcı məlumatları</h2>
                    <div class="form-row">
                        <input type="text" name="seller_name" value="{{$seller->seller_name}}" placeholder="Satıcı adı" maxlength="255" required>
                    </div>
                    <div class="form-row">
                        <input type="text" name="seller_director" value="{{$seller->seller_director}}" placeholder="Direktor (soy ad, ad, ata adı)" maxlength="150" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="seller_voen" value="{{$seller->seller_voen}}" placeholder="Satıcı VÖEN" maxlength="100" required>
                        </div>
                        <div class="form-row form-row-2">
                            <input type="text" name="seller_account_no" value="{{$seller->seller_account_no}}" placeholder="Satıcı hesab nömrəsi" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="text" name="contract_no" value="{{$seller->contract_no}}" placeholder="Müqavilə nömrəsi" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1" style="margin-top: 6px;">
                            <input type="text" disabled placeholder="Müqavilə tarixi">
                        </div>
                        <div class="form-row form-row-2">
                            <input type="date" id="date" name="contract_date" required>
                        </div>
                    </div>
                </div>
                <div class="form-right">
                    <h2>Bank məlumatları</h2>
                    <div class="form-row">
                        <input type="text" name="bank_name" value="{{$seller->bank_name}}" placeholder="Bank adı" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="bank_voen" value="{{$seller->bank_voen}}" placeholder="Bank VÖEN" maxlength="100" required>
                        </div>
                        <div class="form-row form-row-2">
                            <input type="text" name="bank_code" value="{{$seller->bank_code}}" placeholder="Bank kodu" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="bank_swift" value="{{$seller->bank_swift}}" placeholder="Bank swift" maxlength="50" required>
                        </div>
                        <div class="form-row form-row-2">
                            <input type="text" name="bank_m_n" value="{{$seller->bank_m_n}}" placeholder="Bank M/N" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-row-last">
                        <input type="submit" class="register" value="Təsdiqlə">
                    </div>
                </div>
            </form>
        @else
            <form class="form-detail" action="" method="post" id="myform">
                {{csrf_field()}}
                <div class="form-left">
                    @if(session('display') == 'block')
                        <div class="alert alert-{{session('class')}}" role="alert">
                            {{session('message')}}
                        </div>
                    @endif
                    <h2>Satıcı məlumatları</h2>
                    <div class="form-row">
                        <input type="text" name="seller_name" placeholder="Satıcı adı" maxlength="255" required>
                    </div>
                    <div class="form-row">
                        <input type="text" name="seller_director" placeholder="Direktor (soy ad, ad, ata adı)" maxlength="150" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="seller_voen" placeholder="Satıcı VÖEN" maxlength="100" required>
                        </div>
                        <div class="form-row form-row-2">
                            <input type="text" name="seller_account_no" placeholder="Satıcı hesab nömrəsi" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="text" name="contract_no" placeholder="Müqavilə nömrəsi" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1" style="margin-top: 6px;">
                            <input type="text" disabled placeholder="Müqavilə tarixi">
                        </div>
                        <div class="form-row form-row-2">
                            <input type="date" id="date" name="contract_date" required>
                        </div>
                    </div>
                </div>
                <div class="form-right">
                    <h2>Bank məlumatları</h2>
                    <div class="form-row">
                        <input type="text" name="bank_name" placeholder="Bank adı" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="bank_voen" placeholder="Bank VÖEN" maxlength="100" required>
                        </div>
                        <div class="form-row form-row-2">
                            <input type="text" name="bank_code" placeholder="Bank kodu" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="bank_swift" placeholder="Bank swift" maxlength="50" required>
                        </div>
                        <div class="form-row form-row-2">
                            <input type="text" name="bank_m_n" placeholder="Bank M/N" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-row-last">
                        <input type="submit" class="register" value="Təsdiqlə">
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

@if(isset($seller->id))
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            @php($date = date('Y-m-d', strtotime($seller->contract_date)))
            var date = '{{$date}}';
            $('#date').val(date);
        });
    </script>
@endif

</body>
</html>