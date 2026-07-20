<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;

class InvestmentPlanController extends Controller
{
    public function index()
    {
        $plans = InvestmentPlan::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.investment-plans.index', compact('plans'));
    }

    public function create()
    {
        $plan = new InvestmentPlan([
            'roi_percentage' => 0,
            'roi_period'     => 'Daily',
            'duration_days'  => 1,
            'min_amount'     => 1,
            'max_amount'     => 1000000,
            'charge_type'    => 'percentage',
            'charge_amount'  => 0,
            'is_active'      => true,
            'sort_order'     => (int) InvestmentPlan::max('sort_order') + 1,
        ]);

        return view('admin.investment-plans.create', compact('plan'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $plan = InvestmentPlan::create($data);

        $this->log($request, 'create_investment_plan', $plan, 'Created investment plan ' . $plan->name);

        return redirect()->route('admin.investment-plans.index')
            ->with('success', 'Investment plan "' . $plan->name . '" created.');
    }

    public function edit(InvestmentPlan $investmentPlan)
    {
        return view('admin.investment-plans.edit', ['plan' => $investmentPlan]);
    }

    public function update(Request $request, InvestmentPlan $investmentPlan)
    {
        $data = $this->validateData($request);

        $investmentPlan->update($data);

        $this->log($request, 'update_investment_plan', $investmentPlan, 'Updated investment plan ' . $investmentPlan->name);

        return redirect()->route('admin.investment-plans.index')
            ->with('success', 'Investment plan "' . $investmentPlan->name . '" updated.');
    }

    public function toggle(Request $request, InvestmentPlan $investmentPlan)
    {
        $investmentPlan->update(['is_active' => ! $investmentPlan->is_active]);

        $this->log($request, 'toggle_investment_plan', $investmentPlan,
            ($investmentPlan->is_active ? 'Activated' : 'Deactivated') . ' investment plan ' . $investmentPlan->name);

        return back()->with('success', 'Investment plan "' . $investmentPlan->name . '" '
            . ($investmentPlan->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function destroy(Request $request, InvestmentPlan $investmentPlan)
    {
        if ($investmentPlan->investments()->exists()) {
            return back()->with('error',
                'Cannot delete "' . $investmentPlan->name . '" because users have invested in it. Deactivate it instead.');
        }

        $name = $investmentPlan->name;
        $investmentPlan->delete();

        $this->log($request, 'delete_investment_plan', null, 'Deleted investment plan ' . $name);

        return redirect()->route('admin.investment-plans.index')
            ->with('success', 'Investment plan "' . $name . '" deleted.');
    }

    protected function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:100'],
            'roi_percentage' => ['required', 'numeric', 'min:0'],
            'roi_period'     => ['required', 'in:Daily,Weekly,Monthly'],
            'duration_days'  => ['required', 'integer', 'min:1'],
            'min_amount'     => ['required', 'numeric', 'min:0'],
            'max_amount'     => ['required', 'numeric', 'gte:min_amount'],
            'charge_type'    => ['required', 'in:percentage,fixed'],
            'charge_amount'  => ['required', 'numeric', 'min:0'],
            'sort_order'     => ['required', 'integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    protected function log(Request $request, string $action, ?InvestmentPlan $plan, string $description): void
    {
        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => $action,
            'target_user_id' => null,
            'description'    => $description,
            'meta'           => $plan ? ['investment_plan_id' => $plan->id, 'name' => $plan->name] : null,
        ]);
    }
}
