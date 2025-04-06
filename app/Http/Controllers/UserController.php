<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return Inertia::render('User/Index', ['users' => $users]);
    }

    public function create()
    {
        return Inertia::render('User/Create', [
            'roles' => array_map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ], UserRole::cases())
        ]);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $this->userRepository->createUser([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('message', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Update', [
            'user' => $user,
            'roles' => array_map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ], UserRole::cases())
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $this->userRepository->updateUser($user, $updateData);

        return redirect()->route('users.index')->with('message', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $this->userRepository->deleteUser($user);
        return redirect()->route('users.index')->with('message', 'User deactivated successfully!');
    }

    public function restore($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $this->authorize('restore', $user);

        $this->userRepository->restoreUser($user);
        return redirect()->back()->with('message', 'User restored successfully!');
    }

    public function forceDelete($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $this->authorize('forceDelete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot permanently delete your own account!');
        }

        $this->userRepository->forceDeleteUser($user);
        return redirect()->route('users.index')->with('message', 'User permanently deleted!');
    }
}