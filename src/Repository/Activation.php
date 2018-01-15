<?php

namespace Ntavelis\AuthEmail\Repository;

use Carbon\Carbon;
use Illuminate\Database\Connection;

/**
 * Class ActivationRepository
 * @package App
 */
class Activation implements ActivationInterface {

    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var string
     */
    protected $table = 'user_activations';

    /**
     * ActivationRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @return string
     */
    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    /**
     * @param $user
     * @return string
     */
    public function createActivation($user)
    {

        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }

        return $this->regenerateToken($user);

    }

    /**
     * @param $user
     * @return string
     */
    private function regenerateToken($user)
    {

        $token = $this->getToken();
        $this->db->table($this->table)->where('user_id', $user->id)->update([
            'token'      => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    /**
     * @param $user
     * @return string
     */
    private function createToken($user)
    {
        $token = $this->getToken();
        $this->db->table($this->table)->insert([
            'user_id'    => $user->id,
            'token'      => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    /**
     * @param $user
     * @return array|null|\stdClass
     */
    public function getActivation($user)
    {
        return $this->db->table($this->table)->where('user_id', $user->id)->first();
    }


    /**
     * @param $token
     * @return array|null|\stdClass
     */
    public function getActivationByToken($token)
    {
        return $this->db->table($this->table)->where('token', $token)->first();
    }

    /**
     * @param $token
     */
    public function deleteActivation($token)
    {
        $this->db->table($this->table)->where('token', $token)->delete();
    }

}