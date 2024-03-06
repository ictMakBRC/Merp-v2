<?php

namespace App\Imports\Finace;

use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class FmsClientsImport implements ToModel, WithHeadingRow
{
    // public function startRow(): int
    // {
    //     return 2;
    // }

    /**
     * @param  Failure[]  $failures
     */
    public function onFailure(Failure...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function model(array $row)
    {
        try {
            // Validate the data
            if (empty(array_filter($row))) {
                return null;
            }

            $validatedData = Validator::make($row, [
                'name' => 'required|string',
                'code' => 'nullable|string',
                'nationality' => 'nullable|string',
                'address' => 'nullable|string',
                'currency' => 'nullable|string',
                'city' => 'nullable|string',
                'email' => 'nullable|email',
                'alt_email' => 'nullable|string',
                'contact' => 'nullable',
                'fax' => 'nullable',
                'alt_contact' => 'nullable',
                'website' => 'nullable',
                'company_name' => 'nullable|string',
                'payment_terms' => 'nullable',
                'payment_methods' => 'nullable',
                'opening_balance' => 'nullable',
                'tax_registration' => 'nullable',
            ])->validate();

            // Find an existing record with the same name
            $existingCustomerData = FmsCustomer::where(['name' => $validatedData['name']])->first();
            $duplicateIds = [];
            // If an existing record is found, you can choose how to handle it
            if ($existingCustomerData) {

                $existingCustomerData->name = $validatedData['name'];
                $existingCustomerData->name = $validatedData['code'] ?? GeneratorService::generateInitials($validatedData['name']);
                $existingCustomerData->nationality = $validatedData['nationality'] ?? null;
                $existingCustomerData->address = $validatedData['address'] ?? null;
                $existingCustomerData->city = $validatedData['city'] ?? null;
                $existingCustomerData->email = $validatedData['email'] ?? null;
                $existingCustomerData->alt_email = $validatedData['alt_email'] ?? null;
                // $existingCustomerData->currency_id = $validatedData['currency'];
                $existingCustomerData->contact = $validatedData['contact'] ?? null;
                $existingCustomerData->fax = $validatedData['fax']??null;
                $existingCustomerData->alt_contact = $validatedData['alt_contact'] ?? null;
                $existingCustomerData->website = $validatedData['website'] ?? null;
                $existingCustomerData->company_name = $validatedData['company_name'] ?? null;
                // $existingCustomerData->payment_terms = $validatedData['payment_terms'];
                // $existingCustomerData->payment_methods = $validatedData['payment_methods'];
                // $existingCustomerData->opening_balance = $validatedData['opening_balance'];
                // $existingCustomerData->sales_tax_registration = $validatedData['tax_registration']??null;
                $existingCustomerData->update();
                // Option 1: Skip the duplicate record and do not insert it again
                // You can return null to skip the record and move on to the next one

                // Notify the user about the duplicate name
                $errorMessage = 'Duplicate record found for customer: ' . $validatedData['name'] . '. ';
                // Log::error('Duplicate record found for name: ' . $validatedData['name']);

                // Log the error for your reference
                Log::error($errorMessage . 'Duplicate record found. Skipping this record.');

                // Add the duplicate name to the array
                $duplicateIds[] = $errorMessage;
                session()->flash('error', $errorMessage);
                // Return null to skip the record and move on to the next one
                return null;
            }

            // Create a new CustomerData instance and populate its attributes from the validated data
            $currency_id = FmsCurrency::where('code', '%LIKE%', $validatedData['currency'])->first()->id ?? null;
            $CustomerData = new FmsCustomer([
                'type' => 'Customer',
                'name' => $validatedData['name'] ?? null,
                'code' => $validatedData['code'] ?? GeneratorService::generateInitials($validatedData['name']),
                'nationality' => $validatedData['nationality'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'city' => $validatedData['city'] ?? null,
                'email' => $validatedData['email'] ?? null,
                'alt_email' => $validatedData['alt_email'] ?? null,
                'currency_id' => $currency_id ?? null,
                'contact' => $validatedData['contact'] ?? null,
                'fax' => $validatedData['fax'] ?? null,
                'alt_contact' => $validatedData['alt_contact'] ?? null,
                'website' => $validatedData['website'] ?? null,
                'company_name' => $validatedData['company_name'] ?? null,
                'payment_terms' => $validatedData['payment_terms'] ?? null,
                'payment_methods' => $validatedData['payment_methods'] ?? null,
                'opening_balance' => $validatedData['opening_balance'] ?? 0,
                'sales_tax_registration' => $validatedData['tax_registration'] ?? null,
                'as_of' => date('Y-m-d'),
                'is_active' => 1,
            ]);

            // Insert the CustomerData into the database
            $CustomerData->save();
            return $CustomerData;
        } catch (Throwable $error) {
            Log::error($error . 'failed to import record.');

            // Add the duplicate name to the array
        //    return session()->flash('error', $error);
        }
    }

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'name';
    }

    public function rules(): array
    {
        return [
            // 'name' => 'required|unique:sample_data',
            //'specimen_type' => 'required',
            // 'collection_date' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 5;
    }

    // public function chunkSize(): int
    // {
    //     return 100;
    // }
}
