<?php

namespace App\Services\Grants;

use App\Models\Grants\Grant;
use App\Data\Grants\GrantData;

class GrantService
{
    public function createGrant(GrantData $grantDTO):Grant
    {
        $grant = new Grant();
        $this->fillGrantFromDTO($grant, $grantDTO);
        $grant->save();

        return $grant;
    }

    public function updateGrant(Grant $grant, GrantData $grantDTO):Grant
    {
        $this->fillGrantFromDTO($grant, $grantDTO);
        $grant->save();

        return $grant;
    }

    private function fillGrantFromDTO(Grant $grant, GrantData $grantDTO)
    {
        $grant->grant_code = $grantDTO->grant_code;
        $grant->grant_name = $grantDTO->grant_name;
        $grant->grant_type = $grantDTO->grant_type;
        $grant->funding_source = $grantDTO->funding_source;
        $grant->funding_amount = $grantDTO->funding_amount;
        $grant->currency_id = $grantDTO->currency_id;
        $grant->start_date = $grantDTO->start_date;
        $grant->end_date = $grantDTO->end_date;
        $grant->proposal_submission_date = $grantDTO->proposal_submission_date;
        $grant->pi = $grantDTO->pi;
        $grant->proposal_summary = $grantDTO->proposal_summary;
        $grant->award_status = $grantDTO->award_status;
    }

}
