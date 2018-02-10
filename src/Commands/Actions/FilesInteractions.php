<?php
/**
 * Created by PhpStorm.
 * User: Thanasis
 * Date: 07/02/2017
 * Time: 10:44
 */

namespace Ntavelis\AuthEmail\Commands\Actions;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;

abstract class FilesInteractions {

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Holds the Laravel's framework version
     * @var float
     */
    protected $laravelVersion;

    /**
     * Files constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->laravelVersion = (float) Container::getInstance()->version();
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
     * Replace the {{ShouldQueue}} from Activation mail template.
     * @param $stub
     * @return $this
     */
    protected function replaceShouldQueue(&$stub)
    {
        if (ShouldQueue::$bool) {
            return $stub = str_replace('{{ShouldQueue}}', 'implements ShouldQueue', $stub);
        }

        return $stub = str_replace('{{ShouldQueue}}', '', $stub);
    }

    /**
     * Open haystack, find and replace needles, save haystack.
     *
     * @param  string $oldFile The haystack
     * @param  mixed $search String or array to look for (the needles)
     * @param  mixed $replace What to replace the needles for?
     * @param  string $newFile Where to save, defaults to $oldFile
     *
     * @return void
     */
    public function replaceAndSave($oldFile, $search, $replace, $newFile = null)
    {
        if (!isset($newFile) || $newFile == null) {
            $newFile = $oldFile;
        }
        $file = $this->filesystem->get($oldFile);
        $replacing = str_replace($search, $replace, $file);
        $this->filesystem->put($newFile, $replacing);
    }
}