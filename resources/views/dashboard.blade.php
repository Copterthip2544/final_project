<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello! , {{Auth::user()->name}}

            <b class="float-end">Number of admins : <b class="text-danger">{{count($users)}}</b></b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Account creation date</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($users as $row)
                    <tr>
                    <th>{{$i++}}</th>
                    <td>{{$row->name}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            
            </div>
        </div>
    </div>
</x-app-layout>
