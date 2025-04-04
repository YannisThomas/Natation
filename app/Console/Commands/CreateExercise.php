<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use Illuminate\Console\Command;
use Illuminate\Console\View\Components\TwoColumnDetail;

class CreateExercise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-exercise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Création des exercices par défaut';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $exercise = Exercise::create([
                'name' => 'Etirement',
                'category_id' => 1,

            ]);

            with(new TwoColumnDetail($this->getOutput()))->render(
                '<fg=yellow;options=bold>ACTION : </>'.$exercise->nom,
                '<fg=yellow;options=bold>ADDED</>'
            );
        } catch (\Exception $e) {
            echo $e->getMessage();

            with(new TwoColumnDetail($this->getOutput()))->render(
                '<fg=yellow;options=bold>ACTION : </>'.'ECHEC',
                '<fg=red;options=bold>FAILED</>'
            );
        }
    }
}
