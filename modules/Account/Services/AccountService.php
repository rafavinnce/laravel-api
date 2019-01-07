<?php

namespace Modules\Account\Services;

use Carbon\Carbon;
use Laravel\Passport\TokenRepository;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepository;

class AccountService
{
    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * The token repository instance.
     *
     * @var TokenRepository
     */
    protected $tokenRepository;

    public function __construct(UserRepository $userRepository, TokenRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return User
     */
    public function find($id)
    {
        $token = $this->tokenRepository->find($id);

        if (empty($token) || $token->revoked || $token->expires_at < Carbon::now()) {
            abort(404);
        }

        return $this->userRepository->skipPresenter(false)->find($token->user->id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes)
    {
        unset($attributes['is_superuser'], $attributes['is_staff'], $attributes['is_active']);

        $entity = $this->userRepository->skipPresenter(true)->create($attributes);
        return $this->userRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return User
     */
    public function update(array $attributes, $id)
    {
        unset($attributes['is_superuser'], $attributes['is_staff'], $attributes['is_active']);

        $user = $this->find($id);
        $entity = $this->userRepository->skipPresenter(true)->find($user->id);
        $entity->update($attributes);
        return $this->userRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        $user = $this->find($id);
        return $this->userRepository->skipPresenter(true)->find($user->id)->delete();
    }

}