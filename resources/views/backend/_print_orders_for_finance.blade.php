<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .container {
            margin-top: 3%;
        }

        .details {
            display: block;
        }

        table {
            margin-top: 10px;
        }

        .director {
            float: left;
        }

        .date {
            float: right;
        }
    </style>

    <title>Print</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm">

            </div>
            <div class="col-sm">
                <center>
                    <strong>"Silk Way Aviaşirkəti" MMC-nin</strong><br>
                    <strong>"GHC" filialının İcraçı Direktoru</strong><br>
                    <strong>cənab İlqar Ələkbərova</strong>
                </center>
            </div>
        </div>

        <br><br>
        <center><h4><strong>Raport</strong></h4></center>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="column-title">№</th>
                <th class="column-title">Malın adı</th>
                <th class="column-title">Marka, model</th>
                <th class="column-title">Say</th>
                <th class="column-title">Sifariş səbəbi</th>
                <th class="column-title">Sifarişçi</th>
                <th class="column-title">Təsdiq etdi</th>
                <th class="column-title">Rəhbərlik</th>
            </tr>
            </thead>
            <tbody>
                @php($row = 0)
                @foreach($orders as $order)
                    @php($row++)
                    @if(!empty($order->Marka))
                        @php($vehicle = ', ' . $order->Marka . ' - ' . $order->QN . ' - ' . $order->Tipi)
                    @else
                        @php($vehicle = '')
                    @endif
                    <tr>
                        <td>{{$row}}</td>
                        <td>{{$order->Product}}</td>
                        <td>{{$order->Brend}}, {{$order->Model}}</td>
                        <td>{{$order->pcs}} {{$order->Unit}}</td>
                        <td>{{$order->order_remark}}</td>
                        <td>{{$order->user_name}} {{$order->user_surname}}, {{$order->department}}{{$vehicle}}</td>
                        <td>{{$order->chief_name}} {{$order->chief_surname}}</td>
                        <td>Vüqar Zeynalov</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>
        <div>
            {{--<span class="director">Direktor,  __________________ {{$account->seller_director}}</span>--}}
            <span class="date">Tarix: {{$current_date}}</span>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        window.print();
    });
</script>

</html>