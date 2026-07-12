<?php

if (! function_exists('whatsapp_url')) {
    function whatsapp_url(?string $number = null): ?string
    {
        if (! $number) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $number);

        return $digits !== '' ? 'https://wa.me/' . $digits : null;
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (! function_exists('txn_badge')) {
    function txn_badge(string $status): string
    {
        $map = [
            'pending'   => ['label' => 'Pending',   'class' => 'badge-txn-pending'],
            'approved'  => ['label' => 'Approved',  'class' => 'badge-txn-success'],
            'completed' => ['label' => 'Completed', 'class' => 'badge-txn-success'],
            'rejected'  => ['label' => 'Rejected',  'class' => 'badge-txn-danger'],
            'declined'  => ['label' => 'Declined',  'class' => 'badge-txn-danger'],
            'active'    => ['label' => 'Active',    'class' => 'badge-txn-active'],
            'matured'   => ['label' => 'Matured',   'class' => 'badge-txn-success'],
            'cancelled' => ['label' => 'Cancelled', 'class' => 'badge-txn-danger'],
        ];

        $item = $map[$status] ?? ['label' => ucfirst($status), 'class' => 'badge-txn-pending'];

        return '<span class="' . $item['class'] . '">' . $item['label'] . '</span>';
    }
}
