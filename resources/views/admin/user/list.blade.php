@extends('admin.layouts.master')

@section('title','User List Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                        <div class="table-responsive table-responsive-data2">

                            <h3>Total - {{$users->total()}}</h3>

                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>

                                <tbody id="dataList">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="col-2">
                                                @if ($user->image == null)
                                                    @if ($user->gender == 'male')
                                                        <img src="{{asset('image/default_user.png')}}" class="img-thumbnail shadow-sm">
                                                    @else
                                                        <img src="{{asset('image/default_female_user.webp')}}" class="img-thumbnail shadow-sm">
                                                    @endif
                                                @else
                                                    <img src="{{asset('storage/'.$user->image)}}" alt="John Doe" />
                                                @endif
                                            </td>
                                            <input type="hidden" id="userId" value="{{$user->id}}">
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->gender}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->address}}</td>
                                            <td>
                                                <select class="form-control status-change">
                                                    <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                                                    <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="{{route('admin#userEdit',$user->id)}}">
                                                    <i class="fa-solid fa-user-pen me-2" title="User Account Edit"></i>
                                                </a>
                                                <a href="{{route('admin#userDelete',$user->id)}}">
                                                    <i class="fa-solid fa-trash-can" title="Delete"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-5">
                                {{$users->links()}}
                            </div>
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
            // change status
            $(".status-change").change(function(){
                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $userId = $parentNode.find('#userId').val();

                $data = {
                    'userId' : $userId,
                    'role' : $currentStatus
            };

                $.ajax({
                    type: 'get',
                    url: '/user/change/role',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
