@extends('main.main')

@section('container')
<div class="col-sm-12">
    <div class="home-tab">
      <div class="tab-content tab-content-basic">
          <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
              <div class="row">
                  <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                  <h4 class="card-title card-title-dash">Chest</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                  </div>
                                  <div id="performanceLine-legend"></div>
                              </div>
                                <div class="container">
                                    <canvas id="progressiveOverloadChartChest" width="200" height="50"></canvas>
                                    <div id="performanceLine-legend"></div>
                                </div>
                              </div>
                          </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                  <h4 class="card-title card-title-dash">Back</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                  </div>
                                  <div id="performanceLine-legend"></div>
                              </div>
                                <div class="container">
                                    <canvas id="progressiveOverloadChartBack" width="200" height="50"></canvas>
                                    <div id="performanceLine-legend"></div>
                                </div>
                              </div>
                          </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                  <h4 class="card-title card-title-dash">Legs</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                  </div>
                                  <div id="performanceLine-legend"></div>
                              </div>
                                <div class="container">
                                    <canvas id="progressiveOverloadChartLegs" width="200" height="50"></canvas>
                                    <div id="performanceLine-legend"></div>
                                </div>
                              </div>
                          </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                  <h4 class="card-title card-title-dash">Arms</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                  </div>
                                  <div id="performanceLine-legend"></div>
                              </div>
                                <div class="container">
                                    <canvas id="progressiveOverloadChartArms" width="200" height="50"></canvas>
                                    <div id="performanceLine-legend"></div>
                                </div>
                              </div>
                          </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                  <h4 class="card-title card-title-dash">Shoulders</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                  </div>
                                  <div id="performanceLine-legend"></div>
                              </div>
                                <div class="container">
                                    <canvas id="progressiveOverloadChartShoulders" width="200" height="50"></canvas>
                                    <div id="performanceLine-legend"></div>
                                </div>
                              </div>
                          </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                              <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                  <h4 class="card-title card-title-dash">Abs</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                  </div>
                                  <div id="performanceLine-legend"></div>
                              </div>
                                <div class="container">
                                    <canvas id="progressiveOverloadChartAbs" width="200" height="50"></canvas>
                                    <div id="performanceLine-legend"></div>
                                </div>
                              </div>
                          </div>
                          </div>
                      </div>
                  </div>
                 </div>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@section('script')

<script>
    // Chest
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChartChest').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekDataChest }}, {{ $thisWeekDataChest }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });

    // Back
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChartBack').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekDataBack }}, {{ $thisWeekDataBack }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });

    // Legs
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChartLegs').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekDataLegs }}, {{ $thisWeekDataLegs }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });

    // Arms
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChartArms').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekDataArms }}, {{ $thisWeekDataArms }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });

    // Shoulders
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChartShoulders').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekDataShoulders }}, {{ $thisWeekDataShoulders }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });

    // Abs
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressiveOverloadChartAbs').getContext('2d');
        const data = {
            labels: ['Last Week', 'This Week'],
            datasets: [{
                label: 'Total Weight Lifted (kg)',
                data: [{{ $lastWeekDataAbs }}, {{ $thisWeekDataAbs }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });


</script>
@endsection
