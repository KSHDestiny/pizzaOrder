@extends('admin.layouts.master')

@section('title','Contact List Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User's Name</th>
                                        <th>User's Email</th>
                                        <th>Message</th>
                                        <th>Sent at</th>
                                    </tr>
                                </thead>

                                <tbody id="dataList">
                                    @foreach ($users as $user)
                                        <tr class="tr-shadow">
                                            <input type="hidden" class="user-id" value="{{$user->id}}">
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->message}}</td>
                                            <td>{{$user->created_at->format('F-j-y')}}</td>
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
    <div class="mt-3">
        {{$users->links()}}
    </div>
    <!-- END MAIN CONTENT-->
@endsection
