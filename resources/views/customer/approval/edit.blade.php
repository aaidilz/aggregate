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
                <h4 class="card-title">Edit Tiket: {{ $approval->entry_ticket }}</h4>
                <a href="{{ route('customer.approval.details') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
                    Back</a>

            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="entry_ticket">Entry Ticket ID</label>
                            <input type="text" class="form-control" id="entry_ticket" name="entry_ticket"
                                value="{{ old('entry_ticket', $approval->entry_ticket) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="serial_number">Entry SSB ID</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number"
                                value="{{ old('serial_number', $approval->service->serial_number) }}">
                        </div>
                    </div>
                    <hr>
                    <div id="parts-wrapper">
                        @foreach ($approval->parts as $index => $part)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="part_number">Entry PN Part</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="part_number[]"
                                            placeholder="PN Part..."
                                            value="{{ old('part_number.' . $index, $part->part_number ?? '') }}">
                                        <div class="input-group-append">
                                            @if ($loop->first)
                                                <button type="button" class="btn btn-success add-part-btn"><i
                                                        class="fa fa-plus"></i></button>
                                            @else
                                                <button type="button" class="btn btn-success add-part-btn""><i
                                                        class="fa fa-plus"></i></button>
                                                <button type="button" class="btn btn-danger remove-part-btn"><i
                                                        class="fa fa-minus"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="status_part">Status Part</label>
                                    <select name="status_part[]" class="form-control">
                                        <option value="">-- Select Status Part --</option>
                                        <option value="Ready"
                                            {{ old('status_part.' . $index, $part->status_part ?? '') == 'Ready' ? 'selected' : '' }}>
                                            Ready</option>
                                        <option value="Pending Part CWH"
                                            {{ old('status_part.' . $index, $part->status_part ?? '') == 'Pending Part CWH' ? 'selected' : '' }}>
                                            Pending Part CWH</option>
                                        <option value="SOH"
                                            {{ old('status_part.' . $index, $part->status_part ?? '') == 'SOH' ? 'selected' : '' }}>
                                            SOH</option>
                                        <option value="Pending Part Kota Terusan"
                                            {{ old('status_part.' . $index, $part->status_part ?? '') == 'Pending Part Kota Terusan' ? 'selected' : '' }}>
                                            Pending Part Kota Terusan</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="status_part_used">Status Part Used</label>
                                    <select name="status_part_used[]" class="form-control">
                                        <option value="">-- Select Status Part Used --</option>
                                        <option value="Defective"
                                            {{ old('status_part_used.' . $index, $part->status_part_used ?? '') == 'Defective' ? 'selected' : '' }}>
                                            Defective</option>
                                        <option value="Good"
                                            {{ old('status_part_used.' . $index, $part->status_part_used ?? '') == 'Good' ? 'selected' : '' }}>
                                            Good</option>
                                        <option value="DOA"
                                            {{ old('status_part_used.' . $index, $part->status_part_used ?? '') == 'DOA' ? 'selected' : '' }}>
                                            DOA</option>
                                        <option value="Consume"
                                            {{ old('status_part_used.' . $index, $part->status_part_used ?? '') == 'Consume' ? 'selected' : '' }}>
                                            Consume</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="SN_part_good">SN Part Good</label>
                                    <input type="text" name="SN_part_good[]" class="form-control"
                                        placeholder="SN Part Good..."
                                        value="{{ old('SN_part_good.' . $index, $part->SN_part_good ?? '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="SN_part_bad">SN Part Bad</label>
                                    <input type="text" name="SN_part_bad[]" class="form-control"
                                        placeholder="SN Part Bad..."
                                        value="{{ old('SN_part_bad.' . $index, $part->SN_part_bad ?? '') }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="row mb-3" id="template-row" style="display: none;">
                            <div class="col-md-4">
                                <label for="part_number">Entry PN Part</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="part_number[]"
                                        placeholder="PN Part...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-part-btn"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="status_part">Status Part</label>
                                <select name="status_part[]" class="form-control">
                                    <option value="">-- Select Status Part --</option>
                                    <option value="Ready">Ready</option>
                                    <option value="Pending Part CWH">Pending Part CWH</option>
                                    <option value="SOH">SOH</option>
                                    <option value="Pending Part Kota Terusan">Pending Part Kota Terusan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status_part_used">Status Part Used</label>
                                <select name="status_part_used[]" class="form-control">
                                    <option value="">-- Select Status Part Used --</option>
                                    <option value="Defective">Defective</option>
                                    <option value="Good">Good</option>
                                    <option value="DOA">DOA</option>
                                    <option value="Consume">Consume</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="SN_part_good">SN Part Good</label>
                                <input type="text" name="SN_part_good[]" class="form-control"
                                    placeholder="SN Part Good...">
                            </div>
                            <div class="col-md-2">
                                <label for="SN_part_bad">SN Part Bad</label>
                                <input type="text" name="SN_part_bad[]" class="form-control"
                                    placeholder="SN Part Bad...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="request_date">Request Date</label>
                            <input type="datetime-local" name="request_date" id="request_date" class="form-control"
                                onpaste="handlePaste(event)" required
                                value="{{ old('request_date', $approval->request_date ? date('Y-m-d\TH:i', strtotime($approval->request_date)) : '') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="approval_date">Approval Date</label>
                            <input type="datetime-local" name="approval_date" id="approval_date" class="form-control"
                                onpaste="handlePaste(event)"
                                value="{{ old('approval_date', $approval->approval_date ? date('Y-m-d\TH:i', strtotime($approval->approval_date)) : '') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="create_zulu_date">Zulu Date</label>
                            <input type="datetime-local" name="create_zulu_date" id="create_zulu_date"
                                class="form-control" onpaste="handlePaste(event)"
                                value="{{ old('create_zulu_date', $approval->create_zulu_date ? date('Y-m-d\TH:i', strtotime($approval->create_zulu_date)) : '') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="approval_area_remote_date">Approval Area Remote Date</label>
                            <input type="datetime-local" name="approval_area_remote_date" id="approval_area_remote_date"
                                class="form-control" onpaste="handlePaste(event)"
                                value="{{ old('approval_area_remote_date', $approval->approval_area_remote_date ? date('Y-m-d\TH:i', strtotime($approval->approval_area_remote_date)) : '') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email_request">Email Request</label>
                            <select name="email_request" id="email_request" class="form-control">
                                <option value="">-- Select Email Request --</option>
                                <option value="Non Area Remote"
                                    {{ old('email_request', $approval->email_request) == 'Non Area Remote' ? 'selected' : '' }}>
                                    Non Area Remote</option>
                                <option value="Area Remote"
                                    {{ old('email_request', $approval->email_request) == 'Area Remote' ? 'selected' : '' }}>
                                    Area Remote</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status_email_request">Status Email</label>
                            <select name="status_email_request" id="status_email_request" class="form-control">
                                <option value="">-- Select Status Email --</option>
                                <option value="Passed"
                                    {{ old('status_email_request', $approval->status_email_request) == 'Passed' ? 'selected' : '' }}>
                                    Passed</option>
                                <option value="Need Approval"
                                    {{ old('status_email_request', $approval->status_email_request) == 'Need Approval' ? 'selected' : '' }}>
                                    Need Approval</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="reason_description">Reason Description</label>
                            <textarea name="reason_description" id="reason_description" class="form-control" rows="4">{{ old('reason_description', $approval->reason_description) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const partsWrapper = document.getElementById('parts-wrapper');

            partsWrapper.addEventListener('click', function(event) {
                // Check if the clicked element is the plus or minus button
                if (event.target.closest('.add-part-btn')) {
                    addPartRow();
                } else if (event.target.closest('.remove-part-btn')) {
                    removePartRow(event.target.closest('.row'));
                }
            });

            function addPartRow() {
                const row = document.querySelector('.row.mb-3');
                const newRow = row.cloneNode(true);

                // Reset the value of each input and select in the new row
                newRow.querySelectorAll('input, select').forEach(function(input) {
                    input.value = '';
                });

                // Ensure the minus button is present in the new row
                if (!newRow.querySelector('.remove-part-btn')) {
                    const inputGroupAppend = newRow.querySelector('.input-group-append');
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'btn btn-danger remove-part-btn';
                    removeButton.innerHTML = '<i class="fa fa-minus"></i>';
                    inputGroupAppend.appendChild(removeButton);
                }

                partsWrapper.appendChild(newRow);
            }

            function removePartRow(row) {
                if (partsWrapper.querySelectorAll('.row.mb-3').length > 1) {
                    partsWrapper.removeChild(row);
                }
            }
        });
    </script>
@endsection
