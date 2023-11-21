<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\StatMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Path;

class SendStatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendStat';

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
        $articleCount = Path::all()->count();
        Path::whereNotNull('id')->delete();
        $commentCount = Comment::whereDate('created_at', Carbon::today())->count();
        Log::alert(Carbon::today());
        Mail::to('moosbeere_O@mail.ru')->send(new StatMail($articleCount, $commentCount));
        return 0;
    }
}
