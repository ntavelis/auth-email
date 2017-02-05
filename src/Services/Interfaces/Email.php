<?php
namespace Ntavelis\AuthEmail\Services\Interfaces;

interface Email {
    public function sendTo($user,$link);
}