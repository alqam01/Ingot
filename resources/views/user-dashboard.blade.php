@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    Hello {{Auth::user()->name}}!

                    <ul class="list-group mt-3">
                        <li class="list-group-item">Referral link: {{ Auth::user()->referral_link }}</li>
                        <li class="list-group-item">Refferal registered count: {{ count(Auth::user()->referrals)  ?? '0' }}</li>
                        <li class="list-group-item">Refferal visitors count: {{ Auth::user()->referral_views }}</li>
                        @if(!$users->isEmpty())
                            <li class="list-group-item">Refferal registered data
                                <table colspan="2">
                                    <tr>
                                        <th>Name</th>
                                        <th>Registered date</th>
                                    </tr>
                                    @foreach($users as $item)
                                        <tr>
                                            <td>{{ $item->name}}</td>
                                            <td>{{ $item->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                {!! $users->links() !!}
                            </li>
                        @endif

                            <div class="chart-container">
                                <div class="pie-chart-container">
                                <canvas id="pie-chart"></canvas>
                                </div>
                            </div>
                            <script>
                                counts = <?php echo $counts; ?>;
                                var dates = <?php echo $dates; ?>;
                                var barChartData = {
                                    labels: dates,
                                    datasets: [{
                                        label: 'User',
                                        backgroundColor: "pink",
                                        data: counts
                                    }]
                                };

                                window.onload = function() {
                                    var ctx = document.getElementById("pie-chart").getContext("2d");
                                    window.myBar = new Chart(ctx, {
                                        type: 'bar',
                                        data: barChartData,
                                        options: {
                                            elements: {
                                                rectangle: {
                                                    borderWidth: 2,
                                                    borderColor: '#c1c1c1',
                                                    borderSkipped: 'bottom'
                                                }
                                            },
                                            responsive: true,
                                            title: {
                                                display: true,
                                                text: 'Last 14 days referrer registration'
                                            }
                                        }
                                    });
                                };
                            </script>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection