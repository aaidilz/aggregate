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
            </div>
            <form action="{{ route('customer.approval.create-approval') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="entry_ticket">Entry Ticket ID</label>
                            <input type="text" class="form-control" id="entry_ticket" name="entry_ticket"
                                value="{{ old('entry_ticket') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="serial_number">Entry SSB ID</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number"
                                value="{{ old('serial_number') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="part_number">Entry Part ID</label>
                            <div id="parts-wrapper">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="part_number" name="part_number[]"
                                        value="{{ old('part_number.0') }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success add-part-btn"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="request_date">Request Date</label>
                            <input type="datetime-local" name="request_date" id="request_date" class="form-control"
                                onpaste="handlePaste(event)" required value="{{ old('request_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="approval_date">Approval Date</label>
                            <input type="datetime-local" name="approval_date" id="approval_date" class="form-control"
                                onpaste="handlePaste(event)" value="{{ old('approval_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="create_zulu_date">Zulu Date</label>
                            <input type="datetime-local" name="create_zulu_date" id="create_zulu_date" class="form-control"
                                onpaste="handlePaste(event)" value="{{ old('create_zulu_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="approval_area_remote_date">Approval Area Remote Date</label>
                            <input type="datetime-local" name="approval_area_remote_date" id="approval_area_remote_date"
                                class="form-control" onpaste="handlePaste(event)" value="{{ old('approval_area_remote_date') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{-- status part --}}
                            <label for="status_part">Status Part</label>
                            <select name="status_part" id="status_part" class="form-control">
                                <option value="">-- Select Status Part --</option>
                                <option value="Ready">Ready</option>
                                <option value="Pending Part CWH">Pending Part CWH</option>
                                <option value="SOH">SOH</option>
                                <option value="Pending Part Kota Terusan">Pending Part Kota Terusan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for"email_request">Email Request</label>
                            <select name="email_request" id="email_request" class="form-control">
                                <option value="">-- Select Email Request --</option>
                                <option value="Non Area Remote">Non Area Remote</option>
                                <option value="Area Remote">Area Remote</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status_email_request">Status Email</label>
                            <select name="status_email_request" id="status_email_request" class="form-control">
                                <option value="">-- Select Status Email --</option>
                                <option value="Passed">Passed</option>
                                <option value="Need Approval">Need Approval</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="SN_part_good">SN Part Good</label>
                                    <input type="text" name="SN_part_good" id="SN_part_good" class="form-control" value="{{ old('SN_part_good') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="SN_part_bad">SN Part Bad</label>
                                    <input type="text" name="SN_part_bad" id="SN_part_bad" class="form-control" value="{{ old('SN_part_bad') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="status_part_used">Status Part Used</label>
                                    <select name="status_part_used" id="status_part_used" class="form-control">
                                        <option value="">-- Select Status Part Used --</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Good">Good</option>
                                        <option value="DOA">DOA</option>
                                        <option value="Consume">Consume</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label for="reason_description">Reason Description</label>
                                <textarea name="reason_description" id="reason_description" class="form-control" rows="4">{{ old('reason_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk tombol Add Part
            document.querySelector('.add-part-btn').addEventListener('click', function() {
                addPartField();
            });

            function addPartField() {
                // Membuat elemen input baru
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

                // Event listener untuk tombol Remove Part
                removeButton.addEventListener('click', function() {
                    partsWrapper.removeChild(newInputGroup);
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var emailRequest = document.getElementById('email_request');
            var statusEmailRequest = document.getElementById('status_email_request');

            emailRequest.addEventListener('change', function() {
                if (emailRequest.value === 'Non Area Remote') {
                    statusEmailRequest.value = 'Passed';
                } else if (emailRequest.value === 'Area Remote') {
                    statusEmailRequest.value = 'Need Approval';
                } else {
                    statusEmailRequest.value = ''; // Mengatur ulang jika tidak ada yang dipilih
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var approvalDate = document.getElementById('approval_area_remote_date');
            var statusEmailRequest = document.getElementById('status_email_request');

            approvalDate.addEventListener('change', function() {
                if (approvalDate.value) {
                    statusEmailRequest.value = 'Passed';
                } else {
                    statusEmailRequest.value = ''; // Reset jika field dikosongkan kembali
                }
            });
        });
    </script>

    <script>
        function handlePaste(event) {
            // Prevent the default paste behavior
            event.preventDefault();

            // Get the pasted data from the clipboard
            const pasteData = event.clipboardData.getData('text');

            // Try to parse the date from the pasted data
            const parsedDate = parseDate(pasteData);
            if (parsedDate) {
                // Format the date to the datetime-local format
                const formattedDate = formatDateToLocal(parsedDate);
                // Set the value of the input field
                event.target.value = formattedDate;
            } else {
                alert('Invalid date format. Please use "M/D/YY h:mm AM/PM" format.');
            }
        }

        function parseDate(dateString) {
            // Regex to match the date format "M/D/YY h:mm AM/PM"
            const regex = /^(\d{1,2})\/(\d{1,2})\/(\d{2})\s+(\d{1,2}):(\d{2})\s*(AM|PM)$/i;
            const match = dateString.match(regex);

            if (!match) return null;

            let [_, month, day, year, hour, minute, period] = match;
            month = parseInt(month, 10);
            day = parseInt(day, 10);
            year = parseInt('20' + year, 10);
            hour = parseInt(hour, 10);
            minute = parseInt(minute, 10);

            if (period.toUpperCase() === 'PM' && hour < 12) hour += 12;
            if (period.toUpperCase() === 'AM' && hour === 12) hour = 0;

            return new Date(year, month - 1, day, hour, minute);
        }

        function formatDateToLocal(date) {
            const pad = (num) => num.toString().padStart(2, '0');

            const year = date.getFullYear();
            const month = pad(date.getMonth() + 1);
            const day = pad(date.getDate());
            const hours = pad(date.getHours());
            const minutes = pad(date.getMinutes());

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    </script>
@endsection
