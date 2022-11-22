@extends('admin.layouts.master')

@section('title','Order List Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <form action="{{route('admin#changeStatus')}}" method="get" class="col-5">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-database mr-2"></i>{{count($orders)}}
                                </span>
                            </div>
                            <select name="orderStatus" class="form-select" id="inputGroupSelect02">
                                <option value="">All</option>
                                <option value="0" @if (request('orderStatus') == "0") selected @endif>Pending</option>
                                {{-- 0 1 2 ko integer nat pay yin all ka null ka 0 pyit loh all click yin pending pya tae error shi --}}
                                <option value="1" @if (request('orderStatus') == "1") selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == "2") selected @endif>Reject</option>
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text btn ms-3 btn-sm bg-dark text-white" for="inputGroupSelect02"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                            </div>
                        </div>
                    </form>

                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>UserName</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody id="dataList">
                                    @foreach ($orders as $order)
                                        <tr class="tr-shadow">
                                            <input type="hidden" class="order-id" value="{{$order->id}}">
                                            <td>{{$order->user_id}}</td>
                                            <td>{{$order->user_name}}</td>
                                            <td>{{$order->created_at->format('F-j-y')}}</td>
                                            <td>{{$order->order_code}}</td>
                                            <td class="amount">{{$order->total_price}}</td>
                                            <td>
                                                <select name="status" class="form-control status-change">
                                                    <option value="0" @if ($order->status == 0) selected @endif>Pending</option>
                                                    <option value="1" @if ($order->status == 1) selected @endif>Accept</option>
                                                    <option value="2" @if ($order->status == 2) selected @endif>Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function(){
            // $('#orderStatus').change(function(){
            //     $status = $('#orderStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://localhost:8000/order/ajax/status',
            //         data: {
            //             'status': $status
            //         },
            //         dataType: 'json',
            //         success : function(response){
            //                 $list = ``;
            //                 for ($i = 0; $i < response.length; $i++) {

            //                     $months = ['January','February','March','April','May','June','July','August','September','October','November','December']
            //                     $dbDate = new Date(response[$i].created_at);
            //                     $finalDate = $months[$dbDate.getMonth()]+"-"+$dbDate.getDate()+"-"+$dbDate.getFullYear();

            //                     if(response[$i].status == 0){
            //                         $statusMessage = `
            //                         <select name="status" class="form-control status-change">
            //                             <option value="0" selected>Pending</option>
            //                             <option value="1">Accept</option>
            //                             <option value="2">Reject</option>
            //                         </select>`
            //                     }

            //                     if(response[$i].status == 1){
            //                         $statusMessage = `
            //                         <select name="status" class="form-control status-change">
            //                             <option value="0">Pending</option>
            //                             <option value="1" selected>Accept</option>
            //                             <option value="2">Reject</option>
            //                         </select>`
            //                     }

            //                     if(response[$i].status == 2){
            //                         $statusMessage = `
            //                         <select name="status" class="form-control status-change">
            //                             <option value="0">Pending</option>
            //                             <option value="1">Accept</option>
            //                             <option value="2" selected>Reject</option>
            //                         </select>`
            //                     }

            //                     $list += `
            //                     <tr class="tr-shadow">
            //                         <input type="hidden" class="order-id" value="${response[$i].id}">
            //                         <td>${response[$i].user_id}</td>
            //                         <td>${response[$i].user_name}</td>
            //                         <td>${$finalDate}</td>
            //                         <td>${response[$i].order_code}</td>
            //                         <td>${response[$i].total_price}</td>
            //                         <td>
            //                             ${$statusMessage}
            //                         </td>
            //                     </tr>
            //                     `
            //                 }
            //             $('#dataList').html($list);
            //         }
            //     })
            // })

            // change status
            $(".status-change").change(function(){
                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('.order-id').val();

                $data = {
                    'status' : $currentStatus,
                    'orderId' : $orderId
                };

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
