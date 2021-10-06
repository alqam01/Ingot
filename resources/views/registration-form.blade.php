@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <form action="{{url('register')}}" method="POST" encType="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-6 m-auto">
                <div class="card shadow">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{Session::get('success')}}
                        </div>
                    @elseif(Session::has('failed'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{Session::get('failed')}}
                        </div>
                    @endif

                    <div class="card-header">
                        <h4 class="card-title font-weight-bold"> Ingot Regidtration </h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name"> Name <span class="text-danger"> * </span> </label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" />
                                {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
                        </div>

                        <div class="form-group">
                            <label for="email"> Email <span class="text-danger"> * </span> </label>
                                <input type="text" name="email" class="form-control" value="{{old('email')}}" />
                                {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                        </div>

                        <div class="form-group">
                            <label for="password"> Password <span class="text-danger"> * </span></label>
                                <input type="password" name="password" class="form-control" value="{{old('password')}}" />
                                {!!$errors->first("password", "<span class='text-danger'>:message</span>")!!}
                        </div>

                        <div class="form-group">
                            <label for="confirm_password"> Confirm Password <span class="text-danger"> * </span></label>
                                <input type="password" name="confirm_password" class="form-control" value="{{old('confirm_password')}}" />
                                {!!$errors->first("confirm_password", "<span class='text-danger'>:message</span>")!!}
                        </div>

                        <div class="form-group">
                            <label for="profile_image_url"> Profile Image <span class="text-danger"> * </span></label>
                                <input type="file" name="profile_image_url" class="form-control" value="{{old('profile_image_url')}}" />
                                {!!$errors->first("profile_image_url", "<span class='text-danger'>:message</span>")!!}
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> Register </button>
                        <span >
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline"> Go to login</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection