<?php

namespace App\Services\User;

use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

class UpdateUserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Logic to handle the data
     */
    public function handle($id)
    {
        try {
            $data = $this->data;
            if (isset($data['role'])) {
                $authId = Auth::id();
                if ($authId > $data['role']) {
                    return $this->errorResponse('Can not update role', []);
                }
            }
            $this->repository->update($id, $data);

            return $this->successResponse(__('Update success'), []);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }
}
