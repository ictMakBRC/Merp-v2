<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

class ProcurementRequestEnum extends Enum
{
    //Request statuses
    const DRAFT = 'Draft';
    const SUBMITTED = 'Submitted';
    const PENDING = 'Pending';
    const APPROVED = 'Approved';
    const REJECTED = 'Rejected';
    const PROCESSING = 'Processing';
    const COMPLETED = 'Completed';

    //Request steps
    const DEPARTMENT_STEP = 'Department';
    const SUPERVISOR_STEP = 'Supervisor';
    const FINANCE_STEP = 'Finance';
    const OPERATIONS_STEP = 'Operations';
    const MD_STEP = 'Md';
    const PROCUREMENT_STEP = 'Procurement';
    const STORES_STEP = 'Stores';
    const TOTAL_STEPS=7;

    const PM_APPROVAL = 'Procurement Method Approval';
    const ER_APPROVAL = 'Evaluation Report Approval';

    //Committees
    const CC = 'Contracts Committee';
    const EC = 'Evaluation Committee';
    const NC = 'Negotiation Committee';

    public static function color($status)
    {
        return match ($status) {
            ProcurementRequestEnum::DRAFT => 'info',
            ProcurementRequestEnum::SUBMITTED => 'primary',
            ProcurementRequestEnum::PENDING => 'warning',
            ProcurementRequestEnum::APPROVED => 'success',
            ProcurementRequestEnum::REJECTED => 'danger',
            ProcurementRequestEnum::PROCESSING => 'info',

            default => ''
        };
    }

    public static function step($stepOrder)
    {
        return match ($stepOrder) {
            1 => ProcurementRequestEnum::DEPARTMENT_STEP,
            2 => ProcurementRequestEnum::SUPERVISOR_STEP,
            3 => ProcurementRequestEnum::FINANCE_STEP,
            4 => ProcurementRequestEnum::OPERATIONS_STEP,
            5 => ProcurementRequestEnum::MD_STEP,
            6 => ProcurementRequestEnum::PROCUREMENT_STEP,
            7 => ProcurementRequestEnum::STORES_STEP,

            default => ''
        };
    }



}
