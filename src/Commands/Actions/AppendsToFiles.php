<?php
namespace Ntavelis\AuthEmail\Commands\Actions;

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