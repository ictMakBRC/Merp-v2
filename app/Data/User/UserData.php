<?php

namespace App\Data\User;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public ?string $name;
    public ?string $category;
    public ?string $email;
    public ?string $password;
    public ?string $is_active;
    public ?string $signature;

    public function __construct(?string $name = null, ?string $category = null, ?string $email = null,?string $password = null, ?int $is_active = null,$signature=null)
    {
        $this->name = $name;
        $this->category = $category;
        $this->email = $email;
        $this->password = $password;
        $this->is_active = $is_active;
        $this->signature = $signature;
    }
}
