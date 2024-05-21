@if (!empty($workoutSession))
    <!-- Workout sessions data -->
    <div class="card">
        <div class="card-body">
        <h3>{{ $workout->notes }}</h3>
          <div class="table-responsive pt-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th> # </th>
                  <th> Group </th>
                  <th> Name </th>
                  <th><center> Sets </center></th>
                  <th><center> Reps </center></th>
                  <th> Weight </th>
                </tr>
              </thead>
              <tbody>
                    @foreach ($workoutSession as $session)
                    <tr>
                        <td> {{ $loop->iteration }} </td>
                        <td> {{ $session->variation->muscleGroup->name }} </td>
                        <td> {{ $session->variation->name }} </td>
                        <td> <center>{{ $session->sets }}</center></td>
                        <td> <center>{{ $session->reps }}</center></td>
                        <td> {{ $session->weight }} Kg</td>
                    </tr>
                    @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
@else
    <p>No workout sessions found.</p>
@endif
