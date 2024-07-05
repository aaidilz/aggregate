@extends('layouts-customer.dashboard-customer')

@section('page-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{-- import --}}
                <a href="{{ route('customer.database.part.import.index') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                    Import</a>
                {{-- create --}}
                <a href="#" class="btn btn-primary"><i class="fa fa-plus"></i> Create</a>
            </div>
            <form action="#" method="GET">
                @csrf
                <div class="card-body">
                    <div class="row">
                        {{-- create col md 6 with serial_number and Part Type --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="part_number">Serial Number</label>
                                <input type="text" class="form-control" id="part_number" name="part_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="part_type">Part Type</label>
                                <select class="form-control" id="part_type" name="part_type">
                                    <option value="">-- Select Part Type --</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Serial Number</th>
                                <th>Description</th>
                                <th>Part Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parts as $part)
                                <tr>
                                    <td>{{ $loop->iteration + $parts->firstItem() - 1 }}</td>
                                    <td>{{ $part->part_number }}</td>
                                    <td>{{ $part->part_description }}</td>
                                    <td>{{ $part->part_type }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $parts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
