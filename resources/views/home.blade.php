@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div id="chart">
                        </div>
                        <div id="wrapper">
                            <div class="content-area">
                                <div class="container-fluid">
                                    <div class="text-right mt-3 mb-3 d-fixed">
                                        <a href="https://github.com/apexcharts/apexcharts.js/tree/master/samples/vanilla-js/dashboards/modern"
                                            target="_blank" class="btn btn-outline-primary mr-2">
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
                        <form action="{{ route('admin.notification') }}" method="POST">
                            @csrf
                            <table class="table table-striped " style="border-color: black;" border="1px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">اطلاع رسانی</th>
                                        <th class="text-center">فعال</th>
                                        <th class="text-center">غیرفعال</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>در زمان ایجاد، ویرایش، حذف موسیقی</td>
                                        <td>
                                            @if($adminNotifies)
                                                @if($adminNotifies->crud_on_songs)
                                                    ✅
                                                    <input type="hidden" class="custom-control-input" value="1" name="crud_on_songs" checked
                                                    onclick="form.submit();">
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="1" name="crud_on_songs"
                                                        onclick="form.submit();">
                                                @endif
                                            @else
                                                <input type="checkbox" class="custom-control-input" value="1" name="crud_on_songs" 
                                                onclick="form.submit();"> 
                                            @endif
                                        </td>
                                        <td>
                                            @if($adminNotifies)
                                                @if(!$adminNotifies->crud_on_songs)
                                                    ✅
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="0" name="crud_on_songs"
                                                        onclick="form.submit();">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>در زمان ایجاد، ویرایش، حذف هنرمند</td>
                                        <td>
                                            @if($adminNotifies)
                                                @if($adminNotifies->crud_on_artists)
                                                    ✅
                                                    <input type="hidden" class="custom-control-input" value="1" name="crud_on_artists" checked
                                                    onclick="form.submit();">
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="1" name="crud_on_artists"
                                                        onclick="form.submit();">
                                                @endif
                                            @else
                                                <input type="checkbox" class="custom-control-input" value="1" name="crud_on_artists" 
                                                onclick="form.submit();">
                                            @endif
                                        </td>
                                        <td>
                                            @if($adminNotifies)
                                                @if(!$adminNotifies->crud_on_artists)
                                                    ✅
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="0" name="crud_on_artists"
                                                        onclick="form.submit();">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>در زمان ایجاد، ویرایش، حذف آلبوم</td>
                                        <td>
                                            @if($adminNotifies)
                                                @if($adminNotifies->crud_on_albums)
                                                    ✅
                                                    <input type="hidden" class="custom-control-input" value="1" name="crud_on_albums" checked
                                                    onclick="form.submit();">
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="1" name="crud_on_albums"
                                                        onclick="form.submit();">
                                                @endif
                                            @else
                                                <input type="checkbox" class="custom-control-input" value="1" name="crud_on_albums" 
                                                onclick="form.submit();">
                                            @endif
                                        </td>
                                        <td>
                                            @if($adminNotifies)
                                                @if(!$adminNotifies->crud_on_albums)
                                                    ✅
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="0" name="crud_on_albums"
                                                        onclick="form.submit();">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>در زمان ایجاد، ویرایش، حذف کاربر</td>
                                        <td>
                                            @if($adminNotifies)
                                                @if($adminNotifies->crud_on_users)
                                                    ✅
                                                    <input type="hidden" class="custom-control-input" value="1" name="crud_on_users" checked
                                                    onclick="form.submit();">
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="1" name="crud_on_users"
                                                        onclick="form.submit();">
                                                @endif
                                            @else
                                                <input type="checkbox" class="custom-control-input" value="1" name="crud_on_users" 
                                                onclick="form.submit();">
                                            @endif
                                        </td>
                                        <td>
                                            @if($adminNotifies)
                                                @if(!$adminNotifies->crud_on_users)
                                                    ✅
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="0" name="crud_on_users"
                                                        onclick="form.submit();">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>در زمان ایجاد، ویرایش، حذف ژانر</td>
                                        <td>
                                            @if($adminNotifies)
                                                @if($adminNotifies->crud_on_tags)
                                                    ✅
                                                    <input type="hidden" class="custom-control-input" value="1" name="crud_on_tags" checked
                                                    onclick="form.submit();">
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="1" name="crud_on_tags"
                                                        onclick="form.submit();">
                                                @endif
                                            @else
                                                <input type="checkbox" class="custom-control-input" value="1" name="crud_on_tags" 
                                                onclick="form.submit();">
                                            @endif
                                        </td>
                                        <td>
                                            @if($adminNotifies)
                                                @if(!$adminNotifies->crud_on_tags)
                                                    ✅
                                                @else
                                                    <input type="checkbox" class="custom-control-input" value="0" name="crud_on_tags"
                                                        onclick="form.submit();">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <script src="{{ asset('js/apexchart.js') }}"></script>
                        <script>
                            var options = {
                                chart: {
                                    type: 'area'
                                },
                                series: [{
                                    name: 'تعداد',
                                    data: [{!! $songsCount !!}, {!! $usersCount !!}, {!! $artistsCount !!},
                                        {!! $albumsCount !!}
                                    ]
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
