@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="chart">
                    </div>
                    <div id="wrapper">
                        <div class="content-area">
                          <div class="container-fluid">
                            <div class="text-right mt-3 mb-3 d-fixed">
                              <a
                                href="https://github.com/apexcharts/apexcharts.js/tree/master/samples/vanilla-js/dashboards/modern"
                                target="_blank"
                                class="btn btn-outline-primary mr-2"
                              >
                                <span class="btn-text">View Code</span>
                              </a>
                            </div>
                            <div class="main">
                              <div class="row sparkboxes mt-4 mb-4">
                                <div class="col-md-4">
                                  <div class="box box1">
                                    <div id="spark1"></div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="box box2">
                                    <div id="spark2"></div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="box box3">
                                    <div id="spark3"></div>
                                  </div>
                                </div>
                              </div>
                  
                              <div class="row mt-5 mb-4">
                                <div class="col-md-6">
                                  <div class="box">
                                    <div id="bar"></div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="box">
                                    <div id="donut"></div>
                                  </div>
                                </div>
                              </div>
                  
                              <div class="row mt-4 mb-4">
                                <div class="col-md-6">
                                  <div class="box">
                                    <div id="area"></div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="box">
                                    <div id="line"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <script>
                          var options = {
                              chart: {
                                  type: 'area'
                              },
                              series: [{
                                  name: 'تعداد',
                                  data: [{!! $songsCount !!}, {!! $usersCount !!}, {!! $artistsCount !!}, {!! $albumsCount !!}]
                              }],
                              xaxis: {
                                  categories: ["موسیقی ها", "کاربران", "هنرمندان", "آلبوم ها"]
                              }
                          }
                          
                          var chart = new ApexCharts(document.querySelector("#chart"), options);
                          
                          chart.render();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
