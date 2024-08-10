@extends('layouts-customer.dashboard-customer')

@section('page-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('customer.database.service.import') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                    Import</a>
                <a href="{{ route('customer.database.service.export') }}" class="btn btn-success"><i class="fas fa-download"></i>
                    Export</a>
            </div>
            <form action="#" method="GET">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number"
                                    value="{{ old('serial_number', $request->serial_number) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="machine_id">Machine ID</label>
                                <input type="text" class="form-control" id="machine_id" name="machine_id"
                                    value="{{ old('machine_id', $request->machine_id) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="machine_type">Machine Type</label>
                                <select class="form-control" id="machine_type" name="machine_type"">
                                    <option value="">-- Select Machine Type --</option>
                                    @foreach ($machineTypes as $machineType)
                                        <option value="{{ $machineType->machine_type }}"
                                            {{ old('machine_type', $request->machine_type) == $machineType->machine_type ? 'selected' : '' }}>
                                            {{ $machineType->machine_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_center">Service Center</label>
                                <select class="form-control" id="service_center" name="service_center">
                                    <option value="">-- Select Service Center --</option>
                                    @foreach ($serviceCenters as $serviceCenter)
                                        <option value="{{ $serviceCenter->service_center }}"
                                            {{ old('service_center', $request->service_center) == $serviceCenter->service_center ? 'selected' : '' }}>
                                            {{ $serviceCenter->service_center }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select class="form-control" id="customer" name="customer">
                                    <option value="">-- Select Customer --</option>
                                    @foreach ($bankNames as $bankName)
                                        <option value="{{ $bankName->bank_name }}"
                                            {{ old('customer', $request->customer) == $bankName->bank_name ? 'selected' : '' }}>
                                            {{ $bankName->bank_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="partner_code">Partner Code</label>
                                <select class="form-control" id="partner_code" name="partner_code">
                                    <option value="">-- Select Partner Code --</option>
                                    @foreach ($partnerCodes as $partnerCode)
                                        <option value="{{ $partnerCode->partner_code }}"
                                            {{ old('partner_code', $request->partner_code) == $partnerCode->partner_code ? 'selected' : '' }}>
                                            {{ $partnerCode->partner_code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="spv_name">SPV Name</label>
                                <select class="form-control" id="spv_name" name="spv_name">
                                    <option value="">-- Select SPV Name --</option>
                                    @foreach ($SPVNames as $SPVName)
                                        <option value="{{ $SPVName->spv_name }}"
                                            {{ old('spv_name', $request->spv_name) == $SPVName->spv_name ? 'selected' : '' }}>
                                            {{ $SPVName->spv_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fse_name">FSE Name</label>
                                <select class="form-control" id="fse_name" name="fse_name">
                                    <option value="">-- Select FSE Name --</option>
                                    @foreach ($FSENames as $FSEName)
                                        <option value="{{ $FSEName->fse_name }}"
                                            {{ old('fse_name', $request->fse_name) == $FSEName->fse_name ? 'selected' : '' }}>
                                            {{ $FSEName->fse_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
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
                                <th>Bank Name</th>
                                <th>Serial Number</th>
                                <th>Machine ID</th>
                                <th>Machine Type</th>
                                <th>Service Center</th>
                                <th>Location Name</th>
                                <th>Partner Code</th>
                                <th>SPV Name</th>
                                <th>FSE Name</th>
                                <th>FSL Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration + $services->firstItem() - 1 }}</td>
                                    <td>{{ $service->bank_name }}</td>
                                    <td>{{ $service->serial_number }}</td>
                                    <td>{{ $service->machine_id }}</td>
                                    <td>{{ $service->machine_type }}</td>
                                    <td>{{ $service->service_center }}</td>
                                    <td>{{ $service->location_name }}</td>
                                    <td>{{ $service->partner_code }}</td>
                                    <td>{{ $service->spv_name }}</td>
                                    <td>{{ $service->fse_name }}</td>
                                    <td>{{ $service->fsl_name }}</td>
                                    <td>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($services->isEmpty())
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
