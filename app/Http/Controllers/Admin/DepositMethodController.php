<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\DepositMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepositMethodController extends Controller
{
    public function index()
    {
        $methods = DepositMethod::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.deposit-methods.index', compact('methods'));
    }

    public function create()
    {
        $method = new DepositMethod([
            'min_amount'   => 1,
            'max_amount'   => 1000000,
            'charge_type'  => 'percentage',
            'charge_amount' => 0,
            'is_active'    => true,
            'sort_order'   => (int) DepositMethod::max('sort_order') + 1,
        ]);

        return view('admin.deposit-methods.create', compact('method'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['qr_code'] = $this->handleQrUpload($request);

        $method = DepositMethod::create($data);

        $this->log($request, 'create_deposit_method', $method, 'Created deposit method ' . $method->name);

        return redirect()->route('admin.deposit-methods.index')
            ->with('success', 'Deposit method "' . $method->name . '" created.');
    }

    public function edit(DepositMethod $depositMethod)
    {
        return view('admin.deposit-methods.edit', ['method' => $depositMethod]);
    }

    public function update(Request $request, DepositMethod $depositMethod)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('qr_code')) {
            $this->deleteQr($depositMethod);
            $data['qr_code'] = $this->handleQrUpload($request);
        } elseif ($request->boolean('remove_qr')) {
            $this->deleteQr($depositMethod);
            $data['qr_code'] = null;
        }

        $depositMethod->update($data);

        $this->log($request, 'update_deposit_method', $depositMethod, 'Updated deposit method ' . $depositMethod->name);

        return redirect()->route('admin.deposit-methods.index')
            ->with('success', 'Deposit method "' . $depositMethod->name . '" updated.');
    }

    public function toggle(Request $request, DepositMethod $depositMethod)
    {
        $depositMethod->update(['is_active' => ! $depositMethod->is_active]);

        $this->log($request, 'toggle_deposit_method', $depositMethod,
            ($depositMethod->is_active ? 'Activated' : 'Deactivated') . ' deposit method ' . $depositMethod->name);

        return back()->with('success', 'Deposit method "' . $depositMethod->name . '" '
            . ($depositMethod->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function destroy(Request $request, DepositMethod $depositMethod)
    {
        if ($depositMethod->logs()->exists()) {
            return back()->with('error',
                'Cannot delete "' . $depositMethod->name . '" because it has deposit records. Deactivate it instead.');
        }

        $name = $depositMethod->name;
        $this->deleteQr($depositMethod);
        $depositMethod->delete();

        $this->log($request, 'delete_deposit_method', null, 'Deleted deposit method ' . $name);

        return redirect()->route('admin.deposit-methods.index')
            ->with('success', 'Deposit method "' . $name . '" deleted.');
    }

    protected function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'network_type'  => ['nullable', 'string', 'max:100'],
            'wallet_address' => ['nullable', 'string', 'max:255'],
            'qr_code'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'min_amount'    => ['required', 'numeric', 'min:0'],
            'max_amount'    => ['required', 'numeric', 'gte:min_amount'],
            'charge_type'   => ['required', 'in:percentage,fixed'],
            'charge_amount' => ['required', 'numeric', 'min:0'],
            'sort_order'    => ['required', 'integer', 'min:0'],
        ]);

        // qr_code is handled separately as a file upload.
        unset($validated['qr_code']);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    protected function handleQrUpload(Request $request): ?string
    {
        if (! $request->hasFile('qr_code')) {
            return null;
        }

        return $request->file('qr_code')->store('deposit-methods/qr', 'public');
    }

    protected function deleteQr(DepositMethod $method): void
    {
        if ($method->qr_code && Storage::disk('public')->exists($method->qr_code)) {
            Storage::disk('public')->delete($method->qr_code);
        }
    }

    protected function log(Request $request, string $action, ?DepositMethod $method, string $description): void
    {
        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => $action,
            'target_user_id' => null,
            'description'    => $description,
            'meta'           => $method ? ['deposit_method_id' => $method->id, 'name' => $method->name] : null,
        ]);
    }
}
