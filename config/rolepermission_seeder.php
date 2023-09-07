<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => env('LARATRUST_CREATE_USERS', false),

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => env('LARATRUST_TRUNCATE_TABLES', false),

    /**
     * Control if all the laratrust pivot tables should be truncated before running the seeder.
     */
    'truncate_pivot_tables' => env('LARATRUST_TRUNCATE_PIVOT_TABLES', false),

    /**
     * Control if default roles other than Admin should be created after seeding.
     */
    'seed_default_roles' => env('LARATRUST_SEED_DEFAULT_ROLES', false),

    'roles_structure' => [
        'Admin' => [
            'User Management' => [

                'Create'=>[
                    'create_user',
                    'create_role',
                ],

                'Read'=>[
                    'access_user_management_module',
                    'view_user',
                    'view_role',
                    'view_permission',
                    'view_login_activity',
                    'view_activity_trail',
                    'generate_user_management_reports',
                ],

                'Update'=>[
                    'update_user',
                    'update_role',
                    'update_permission',
                    'assign_role',
                    'assign_permission',
                ],

                'Delete'=> [
                    'delete_user',
                    'delete_role',
                ],
            ],
            'Human Resource' => [
                'Create'=> [
                    'create_grievance_type',
                    'create_grievance',
                ],
                'Read'=> [
                    'view_grievance_types',
                    'view_grievances',
                ],
                'Update'=> [
                    'update_grievance_type',
                    'update_grievance',
                ],
                'Restore'=> [
                    'restore_grievance_type',
                    'restore_grievance',
                ],
                'Delete'=> [
                    'archive_grievance_type',
                    'force_delete_grievance_type',
                    'archive_grievance',
                    'force_delete_grievance',
                ],
            ],
            'Human Resource/Performance' => [
                'Create'=> [
                    'create_appraisal',
                    'create_warning',
                    'create_exit_interview',
                    'create_termination',
                    'create_resignation',
                ],
                'Read'=> [
                    'view_appraisals',
                    'view_warnings',
                    'view_exit_interviews',
                    'view_terminations',
                    'view_resignations',
                ],
                'Update'=> [
                    'update_appraisal',
                    'update_warning',
                    'update_exit_interview',
                    'update_termination',
                    'update_resignation',
                ],
                'Restore'=> [
                    'restore_appraisal',
                    'restore_warning',
                    'restore_exit_interview',
                    'restore_termination',
                    'restore_resignation',
                ],
                'Delete'=> [
                    'archive_appraisal',
                    'archive_warning',
                    'archive_exit_interview',
                    'archive_termination',
                    'archive_resignation',
                    'force_delete_appraisal',
                    'force_delete_warning',
                    'force_delete_exit_interview',
                    'force_delete_termination',
                    'force_delete_resignation',
                ],
            ],
            'Human Resource/Leave Management' => [
                'Create'=> [
                    'create_leave_request',
                    'create_leave_delegation_request',
                ],
                'Read'=> [
                    'view_leave_requests',
                    'view_leave_grievances',
                    'view_department_leave_requests',
                ],
                'Update'=> [
                    'update_leave_request',
                    'approve_leave_request',
                    'update_leave_grievance_request',
                    'approve_leave_grievance_request',
                    'approve_department_leave_request',
                ],
                'Restore'=> [
                    'restore_leave_request',
                ],
                'Delete'=> [
                    'archive_leave_request',
                    'decline_leave_request',
                    'force_delete_leave_request',
                    'decline_leave_request',
                    'decline_department_leave_request',
                    'force_delete_leave_request'
                ],
            ],
            'Human Resource/Employee Management' => [
                'Create'=> [
                    'register employee',
                ],
                'Read'=> [
                    'view_employees',
                ],
                'Update'=> [
                    'update_employee',
                    'activate_employee',
                ],
                'Restore'=> [
                    'restore_employee',
                ],
                'Delete'=> [
                    'archive_employee',
                    'deactivate_employee',
                    'force_delete_employee'
                ],
            ],
            'Human Resource/Settings' => [
                'Create'=> [
                    'create_duty_station',
                    'create_department',
                    'create_designation',
                    'create_holiday',
                    'create_office',
                    'create_statutory_charge',
                    'register_currency_&_rate',
                    'create_leave_type',
                ],
                'Read'=> [
                    'view_duty_stations',
                    'view_departments',
                    'view_designations',
                    'view_holidays',
                    'view_offices',
                    'view_statutory_charges',
                    'view_currencies_&_rates',
                    'view_leave_types',
                ],
                'Update'=> [
                    'update_duty_station',
                    'update_department',
                    'update_designation',
                    'update_holiday',
                    'update_office',
                    'update_statutory_charge',
                    'update_currency_&_rate',
                    'update_leave_type',
                ],
                'Restore'=> [
                    'restore_duty_station',
                    'restore_department',
                    'restore_designation',
                    'restore_holiday',
                    'restore_office',
                    'restore_statutory_charge',
                    'restore_currency_&_rate',
                    'restore_leave_type',
                ],
                'Delete'=> [
                    'archive_duty_station',
                    'archive_department',
                    'archive_designation',
                    'archive_holiday',
                    'archive_office',
                    'archive_statutory_charge',
                    'archive_currency_&_rate',
                    'archive_leave_type',
                    'force_delete_duty_station',
                    'force_delete_department',
                    'force_delete_designation',
                    'force_delete_holiday',
                    'force_delete_office',
                    'force_delete_statutory_charge',
                    'force_delete_currency_&_rate',
                    'force_delete_leave_type',
                ],
            ],
        ],
    ],

    //Configure Default Roles and Permissions
    'default_roles' => [
        //TRAINING MANAGEMENT
        // 'Training Management' =>[
        //     'Training Coordinator' => [
        //         'access_training_module',
        //         'access_workshops_centre',
        //         'access_technical_support_centre',
        //         'add_training_partner',
        //         'view_training',
        //         'view_trainer',
        //         'view_nominee',
        //     ],
        //  ],
     ],


];
