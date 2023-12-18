<?php
namespace App\Services\User;

use App\Data\User\UserData;
use App\Models\User;

class UserService
{

    public function createUser(UserData $userData): User
    {
        $user = new User([
            'employee_id' => $userData->employee_id,
            'name' => $userData->name,
            'category' => $userData->category,
            'email' => $userData->email,
            'contact' => $userData->contact,
            'password' => $userData->password,
            'is_active' => $userData->is_active,
            'signature' => $userData->signature,
        ]);

        // Save the user to the database
        $user->save();

        // You can perform additional logic or actions after creating the user

        return $user;
    }

    public function updateUser(User $user, UserData $userData): User
    {
        $user->name = $userData->name ?? $user->name;
        $user->category = $userData->category ?? $user->category;
        $user->email = $userData->email ?? $user->email;
        $user->contact = $userData->contact ?? $user->contact;
        $user->is_active = $userData->is_active ?? $user->is_active;
        $user->signature = $userData->signature ?? $user->signature;

        // Update the user in the database
        $user->save();

        // You can perform additional logic or actions after updating the user

        return $user;
    }
}