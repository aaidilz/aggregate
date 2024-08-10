@extends('layouts-customer.dashboard-customer')

@section('page-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{-- import --}}
                <a href="{{ route('customer.database.part.import.index') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                    Import</a>
                {{-- export --}}
                <a href="{{ route('customer.database.part.export') }}" class="btn btn-success"><i class="fa fa-download"></i>
                    Export</a>
            </div>
            <form action="#" method="GET">
                @csrf
                <div class="card-body">
                    <div class="row">
                        {{-- create col md 6 with serial_number and Part Type --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="part_number">Serial Number</label>
                                <input type="text" class="form-control" id="part_number" name="part_number" value="{{ old('part_number', $request->part_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="part_type">Part Type</label>
                                <select class="form-control" id="part_type" name="part_type">
                                    <option value="">-- Select Part Type --</option>
                                    @foreach ($partTypes as $partType)
                                        <option value="{{ $partType->part_type }}" {{ old('part_type', $request->part_type) == $partType->part_type ? 'selected' : '' }}>
                                            {{ $partType->part_type }}
                                        </option>
                                    @endforeach
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
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parts as $part)
                                <tr>
                                    <td>{{ $loop->iteration + $parts->firstItem() - 1 }}</td>
                                    <td>{{ $part->part_number }}</td>
                                    <td>{{ $part->part_description }}</td>
                                    <td>{{ $part->part_type }}</td>
                                    {{-- <td>
                                        <a href="{{ route('customer.database.part.details', $part->part_id) }}"
                                            class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('customer.database.part.delete', $part->part_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="confirmDelete(event)"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- if not data from search then "tidak ada" --}}
                        @if ($parts->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $parts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection


@section('js-tambahan')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: 'Hapus Part',
                text: 'Apakah anda yakin ingin menghapus part ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection
