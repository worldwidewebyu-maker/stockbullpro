<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $faq = new Faq([
            'is_active'  => true,
            'sort_order' => (int) Faq::max('sort_order') + 1,
        ]);

        return view('admin.faqs.create', compact('faq'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $faq = Faq::create($data);

        $this->log($request, 'create_faq', 'Created FAQ: ' . $faq->question);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ added successfully.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($this->validateData($request));

        $this->log($request, 'update_faq', 'Updated FAQ: ' . $faq->question);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Request $request, Faq $faq)
    {
        $question = $faq->question;
        $faq->delete();

        $this->log($request, 'delete_faq', 'Deleted FAQ: ' . $question);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ removed successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'question'   => ['required', 'string', 'max:500'],
            'answer'     => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function log(Request $request, string $action, string $description): void
    {
        AdminActivityLog::create([
            'admin_id'    => $request->user()->id,
            'action'      => $action,
            'description' => $description,
        ]);
    }
}
