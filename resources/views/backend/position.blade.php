<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Crud operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
 .post_list_ul {
            margin: 0px;
            padding: 5px;
        }

        .post_list_ul li {
            list-style: none;
            padding: 5px 10px 5px 30px;
            background: #fff;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.3);
            margin-bottom: 10px;
            cursor: move;
            position: relative;
            font-size: 16px;
        }


        .post_list_ul li .pos_num {
            display: inline-block;
            padding: 2px 5px;
            /* width: 30px; */
            height: 20px;
            line-height: 17px;
            background: rgb(6, 160, 65);
            color: #fff;
            text-align: center;
            border-radius: 5px;
            position: absolute;
            left: -5px;
            top: 6px;
        }

        .post_list_ul li:hover {
            list-style: none;
            background: #7a49eb;
            color: #fff;
        }

        .post_list_ul li.ui-state-highlight {
            padding: 20px;
            background-color: #eaecec;
            border: 1px dotted #ccc;
            cursor: move;
            margin-top: 12px;
        }

        .post_list_ul .btn_move {
            display: inline-block;
            cursor: move;
            background: #ededed;
            border-radius: 2px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
        }
        </style>
</head>

<body>
    <div class="container p-3">
        <div class="row">

            <div class="col-md-12">

                @if (session('message'))
                    <h3 style="color:green">{{ session('message') }}</h3>
                @endif
            </div>

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header with-border d-flex justify-content-between align-items-center">
                        Drag Drop To changes Post Order
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul id="post_sortable" class="post_list_ul">
                                            @foreach ($items as $item)
                                                <li class="ui-state-default" data-id="{{ $item->id }}">
                                                    <span class="pos_num">{{ $loop->index + 1 }}</span>
                                                    <span>{{ $item->name }}</span>
                                                    <span> position: {{ $item->order_by }}</span>
                                                </li>
                                            @endforeach
                                            </li>
                                        </ul>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {
            $("#post_sortable").sortable({
                placeholder: "ui-state-highlight",
                update: function(event, ui) {
                    //var data = $(this).sortable('toArray');

                    var post_order_ids = new Array();
                    $('#post_sortable li').each(function() {
                        post_order_ids.push($(this).data("id"));
                    });

                    console.log(post_order_ids);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.vehicle.position.change') }}",
                        dataType: "json",
                        data: {
                            order: post_order_ids,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            $('#post_sortable li').each(function(index) {
                                $(this).find('.pos_num').text(index + 1);

                                //console.log(index);
                            });

                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>