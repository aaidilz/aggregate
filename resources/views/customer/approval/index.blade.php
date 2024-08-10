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
                {{-- create approval --}}
                <a href="{{ route('customer.approval.create') }}" class="btn btn-primary"><i class=" fa fa-plus"></i> Create
                    Approval</a>
            </div>
            <form action="#" method="GET">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Entry Ticket</label>
                                <input type="text" class="form-control" name="entry_ticket"
                                    value="{{ old('entry_ticket') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

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
                                <th>Ticket Number</th>
                                <th>Request Date</th>
                                <th>Approval Date</th>
                                <th>Create Zulu Date</th>
                                <th>Approval Area Remote Date</th>
                                <th>SSB Number</th>
                                <th>Bank Name</th>
                                <th>ATM ID</th>
                                <th>Location</th>
                                <th>Service Center</th>
                                <th>FSE Name</th>
                                <th>SPV Name</th>
                                <th>FSL Name</th>
                                <th>Partner Code</th>
                                <th>PN Part of Request</th>
                                <th>Name of Part</th>
                                <th>Status Part</th>
                                <th>Email Request</th>
                                <th>Status Email Request</th>
                                <th>SN Part Good</th>
                                <th>SN Part Bad </th>
                                <th>Status Part Used</th>
                                <th>Reason Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvals as $approval)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $approval->entry_ticket }}</td>
                                    <td>{{ $approval->request_date }}</td>
                                    <td>{{ $approval->approval_date }}</td>
                                    <td>{{ $approval->create_zulu_date }}</td>
                                    <td>{{ $approval->approval_area_remote_date }}</td>
                                    <td>{{ $approval->service->serial_number }}</td>
                                    <td>{{ $approval->service->bank_name }}</td>
                                    <td>{{ $approval->service->machine_id }}</td>
                                    <td>{{ $approval->service->location_name }}</td>
                                    <td>{{ $approval->service->service_center }}</td>
                                    <td>{{ $approval->service->fse_name }}</td>
                                    <td>{{ $approval->service->spv_name }}</td>
                                    <td>{{ $approval->service->fsl_name }}</td>
                                    <td>{{ $approval->service->partner_code }}</td>
                                    <!-- Display parts with bullet points -->
                                    <td>
                                        <ul>
                                            @foreach ($approval->parts as $part)
                                                <li>{{ $part->part_number }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($approval->parts as $part)
                                                <li>{{ $part->part_description }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $approval->status->status_part }}</td>
                                    <td>{{ $approval->status->email_request }}</td>
                                    <td>{{ $approval->status->status_email_request }}</td>
                                    <td>{{ $approval->status->SN_part_good }}</td>
                                    <td>{{ $approval->status->SN_part_bad }}</td>
                                    <td>{{ $approval->status->status_part_used }}</td>
                                    <td>{{ $approval->status->reason_description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($approvals->isEmpty())
                            <tr>
                                <td colspan="24" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $approvals->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
