<?php

namespace App\Services;

use App\Models\Contract;

class ContractService
{

    public function createContract($request)
    {
        $contract = new Contract();
        $contract->reference_number = $request->input('reference_number');
        $contract->company_name = $request->input('company_name');
        $contract->project_name = $request->input('project_name');
        $contract->start_date = $request->input('start_date');
        $contract->end_date = $request->input('end_date');
        $contract->contract_amount_without_tax = $request->input('contract_amount_without_tax');
        $contract->tax_percentage = $request->input('tax_percentage');
        $contract->modified_tax = $request->input('modified_tax');
        $contract->deduction_ratio = $request->input('deduction_ratio');
        $contract->note = $request->input('note');
        $contract->commission_date = $request->input('commission_date');
        $contract->award_date = $request->input('award_date');
        $contract->contract_signing_date = $request->input('contract_signing_date');
        $contract->contract_type_id = $request->input('contract_type_id');

        $contract->save();
    }

}
