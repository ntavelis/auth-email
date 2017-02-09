<?php
namespace Ntavelis\AuthEmail\Commands\Actions;

class Actions {

    /**
     * Array which holds all the instances
     * of the action classes we pass through the constructor
     * @array actions
     */
    public $actions = [];

    /**
     * ExecuteActions constructor.
     * @param DeleteFiles $delete
     * @param CreateFiles $create
     * @param AppendsToFiles $append
     * @param ReplaceStringsToFiles $replace
     */
    public function __construct(DeleteFiles $delete, CreateFiles $create, AppendsToFiles $append, ReplaceStringsToFiles $replace)
    {
        array_push($this->actions, $delete, $create, $append, $replace);
    }
}
