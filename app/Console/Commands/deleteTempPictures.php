<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use File;

class deleteTempPictures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do:deleteTempPictures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'With this command all temporary pictures that have been made will be deleted';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $allFiles = File::allFiles('img/tempPictures');
        foreach($allFiles as $key => $filePath){
            $fileName = basename($filePath); //This is used to get the filename 
            $fileNameArray = explode("-", $fileName); //This is used to split the fileName, to get the timestamp
            $timestampFileAddedWithHour = $fileNameArray[0] + 3600; //We will add 1 hour to the timestamp
            $currentTime = Carbon::now()->timestamp;

            //If There is more than 1 hour past since the creation of the file, the file will be deleted.
            if($currentTime > $timestampFileAddedWithHour){ 
                unlink($filePath);
                echo "File deleted";
            } 
        }
    }
}
