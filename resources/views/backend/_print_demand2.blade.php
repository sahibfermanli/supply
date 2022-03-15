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
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .header-text h2 {
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
        <div class="pull-left"><h5>"ASG Business Aviation MMC -nin "GHC" filialı <br> (idarə), müəssisə"</h5></div>
        <div class="pull-right"><h5>M-11 N-li nümunəvi idarələrarası Forma</h5></div>
    </div>
</div>
<div class="col-md-12">
    <div class="header-text">
        <h2>TƏLƏBNAMƏ {{$demand->id}}</h2>

    </div>
</div>


<div class="container">

    <div class="col-md-12 col-xs-12">
        <div class="col-md-2 col-xs-2 ">
            <div class="baslıq-telebname">
                <ul>
                    <li style="font-size: 12px;">{{$current_date}}</li>
                    <li style="font-size: 12px;">{{$orders[0]->company}}</li>
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
            <th>Növü, markası, part №</th>
            <th>Miqdarı</th>
            <th>Qiyməti</th>
            <th>Məbləği</th>
            <th>Əlavə məlumat</th>
{{--            <th>Sifarişçi</th>--}}
        </tr>

        @foreach($orders as $order)
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
                <td>{{$order->id}}</td>
                <td>{{$order->Product}}</td>
                <td>{{$order->Brend}}, {{$order->Model}}, {{$order->PartSerialNo}}</td>
                <td>{{$order->pcs}} {{$order->Unit}}</td>
                <td>{{$order->cost}}</td>
                <td>{{$order->total_cost}}{{$order->currency}}</td>
                <td>{{$order->Translation_Brand}} {{$vehicle}}</td>
{{--                <td>{{substr($order->user_name, 0, 1)}}.{{$order->user_surname}}, ({{substr($order->chief_name, 0, 1)}}.{{$order->chief_surname}})</td>--}}
            </tr>
        @endforeach
    </table>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-xs-6 izinler">
            <div class="row">
                <div class="col-md-4 col-xs-4"><h5>Tərtib etdi</h5></div>
                <div class="col-md-4 col-xs-5 sexs"><h5>{{Auth::user()->name}} {{Auth::user()->surname}}</h5></div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4"><h5>Təslim alan</h5></div>
                <div class="col-md-4 col-xs-5 sexs"><h5>{{$orders[0]->delivered_name}} {{$orders[0]->delivered_surname}}</h5></div>
            </div>
        </div>
        <div class="col-md-6 col-xs-6 izinler">
            <div class="row">
                <div class="col-md-4 col-xs-4"><h5>Tələb etdi</h5></div>
                <div class="col-md-4 col-xs-5 sexs"><h5>{{$orders[0]->user_name}} {{$orders[0]->user_surname}}</h5></div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4"><h5>Təsdiq etdi</h5></div>
                <div class="col-md-4 col-xs-5 sexs"><h5>{{$orders[0]->chief_name}} {{$orders[0]->chief_surname}}</h5></div>
            </div>
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