@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    Hello {{Auth::user()->name}}!

                    <table colspan="4">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered date</th>
                            <th>Referred users</th>
                        </tr>
                        @foreach($users as $item)
                            <tr>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->email}}</td>
                                <td>{{ $item->created_at}}</td>
                                <td>{{ $item->referrals_count}}</td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection