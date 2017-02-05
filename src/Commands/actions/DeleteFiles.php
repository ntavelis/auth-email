<?php
namespace Ntavelis\AuthEmail\Commands\actions;

class DeleteFiles extends Files {

    /**
     * Delete some of the files created by auth:make.
     */
    public function run()
    {
        //Deletes make:auth controllers
        $this->filesystem->delete($this->getControllers());

        //Deletes blades
        $this->filesystem->delete($this->getBlades());
    }
}