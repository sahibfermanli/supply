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
                <div>
                    <h4><strong>Hesab faktura № {{$account->account_no}}</strong></h4>
                    <h5 class="details"><strong>Tarix:</strong> {{$current_date}}</h5>
                    <br>
                    <span class="details"><strong>Alıcı:</strong> ASG Business Aviation (GHC)</span>
                    <span class="details"><strong>Mal qəbul edən:</strong>ASG Business Aviation (GHC)</span>
                    <span class="details"><strong>Ödəniş və ödəmə sənədi №:</strong> </span>
                    <span class="details"><strong>Ünvan:</strong> </span>
                    <span class="details"><strong>VÖEN:</strong> 9900067141</span>
                    <span class="details"><strong>Valyuta:</strong> {{$orders[0]->currency}}</span>
                </div>
            </div>
            <div class="col-sm">
                <span class="details"><strong>Satıcı:</strong> {{$account->seller_name}}</span>
                <span class="details"><strong>VÖEN:</strong> {{$account->seller_voen}}</span>
                <span class="details"><strong>Hesab №:</strong> {{$account->seller_account_no}}</span>
                <span class="details"><strong>Bank:</strong> {{$account->bank_name}}</span>
                <span class="details"><strong>VÖEN:</strong> {{$account->bank_voen}}</span>
                <span class="details"><strong>KOD:</strong> {{$account->bank_code}}</span>
                <span class="details"><strong>M/Hesab №:</strong> {{$account->bank_m_n}}</span>
                <span class="details"><strong>SWİFT:</strong> {{$account->bank_swift}}</span>
                <br>
                <span class="details"><strong>Müqavilə №:</strong> {{$account->contract_no}}</span>
                @php($date = date('d M Y', strtotime($account->contract_date)))
                <span class="details"><strong>Müqavilə tarixi:</strong> {{$date}}</span>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="column-title">№</th>
                <th class="column-title">ID</th>
                <th class="column-title">Malın adı</th>
                <th class="column-title">Marka</th>
                <th class="column-title">Model</th>
                <th class="column-title">Miqdar</th>
                <th class="column-title">Ölçü vahidi</th>
                <th class="column-title">Qiymət</th>
                <th class="column-title">Ümumi qiymət</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><center><small>1</small></center></td>
                    <td><center><small>2</small></center></td>
                    <td><center><small>3</small></center></td>
                    <td><center><small>4</small></center></td>
                    <td><center><small>5</small></center></td>
                    <td><center><small>6</small></center></td>
                    <td><center><small>7</small></center></td>
                    <td><center><small>8</small></center></td>
                    <td><center><small>9</small></center></td>
                </tr>
                @php($total = 0)
                @php($row = 0)
                @foreach($orders as $order)
                    @php($row++)
                    @php($total += $order->total_cost)
                    <tr>
                        <td>{{$row}}</td>
                        <td>{{$order->id}}</td>
                        <td>{{$order->Product}}</td>
                        <td>{{$order->Brend}}</td>
                        <td>{{$order->Model}}</td>
                        <td>{{$order->pcs}}</td>
                        <td>{{$order->Unit}}</td>
                        <td>{{$order->cost}}</td>
                        <td>{{$order->total_cost}}</td>
                    </tr>
                @endforeach
                @php($edv = $total * 18 / 100)
                @php($total_with_edv = $total + $edv)
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$total}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$edv}}</td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Cəmi, {{$orders[0]->currency}}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$total_with_edv}}</td>
                </tr>
            </tbody>
        </table>

        <br>
        <div>
            <span class="director">Direktor,  __________________ {{$account->seller_director}}</span>
            {{--<span class="date">Tarix: {{$current_date}}</span>--}}
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