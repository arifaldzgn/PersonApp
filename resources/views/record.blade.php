@extends('main.main')

@section('css')
<link rel="stylesheet" href="{{ asset("assets/vendors/select2/select2.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css") }}">
@endsection

@section('container')

<div class="col-md-3 grid-margin stretch-card"></div>

<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Workout</h4>
            <p class="card-description"> Add your new workout with sessions </p>
            <form class="forms-sample" method="POST" action="{{ route('addRecord') }}">
                @csrf
                <div class="form-group">
                    <label for="startDate">Start</label>
                    <input id="startDate" class="form-control" type="date" name="date" />
                    <span id="startDateSelected"></span>
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <input type="text" class="form-control" id="notes" name="notes" value="">
                </div>

                <div id="sessions-container">
                    <!-- Sessions will be appended here -->
                </div>

                <button type="button" class="btn btn-secondary w-100 mt-3" onclick="addSession()">Add Session</button>
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>


<div class="col-md-3 grid-margin stretch-card"></div>

@endsection

@section('script')

    <!-- Plugin js for this page -->
    <script src="{{ asset("assets/vendors/typeahead.js/typeahead.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/vendors/select2/select2.min.js") }}"></script>
    <script src="{{ asset("assets/js/select2.js") }}"></script>
    <!-- End plugin js for this page -->
    <script>
    let sessionCount = 0;

    // Function to fetch variations based on selected muscle group
function fetchVariations(muscleGroupId, sessionCount) {
    // AJAX request to fetch variations
    $.ajax({
        url: '/fetch-variations', // Update with your route for fetching variations
        type: 'GET',
        data: { muscleGroupId: muscleGroupId },
        success: function(response) {
            // Populate the variation dropdown with fetched variations
            const variationSelect = document.getElementById(`variation_${sessionCount}`);
            variationSelect.innerHTML = ''; // Clear previous options
            response.forEach(function(variation) {
                const option = document.createElement('option');
                option.value = variation.id;
                option.textContent = variation.name;
                variationSelect.appendChild(option);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Function to add a new session
function addSession() {
    sessionCount++;

    const sessionContainer = document.getElementById('sessions-container');

    const sessionDiv = document.createElement('div');
    sessionDiv.className = 'form-group';
    sessionDiv.id = `session-${sessionCount}`;

    sessionDiv.innerHTML = `
        <h5>Session ${sessionCount}</h5>
        <div class="form-group">
            <label for="muscle_group_${sessionCount}">Muscle Group</label>
            <select class="form-control" id="muscle_group_${sessionCount}" onchange="fetchVariations(this.value, ${sessionCount})">
                @foreach ($muscleGroups as $mG)
                <option value="{{ $mG->id }}">{{ $mG->name }}</option>
                @endforeach
                <!-- Populate with options from database or predefined list -->
            </select>
        </div>
        <div class="form-group">
            <label for="variation_${sessionCount}">Variation</label>
            <select class="form-control" id="variation_${sessionCount}" name="sessions[${sessionCount}][variation]">
                <option value="">Select Variation</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sets_${sessionCount}">Sets</label>
            <input type="number" class="form-control" id="sets_${sessionCount}" name="sessions[${sessionCount}][sets]" value="">
        </div>
        <div class="form-group">
            <label for="reps_${sessionCount}">Reps</label>
            <input type="number" class="form-control" id="reps_${sessionCount}" name="sessions[${sessionCount}][reps]" value="">
        </div>
        <div class="form-group">
            <label for="weight_${sessionCount}">Weight</label>
            <input type="number" class="form-control" id="weight_${sessionCount}" name="sessions[${sessionCount}][weight]" value="">
        </div>
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-danger w-100" onclick="removeSession(${sessionCount})">Remove Session</button>
            </div>
        </div>
        <hr>
    `;

    sessionContainer.appendChild(sessionDiv);
}

// Function to remove a session
function removeSession(sessionId) {
    const sessionDiv = document.getElementById(`session-${sessionId}`);
    sessionDiv.remove();
}

// Function to reset the form
function resetForm() {
    document.querySelector('.forms-sample').reset();
    document.getElementById('sessions-container').innerHTML = '';
    sessionCount = 0;
}

    </script>
@endsection
