<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tələbnamə</title>
    <link rel="stylesheet" href="/css/demand/bootstrap.css">

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .header-text h1 {
            text-align: center;
        }
        .header-text {
            margin-bottom: 30px;
            margin-top: 30px;
        }
        .baslıq-telebname ul li {
            list-style: none;
            padding: 6px 4px;
            border-bottom: 1px solid grey;
        }
        .table-telebname {
            margin: 30px 20px;
        }
        .baslıq-telebname ul {
            padding: 0;
        }
        .sexs {
            border-bottom: 1px solid;
        }
        .col-md-12.izinler {
            border: 1px dotted #dddddd;
            padding: 11px 0;
            margin-top: 17px;
            margin-bottom: 20px;
        }
        .col-md-12.forma {
            margin-top: 40px;
        }
        @media print {

        }
    </style>
</head>
<body>
<div class="container">
    <div class="col-md-12 forma">
        <div class="pull-left"><h4>"Silk Way Aviaşirkəti MMC -nin "GHC" filialı <br> (idarə), müəssisə"</h4></div>
        <div class="pull-right"><h4>M-11 N-li nümunəvi idarələrarası Forma</h4></div>
    </div>
</div>
<div class="col-md-12">
    <div class="header-text">
        <h1>TƏLƏBNAMƏ</h1>

    </div>
</div>


<div class="container">

    <div class="col-md-12 col-xs-12">
        <div class="col-md-2 col-xs-2 ">
            <div class="baslıq-telebname">
                <ul>
                    <li><b>{{$account->account_no}}</b></li>
                    <li>{{$current_date}}</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 col-xs-4 col-md-offset-4 col-xs-offset-5 ">
            <div class="baslıq-telebname">
                <table>
                    <tr>
                        <th>Məbləğ</th>
                        <th>Valyuta</th>
                    </tr>
                    @foreach($cost_arr as $key=>$value)
                        <tr>
                            <td>{{$value}}</td>
                            <td>{{$key}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

</div>

<div class="table-telebname">
    <table>
        <tr>
            <th>№</th>
            <th>Malın adı</th>
            <th>Növü, ölçüsü, markası</th>
            <th>Əlavə məlumat</th>
            <th>Sifariş səbəbi</th>
            <th>Miqdarı</th>
            <th>Qiyməti</th>
            <th>Məbləği</th>
            <th>Valyuta</th>
            <th>Sifarişçi</th>
            <th>Təsdiq etdi</th>
        </tr>

        @foreach($orders as $order)
            @if(!empty($order->Marka))
                @php($vehicle = ', ' . $order->Marka . ' - ' . $order->QN . ' - ' . $order->Tipi)
            @else
                @php($vehicle = '')
            @endif
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->Product}}</td>
                <td>{{$order->Brend}}, {{$order->Model}}</td>
                <td>{{$order->Translation_Brand}}</td>
                <td>{{$order->order_remark}}</td>
                <td>{{$order->pcs}} {{$order->Unit}}</td>
                <td>{{$order->cost}}</td>
                <td>{{$order->total_cost}}</td>
                <td>{{$order->currency}}</td>
                <td>{{$order->user_name}} {{$order->user_surname}}, {{$order->department}}{{$vehicle}} ({{$order->chief_name}} {{$order->chief_surname}})</td>
                <td>{{$order->director_name}} {{$order->director_surname}}</td>
            </tr>
        @endforeach
    </table>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 izinler">
            <div class="col-md-4 col-xs-4"><h4>Tərtib etdi</h4></div>
            <div class="col-md-4 col-xs-5 sexs"><h4>{{Auth::user()->name}} {{Auth::user()->surname}}</h4></div>
        </div>
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