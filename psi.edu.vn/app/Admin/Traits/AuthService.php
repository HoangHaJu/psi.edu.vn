<?php

namespace App\Admin\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait AuthService
{

    /**
     * Get the ID of the currently authenticated user.
     *
     * @return int|null
     */
    public function getCurrentUserId(): ?int
    {
        return Auth::id();
    }

    /**
     * Check if the current user is authenticated.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function getCurrentUser(): ?Authenticatable
    {
        return Auth::user();
    }

    /**
     * Get the role of the currently authenticated user.
     *
     * @return string|null
     */
    public function getCurrentUserRole(): ?string
    {
        $user = $this->getCurrentUser();
        return $user?->roles;
    }

    public function getCurrentAdmin(): ?Authenticatable
    {
        return Auth::guard('admin')->user();
    }

    public function getCurrentAdminId(): ?int
    {
        return Auth::guard('admin')->id();
    }

    public function getCurrentStudent(): ?Authenticatable
    {
        $user = Auth::guard('admin')->user(); // Adjust the guard name if needed
        return $user && $user->isStudent ? $user : null;
    }

    /**
     * Get the current teacher.
     *
     * @return Authenticatable|null
     */
    public function getCurrentTeacher(): ?Authenticatable
    {
        $user = Auth::guard('admin')->user(); // Adjust the guard name if needed
        return $user && $user->isTeacher ? $user : null;
    }

    /**
     * Get the current super admin.
     *
     * @return Authenticatable|null
     */
    public function getCurrentSuperAdmin(): ?Authenticatable
    {
        $user = Auth::guard('admin')->user(); // Adjust the guard name if needed
        return $user && $user->isSuperAdmin ? $user : null;
    }
}
