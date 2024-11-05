<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Repositories\Eloquent\Interfaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserIndexRequest $request
     * @return \Inertia\Response
     */
    public function index(UserIndexRequest $request): \Inertia\Response
    {
        $users = $this->userRepository->paginate($request);

        return Inertia::render('Admin/User/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        $roles = Role::all();

        return Inertia::render('Admin/User/CreateEdit', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $user = $this->userRepository->create($request->except('roles'));
        $user->syncRoles($request->input('roles'));

        session()->flash('success', __('pages.user.add_user_success'));

        return redirect()->route('backend.users.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        $user = $this->userRepository->find($id);
        $user->load('roles');
        $roles = Role::all();
        return Inertia::render('Admin/User/CreateEdit', ['user' => $user, 'roles' => $roles]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, int $id): RedirectResponse
    {
        $user = $this->userRepository->update($id, $request->all());
        $user->syncRoles($request->input('roles'));

        session()->flash('success', __('pages.user.edit_user_success'));

        return redirect()->route('backend.users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserDeleteRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(UserDeleteRequest $request, int $id): RedirectResponse
    {
        $this->userRepository->delete($id);

        session()->flash('success', __('pages.user.delete_user_success'));

        return redirect()->route('backend.users.index');
    }
}
