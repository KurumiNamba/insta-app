@extends('layouts.app')

@section('title', 'Users')

@section('content')
<h3><a href="{{route('reports')}}" class="text-decoration-none text-dark"><i class="fa-solid fa-chart-line"></i> Reports</a></h3>
<h4><i class="fa-solid fa-arrow-right-long ms-3"></i> Users</h4>

<div class="row mt-3">
    <div class="col-4 text-center">
        <p class="fw-bold">Total Accounts</p>
        <p class="fw-bold fs-3">{{count($all_users)}}</p>
    </div>
    <div class="col-4 text-center">
        <p class="fw-bold">Accounts Created This Week</p>
        <p class="fw-bold fs-3">{{count($weeks_users)}}</p>
    </div>
    <div class="col-4 text-center">
        <p class="fw-bold">Accounts Creted Today</p>
        <p class="fw-bold fs-3">{{count($todays_users)}}</p>
    </div>
</div>

<div class="row mt-5">
    <h4><i class="fa-solid fa-ranking-star icon-sm"></i> Top Users</h4>
    <span class="small">*Users with many followers.</span>
</div>
{{-- @for ($i = 0; $i < 5; $i++)
    @if ($popular_users[$i]->avatar)
        <img src="{{$popular_users[$i]->avatar}}" alt="" class="avatar-md rounded-circle">
    @else
        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
    @endif
@endfor --}}
<div class="container mt-5">

    <canvas id="histogramChart" width="400" height="200"></canvas>
</div>

<script>
    const ctx = document.getElementById('histogramChart').getContext('2d');

    
    const labels = @json($user_names);
    const dataCounts = @json($follower_counts);

    const histogramChart = new Chart(ctx, {
        type: 'bar', // ヒストグラムのタイプ
        data: {
            labels: labels,
            datasets: [{
                label: 'Followers Count',
                data: dataCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Followers'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Users'
                    }
                }
            }
        }
    });
</script>

<h4 class="mt-4">Details</h4>
<table class="table">
    @foreach ($popular_users as $user)
    <tr>
        <td class="fs-4 text-center">
            @if ($loop->first)
            <p class="mt-3"><i class="fa-solid fa-crown"></i> 1</p>
            @elseif($loop->iteration == 2)
            <p class="mt-3">2</p>
            @elseif($loop->iteration == 3)
            <p class="mt-3">3</p>
            @endif
        </td>
    <td>
        @if ($user->avatar)
            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-md">
        @else
        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
        @endif
    </td>
    <td>
        <p class="fw-bold mt-4">{{$user->name}}</p>
    </td>
    <td>
        <p class="fw-bold mt-4">{{$user->followers()->count()}} Followers</p>
    </td>
    <td>
        <p class="mt-4">{{$user->following()->count()}} Following</p>
    </td>
    <td>
        <p class="mt-4"><a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark">See Profile <i class="fa-solid fa-angle-right"></i></a></p>
    </td>
    </tr>
    @endforeach
</table>

<h4 class="mt-4">New Users</h4>
<table class="table">
    
</table>
@endsection