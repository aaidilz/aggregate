@extends('layouts-customer.dashboard-customer')
@section('page-content')
    {{-- hello world --}}
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

            </div>
            <form action="#" method="post">
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </form>
        </div>
    </div>
@endsection
