<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\LandingPage\Entities\LandingPage;
class charge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge-lead';

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
        $plans = DB::table('plans')->first();
      
        $current_date =\Carbon\Carbon::now()->addDays(1); 
        $test= $current_date->toDateString(); 
        $firstDay = $current_date->firstOfMonth();
        $fs1= $firstDay->toDateString();  
        $lastDay=$current_date->lastOfMonth()->addDays(1); 
        $test2= $lastDay->toDateString(); 
        
        $data = LandingPage::get();
        // dd($data);
        foreach($data as $d)
        {
            $lead_count=count($d->formdata->whereBetween('created_at', [$fs1, $test2]));
            if($lead_count<1000)
            {
                if($d->user->wallet>1)
               {
                $d->user->wallet=($d->user->wallet)-($plans->charge_per_lead);
                 $d->user->save();
               }
               else
               if($d->user->is_admin==0)
               {
                // return redirect('/dashboard')
                // ->withErrors('Your wallet is empty! make payment first.');
               }
              

            }
            else
            {
                if($lead_count>1000)
                {
                    if($d->user->wallet>1)
                    {
                        $d->user->wallet=($d->user->wallet)-($plans->charge_per_lead);
                        $d->user->save();
                    }
                    else
                    if($d->user->is_admin==0)
                    {
                        // return redirect('/dashboard')
                        //     ->withErrors('Your wallet is empty! make payment first.');
                    }
                   
                }     
            }
        }
        
      
        // return redirect('/dashboard');
    }
}
