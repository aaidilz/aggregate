@extends('layouts-customer.dashboard-customer')

@section('page-content')
    <div class="container-fluid">
        {{-- Success and error messages --}}
        @if (session('success') || session('error') || $errors->any())
            <div class="alert @if (session('success')) alert-success @elseif (session('error') || $errors->any()) alert-danger @endif"
                role="alert">
                @if (session('success'))
                    {{ session('success') }}
                @endif
                @if (session('error'))
                    {{ session('error') }}
                @endif
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h1 class="h3 mb-0 text-gray-800">Profile</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('img/undraw_profile.svg') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-body">
                                    <h3>My Account</h3>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control w-50" id="username" name="username"
                                            value="{{ Auth::user()->username }}">
                                    </div>
                                    <h3>Change Password</h3>
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control w-50" id="current_password" name="current_password">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" class="form-control w-50" id="new_password" name="new_password">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control w-50" id="new_password_confirmation" name="new_password_confirmation">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
