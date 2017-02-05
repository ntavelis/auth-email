<?php

namespace Ntavelis\AuthEmail\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Ntavelis\AuthEmail\Commands\actions\AppendsToFiles;
use Ntavelis\AuthEmail\Commands\actions\CreateFiles;
use Ntavelis\AuthEmail\Commands\actions\DeleteFiles;

/**
 * Class AuthEmail
 * @package Ntavelis\emailauth\Commands
 */
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
                                        {--m|migrate : After setup run migrations. }';

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
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @param DeleteFiles $delete
     * @param CreateFiles $create
     * @param AppendsToFiles $append
     * @return mixed
     */
    public function handle(DeleteFiles $delete,CreateFiles $create,AppendsToFiles $append)
    {
        /**
         * Unless flag --only is passed, call the `make:auth` artisan command.
         */
        if(! $this->option('only')){
            $this->call('make:auth');
        }

        $delete->run();
        $create->run();
        $append->run();

        /**
         * If the flag --migrate is passed, call the `migrate` artisan command.
         */
        if($this->option('migrate')){
            $this->call('migrate');
        }

        $this->Success();
    }

    /**
     * Show success message and run composer dump-autoload.
     */
    private function Success()
    {
        $migrated='';

        if($this->option('migrate')){
            $migrated=' and migrated database';
        }

        $this->info('Email authentication generated successfully'.$migrated.'.');

        $this->composer->dumpAutoloads();
    }
}
