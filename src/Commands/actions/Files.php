<?php
namespace Ntavelis\AuthEmail\Commands\actions;

use Illuminate\Filesystem\Filesystem;

abstract class Files {

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Files constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
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
            'auth.email'   => $path . 'emails/auth.blade.php',
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
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Compile the migration stub.
     *
     * @param $fileName
     * @return string
     */
    protected function compileStub($fileName)
    {
        $stub = $this->filesystem->get(__DIR__ . '/../../stubs/' . $fileName . '.stub');

        return $stub;
    }

    /**
     * Append to a file a particular stub.
     * @param $file
     * @param $stub
     * @return int
     */
    protected function AppendTo($file, $stub)
    {
        return $this->filesystem->append(base_path() . '/routes/' . $file . '.php', $this->compileStub($stub));
    }

    /**
     * Every subclass must provide a run method.
     * @return mixed
     */
    abstract function run();
}