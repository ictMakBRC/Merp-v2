<?php

namespace App\Data\User;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public ?int $employee_id;
    public ?string $name;
    public ?string $category;
    public ?string $email;
    public ?string $contact;
    public ?string $password;
    public ?string $is_active;
    public ?string $signature;

    public function __construct(?int $employee_id = null, ?string $name = null, ?string $category = null, ?string $email = null,?string $contact = null,?string $password = null, ?int $is_active = null,$signature=null)
    {
        $this->employee_id = $employee_id;
        $this->name = $name;
        $this->category = $category;
        $this->email = $email;
        $this->contact = $contact;
        $this->password = $password;
        $this->is_active = $is_active;
        $this->signature = $signature;
    }
}
