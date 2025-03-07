<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Controller
{
    public function createForm(){
        $fileAll = FileModel::all();

        return view("file-upload",compact ('fileAll'));
    }
    public function fileUpload(Request $request){
        $request->validate([
            "file"=> "required|mimes:csv,txt,pdf,wav,mp3,jpeg,png",
        ]);
        
        $fileModel = new FileModel();
        if($request->file()){
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads',$fileName,'public');
            $fileType = $request->file('file')->getClientOriginalExtension();
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/'.$filePath;
            $fileModel->file_type = $fileType;
            $fileModel->save();
            
            return back()->with('success','File has been uploaded successfully!')->with('file',$fileName);
        }
        else{
            return back()->with('error','File could not be uploaded!');
        }
    }
    
    public function fileDownload($id){
        Log::info('Download method reached');
        $File = FileModel::find($id);
        $file_name = $File->name;
        
        $file_path = '/Users/rudihamilton/FileTransferExample/storage/app/public/uploads/'.$file_name;
        // Storage::download("{$file_path}");
        return response()->download($file_path);
    }
    public function deleteFile($id){
        Log::info('Delete method reached');
        $File = FileModel::find($id);
        $file_name = $File->name;
        $file_path = '/Users/rudihamilton/FileTransferExample/storage/app/public/uploads/'.$file_name;
        File::exists($file_path);
        File::delete($file_path);
        FileModel::where('id',$id)->delete();
        return back()->with('Success','File Deleted successfully');
    }
    public function filePreview($id){
        Log::info('File preview reached');

        $file = FileModel::find($id);  // Ensure 'File' is your model
        if (!$file) {
            abort(404, 'File not found');
        }
    
        $file_name = $file->name;
        
        // Use Laravel's storage helper to get the correct public URL
        $file_path = asset('storage/uploads/' . $file_name);
    
        return view('preview-mp3-files', compact('file_path'));
        // Log::info('File preview reached');
        // $File = File::find($id);
        // $file_name = $File->name;
        // $file_path = '/Users/rudihamilton/FileTransferExample/storage/app/public/uploads/'.$file_name;
        // return view('preview-mp3-files',compact('file_path'));
    }
}
