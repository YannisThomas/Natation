<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use Illuminate\Console\View\Components\TwoColumnDetail;

class CreateRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roles = [
            'superAdmin',
            'admin',
            'coach',
            'sportif',
        ];

        foreach ($roles as $role) {
            try {
                $role = Role::create([
                    'name' => $role,
                ]);
                with(new TwoColumnDetail($this->getOutput()))->render(
                    '<fg=yellow;options=bold>ACTION : </>' . $role->name,
                    '<fg=yellow;options=bold>ADDED</>'
                );
            } catch (\Exception $exception) {
                echo $exception->getMessage();
                with(new TwoColumnDetail($this->getOutput()))->render(
                    '<fg=yellow;options=bold>ACTION : </>' . "ECHEC",
                    '<fg=red;options=bold>FAILED</>'
                );
            }
        }
    }
}
