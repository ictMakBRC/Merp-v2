<?php

use App\Enums\ProcurementRequestEnum;



function getProcurementRequestStatusColor($status)
{
    return ProcurementRequestEnum::color($status);
}

function getProcurementRequestStep($stepOrder)
{
    return ProcurementRequestEnum::step($stepOrder);
}


