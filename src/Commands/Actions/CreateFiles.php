<?php

namespace Ntavelis\AuthEmail\Commands\Actions;

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

        //Create activation mail, if the --queue flag is passed, then it implements the ShouldQueue interface.
        foreach ($this->getEmails() as $fileName => $filePath) {
            $this->makeDirectory($filePath);
            $stub = $this->filesystem->get(__DIR__ . '/../../stubs/' . $fileName . '.stub');

            $this->filesystem->put($filePath, $this->replaceShouldQueue($stub));
        }

        //Create language files
        foreach ($this->getLanguages() as $fileName => $filePath) {
            $this->filesystem->put($filePath, $this->compileStub($fileName));
        }
    }
}