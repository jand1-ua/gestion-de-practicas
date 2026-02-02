@if ($errors->any())
    <div class="error-box" role="alert" aria-live="polite">
        <div class="error-text" style="font-weight:650; margin-bottom:6px;">Se han encontrado errores:</div>
        <ul style="margin:0; padding-left:18px; color: rgba(255,255,255,.88); font-size:13px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
