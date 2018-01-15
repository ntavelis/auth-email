<?php

namespace Ntavelis\AuthEmail\Commands\Actions;

use Illuminate\Filesystem\Filesystem;

abstract class Files extends FilesInteractions {

    /**
     * Files constructor.
     * @param Filesystem $filesystem
     * @param ShouldQueue $queue
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct($filesystem);
    }

    /**
     * Get the paths to the make:auth generated controllers of interest.
     * @return array
     */
    protected function getControllers()
    {
        $path = base_path() . '/app/Http/Controllers/Auth/';
        $files = [
            'LoginController'    => $path . 'LoginController.php',
            'RegisterController' => $path . 'RegisterController.php',
        ];

        return $files;
    }

    /**
     * Get the path to the blade login file.
     *
     * @return array
     */
    protected function getBlades()
    {
        $path = base_path() . '/resources/views/';
        $files = [
            'login.blade' => $path . 'auth/login.blade.php',
            'auth.email'  => $path . 'emails/auth.blade.php',
        ];

        return $files;
    }

    /**
     * Get controllers directory path.
     * @return array
     */
    protected function getLanguages()
    {
        $path = base_path() . '/resources/lang/en/';
        $files = [
            'lang.authEmail' => $path . 'authEmail.php',
        ];

        return $files;
    }

    /**
     * Get the path to the migrations location.
     *
     * @return array
     */
    protected function getMigrations()
    {
        $formatted_date = date('Y_m_d_His');
        $path = base_path() . '/database/migrations/';
        $files = [
            'MigrationActivations' => $path . $formatted_date . '_create_user_activations_table.php',
            'MigrationUsers'       => $path . $formatted_date . '_add_boolean_column_to_users_table.php'
        ];

        return $files;
    }

    /**
     * Get the path to the blade login file.
     *
     * @return array
     */
    protected function getEmails()
    {
        $path = base_path() . '/app/Mail/';
        $files = [
            'ActivationEmail' => $path . 'ActivateAccount.php',
        ];

        return $files;
    }


    /**
     * Every subclass must provide a run method.
     * @return mixed
     */
    public abstract function run();
}