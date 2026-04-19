<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body class="auth-body">
<div class="auth-shell">
    <section class="auth-hero">
        <div class="brand">
            <div class="brand-badge">S</div>
            <div>
                <div>SoundWave</div>
                <small style="color:var(--muted)">Crea tu cuenta</small>
            </div>
        </div>

        <div class="hero-copy">
            <div class="hero-kicker">Registro rápido · Usuario normal</div>
            <h2 class="hero-title">Empieza a <span>descubrir</span> música.</h2>
            <p class="hero-text">
                Crea tu cuenta y entra al ecosistema: playlists, recomendaciones y acceso
                desde web o aplicación móvil.
            </p>

            <div class="hero-features">
                <div class="feature-pill">Cuenta segura</div>
                <div class="feature-pill">API central</div>
                <div class="feature-pill">Perfil único</div>
                <div class="feature-pill">Listo para MAUI</div>
            </div>
        </div>

        <div class="small">
            El rol se asigna automáticamente como USUARIO. El administrador se define aparte.
        </div>
    </section>

    <section class="auth-panel">
        <div class="auth-card">
            <h1>Crear cuenta</h1>
            <p>Completa tus datos para registrarte.</p>

            <div id="notice" class="notice"></div>

            <form id="registerForm">
                <div class="row">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" placeholder="Luis Roberto" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidoPaterno">Apellido paterno</label>
                        <input type="text" id="apellidoPaterno" placeholder="Carrillo" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="apellidoMaterno">Apellido materno</label>
                        <input type="text" id="apellidoMaterno" placeholder="Perez" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" placeholder="luis@gmail.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirmar contraseña</label>
                    <input type="password" id="confirmPassword" placeholder="••••••••" required>
                </div>

                <button class="btn btn-primary" type="submit">Crear cuenta</button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes cuenta? <a href="<?= site_url('login') ?>">Inicia sesión</a>
            </div>
        </div>
    </section>
</div>

<script>
const form = document.getElementById('registerForm');
const notice = document.getElementById('notice');

function showNotice(type, message) {
    notice.className = 'notice ' + type;
    notice.textContent = message;
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    notice.className = 'notice';
    notice.textContent = '';

    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        showNotice('error', 'Las contraseñas no coinciden.');
        return;
    }

    const payload = {
        nombre: document.getElementById('nombre').value.trim(),
        apellidoPaterno: document.getElementById('apellidoPaterno').value.trim(),
        apellidoMaterno: document.getElementById('apellidoMaterno').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: password
    };

    try {
        const res = await fetch('<?= site_url('api/register') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (!res.ok) {
            showNotice('error', data.error || 'No se pudo registrar.');
            return;
        }

        showNotice('success', 'Cuenta creada correctamente. Ahora puedes iniciar sesión.');

        setTimeout(() => {
            window.location.href = '<?= site_url('login') ?>';
        }, 1000);

    } catch (err) {
        showNotice('error', 'Error de red o servidor.');
    }
});
</script>
</body>
</html>