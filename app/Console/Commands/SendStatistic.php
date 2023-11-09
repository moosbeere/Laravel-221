<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\StatMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Path;
use Carbon\Carbon;
use App\Models\Comment;



class SendStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendStatistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $countShowArticle = Path::all()->count();
        Log::alert($countShowArticle);
        Path::whereNotNull('id')->delete();
        $countComment = Comment::whereDate('created_at', Carbon::today())->count();
        Mail::to('moosbeere_O@mail.ru')->send(new StatMail($countShowArticle, $countComment));
    }
}
