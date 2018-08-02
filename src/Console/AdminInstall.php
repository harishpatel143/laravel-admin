<?php

namespace Multidots\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AdminInstall extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'multidots-admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install admin panel';

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
        $this->info('1. Publishing Admin Controllers, Models, Views and Migrations');
        $this->publishAdminFile();
        $this->info('2. Running migration');
        $this->call('migrate');
        $this->info('3. Append routes to web.php');
        $this->appendRoutes();
        $this->removeTempFile();
        $this->info('4. Create Role');
        $this->createRole();
        $this->info('5. Create Admin');
        $this->createAdmin();
        Artisan::call('cache:clear');
        $this->info('Package install successfuly.');
        $this->info('Run on -> http://127.0.0.1:8000/admin/ ');
    }

    /**
     * Publishing all the file from service provider.
     */
    public function publishAdminFile()
    {
        $this->callSilent('vendor:publish', [
            '--tag' => ['admin-controllers', 'admin-models', 'admin-views', 'admin-seeds', 'admin-migrations', 'admin-assets', 'admin-request', 'admin-config', 'admin-helper','admin-traits'],
            '--force' => true
        ]);
        $this->info('Files published successfully.');
    }

    /**
     *  Create first user
     */
    public function createRole()
    {
        $this->info('Please enter role details');
        $data['name'] = $this->ask('Role name');
        $data['description'] = $this->ask('Role description');
        $data['status'] = 1;
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
        $data['password'] = $this->secret('Administrator password');
        $data['avatar'] = 'default-user.png';
        $data['status'] = 1;
        $data['role_id'] = 1;
        \App\Models\Administrator::create($data);
        $this->info('Admin has been created');
    }

    /**
     * Append routes  to web.php from package.
     */
    public function appendRoutes()
    {
        file_put_contents(base_path('routes/web.php'), file_get_contents(__DIR__ . '/../routes/web.stub'), FILE_APPEND);
    }

    /**
     * 
     * @param type $names
     */
    public function removeTempFile()
    {
        $dir = public_path() . '/Temp/';
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}
