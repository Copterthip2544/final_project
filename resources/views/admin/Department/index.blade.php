<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello! , {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session("success"))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <center>
                                    Department Lists
                                </center>
                            </h4>   
                        </div>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                    <th scope="col"><center>No.</center></th>
                                    <th scope="col"><center>Departments</center></th>
                                    <th scope="col"><center>Edit</center></th>
                                    <th scope="col"><center>Delete</center></th>
                                    <th scope="col">Recorder</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>         
                                    @foreach($departments as $row)
                                    <tr>
                                    <th><center>{{$departments->firstItem()+$loop->index}}</center></th>
                                    <td>{{$row->department_name}}</td>
                                    <td><center><a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-warning">Edit</a></center></td>
                                    <td><center><a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-danger ">Delete</a></center></td>
                                    <td>{{$row->user->name}}</td>
                                    
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>            
                        {{$departments->links()}}
                    </div>
                        @if(count($trashDepartments))
                            <div class="card my-2">
                                <div class="card-header">
                                    <h4>
                                        <center>
                                            Trash
                                        </center>
                                    </h4>   
                                </div>
                                    <table class="table table-bordered">
                                        <thead class="table-danger">
                                            <tr>
                                            <th scope="col"><center>No.</center></th>
                                            <th scope="col"><center>Departments</center></th>
                                            <th scope="col"><center>Restore</center></th>
                                            <th scope="col"><center>Permanent Delete</center></th>
                                            <th scope="col">Recorder</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>         
                                            @foreach($trashDepartments as $row)
                                            <tr>
                                            <th><center>{{$trashDepartments->firstItem()+$loop->index}}</center></th>
                                            <td>{{$row->department_name}}</td>
                                            <td><center><a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-warning">Restore</a></center></td>
                                            <td><center><a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">Delete</a></center></td>
                                            <td>{{$row->user->name}}</td>
                                            
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$trashDepartments->links()}}
                            </div>
                        @endif

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Department Form</div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">Department</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <!-- <center> -->
                                <input type="submit" value="Save" class="btn btn-success">
                                <!-- </center> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
