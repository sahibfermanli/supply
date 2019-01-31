<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        table {
            margin-top: 3%;
        }
    </style>

    <title>Print</title>
</head>
<body>
    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="column-title">#</th>
                <th class="column-title">Malın adı</th>
                <th class="column-title">Marka</th>
                <th class="column-title">Model</th>
                <th class="column-title">Miqdar</th>
                <th class="column-title">Ölçü vahidi</th>
                <th class="column-title">Qiymət</th>
                <th class="column-title">Ümumi qiymət</th>
                <th class="column-title">Şirkət</th>
            </tr>
            </thead>
            <tbody>
                @php($row = 0)
                @foreach($orders as $order)
                    @php($row++)
                    <tr>
                        <td scope="row">{{$row}}</td>
                        <td>{{$order->Product}}</td>
                        <td>{{$order->Brend}}</td>
                        <td>{{$order->Model}}</td>
                        <td>{{$order->pcs}}</td>
                        <td>{{$order->Unit}}</td>
                        <td>{{$order->cost}}</td>
                        <td>{{$order->total_cost}}</td>
                        <td>{{$order->company}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        window.print();
    });
</script>

</html>