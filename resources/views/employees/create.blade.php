@extends('layouts.app')

@section('content')
    <h1>Add Employee</h1>
    <form id="employeeForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <h3>Education Details</h3>
        <div id="education-fields">
            <div class="education-entry mb-3">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" name="educations[0][degree]" placeholder="Degree" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="educations[0][institution]" placeholder="Institution" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="educations[0][year]" placeholder="Year" required>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-danger remove-education">Remove</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-education">Add Education</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let educationCount = 1;

            $('#add-education').click(function() {
                $('#education-fields').append(`
                    <div class="education-entry mb-3">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="educations[${educationCount}][degree]" placeholder="Degree" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="educations[${educationCount}][institution]" placeholder="Institution" required>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="educations[${educationCount}][year]" placeholder="Year" required>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger remove-education">Remove</button>
                            </div>
                        </div>
                    </div>
                `);
                educationCount++;
            });

            $(document).on('click', '.remove-education', function() {
                $(this).closest('.education-entry').remove();
            });

            $('#employeeForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: '{{ route("employees.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        window.location.href = '{{ route("employees.index") }}';
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
