<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Controller
{
    public function createForm(){
        $fileAll = File::all();

        return view("file-upload",compact ('fileAll'));
    }
    public function fileUpload(Request $request){
        $request->validate([
            "file"=> "required|mimes:csv,txt,pdf,wav,mp3,jpeg,png|max:20000",
        ]);
        
        $fileModel = new File();
        if($request->file()){
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads',$fileName,'public');
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/'.$filePath;
            $fileModel->save();
            
            return back()->with('success','File has been uploaded successfully!')->with('file',$fileName);
        }
        else{
            return back()->with('error','File could not be uploaded!');
        }
    }
    
    public function fileDownload($id){
        Log::info('Download method reached');
        $File = File::find($id);
        $file_name = $File->name;
        
        $file_path = '/Users/rudihamilton/FileTransferExample/storage/app/public/uploads/'.$file_name;
        // Storage::download("{$file_path}");
        return response()->download($file_path);
    }
}
