@extends('backend.app')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%; !important;">
                    <h3 style="display: inline-block;"> Alımlar</h3>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="search-inputs-area" class="search-areas">
                                <input type="text" class="form-control search-input" id="product_search" placeholder="Malın adı" value="{{$search_arr['product']}}">
                                <input type="text" class="form-control search-input" id="brand_search" placeholder="Marka" value="{{$search_arr['brand']}}">
                                <input type="text" class="form-control search-input" id="model_search" placeholder="Model" value="{{$search_arr['model']}}">
                                <select class="form-control search-input" id="department_search">
                                    <option value="">Departament</option>
                                    @foreach($departments as $department)
                                        @if($department->id == $search_arr['department'])
                                            <option selected value="{{$department->id}}">{{$department->Department}}</option>
                                        @else
                                            <option value="{{$department->id}}">{{$department->Department}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select class="form-control search-input" id="vehicle_search">
                                    <option value="">Texnika</option>
                                    @foreach($vehicles as $vehicle)
                                        @if($vehicle->id == $search_arr['vehicle'])
                                            <option selected value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}}
                                                - {{$vehicle->Tipi}}</option>
                                        @else
                                            <option value="{{$vehicle->id}}">{{$vehicle->QN}} - {{$vehicle->Marka}}
                                                - {{$vehicle->Tipi}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select class="form-control search-input" id="status_search">
                                    <option value="">Status</option>
                                    @foreach($statuses as $status)
                                        @if($status->id == $search_arr['status'])
                                            <option selected value="{{$status->id}}">{{$status->status}}</option>
                                        @else
                                            <option value="{{$status->id}}">{{$status->status}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select class="form-control search-input" id="seller_search">
                                    <option value="">Satıcı</option>
                                    @foreach($sellers as $seller)
                                        @if($seller->id == $search_arr['seller'])
                                            <option selected value="{{$seller->id}}">{{$seller->seller}}</option>
                                        @else
                                            <option value="{{$seller->id}}">{{$seller->seller}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary" onclick="search_data();">Axtar</button>
                            </div>
                            <div id="search-type-area" class="search-areas">
                                <label for="cost_search">Qiymət aralığı</label>
                                <input type="checkbox" id="cost_search" placeholder="min" onclick="cost_area();">
                                <label for="date_search">Tarix aralığı</label>
                                <input type="checkbox" id="date_search" placeholder="max" onclick="date_area();">
                            </div>
                            <div id="search-cost-area" class="search-areas">
                                <input type="number" class="form-control search-input" placeholder="min" id="min_cost_search" value="{{$search_arr['min_cost']}}">
                                <input type="number" class="form-control search-input" placeholder="max" id="max_cost_search" value="{{$search_arr['max_cost']}}">
                            </div>
                            <div id="search-date-area" class="search-areas">
                                <label for="start_date">Hardan</label>
                                <input type="date" id="start_date_search" class="form-control search-input" value="{{$search_arr['start_date']}}">
                                <label for="end_date">Hara</label>
                                <input type="date" id="end_date_search" class="form-control search-input" value="{{$search_arr['end_date']}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="table-responsive">
                                <div>
                                    {!! $purchases->links(); !!}
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title" style="min-width: 200px;">Sifarişçi</th>
                                        <th class="column-title">Status</th>
                                        <th class="column-title" style="min-width: 100px;">Malın adı</th>
                                        <th class="column-title" style="min-width: 150px;">Marka</th>
                                        <th class="column-title" style="min-width: 100px;">Model</th>
                                        <th class="column-title">Miqdar</th>
                                        <th class="column-title">Ölçü vahidi</th>
                                        <th class="column-title">Qiymət</th>
                                        <th class="column-title">Ümumi qiymət</th>
                                        <th class="column-title">Yaradılma tarixi</th>
                                        <th class="column-title">Satıcı</th>
                                        <th class="column-title">Hesab</th>
                                        <th class="column-title">Qaime</th>
                                        <th class="column-title">Qiymətləndirən</th>
                                        <th class="column-title">Qiyməti təsdiq edən</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php
                                        $row = 1;
                                    @endphp
                                    @foreach($purchases as $purchase)
                                        <?php
                                        $date = date('d.m.Y', strtotime($purchase->created_at));
                                        //deadline
                                        $dead_line = $purchase->deadline;
                                        $difference = intval(abs(strtotime($current_date) - strtotime($dead_line)) / 86400);
                                        $color = 'white';

                                        foreach ($deadlines as $deadline) {
                                            if ($difference <= $deadline->deadline) {
                                                $color = $deadline->color;
                                                break;
                                            }
                                        }
                                        ?>
                                        <tr class="even pointer" id="row_{{$row}}">
                                            <td style="background-color: {{$color}};">{{$purchase->order_id}}</td>
                                            <td>{{$purchase->name}} {{$purchase->surname}}
                                                , {{$purchase->Department}}</td>
                                            <td><span onclick="show_status({{$purchase->order_id}}, '{{$purchase->Product}}');" style="background-color: {{$purchase->status_color}}; border-color: {{$purchase->status_color}};" class="btn btn-primary btn-xs">{{$purchase->status}}</span></td>
                                            <td>{{$purchase->Product}}</td>
                                            <td>{{$purchase->Brend}}</td>
                                            <td>{{$purchase->Model}}</td>
                                            <td>{{$purchase->pcs}}</td>
                                            <td>{{$purchase->Unit}}</td>
                                            <td>{{$purchase->cost}}</td>
                                            <td>{{$purchase->total_cost}}</td>
                                            <td>{{$date}}</td>
                                            <td>{{$purchase->seller_name}}</td>
                                            <td>
                                                @if(isset($purchase->account_id))
                                                    @if(Auth::user()->authority() == 6)
                                                        <a title="{{$purchase->account_date}}"
                                                           class="btn btn-success btn-xs"
                                                           title="{{$purchase->account_date}}" target="_blank"
                                                           href="/law/accounts/print?a={{$purchase->account_id}}"><i
                                                                    class="fa fa-file-pdf-o"></i> {{$purchase->account_no}}
                                                        </a>
                                                    @elseif(Auth::user()->authority() == 7)
                                                        <a title="{{$purchase->account_date}}"
                                                           class="btn btn-success btn-xs"
                                                           title="{{$purchase->account_date}}" target="_blank"
                                                           href="/finance/accounts/print?a={{$purchase->account_id}}"><i
                                                                    class="fa fa-file-pdf-o"></i> {{$purchase->account_no}}
                                                        </a>
                                                    @elseif(Auth::user()->authority() == 5)
                                                        <a title="{{$purchase->account_date}}"
                                                           class="btn btn-success btn-xs"
                                                           title="{{$purchase->account_date}}" target="_blank"
                                                           href="/director/accounts/print?a={{$purchase->account_id}}"><i
                                                                    class="fa fa-file-pdf-o"></i> {{$purchase->account_no}}
                                                        </a>
                                                    @endif
                                                @else
                                                    <span title="Heç bir hesaba əlavə edilməyib" disabled="true"
                                                          class="btn btn-success btn-xs"
                                                          style="background-color: #b6a338; border-color: #b6a338;"><i
                                                                class="fa fa-file-pdf-o"></i></span>
                                                @endif
                                            </td>
                                            <td style="min-width: 150px;">
                                                @if(isset($purchase->qaime_doc))
                                                    <a href="{{$purchase->qaime_doc}}" title="{{$purchase->qaime_date}}"
                                                       class="btn btn-success btn-xs"
                                                       style="background-color: #1b6d85; border-color: #1b6d85;"><i
                                                                class="fa fa-download"></i> {{$purchase->qaime_no}}</a>
                                                @else
                                                    <span title="Qaiməni yoxdur" disabled="true"
                                                          class="btn btn-success btn-xs"
                                                          style="background-color: #b6a338; border-color: #b6a338;"><i
                                                                class="fa fa-download"></i></span>
                                                @endif
                                            </td>
                                            <td title="{{$purchase->supply_date}}">{{$purchase->supply_name}} {{$purchase->supply_surname}}</td>
                                            <td title="{{$purchase->lawyer_date}}">{{$purchase->lawyer_name}} {{$purchase->lawyer_surname}}</td>
                                        </tr>
                                        @php
                                            $row++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {!! $purchases->links(); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--status modal--}}
    <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="status_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">Status</th>
                            <th class="column-title">Tarix</th>
                        </tr>
                        </thead>
                        <tbody id="status_table">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        var show_cost_area = false;
        var show_date_area = false;

        $(document).ready(function(){
            var url = window.location.href;
            var url_arr = url.split('product');
            var where_url = 'product' + url_arr[1];

            if (url_arr.length > 1) {
                $('.pagination').each(function(){
                    $(this).find('a').each(function(){
                        var current = $(this);
                        var old_url = current.attr('href');
                        var new_url = old_url + '&' + where_url;
                        current.prop('href', new_url);
                    });
                });
            }
        });

        function cost_area() {
            if (show_cost_area) {
                show_cost_area = false;
                $('#search-cost-area').css('display', 'none');
            } else {
                show_cost_area = true;
                $('#search-cost-area').css('display', 'block');
            }
        }

        function date_area() {
            if (show_date_area) {
                show_date_area = false;
                $('#search-date-area').css('display', 'none');
            } else {
                show_date_area = true;
                $('#search-date-area').css('display', 'block');
            }
        }

        function search_data() {
            var product = $('#product_search').val();
            var brand = $('#brand_search').val();
            var model = $('#model_search').val();
            var department = $('#department_search').val();
            var vehicle = $('#vehicle_search').val();
            var status = $('#status_search').val();
            var seller = $('#seller_search').val();
            var min_cost = $('#min_cost_search').val();
            var max_cost = $('#max_cost_search').val();
            var start_date = $('#start_date_search').val();
            var end_date = $('#end_date_search').val();

            var link = '?product=' + product + '&brand=' + brand + '&model=' + model + '&department=' + department + '&vehicle=' + vehicle + '&status=' + status + '&seller=' + seller + '&min_cost=' + min_cost + '&max_cost=' + max_cost + '&start_date=' + start_date + '&end_date=' + end_date;

            location.href = link;
        }

        //show status
        function show_status(order_id, order) {
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Əməliyyat aparılır...</span>',
                text: 'Əməliyyat aparılır, xaiş olunur gözləyin...',
                showConfirmButton: false
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'order_id': order_id,
                    '_token': CSRF_TOKEN,
                    'type': 'show_status'
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal.close();

                        var statuses = response.statuses;
                        var i = 0;
                        var status_arr = '';
                        var no = 0;
                        var status = '';
                        var color = '';
                        var date = '';
                        var tr = '';
                        var table = '';
                        for (i = 0; i < statuses.length; i++) {
                            status_arr = statuses[i];

                            no = i + 1;
                            status = status_arr['status'];
                            color = status_arr['status_color'];
                            date = status_arr['status_date'];

                            tr = '<tr><td>' + no + '</td><td style="color: ' + color + ';">' + status + '</td><td>' + date + '</td></tr>';
                            table = table + tr;
                        }

                        $('#status_title').html(order);
                        $('#status_table').html(table);
                        $('#status-modal').modal('show');
                    } else {
                        swal(
                            response.title,
                            response.content,
                            response.case
                        );
                    }
                }
            });
        }
    </script>
@endsection
