<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Picture;
use App\Winner;

class getWinnerForContest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do:getWinnerForContest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will get the winner of the previous month and put the winner on the homepage';

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
        $currentDay = Carbon::today();
        $currentDaySubbedWithMonth = Carbon::today()->submonth(1);
        $previousMonth = $currentDaySubbedWithMonth->format('F');

        $picture = new Picture;
        $allPicturesFromPreviousMonth = $picture->getAllPicturesFromPreviousMonth($currentDaySubbedWithMonth,$currentDay);
        $winningPicture_id = $allPicturesFromPreviousMonth->first()->picture_id;
        
        $winner = new Winner;
        $winner->picture_id = $winningPicture_id;
        $winner->month = $previousMonth;
        $winner->save();
    }
}
