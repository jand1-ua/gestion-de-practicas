@if (session('success'))
    <div class="alert alert-success" role="status">
        <strong>OK:</strong> {{ session('success') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info" role="status">
        <strong>Info:</strong> {{ session('info') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> {{ session('error') }}
    </div>
@endif

@if (session('portal_access'))
    @php($portalAccess = session('portal_access'))
    <div class="alert alert-success portal-access-alert" role="status">
        <strong>Acceso al portal generado.</strong>
        <div class="portal-access-grid">
            <div>
                <div class="portal-access-label">Perfil</div>
                <div>{{ $portalAccess['role_label'] ?? 'Usuario' }}</div>
            </div>
            <div>
                <div class="portal-access-label">Nombre</div>
                <div>{{ $portalAccess['name'] ?? '-' }}</div>
            </div>
            <div>
                <div class="portal-access-label">Email de acceso</div>
                <div><strong>{{ $portalAccess['email'] ?? '-' }}</strong></div>
            </div>
            <div>
                <div class="portal-access-label">Contraseña temporal</div>
                <div><code>{{ $portalAccess['password'] ?? '-' }}</code></div>
            </div>
        </div>
        <div class="help" style="margin-top:8px; color:inherit;">
            Guarda esta contraseña ahora. Solo se muestra una vez y el usuario deberá cambiarla en su primer acceso.
        </div>
    </div>
@endif
