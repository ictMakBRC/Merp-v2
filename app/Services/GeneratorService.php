<?php

namespace App\Services;

use App\Models\EQA\EqaRequest;
use App\Models\HelpDesk\Ticket;
use App\Models\NetworkManagement\Institution;
use App\Models\SampleManagement\NationalReferral;
use App\Models\SampleManagement\NationalReferralShipment;
use App\Models\SampleManagement\NationalSample;
use App\Models\SampleManagement\ReferralRequest;
use App\Models\SampleManagement\SampleData;
use App\Models\SampleManagement\SampleShipment;
use App\Models\TrainingManagement\Training;
use App\Models\TrainingManagement\TrainingEvent;
use App\Models\SampleManagement\SequencingApplication;
use Illuminate\Support\Str;

class GeneratorService
{
    public static function password($length = 2)
    {
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomNumber = '';
        $randomSymbol = '';
        $randomUppercase = '';
        $randomLowercase = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $numbers[rand(0, strlen($numbers) - 1)];
            $randomSymbol .= $symbols[rand(0, strlen($symbols) - 1)];
            $randomUppercase .= $uppercase[rand(0, strlen($uppercase) - 1)];
            $randomLowercase .= $lowercase[rand(0, strlen($lowercase) - 1)];
        }

        return str_shuffle($randomNumber.$randomSymbol.$randomUppercase.$randomLowercase);
    }

    public static function institutionIdentifier()
    {
        $identifier = '';
        $yearStart = date('y');
        $latestInstitutionIdentifier = Institution::select('identifier')->orderBy('id', 'desc')->first();

        if ($latestInstitutionIdentifier) {
            $institutionNumberSplit = explode('-', $latestInstitutionIdentifier->identifier);
            $institutionNumberYear = (int) filter_var($institutionNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($institutionNumberYear == $yearStart) {
                $identifier = $institutionNumberSplit[0].'-'.str_pad(((int) filter_var($institutionNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).'F';
            } else {
                $identifier = 'PGI'.$yearStart.'-001F';
            }
        } else {
            $identifier = 'PGI'.$yearStart.'-001F';
        }

        return $identifier;
    }

    public static function eqaRequestTracker()
    {
        $tracker = '';
        $yearStart = date('y');
        $latestTracker = EqaRequest::select('tracker')->orderBy('id', 'desc')->first();
        $randomAlphabet = ucfirst(Str::random(1));

        if ($latestTracker) {
            $trackerNumberSplit = explode('-', $latestTracker->tracker);
            $trackerNumberYear = (int) filter_var($trackerNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($trackerNumberYear == $yearStart) {
                $tracker = $trackerNumberSplit[0].'-'.str_pad(((int) filter_var($trackerNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).$randomAlphabet;
            } else {
                $tracker = 'EQA'.$yearStart.'-001'.$randomAlphabet;
            }
        } else {
            $tracker = 'EQA'.$yearStart.'-001'.$randomAlphabet;
        }

        return $tracker;
    }

    public static function sampleIdentifier()
    {
        $identifier = '';
        $yearStart = date('y');
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $l = $characters[rand(0, strlen($characters) - 2)];
        $latestIdentifier = SampleData::select('identifier')->orderBy('id', 'desc')->first();

        if ($latestIdentifier) {
            $numberSplit = explode('-', $latestIdentifier->identifier);
            $numberYear = (int) filter_var($numberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($numberYear == $yearStart) {
                $identifier = $numberSplit[0].'-'.str_pad(((int) filter_var($numberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 4, '0', STR_PAD_LEFT).$l;
            } else {
                $identifier = 'ExS'.$yearStart.'-0001'.$l;
            }
        } else {
            $identifier = 'ExS'.$yearStart.'-0001'.$l;
        }

        return $identifier;
    }

    public static function nationalSampleIdentifier()
    {
        $identifier = '';
        $yearStart = date('y');
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $l = $characters[rand(0, strlen($characters) - 2)];
        $latestIdentifier = NationalSample::select('identifier')->orderBy('id', 'desc')->first();

        if ($latestIdentifier) {
            $numberSplit = explode('-', $latestIdentifier->identifier);
            $numberYear = (int) filter_var($numberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($numberYear == $yearStart) {
                $identifier = $numberSplit[0].'-'.str_pad(((int) filter_var($numberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 4, '0', STR_PAD_LEFT).$l;
            } else {
                $identifier = 'InS'.$yearStart.'-0001'.$l;
            }
        } else {
            $identifier = 'InS'.$yearStart.'-0001'.$l;
        }

        return $identifier;
    }

    public static function requestBatchNo()
    {
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $l = $characters[rand(0, strlen($characters) - 2)];
        $request_no = '';
        $yearStart = date('ymd');
        $latestrequestrequest_no = ReferralRequest::select('request_no')->orderBy('id', 'desc')->first();

        if ($latestrequestrequest_no) {
            $requestNumberSplit = explode('-', $latestrequestrequest_no->request_no);
            $requestNumberYear = (int) filter_var($requestNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($requestNumberYear == $yearStart) {
                $request_no = $requestNumberSplit[0].'-'.str_pad(((int) filter_var($requestNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).$l;
            } else {
                $request_no = 'ExREF'.$yearStart.'-001'.$l;
            }
        } else {
            $request_no = 'ExREF'.$yearStart.'-001'.$l;
        }

        return $request_no;
    }

    public static function nationalrequestBatchNo()
    {
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $l = $characters[rand(1, strlen($characters) - 2)];
        $request_no = '';
        $yearStart = date('ymd');
        $latestrequestrequest_no = NationalReferral::select('request_no')->orderBy('id', 'desc')->first();

        if ($latestrequestrequest_no) {
            $requestNumberSplit = explode('-', $latestrequestrequest_no->request_no);
            $requestNumberYear = (int) filter_var($requestNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($requestNumberYear == $yearStart) {
                $request_no = $requestNumberSplit[0].'-'.str_pad(((int) filter_var($requestNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).$l;
            } else {
                $request_no = 'InREF'.$yearStart.'-001'.$l;
            }
        } else {
            $request_no = 'InREF'.$yearStart.'-001'.$l;
        }

        return $request_no;
    }

    public static function getNumber($length)
    {
        $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function generateStringCode()
    {
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $tracker = mt_rand(100, 9999)
        .$characters[rand(0, strlen($characters) - 3)];

        return str_shuffle($tracker);
    }

    public static function generatePackageNo($request_no)
    {
        $package_no = '';
        $latestPackage_no = SampleShipment::where(['request_no' => $request_no, 'recieved_at' => null, 'receiver_id' => null, 'sender_id' => auth()->user()->institution_id])
            ->where('shipment_status', '!=', 'Dispatched')->select('package_no')->orderBy('id', 'desc')->first();
        if ($latestPackage_no?->shipment_status == 'Pending') {
            $package_no = $latestPackage_no->package_no;
        } else {
            if ($latestPackage_no) {
                $requestNumberSplit = explode('_', $latestPackage_no->package_no);
                $requestNumber = (int) filter_var($requestNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

                $package_no = $requestNumberSplit[0].'_'.str_pad(((int) filter_var($requestNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 1, STR_PAD_LEFT);
            } else {
                $package_no = $request_no.'_1';
            }
        }

        return $package_no;
    }

    public static function generateNationalPackageNo($request_no)
    {
        $package_no = '';
        $latestPackage_no = NationalReferralShipment::where(['request_no' => $request_no, 'recieved_at' => null, 'receiver_id' => null, 'sender_id' => auth()->user()->institution_id])
            ->where('shipment_status', '!=', 'Dispatched')->select('package_no')->orderBy('id', 'desc')->first();
        if ($latestPackage_no?->shipment_status == 'Pending') {
            $package_no = $latestPackage_no->package_no;
        } else {
            if ($latestPackage_no) {
                $requestNumberSplit = explode('_', $latestPackage_no->package_no);
                $requestNumber = (int) filter_var($requestNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

                $package_no = $requestNumberSplit[0].'_'.str_pad(((int) filter_var($requestNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 1, STR_PAD_LEFT);
            } else {
                $package_no = $request_no.'_1';
            }
        }

        return $package_no;
    }

    public static function generateInitials(string $name)
    {
        $n = Str::of($name)->wordCount();
        $words = explode(' ', $name);

        if (count($words) <= 2) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 3) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 4) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 5) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 6) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 7) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr($words[5], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) == 8) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr($words[5], 0, 1, 'UTF-8').
                mb_substr($words[6], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        } elseif (count($words) >= 9) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8').
                mb_substr($words[1], 0, 1, 'UTF-8').
                mb_substr($words[2], 0, 1, 'UTF-8').
                mb_substr($words[3], 0, 1, 'UTF-8').
                mb_substr($words[4], 0, 1, 'UTF-8').
                mb_substr($words[5], 0, 1, 'UTF-8').
                mb_substr($words[6], 0, 1, 'UTF-8').
                mb_substr($words[7], 0, 1, 'UTF-8').
                mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8');
        }

        return self::makeInitialsFromSingleWord($name);
    }

    /**
     * Make initials from a word with no spaces
     *
     * @return string
     */
    protected static function makeInitialsFromSingleWord(string $name)
    {
        $n = Str::of($name)->wordCount();
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= $n) {
            return mb_substr(implode('', $capitals[1]), 0, $n, 'UTF-8');
        }

        return mb_strtoupper(mb_substr($name, 0, $n, 'UTF-8'), 'UTF-8');
    }

    //Generate standard ticket reference
    public static function ticketReference()
    {
        $reference = '';
        $yearStart = date('y');
        $latestReference = Ticket::select('reference_number')->orderBy('id', 'desc')->first();

        if ($latestReference) {
            $referenceNumberSplit = explode('-', $latestReference->reference_number);
            $referenceYear = (int) filter_var($referenceNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($referenceYear == $yearStart) {
                $reference = $referenceNumberSplit[0].'-'.str_pad(((int) filter_var($referenceNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).'TR';
            } else {
                $reference = '#NIMS'.$yearStart.'-001TR';
            }
        } else {
            $reference = '#NIMS'.$yearStart.'-001TR';
        }

        return $reference;
    }

    //Generate a tracker/Code for training workshop
    public static function workshopCode($trainingId)
    {
        $workshopCode = '';

        $latestWorkshop = TrainingEvent::where('training_id', $trainingId)->orderBy('id', 'desc')->first();

        if ($latestWorkshop && $latestWorkshop->workshop_code) {
            $codeNumberSplit = explode('-', $latestWorkshop->workshop_code);
            $workshopCode = $codeNumberSplit[0].'-'.((int) filter_var($codeNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1);

        } else {
            $newCode = Training::where('id', $trainingId)->first()->course_code;
            $workshopCode = $newCode.'-1';
        }

        return $workshopCode;
    }

    //id Builder
    public static function idBuilder()
    {
      $yearMonth = date('ym');
      $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';
      $l = $characters[rand(2, strlen($characters) - 4)];
      $randomGeneratedNumber = intval('0'.mt_rand(1, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9));

     return $yearMonth.'-'.$randomGeneratedNumber.'-'.$l;
    }

    //Generate a sequencing application uuid
    public static function sequencingApplication()
    {
      $yearMonth = date('ym');
      $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';
      $l = $characters[rand(2, strlen($characters) - 4)];
      $randomGeneratedNumber = intval('0'.mt_rand(1, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9));

      return 'NIMS-SeqApp/'.$yearMonth.'-'.$randomGeneratedNumber.'-'.$l;

    }

    //Generate a forecast uuid
    public static function forecastGenerator()
    {
      $yearMonth = date('ym');
      $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';
      $l = $characters[rand(2, strlen($characters) - 4)];
      $randomGeneratedNumber = intval('0'.mt_rand(1, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9));

      return 'PGI-FC/'.$yearMonth.'-'.$randomGeneratedNumber.'-'.$l;

    }
}
