<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use Illuminate\Console\View\Components\TwoColumnDetail;

class createRole extends Command
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
            'SuperAdmin',
            'Admin',
            'Coach',
            'Sportif'
        ];

        foreach ($roles as $role) {

            try {
                $userRole = Role::create([
                    "name" => $role,
                ]);

                with(new TwoColumnDetail($this->getOutput()))->render(
                    '<fg=yellow;options=bold>ACTION : </>' . $userRole->nom,
                    '<fg=yellow;options=bold>ADDED</>'
                );
            } catch (\Exception $exception) {
                with(new TwoColumnDetail($this->getOutput()))->render(
                    '<fg=yellow;options=bold>ACTION : </>' . $exception->getMessage(),
                    '<fg=Red;options=bold>FAILED</>'
                );
            }
        }
    }
}
