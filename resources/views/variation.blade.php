@extends('main.main')

@section('css')
<link rel="stylesheet" href="{{ asset("assets/vendors/select2/select2.min.css") }}">
<link rel="stylesheet" href="{{ asset("assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css") }}">
@endsection

@section('container')
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">All variation for {{$muscle->name}}</h4>
            <p class="card-description"> Add class <code>.table</code>
            </p>
            <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Equipment</th>
                    <th>Difficulty</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data as $v)
                    <tr>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->description }}</td>
                        <td>{{ $v->equipment }}</td>
                        @if( $v->difficulty == 'Easy' )
                            <td><label class="badge badge-info">{{ $v->difficulty }}</label></td>
                        @elseif( $v->difficulty == 'Medium' )
                            <td><label class="badge badge-warning">{{ $v->difficulty }}</label></td>
                        @elseif( $v->difficulty == 'Hard' )
                            <td><label class="badge badge-danger">{{ $v->difficulty }}</label></td>
                        @else
                            <td><label class="badge badge-dark">{{ $v->difficulty }}</label></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Variation</h4>
            <p class="card-description"> Add your new form variation for {{ $muscle->name }} </p>
            <form class="forms-sample" method="POST" action="{{ route('addVariation') }}">
            @csrf
              <div class="form-group">
                <label for="muscle">Muscle Group</label>
                <input type="text" class="form-control" id="muscle" value="{{ $muscle->name }}" disabled>
            </div>
            <input type="hidden" class="form-control" id="muscle_group_id" name="muscle_group_id" value="{{ $muscle->id }}">
              <div class="form-group">
                <label for="name">Variation name</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description">
              </div>
              <div class="form-group">
                <label for="equipment">Equipment</label>
                <input type="text" class="form-control" id="equipment" name="equipment">
              </div>
              <div class="form-group">
                <label for="difficulty">Difficulty</label>
                <select name="difficulty" class="form-select" id="difficulty">
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                    <option value="Advanced">Advanced</option>
                </select>
              </div>
              <div class="form-group">
                <label>Muscle Hit</label>
                <select class="js-example-basic-multiple w-100" multiple="multiple" name="muscle_hit[]">
                  <option value="AL">Alabama</option>
                  <option value="WY">Wyoming</option>
                  <option value="AM">America</option>
                  <option value="CA">Canada</option>
                  <option value="RU">Russia</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary me-2">Submit</button>
              <button class="btn btn-light">Cancel</button>
            </form>
          </div>
        </div>
      </div>

@endsection

@section('script')
    <!-- Plugin js for this page -->
    <script src="{{ asset("assets/vendors/typeahead.js/typeahead.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/vendors/select2/select2.min.js") }}"></script>
    <script src="{{ asset("assets/js/select2.js") }}"></script>
    <!-- End plugin js for this page -->
@endsection
