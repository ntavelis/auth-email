<?php
namespace Ntavelis\AuthEmail\Commands\actions;


class ReplaceStringsToFiles extends Files {

    /**
     * Every subclass must provide a run method.
     * @return mixed
     */
    public function run()
    {
        $this->replaceAndSave(
            base_path() . "/resources/lang/en/validation.php",
            "'alpha_num'            => 'The :attribute may only contain letters and numbers.',",
            "'alpha_num'            => 'The :attribute may only contain letters and numbers.',\n    'alpha_spaces'         => 'The :attribute can contain only alphanumeric characters and spaces.',"
        );
    }
}