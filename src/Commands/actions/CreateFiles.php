<?php
namespace Ntavelis\AuthEmail\Commands\actions;

class CreateFiles extends Files {

    /**
     * Generate our own files.
     */
    public function run()
    {
        //Create controller files
        foreach ($this->getControllers() as $fileName => $filePath) {
            $this->makeDirectory($filePath);
            $this->filesystem->put($filePath, $this->compileStub($fileName));
        }

        //Create blades
        foreach ($this->getBlades() as $fileName => $filePath) {
            $this->makeDirectory($filePath);
            $this->filesystem->put($filePath, $this->compileStub($fileName));
        }

        //Create migration files
        foreach ($this->getMigrations() as $fileName => $filePath) {
            $this->filesystem->put($filePath, $this->compileStub($fileName));
        }

        //Create language files
        foreach ($this->getLanguages() as $fileName => $filePath) {
            $this->filesystem->put($filePath, $this->compileStub($fileName));
        }
    }
}