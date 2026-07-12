<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;

class WithdrawalMethodController extends Controller
{
    public function index()
    {
        $methods = WithdrawalMethod::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.withdrawal-methods.index', compact('methods'));
    }

    public function create()
    {
        $method = new WithdrawalMethod([
            'min_amount'    => 10,
            'max_amount'    => 1000000,
            'charge_type'   => 'percentage',
            'charge_amount' => 0,
            'duration'      => 'Instant Payment',
            'is_active'     => true,
            'sort_order'    => (int) WithdrawalMethod::max('sort_order') + 1,
        ]);

        return view('admin.withdrawal-methods.create', compact('method'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $method = WithdrawalMethod::create($data);

        $this->log($request, 'create_withdrawal_method', $method, 'Created withdrawal method ' . $method->name);

        return redirect()->route('admin.withdrawal-methods.index')
            ->with('success', 'Withdrawal method "' . $method->name . '" created.');
    }

    public function edit(WithdrawalMethod $withdrawalMethod)
    {
        return view('admin.withdrawal-methods.edit', ['method' => $withdrawalMethod]);
    }

    public function update(Request $request, WithdrawalMethod $withdrawalMethod)
    {
        $data = $this->validateData($request);

        $withdrawalMethod->update($data);

        $this->log($request, 'update_withdrawal_method', $withdrawalMethod, 'Updated withdrawal method ' . $withdrawalMethod->name);

        return redirect()->route('admin.withdrawal-methods.index')
            ->with('success', 'Withdrawal method "' . $withdrawalMethod->name . '" updated.');
    }

    public function toggle(Request $request, WithdrawalMethod $withdrawalMethod)
    {
        $withdrawalMethod->update(['is_active' => ! $withdrawalMethod->is_active]);

        $this->log($request, 'toggle_withdrawal_method', $withdrawalMethod,
            ($withdrawalMethod->is_active ? 'Activated' : 'Deactivated') . ' withdrawal method ' . $withdrawalMethod->name);

        return back()->with('success', 'Withdrawal method "' . $withdrawalMethod->name . '" '
            . ($withdrawalMethod->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function destroy(Request $request, WithdrawalMethod $withdrawalMethod)
    {
        if ($withdrawalMethod->requests()->exists()) {
            return back()->with('error',
                'Cannot delete "' . $withdrawalMethod->name . '" because it has withdrawal records. Deactivate it instead.');
        }

        $name = $withdrawalMethod->name;
        $withdrawalMethod->delete();

        $this->log($request, 'delete_withdrawal_method', null, 'Deleted withdrawal method ' . $name);

        return redirect()->route('admin.withdrawal-methods.index')
            ->with('success', 'Withdrawal method "' . $name . '" deleted.');
    }

    protected function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'duration'      => ['required', 'string', 'max:100'],
            'min_amount'    => ['required', 'numeric', 'min:0'],
            'max_amount'    => ['required', 'numeric', 'gte:min_amount'],
            'charge_type'   => ['required', 'in:percentage,fixed'],
            'charge_amount' => ['required', 'numeric', 'min:0'],
            'sort_order'    => ['required', 'integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    protected function log(Request $request, string $action, ?WithdrawalMethod $method, string $description): void
    {
        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => $action,
            'target_user_id' => null,
            'description'    => $description,
            'meta'           => $method ? ['withdrawal_method_id' => $method->id, 'name' => $method->name] : null,
        ]);
    }
}
