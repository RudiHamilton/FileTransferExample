<?php

namespace App\Console\Commands;

use App\Models\File as FileModel;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class DeleteRedundantFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filefolder:wipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command wipes the public storage folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $destinationPath = '/Users/rudihamilton/FileTransferExample/storage/app/public/uploads/';

        $files = FileModel::all();
        foreach ($files as $file) {
            $filePath = $destinationPath . '/' . $file->name;
            echo('Deleting file: ' . $filePath);
        
            if (File::exists($filePath)) {
                echo('file exists you cannot run redundant file command');
            } else {
                File::delete($filePath);
                echo('File not found: ' . $filePath);
                Artisan::call('migrate:fresh');
            }
        }
    }
}
