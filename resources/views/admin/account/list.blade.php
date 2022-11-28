@extends('admin.layouts.master')

@section('title','Admin List Page')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>
                            </div>
                        </div>
                        {{-- <div class="table-data__tool-right">
                            <a href="{{route('category#createPage')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add Category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div> --}}
                    </div>

                    {{-- Created Message --}}
                    {{-- @if (session('categorySuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check"></i> {{session('categorySuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>
                    @endif --}}

                    {{-- Deleted Message --}}
                    @if (session('deleteSuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{session('deleteSuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>
                    @endif

                    {{-- Change Password Message --}}
                    {{-- @if (session('changeSuccess'))
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-check me-2"></i> {{session('changeSuccess')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif --}}

                    {{-- Search --}}
                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{request('key')}}</span></h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{route('admin#list')}}" method="get" class="d-flex">
                                @csrf
                                <input type="text" name="key" class="form-control" placeholder="Search..." value="{{request('key')}}">
                                <button class="btn btn-dark text-white" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-1 offset-10 rounded bg-white shadow-sm py-1 px-2 text-center">
                            <h3><i class="fa-solid fa-database mr-2"></i> {{$admins->total()}}</h3>
                        </div>
                    </div>

                    {{-- @if (count($categories) != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr class="tr-shadow">
                                        <input type="hidden" name="" value="{{$admin->id}}" id="adminId">
                                        <td class="col-2">
                                            @if ($admin->image == null)
                                                @if ($admin->gender == 'male')
                                                    <img src="{{asset('image/default_user.png')}}" class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{asset('image/default_female_user.webp')}}" class="img-thumbnail shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{asset('storage/'.$admin->image)}}" class="img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{$admin->name}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>{{$admin->gender}}</td>
                                        <td>{{$admin->phone}}</td>
                                        <td>{{$admin->address}}</td>
                                        <td>
                                            @if (Auth::user()->id == $admin->id)

                                            @else
                                                <div class="table-data-feature">
                                                    <select class="form-control status-change">
                                                        <option value="user" @if ($admin->role == 'user') selected @endif>User</option>
                                                        <option value="admin" @if ($admin->role == 'admin') selected @endif>Admin</option>
                                                    </select>
                                                </div>
                                            @endif

                                                {{-- @if (Auth::user()->id == $admin->id)

                                                @else
                                                    <a href="{{route('admin#changeRole',$admin->id)}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Change Admin Role">
                                                            <i class="fa-solid fa-person-circle-minus"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{route('admin#delete',$admin->id)}}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{$admins->links()}}
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
                $adminId = $parentNode.find('#adminId').val();

                $data = {
                    'adminId' : $adminId,
                    'role' : $currentStatus
            };

                $.ajax({
                    type: 'get',
                    url: '/admin/change/role',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
