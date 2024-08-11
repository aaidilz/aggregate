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
                <h3 class="card-title">{{ $part->part_description }}</h3>
            </div>
            {{-- <form action="{{ route('customer.database.part.update', $part->part_id) }}" method="POST"> --}}
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="part_number">Part Number</label>
                                <input type="text" class="form-control" id="part_number" name="part_number"
                                    value="{{ $part->part_number }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="part_description">Part Description</label>
                                <input type="text" class="form-control" id="part_description" name="part_description"
                                    value="{{ $part->part_description }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="part_type">Part Type</label>
                                <input type="text" class="form-control" id="part_type" name="part_type"
                                    value="{{ $part->part_type }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('customer.database.part.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Part</button>
                </div>
            </form>
        </div>
    </div>
@endsection
