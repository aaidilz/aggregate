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
                <h4 class="card-title">Edit Entry ID {{ $approval->entry_ticket }}</h4>
                <a href="{{ route('customer.approval.details') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>

            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="entry_ticket">Entry Ticket ID</label>
                            <input type="text" class="form-control" id="entry_ticket" name="entry_ticket"
                                value="{{ old('entry_ticket', $approval->entry_ticket) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="serial_number">Entry SSB ID</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number"
                                value="{{ old('serial_number', $approval->service->serial_number) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="part_number">Entry Part ID</label>
                            <div id="parts-wrapper">
                                <!-- First input field with a plus button -->
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="part_number[]"
                                        value="{{ old('part_number.0', $approval->parts[0]->part_number ?? '') }}"
                                        placeholder="Enter Part ID">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success add-part-btn"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>

                                <!-- If there are more parts, render them with a minus button -->
                                @for ($i = 1; $i < count($approval->parts); $i++)
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="part_number[]"
                                            value="{{ old('part_number.' . $i, $approval->parts[$i]->part_number) }}"
                                            placeholder="Enter Part ID">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-part-btn"><i
                                                    class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="request_date">Request Date</label>
                            <input type="datetime-local" name="request_date" id="request_date" class="form-control"
                                onpaste="handlePaste(event)" required
                                value="{{ old('request_date', $approval->request_date) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="approval_date">Approval Date</label>
                            <input type="datetime-local" name="approval_date" id="approval_date" class="form-control"
                                onpaste="handlePaste(event)" value="{{ old('approval_date', $approval->approval_date) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="create_zulu_date">Zulu Date</label>
                            <input type="datetime-local" name="create_zulu_date" id="create_zulu_date" class="form-control"
                                onpaste="handlePaste(event)"
                                value="{{ old('create_zulu_date', $approval->create_zulu_date) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="approval_area_remote_date">Approval Area Remote Date</label>
                            <input type="datetime-local" name="approval_area_remote_date" id="approval_area_remote_date"
                                class="form-control" onpaste="handlePaste(event)"
                                value="{{ old('approval_area_remote_date', $approval->approval_area_remote_date) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{-- status part --}}
                            <label for="status_part">Status Part</label>
                            <select name="status_part" id="status_part" class="form-control">
                                <option value="">-- Select Status Part --</option>
                                <option value="Ready"
                                    {{ old('status_part', $approval->status->status_part) == 'Ready' ? 'selected' : '' }}>
                                    Ready</option>
                                <option value="Pending Part CWH"
                                    {{ old('status_part', $approval->status->status_part) == 'Pending Part CWH' ? 'selected' : '' }}>
                                    Pending Part CWH</option>
                                <option value="SOH"
                                    {{ old('status_part', $approval->status->status_part) == 'SOH' ? 'selected' : '' }}>SOH
                                </option>
                                <option value="Pending Part Kota Terusan"
                                    {{ old('status_part', $approval->status->status_part) == 'Pending Part Kota Terusan' ? 'selected' : '' }}>
                                    Pending Part Kota Terusan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="email_request">Email Request</label>
                            <select name="email_request" id="email_request" class="form-control">
                                <option value="">-- Select Email Request --</option>
                                <option value="Non Area Remote"
                                    {{ old('email_request', $approval->status->email_request) == 'Non Area Remote' ? 'selected' : '' }}>
                                    Non Area Remote</option>
                                <option value="Area Remote"
                                    {{ old('email_request', $approval->status->email_request) == 'Area Remote' ? 'selected' : '' }}>
                                    Area Remote</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status_email_request">Status Email</label>
                            <select name="status_email_request" id="status_email_request" class="form-control">
                                <option value="">-- Select Status Email --</option>
                                <option value="Passed"
                                    {{ old('status_email_request', $approval->status->status_email_request) == 'Passed' ? 'selected' : '' }}>
                                    Passed</option>
                                <option value="Need Approval"
                                    {{ old('status_email_request', $approval->status->status_email_request) == 'Need Approval' ? 'selected' : '' }}>
                                    Need Approval</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="SN_part_good">SN Part Good</label>
                                    <input type="text" name="SN_part_good" id="SN_part_good" class="form-control"
                                        value="{{ old('SN_part_good', $approval->status->SN_part_good) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="SN_part_bad">SN Part Bad</label>
                                    <input type="text" name="SN_part_bad" id="SN_part_bad" class="form-control"
                                        value="{{ old('SN_part_bad', $approval->status->SN_part_bad) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="status_part_used">Status Part Used</label>
                                    <select name="status_part_used" id="status_part_used" class="form-control">
                                        <option value="">-- Select Status Part Used --</option>
                                        <option value="Defective"
                                            {{ old('status_part_used', $approval->status->status_part_used) == 'Defective' ? 'selected' : '' }}>
                                            Defective</option>
                                        <option value="Good"
                                            {{ old('status_part_used', $approval->status->status_part_used) == 'Good' ? 'selected' : '' }}>
                                            Good</option>
                                        <option value="DOA"
                                            {{ old('status_part_used', $approval->status->status_part_used) == 'DOA' ? 'selected' : '' }}>
                                            DOA</option>
                                        <option value="Consume"
                                            {{ old('status_part_used', $approval->status->status_part_used) == 'Consume' ? 'selected' : '' }}>
                                            Consume</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label for="reason_description">Reason Description</label>
                                <textarea name="reason_description" id="reason_description" class="form-control" rows="4">{{ old('reason_description', $approval->status->reason_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </form>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for "Add Part" button
            document.querySelector('.add-part-btn').addEventListener('click', function() {
                addPartField();
            });

            // Function to create a new part input field
            function addPartField() {
                let partsWrapper = document.getElementById('parts-wrapper');
                let newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-3');

                let newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.className = 'form-control';
                newInput.name = 'part_number[]';
                newInput.placeholder = 'Enter Part ID';

                let inputGroupAppend = document.createElement('div');
                inputGroupAppend.className = 'input-group-append';

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger remove-part-btn';
                removeButton.innerHTML = '<i class="fa fa-minus"></i>';

                inputGroupAppend.appendChild(removeButton);
                newInputGroup.appendChild(newInput);
                newInputGroup.appendChild(inputGroupAppend);

                partsWrapper.appendChild(newInputGroup);

                // Event listener to remove the input field
                removeButton.addEventListener('click', function() {
                    partsWrapper.removeChild(newInputGroup);
                });
            }

            // Add event listeners to existing "Remove Part" buttons
            document.querySelectorAll('.remove-part-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('.input-group').remove();
                });
            });
        });
    </script>
@endsection
