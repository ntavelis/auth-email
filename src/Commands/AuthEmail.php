<?php

namespace Ntavelis\AuthEmail\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Ntavelis\AuthEmail\Commands\Actions\Actions;
use Ntavelis\AuthEmail\Commands\Actions\ShouldQueue;

class AuthEmail extends Command {

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:email {--o|only : Do not run make:auth command. }
                                        {--m|migrate : After setup run migrations. }
                                        {--s|queue : The Activation Email should queue. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Email Authentication on top of artisan\'s make:auth command.';

    /**
     * @var Composer
     */
    private $composer;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @param Actions $actions
     */
    public function handle(Actions $actions)
    {
        /**
         * Unless flag --only is passed, call the `make:auth` artisan command.
         */
        if (!$this->option('only')) {
            $this->call('make:auth');
        }

        /**
         * If flag --queue is passed, make the mailable implement ShouldQueue interface.
         */
        if ($this->option('queue')) {
            ShouldQueue::$bool = true;
        }

        /**
         * We iterate through all the Actions and
         * execute run() method on each one.
         */
        foreach ($actions->actions as $action) {
            $action->run();
        }

        /**
         * If the flag --migrate is passed, call the `migrate` artisan command.
         */
        if ($this->option('migrate')) {
            $this->call('migrate');
        }

        $this->Success();
    }

    /**
     * Show success message and run composer dump-autoload.
     */
    private function Success()
    {
        $migrated = '';

        if ($this->option('migrate')) {
            $migrated = ' and migrated database';
        }

        $this->info('Email authentication generated successfully' . $migrated . '.');

        $this->composer->dumpAutoloads();
    }
}
