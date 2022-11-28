@extends('user.layouts.master')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact</h3>
                            </div>
                            <hr>
                            <form action="{{route('user#contactForm',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-3 offset-1">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{asset('image/default_user.png')}}" class="img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{asset('image/default_female_user.webp')}}" class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.Auth::user()->image)}}" class="img-thumbnail shadow-sm" alt="John Doe" />
                                        @endif
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1 me-5">Name</label>
                                            <input id="cc-pament" name="name" disabled type="text" value="{{old('name',Auth::user()->name)}}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Name...">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1 me-5">Email</label>
                                            <input id="cc-pament" name="email" disabled type="text" value="{{old('email',Auth::user()->email)}}" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Email...">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Message</label>
                                            <textarea id="cc-pament" name="message" rows="5" type="text" class="form-control @error('message') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your Message...">{{old('message',Auth::user()->message)}}</textarea>
                                            @error('message')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-paper-plane"></i> Send</button>
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
