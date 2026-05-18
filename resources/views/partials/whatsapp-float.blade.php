@php
    $adminId = session('admin_user.id');
    $dbWaNumber = null;

    if ($adminId) {
        $dbWaNumber = \App\Models\User::where('id', $adminId)->value('no_wa');
    }

    if (! $dbWaNumber) {
        $dbWaNumber = \App\Models\User::whereNotNull('no_wa')->orderBy('id')->value('no_wa');
    }

    $waNumber = preg_replace('/\D+/', '', $dbWaNumber ?: env('WHATSAPP_SELLER_NUMBER', '6281933918737'));
    $waDefaultMessage = __('site.whatsapp.default_message');
    $waText = urlencode(env('WHATSAPP_DEFAULT_MESSAGE', $waDefaultMessage));
    $waUrl = 'https://wa.me/' . $waNumber . '?text=' . $waText;
@endphp

<style>
    .wa-float {
        position: fixed;
        right: 18px;
        bottom: 18px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #25d366;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .22);
        z-index: 9999;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .wa-float:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, .25);
    }

    .wa-float svg {
        width: 30px;
        height: 30px;
        fill: #fff;
    }
</style>

<a class="wa-float" href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('site.whatsapp.aria') }}">
    <svg viewBox="0 0 32 32" role="img" aria-hidden="true">
        <path d="M19.11 17.21c-.27-.14-1.59-.79-1.83-.88-.24-.09-.42-.14-.6.14-.18.27-.69.88-.85 1.06-.16.18-.31.2-.58.07-.27-.14-1.12-.41-2.14-1.3-.79-.7-1.33-1.56-1.49-1.83-.16-.27-.02-.42.12-.56.13-.13.27-.31.41-.47.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.47-.07-.14-.6-1.46-.82-2-.22-.52-.45-.45-.6-.45-.16-.01-.34-.01-.52-.01-.18 0-.47.07-.72.34-.24.27-.94.91-.94 2.21 0 1.3.96 2.56 1.09 2.74.14.18 1.88 2.87 4.55 4.03.64.28 1.14.45 1.53.58.64.2 1.22.17 1.68.1.51-.08 1.59-.65 1.81-1.27.22-.61.22-1.14.16-1.27-.07-.13-.25-.2-.52-.34M16.01 4.01c-6.62 0-12 5.38-12 12 0 2.12.55 4.11 1.52 5.84L4 28l6.35-1.66a11.94 11.94 0 0 0 5.66 1.44h.01c6.62 0 12-5.38 12-12s-5.39-12-12.01-12m0 21.71h-.01c-1.8 0-3.57-.48-5.11-1.39l-.37-.22-3.77.99 1.01-3.67-.24-.38a9.93 9.93 0 0 1-1.52-5.27c0-5.5 4.48-9.98 9.99-9.98 2.66 0 5.16 1.03 7.04 2.92a9.88 9.88 0 0 1 2.93 7.05c0 5.5-4.49 9.98-9.95 9.98"></path>
    </svg>
</a>

