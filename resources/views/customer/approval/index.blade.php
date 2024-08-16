@php
    use carbon\carbon;
@endphp

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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            </form>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{-- details --}}
                <a href="{{ route('customer.approval.details') }}" class="btn btn-secondary"><i class=" fa fa-list"></i>
                    Action Mode </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr class="">
                                <th>No</th>
                                <th>Ticket Number</th>
                                <th>Request Date</th>
                                <th>Approval Date</th>
                                <th>Create Zulu Date</th>
                                <th>Approval Area Remote Date</th>
                                <th>SSB Number</th>
                                <th>Bank Name</th>
                                <th>Machine ID</th>
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
                                    <td>{{ $loop->iteration + $approvals->firstItem() - 1 }}</td>
                                    <td>{{ $approval->entry_ticket }}</td>
                                    <td>{{ Carbon::parse($approval->request_date)->format('d-m-Y') }}</td>
                                    <td>{{ Carbon::parse($approval->approval_date)->format('d-m-Y') }}</td>
                                    <td>{{ Carbon::parse($approval->create_zulu_date)->format('d-m-Y') }}</td>
                                    <td>{{ Carbon::parse($approval->approval_area_remote_date)->format('d-m-Y') }}</td>
                                    <td>{{ $approval->service->serial_number }}</td>
                                    <td>{{ $approval->service->bank_name }}</td>
                                    <td>{{ $approval->service->machine_id }}</td>
                                    <td>{{ $approval->service->location_name }}</td>
                                    <td>{{ $approval->service->service_center }}</td>
                                    <td>{{ $approval->service->fse_name }}</td>
                                    <td>{{ $approval->service->spv_name }}</td>
                                    <td>{{ $approval->service->fsl_name }}</td>
                                    <td>{{ $approval->service->partner_code }}</td>
                                    <td>
                                        <ul style="list-style: none; padding-left: 0;">
                                            @foreach ($approval->parts as $part)
                                                <li style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <span
                                                        style="display: inline-block; width: 1em; text-align: center; margin-right: 0.5em;">•</span>
                                                    {{ $part->part_number }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style="list-style: none; padding-left: 0;">
                                            @foreach ($approval->parts as $part)
                                                <li style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <span
                                                        style="display: inline-block; width: 1em; text-align: center; margin-right: 0.5em;">•</span>
                                                    {{ $part->part_description }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style="list-style: none; padding-left: 0;">
                                            @foreach ($approval->parts as $part)
                                                <li style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <span
                                                        style="display: inline-block; width: 1em; text-align: center; margin-right: 0.5em;">•</span>
                                                    {{ $part->statusPart->status_part ?? 'N/A' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $approval->email_request ?? 'N/A' }}</td>
                                    <td>{{ $approval->status_email_request ?? 'N/A'}}</td>
                                    <td>
                                        <ul style="list-style: none; padding-left: 0;">
                                            @foreach ($approval->parts as $part)
                                                <li style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <span
                                                        style="display: inline-block; width: 1em; text-align: center; margin-right: 0.5em;">•</span>
                                                    {{ $part->statusPart->SN_part_good ?? 'N/A' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style="list-style: none; padding-left: 0;">
                                            @foreach ($approval->parts as $part)
                                                <li style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <span
                                                        style="display: inline-block; width: 1em; text-align: center; margin-right: 0.5em;">•</span>
                                                    {{ $part->statusPart->SN_part_bad ?? 'N/A' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style="list-style: none; padding-left: 0;">
                                            @foreach ($approval->parts as $part)
                                                <li style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <span
                                                        style="display: inline-block; width: 1em; text-align: center; margin-right: 0.5em;">•</span>
                                                    {{ $part->statusPart->status_part_used ?? 'N/A' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <td>{{ $approval->reason_description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $approvals->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
