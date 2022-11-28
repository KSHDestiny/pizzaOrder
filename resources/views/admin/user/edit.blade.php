@extends('admin.layouts.master')

@section('title','Edit User Account Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('admin#userList')}}">
                                <div class="ms-5">
                                    <i class="fa-solid fa-arrow-left text-dark" style="cursor: pointer"></i>
                                </div>
                            </a>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit User Account</h3>
                            </div>
                            <hr>
                            <form action="{{route('admin#userUpdate',$account->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            @if ($account->gender == 'male')
                                                <img src="{{asset('image/default_user.png')}}" class="img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{asset('image/default_female_user.webp')}}" class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.$account->image)}}" alt="John Doe" />
                                        @endif

                                        <div class="mt-3">
                                            <input type="file" name="image" id="" class="form-control @error('image') is-invalid @enderror">
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mt-3 ">
                                            <button class="btn bg-dark text-white col-12" type="submit"><i class="fa-solid fa-circle-chevron-right me-3"></i>Change</button>
                                        </div>
                                    </div>

                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" value="{{old('name',$account->name)}}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Name...">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text" value="{{old('email',$account->email)}}" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Email...">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="text" value="{{old('phone',$account->phone)}}" class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Phone...">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Gender</label>
                                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                                <option value="" disabled>Choose Gender...</option>
                                                <option value="male" @if($account->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if($account->gender == 'female') selected @endif>Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea id="cc-pament" name="address" type="text" class="form-control @error('address') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Address...">{{old('address',$account->address)}}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
