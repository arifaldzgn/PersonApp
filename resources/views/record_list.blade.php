@extends('main.main')

@section('css')
<link rel="stylesheet" href="{{ asset("assets/vendors/select2/select2.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css") }}">
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}

@endsection

@section('container')

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">May</h4>
        <p class="card-description"> Add class <code>.table-striped</code>
        </p>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> Date </th>
                <th> Notes </th>
                <th> Total Time </th>
                <th> Detail </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($workoutsMay as $may)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($may->date)->translatedFormat('l d F Y') }}</td>
                    <td>{{ $may->notes }}</td>
                    <td>1:37 Hours</td>
                    <td><button type="button" class="btn btn-primary view-sessions" data-toggle="modal" data-target="#sessionModal" data-workout-id="{{ $may->id }}">View</button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">February</h4>
        <p class="card-description"> Add class <code>.table-striped</code>
        </p>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> User </th>
                <th> First name </th>
                <th> Progress </th>
                <th> Amount </th>
                <th> Deadline </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-1">
                  <img src="../../assets/images/faces/face1.jpg" alt="image" />
                </td>
                <td> Herman Beck </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $ 77.99 </td>
                <td> May 15, 2015 </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sessionModalLabel">Workout Sessions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Session data will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <!-- Plugin js for this page -->
    <script src="{{ asset("assets/vendors/typeahead.js/typeahead.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/vendors/select2/select2.min.js") }}"></script>
    <script src="{{ asset("assets/js/select2.js") }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <script>

    $(document).ready(function() {
            // Show the respective session details when modal is shown
            $('#sessionModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var workoutId = button.data('workout-id'); // Extract workout ID from data attribute

                // Make AJAX request to fetch workout session data
                $.ajax({
                    url: '/workouts/' + workoutId + '/sessions',
                    type: 'GET',
                    success: function (response) {
                        // Update modal body with workout session data
                        $('.modal-body').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

    </script>

@endsection
