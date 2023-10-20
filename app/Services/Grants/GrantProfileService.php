<?php

namespace App\Services\Grants;

use App\Data\Grants\GrantProfileData;
use App\Models\Grants\GrantDocument;
use App\Models\Grants\GrantProfile;

class GrantProfileService
{
    public function createGrantProfile(GrantProfileData $grantProfileDTO): GrantProfile
    {
        $grantProfile = new GrantProfile();
        $this->fillGrantProfileFromDTO($grantProfile, $grantProfileDTO);
        $grantProfile->save();

        return $grantProfile;
    }

    public function updateGrantProfile(GrantProfile $grantProfile, GrantProfileData $grantProfileDTO): GrantProfile
    {
        $this->fillGrantProfileFromDTO($grantProfile, $grantProfileDTO);
        $grantProfile->save();

        return $grantProfile;
    }

    private function fillGrantProfileFromDTO(GrantProfile $grantProfile, GrantProfileData $grantProfileDTO)
    {
        $grantProfile->grant_code = $grantProfileDTO->grant_code;
        $grantProfile->grant_name = $grantProfileDTO->grant_name;
        $grantProfile->grant_type = $grantProfileDTO->grant_type;
        $grantProfile->funding_source = $grantProfileDTO->funding_source;
        $grantProfile->funding_amount = $grantProfileDTO->funding_amount;
        $grantProfile->currency = $grantProfileDTO->currency;
        $grantProfile->start_date = $grantProfileDTO->start_date;
        $grantProfile->end_date = $grantProfileDTO->end_date;
        $grantProfile->proposal_submission_date = $grantProfileDTO->proposal_submission_date;
        $grantProfile->pi = $grantProfileDTO->pi;
        $grantProfile->proposal_summary = $grantProfileDTO->proposal_summary;
        $grantProfile->award_status = $grantProfileDTO->award_status;
    }

    //GRANT DOCUMENTS
    public function createGrantDocument(GrantProfileData $grantDocumentDTO): GrantDocument
    {
        $grantDocument = new GrantDocument();
        $this->fillGrantDocumentFromDTO($grantDocument, $grantDocumentDTO);
        $grantDocument->save();

        return $grantDocument;
    }

    public function updateGrantDocument(GrantDocument $grantDocument, GrantProfileData $grantDocumentDTO): GrantDocument
    {
        $this->fillGrantDocumentFromDTO($grantDocument, $grantDocumentDTO);
        $grantDocument->save();

        return $grantDocument;
    }

    private function fillGrantDocumentFromDTO(GrantDocument $grantDocument, GrantProfileData $grantDocumentDTO)
    {
        $grantDocument->grant_profile_id = $grantDocumentDTO->grant_profile_id;
        $grantDocument->document_category = $grantDocumentDTO->document_category;
        $grantDocument->expires = $grantDocumentDTO->expires;
        $grantDocument->expiry_date = $grantDocumentDTO->expiry_date;
        $grantDocument->document_name = $grantDocumentDTO->document_name;
        $grantDocument->document_path = $grantDocumentDTO->document_path;
        $grantDocument->description = $grantDocumentDTO->description;
    }
}
