<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContractRequest;
use App\Models\Contract;
use App\Models\ContractType;
use App\Services\ContractService;

class ContractController extends Controller
{
    private $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function index()
    {
        $user = auth()->user();
        $contracts = Contract::all();
        return view('contract.index', compact('contracts'));
    }

    public function create()
    {
        $contractTypes = ContractType::all();
        return view('contract.create', compact('contractTypes'));
    }

    public function store(CreateContractRequest $request)
    {
        $this->contractService->createContract($request);
        return redirect()->route('contract.index')->with('success', 'تم إنشاء العقد بنجاح');
    }

}
