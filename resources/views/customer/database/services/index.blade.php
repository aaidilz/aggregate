@extends('layouts-customer.dashboard-customer')

@section('page-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('customer.database.service.import') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                    Import</a>
            </div>
            <form action="#" method="GET">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="machine_id">Machine ID</label>
                                <input type="text" class="form-control" id="machine_id" name="machine_id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="machine_type">Machine Type</label>
                                <select class="form-control" id="machine_type" name="machine_type">
                                    <option value="">-- Select Machine Type --</option>
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

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location_name">Location Name</label>
                                <input type="text" class="form-control" id="location_name" name="location_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select class="form-control" id="customer" name="customer">
                                    <option value="">-- Select Customer --</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="partner_code">Partner Code</label>
                                <select class="form-control" id="partner_code" name="partner_code">
                                    <option value="">-- Select Partner Code --</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="spv_name">SPV Name</label>
                                <select class="form-control" id="spv_name" name="spv_name">
                                    <option value="">-- Select SPV Name --</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fse_name">FSE Name</label>
                                <select class="form-control" id="fse_name" name="fse_name">
                                    <option value="">-- Select FSE Name --</option>

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

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
@endsection
