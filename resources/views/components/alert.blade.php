@if (session('alert'))
    @php
        // Map custom alert types to Bootstrap classes
        $bootstrapClasses = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
        ];

        // Get the Bootstrap class for the current alert type, or fallback to 'alert-info'
        $alertClass = $bootstrapClasses[session('alert')['type']] ?? 'alert-info';
    @endphp

    <div class="alert {{ $alertClass }} rounded p-3 my-3">
        {{ session('alert')['message'] }}
    </div>
@endif
