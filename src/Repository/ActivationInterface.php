<?php

namespace Ntavelis\AuthEmail\Repository;


interface ActivationInterface {

    public function getActivation($user);

    public function getActivationByToken($token);

    public function deleteActivation($user);

    public function createActivation($user);

}