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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="m-0 font-weight-bold text-primary">Import Services</h1>
            </div>
            <form action="{{ route('customer.database.service.import') }}" method="POST" enctype="multiservice/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="file">Choose file</label>
                        <input type="file" name="file" class="form-control-file">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <a href="{{ route('customer.database.service.export-template') }}" class="btn btn-success">Download template</a>
                </div>
            </form>
        </div>
    </div>


@endsection
