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
                    <strong>"ASG Business Aviation" MMC-nin</strong><br>
                    <strong>"GHC" filialının İcraçı Direktoru</strong><br>
                    <strong>cənab Fəxri Əhmədova</strong>
                </center>
            </div>
        </div>

        <br><br>
        <center><h4><strong>Raport</strong></h4></center>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="column-title">№</th>
                <th class="column-title">ID</th>
                <th class="column-title">Malın adı</th>
                <th class="column-title">Marka, model</th>
                <th class="column-title">Əlavə məlumat</th>
                <th class="column-title">Sifariş səbəbi</th>
                <th class="column-title">Say</th>
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
                        @php($vehicle = ', ')
                        @if(!empty($order->Marka) && $order->Marka != 'null')
                            @php($vehicle .= $order->Marka)
                        @endif
                        @if(!empty($order->QN) && $order->QN != 'null')
                            @php($vehicle .= ' - ' . $order->QN)
                        @endif
                        @if(!empty($order->Tipi) && $order->Tipi != 'null')
                            @php($vehicle .= ' - ' . $order->Tipi)
                        @endif
                    @else
                        @php($vehicle = '')
                    @endif
                    <tr>
                        <td>{{$row}}</td>
                        <td>{{$order->id}}</td>
                        <td>{{$order->Product}}</td>
                        <td>{{$order->Brend}}, {{$order->Model}}</td>
                        <td>{{$order->Translation_Brand}} {{$vehicle}}</td>
                        <td>{{$order->order_remark}}</td>
                        <td>{{$order->pcs}} {{$order->Unit}}</td>
                        <td>{{$order->user_name}} {{$order->user_surname}}, {{$order->department}}</td>
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