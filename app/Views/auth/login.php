<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body class="auth-body">
<div class="auth-shell">
    <section class="auth-hero">
        <div class="brand">
            <div class="brand-badge">S</div>
            <div>
                <div>SoundWave</div>
                <small style="color:var(--muted)">Tu música, tus listas</small>
            </div>
        </div>

        <div class="hero-copy">
            <div class="hero-kicker">Música · Playlists · Descubrimiento</div>
            <h2 class="hero-title">Escucha lo que <span>te mueve</span>.</h2>
            <p class="hero-text">
                Una experiencia visual oscura, moderna y fluida para acceder a tu música
                y a tus playlists desde web o app móvil.
            </p>

            <div class="hero-features">
                <div class="feature-pill">Inicio rápido</div>
                <div class="feature-pill">API única</div>
                <div class="feature-pill">Diseño responsive</div>
                <div class="feature-pill">Estilo premium</div>
            </div>
        </div>

        <div class="small">
            Hecho para consumir tu API en CI4 y reutilizar la misma lógica en la app móvil.
        </div>
    </section>

    <section class="auth-panel">
        <div class="auth-card">
            <h1>Iniciar sesión</h1>
            <p>Accede con tu correo y contraseña.</p>

            <div id="notice" class="notice"></div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" placeholder="luis@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" placeholder="••••••••" required>
                </div>

                <button class="btn btn-primary" type="submit">Entrar</button>
            </form>

            <div class="auth-footer">
                ¿No tienes cuenta? <a href="<?= site_url('register') ?>">Regístrate</a>
            </div>
        </div>
    </section>
</div>

<script>
const form = document.getElementById('loginForm');
const notice = document.getElementById('notice');

function showNotice(type, message) {
    notice.className = 'notice ' + type;
    notice.textContent = message;
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    notice.className = 'notice';
    notice.textContent = '';

    const payload = {
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value
    };

    try {
        const res = await fetch('<?= site_url('api/login') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (!res.ok) {
            showNotice('error', data.error || 'No se pudo iniciar sesión.');
            return;
        }

        localStorage.setItem('auth_token', data.token);
        localStorage.setItem('auth_user', JSON.stringify(data.usuario));
        localStorage.setItem('auth_roles', JSON.stringify(data.roles));

        showNotice('success', 'Sesión iniciada correctamente. Redirigiendo...');

        setTimeout(() => {
            window.location.href = '<?= site_url('perfil') ?>';
        }, 700);

    } catch (err) {
        showNotice('error', 'Error de red o servidor.');
    }
});
</script>
</body>
</html>