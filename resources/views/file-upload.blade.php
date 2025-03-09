<x-layout>
    <div class="container">
        <div class="mt-5">
            <form action="{{route('fileUpload')}}" method="POST" enctype="multipart/form-data">
                <h3 class="text-center mb-5">Uploading File</h3>
                @csrf
                @if ($message = Session::get('Success'))
                    <div class="alert alert-success">
                        <strong>{{$message}}</strong>
                    </div>
                @endif
                @if (count($errors)>0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="custom-file"> 
                    <input type="file" name="file" class="custom-file-input" id="chooseFile">
                    <label for="chooseFile" class="custom-file-label">Select File</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-5">
                    Upload Files
                </button>
            </form>
        </div>
    </div>
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>File ID</th>
                    <th>File Name</th>
                    <th>File Type</th>
                    <th>Download/Delete File</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fileAll as $file)
                <tr>
                    <td>{{$file->id}}</td>
                    <td>{{$file->name}}</td>
                    <td>{{$file->file_type}}</td>
                    <td class="inline-block">
                        <form action="{{route('fileDownload',parameters: ['id' =>  $file->id])}}" method="GET" class="inline-block w-0 ">
                            @csrf
                            <button class="btn btn-primary btn-block mb-2" >Download</button>
                        </form>
                        <form action="{{route('deleteFile',parameters: ['id' =>  $file->id])}}" method="POST" class="inline-block w-0 ">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-block mb-2">Delete</button>
                        </form>
                        <form action="{{route('previewfiles',parameters: ['id' =>  $file->id])}}" method="POST" class="inline-block w-0 ">
                            @csrf
                            @method('GET')
                            <button class="btn btn-primary btn-block mb-2">Preview</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>