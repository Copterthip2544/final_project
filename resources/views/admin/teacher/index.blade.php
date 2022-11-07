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
                                    Teachers
                                </center>
                            </h4>   
                        </div>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                    <!-- <th scope="col"><center>ลำดับ</center></th> -->
                                    <th scope="col"><center>Picture</center></th>
                                    <th scope="col"><center>Title</center></th>
                                    <th scope="col"><center>Name</center></th>
                                    <th scope="col"><center>Delete</center></th>
                                    <th scope="col">Recording time</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>         
                                    @foreach($teachers as $row)
                                    <tr>
                                    <!-- <th><center>{{$teachers->firstItem()+$loop->index}}</center></th> -->
                                    <td><center><img src="{{asset($row->teacher_image )}}" alt="" width="100" height="100"></center></td>
                                    <td><center>{{$row->teacher_id}}</center></td>
                                    <td><center>{{$row->teacher_name}}</center></td>
                                    <td>
                                        <center>
                                            <a href="{{url('/teacher/delete/'.$row->id)}}" 
                                                class="btn btn-danger" 
                                                onclick="return confirm('Want to delete this information ? *The data will not be recovered.*')">Delete
                                            </a>
                                        </center>
                                    </td>
                                    <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                                    
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>            
                        {{$teachers->links()}}
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Teacher Form</div>
                        <div class="card-body">
                            <form action="{{route('addTeacher')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="teacher_name">Title</label>
                                    <input type="text" class="form-control" name="teacher_id">
                                </div>
                                @error('teacher_id')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="teacher_name">Name</label>
                                    <input type="text" class="form-control" name="teacher_name">
                                </div>
                                @error('teacher_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="teacher_image">Picture</label>
                                    <input type="file" class="form-control" name="teacher_image">
                                </div>
                                @error('teacher_image')
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
