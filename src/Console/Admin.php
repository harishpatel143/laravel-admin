<?php

namespace Multidots\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Admin extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the all the package required files.';

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
        $this->info('Welcome to Multidots Admin Panel');
        $this->info('Publishing Admin Controllers');
        $this->info('1. Publishing Admin Models');
        $this->admin();
        $this->info('2. Running migration');
        $this->call('migrate');
        $this->info('3. Create Role');
        $this->createRole();
        $this->info('4. Create Admin');
        $this->createAdmin();
        $code = Artisan::call('cache:clear');
        $this->info('command is run');
    }

    protected function publishPackageRequireFiles()
    {
        $this->info('publishPackageRequireFiles is run');
    }

    public function admin()
    {
        $this->callSilent('vendor:publish', [
            '--tag' => ['admin-controllers', 'admin-models', 'admin-views', 'admin-seeds', 'admin-migrations', 'admin-assets'],
            '--force' => true
        ]);
    }

    /**
     *  Create first user
     */
    public function createRole()
    {
        $this->info('Please enter role details');
        $data['name'] = $this->ask('Role name');
        $data['description'] = $this->ask('Role description');
        $data['role_id'] = 1;
        \App\Models\Role::create($data);
        $this->info('Role has been created');
    }

    /**
     *  Create first user
     */
    public function createAdmin()
    {
        $this->info('Please enter admin details');
        $data['first_name'] = $this->ask('First name');
        $data['last_name'] = $this->ask('Last name');
        $data['user_name'] = $this->ask('Enter username');
        $data['email'] = $this->ask('Email');
        $data['password'] = bcrypt($this->secret('Administrator password'));
        $data['avatar'] = 'default-user.png';
        $data['status'] = 1;
        $data['role_id'] = 1;
        \App\Models\Administrator::create($data);
        $this->info('Admin has been created');
    }

}
