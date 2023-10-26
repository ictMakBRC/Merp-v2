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
    const PROCESSED = 'Processed';
    const COMPLETED = 'Completed';
    const PAID = 'Paid';

    //Request steps
    const DEPARTMENT_STEP = 'Department';
    const SUPERVISOR_STEP = 'Supervisor';
    const FINANCE_STEP = 'Finance';
    const OPERATIONS_STEP = 'Operations';
    const MD_STEP = 'Md';
    const PROCUREMENT_STEP = 'Procurement';
    const STORES_STEP = 'Stores';
    const ACCOUNTS_STEP = 'Accounts';
    const TOTAL_STEPS=8;

    const PM_APPROVAL = 'Procurement Method Approval';
    const ER_APPROVAL = 'Evaluation Report Approval';

    //Committees
    const CC = 'Contracts Committee';
    const EC = 'Evaluation Committee';
    const NC = 'Negotiation Committee';

    //ITEM QUALITY
    const LOW = 'Low';
    const AVERAGE = 'Average';
    const HIGH = 'High';

    //PROVIDER RATING

    //quality
    const POOR = 'Poor';
    const FAIR = 'Fair';
    const GOOD = 'Good';
    const VERY_GOOD = 'Very Good';
    const EXCELLENT = 'Excellent';

    //Timeliness
    const VERY_LATE = 'Very Late';
    const LATE = 'Late';
    const ON_TIME = 'On Time';
    const EARLY = 'Early';
    const VERY_EARLY = 'Very Early';

     // Cost Ratings
     const VERY_CHEAP = 'Very Cheap';
     const CHEAP = 'Cheap';
     const MODERATE = 'Moderate';
     const EXPENSIVE = 'Expensive';
     const VERY_EXPENSIVE = 'Very Expensive';

    public static function color($status)
    {
        return match ($status) {
            ProcurementRequestEnum::DRAFT => 'info',
            ProcurementRequestEnum::SUBMITTED => 'primary',
            ProcurementRequestEnum::PENDING => 'warning',
            ProcurementRequestEnum::APPROVED => 'success',
            ProcurementRequestEnum::REJECTED => 'danger',
            ProcurementRequestEnum::PROCESSING => 'info',
            ProcurementRequestEnum::PROCESSED => 'success',
            ProcurementRequestEnum::PAID => 'success',
            ProcurementRequestEnum::COMPLETED => 'success',

            ProcurementRequestEnum::LOW => 'danger',
            ProcurementRequestEnum::AVERAGE => 'warning',
            ProcurementRequestEnum::HIGH => 'success',
            

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
            8 => ProcurementRequestEnum::ACCOUNTS_STEP,

            default => ''
        };
    }

    public static function ratingColor($rating)
    {
        return match ($rating) {
            1 => 'danger',
            2 => 'warning',
            3 => 'primary',
            4 => 'info',
            5 => 'success',

            default => ''
        };
    }

    public static function qualityRating($rating)
    {
        return match ($rating) {
            1 => ProcurementRequestEnum::POOR,
            2 => ProcurementRequestEnum::FAIR,
            3 => ProcurementRequestEnum::GOOD,
            4 => ProcurementRequestEnum::VERY_GOOD,
            5 => ProcurementRequestEnum::EXCELLENT,

            default => ''
        };
    }

    public static function timelinessRating($rating)
    {
        return match ($rating) {
            1 => ProcurementRequestEnum::VERY_LATE,
            2 => ProcurementRequestEnum::LATE,
            3 => ProcurementRequestEnum::ON_TIME,
            4 => ProcurementRequestEnum::EARLY,
            5 => ProcurementRequestEnum::VERY_EARLY,

            default => ''
        };
    }

    public static function costRating($rating)
    {
        return match ($rating) {
            1 => ProcurementRequestEnum::VERY_CHEAP,
            2 => ProcurementRequestEnum::CHEAP,
            3 => ProcurementRequestEnum::MODERATE,
            4 => ProcurementRequestEnum::EXPENSIVE,
            5 => ProcurementRequestEnum::VERY_EXPENSIVE,

            default => ''
        };
    }
}
