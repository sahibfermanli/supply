@extends('backend.app')
@section('content')
    <!-- page content -->
    <style>
        footer {
        display: none;
        }
    </style>
    <div class="right_col" role="main">
        <div class="layaut">
            <div class="sidebar">
                <div class="container">
                    <div class="tab-content">
                        <!-- Start of Discussions -->
                        <div class="tab-pane   active" id="conversations" role="tabpanel">
                            <div class="middle">
                                <h4>Mesajlar</h4>
                                <button type="button" class="btn round" onclick="create_new_chat();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         class="eva eva-edit-2">
                                        <g data-name="Layer 2">
                                            <g data-name="edit-2">
                                                <rect width="24" height="24" opacity="0"></rect>
                                                <path d="M19 20H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2z"></path>
                                                <path d="M5 18h.09l4.17-.38a2 2 0 0 0 1.21-.57l9-9a1.92 1.92 0 0 0-.07-2.71L16.66 2.6A2 2 0 0 0 14 2.53l-9 9a2 2 0 0 0-.57 1.21L4 16.91a1 1 0 0 0 .29.8A1 1 0 0 0 5 18zM15.27 4L18 6.73l-2 1.95L13.32 6z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                <hr>
                                <ul class="nav discussions" role="tablist">
                                    @foreach($messages as $message)
                                        @if($message->viewed != 1)
                                            @php($view = '#7fdfff')
                                        @else
                                            @php($view = '#bdbac2')
                                        @endif
                                        <li onclick="get_messages({{$message->order_id}}, {{$message->message_id}});">
                                            <a class="filter direct">
                                                <div class="content">
                                                    <div class="headline">
                                                        <h5 title="{{$message->Product}}">{{substr($message->Product, 0, 10)}}...
                                                            <small style="display: block;">Sifariş No: {{$message->order_id}}</small>
                                                        </h5>
                                                        <span style="color: {{$view}};">{{date('Y-m-d H:i', strtotime($message->message_date))}}</span>
                                                    </div>
                                                    <p title="{{$message->message}}">{{substr($message->message, 0, 40)}}...</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- End of Discussions -->
                    </div>
                </div>
            </div>
            <div class="chat">
                <div class="tab-content">
                    <!-- Start of Chat Room -->
                    <div class="tab-pane  show active" id="chat1" role="tabpanel">
                        <div class="item">
                            <div class="content">
                                <div class="container">
                                    <div class="top">
                                        <ul>
                                            <li>
                                                <button id="refresh_btn" type="button" class="btn" disabled title="Yenilə">
                                                    <i class="eva-hover">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24"
                                                             class="eva eva-video eva-animation eva-icon-hover-pulse">
                                                            <g data-name="Layer 2">
                                                                <g data-name="video">
                                                                    <rect width="24" height="24" opacity="0"></rect>

                                                                    <path fill="#333333"
                                                                          d="M12.319,5.792L8.836,2.328C8.589,2.08,8.269,2.295,8.269,2.573v1.534C8.115,4.091,7.937,4.084,7.783,4.084c-2.592,0-4.7,2.097-4.7,4.676c0,1.749,0.968,3.337,2.528,4.146c0.352,0.194,0.651-0.257,0.424-0.529c-0.415-0.492-0.643-1.118-0.643-1.762c0-1.514,1.261-2.747,2.787-2.747c0.029,0,0.06,0,0.09,0.002v1.632c0,0.335,0.378,0.435,0.568,0.245l3.483-3.464C12.455,6.147,12.455,5.928,12.319,5.792 M8.938,8.67V7.554c0-0.411-0.528-0.377-0.781-0.377c-1.906,0-3.457,1.542-3.457,3.438c0,0.271,0.033,0.542,0.097,0.805C4.149,10.7,3.775,9.762,3.775,8.76c0-2.197,1.798-3.985,4.008-3.985c0.251,0,0.501,0.023,0.744,0.069c0.212,0.039,0.412-0.124,0.412-0.34v-1.1l2.646,2.633L8.938,8.67z M14.389,7.107c-0.34-0.18-0.662,0.244-0.424,0.529c0.416,0.493,0.644,1.118,0.644,1.762c0,1.515-1.272,2.747-2.798,2.747c-0.029,0-0.061,0-0.089-0.002v-1.631c0-0.354-0.382-0.419-0.558-0.246l-3.482,3.465c-0.136,0.136-0.136,0.355,0,0.49l3.482,3.465c0.189,0.186,0.568,0.096,0.568-0.245v-1.533c0.153,0.016,0.331,0.022,0.484,0.022c2.592,0,4.7-2.098,4.7-4.677C16.917,9.506,15.948,7.917,14.389,7.107 M12.217,15.238c-0.251,0-0.501-0.022-0.743-0.069c-0.212-0.039-0.411,0.125-0.411,0.341v1.101l-2.646-2.634l2.646-2.633v1.116c0,0.174,0.126,0.318,0.295,0.343c0.158,0.024,0.318,0.034,0.486,0.034c1.905,0,3.456-1.542,3.456-3.438c0-0.271-0.032-0.541-0.097-0.804c0.648,0.719,1.022,1.659,1.022,2.66C16.226,13.451,14.428,15.238,12.217,15.238"></path>

                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="middle" id="scroll">
                                    <div class="container">
                                        <ul id="messages_list">

                                        </ul>
                                    </div>
                                    <div id="for_scroll"></div>
                                </div>
                                <div class="container">
                                    <div class="bottom">
                                        <small style="padding-left: 5px;">Avtomatik yenilənmə 10 dəqiqədən birdir.</small>
                                        <form action="" method="post">
                                            {{csrf_field()}}
                                            <div id="order_id_for_new_message"></div>
                                            <input type="hidden" name="type" value="add_message">
                                            <textarea disabled class="form-control chat-inputs" id="message_input" placeholder="Mesaj yaz..."
                                                      rows="1" name="message"></textarea>
                                            <button type="submit" class="btn prepend" disabled id="message_btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" class="eva eva-paper-plane">
                                                    <g data-name="Layer 2">
                                                        <g data-name="paper-plane">
                                                            <rect width="24" height="24" opacity="0"></rect>
                                                            <path d="M21 4a1.31 1.31 0 0 0-.06-.27v-.09a1 1 0 0 0-.2-.3 1 1 0 0 0-.29-.19h-.09a.86.86 0 0 0-.31-.15H20a1 1 0 0 0-.3 0l-18 6a1 1 0 0 0 0 1.9l8.53 2.84 2.84 8.53a1 1 0 0 0 1.9 0l6-18A1 1 0 0 0 21 4zm-4.7 2.29l-5.57 5.57L5.16 10zM14 18.84l-1.86-5.57 5.57-5.57z"></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Chat Room -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /page content -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/swipe.css">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        let user_id = {{Auth::id()}};
        let myTimer;
        let order = 0;

        function my_timer() {
            let i = 0;
            myTimer = setInterval(function() {
                i++;

                if (i % 600 === 0) {
                    if (order !== 0) {
                        get_messages(order);
                    }
                }
            }, 1000);
        }

        $(document).ready(function () {
            $('form').validate();
            $('form').ajaxForm({
                beforeSubmit:function () {
                    //loading
                    swal ({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Əməliyyat aparılır...</span>',
                        text: 'Əməliyyat aparılır, xaiş olunur gözləyin...',
                        showConfirmButton: false
                    });
                },
                success:function (response) {
                    swal(
                        response.title,
                        response.content,
                        response.case
                    );
                    if (response.case === 'success') {
                        if (response.type === 'new_message') {
                            swal.close();
                            let current_date = response.added_date;
                            let bubble = '<div class="bubble"><p>' + response.added_message + '</p></div>';
                            let date = '<span>' + current_date.substr(0, 16) + '</span>';
                            let message_div = '<div class="message">' + bubble + '</div>';
                            let content = '<div class="content">' + message_div + date + '</div>';
                            let new_message = '<li>' + content + '</li>';

                            $("#messages_list").append(new_message);
                            $("#message_input").val('');
                            $('#scroll').animate({scrollTop: $('#scroll')[0].scrollHeight}, "slow");

                            get_messages(response.order_id);
                        }
                    }
                }
            });
        });

        function get_messages(order_id, message_id) {
            swal ({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Gözləyin...</span>',
                text: 'Mesajlar hazırlanır...',
                showConfirmButton: false
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "Post",
                url: '',
                data: {
                    'order_id': order_id,
                    'message_id': message_id,
                    '_token': CSRF_TOKEN,
                    'type': 'show_messages'
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal.close();

                        order = order_id;
                        $("#order_id_for_new_message").html("<input type='hidden' name='order_id' value='" + order_id + "'>");

                        let messages = response.messages;
                        let i = 0;
                        let message = '';
                        let messages_html = '';
                        let li = '';
                        let content = '';
                        let message_div = '';
                        let bubble = '';
                        let author = '';
                        let date = '';
                        let author_class = '';
                        
                        for (i = 0; i < messages.length; i++) {
                            message = messages[i];

                            if (message['author'] === user_id) {
                                author_class = '';
                                author = '';
                            } else {
                                author_class = 'class="author"';
                                author = '<span>' + message['name'] + ' ' + message['surname'] + '</span>';
                            }

                            bubble = '<div class="bubble"><p>' + message['message'] + '</p></div>';
                            date = '<span>' + message['created_at'].substr(0, 16) + '</span>';
                            message_div = '<div class="message">' + author + bubble + '</div>';
                            content = '<div class="content">' + message_div + date + '</div>';
                            li = '<li ' + author_class + '>' + content + '</li>';

                            messages_html += li;
                        }

                        $("#messages_list").html(messages_html);
                        $("#message_input").prop("disabled", false);
                        $("#message_btn").prop("disabled", false);
                        $("#refresh_btn").prop("disabled", false).attr("onclick", "get_messages(" + order_id + ")");

                        $('#scroll').animate({scrollTop: $('#scroll')[0].scrollHeight}, "slow");

                        clearTimeout(myTimer);
                        my_timer();
                    }
                    else {
                        swal(
                            response.title,
                            response.content,
                            response.case
                        );
                    }
                }
            });
        }

        function create_new_chat() {
            swal({
                title: 'Sifariş No',
                input: 'number',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                cancelButtonText: 'Geri',
                confirmButtonText: 'Yarat',
                showLoaderOnConfirm: true,
                preConfirm: (order_id) => {
                    get_messages(order_id);
                }
            });
        }
    </script>
@endsection
