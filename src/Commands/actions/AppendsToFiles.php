<?php
namespace Ntavelis\AuthEmail\Commands\actions;

class AppendsToFiles extends Files {

    /**
     * Append to already existing files
     */
    public function run()
    {
        //Appends to routes file (Web.php)
        $this->AppendTo('Web', 'Routes');
    }
}