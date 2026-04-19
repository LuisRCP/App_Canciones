<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        body.profile-body{
            margin:0;
            font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
            color:#f4f7fb;
            background:
                radial-gradient(circle at top left, rgba(29,185,84,.18), transparent 35%),
                radial-gradient(circle at bottom right, rgba(30,215,96,.10), transparent 28%),
                linear-gradient(180deg, #090d12 0%, #0b0f14 100%);
            min-height:100vh;
        }
        .profile-shell{
            display:grid;
            grid-template-columns: 280px 1fr;
            min-height:100vh;
        }
        .sidebar{
            padding:24px;
            border-right:1px solid rgba(255,255,255,.08);
            background:rgba(8,12,17,.72);
            backdrop-filter: blur(14px);
        }
        .brand{
            display:flex;
            align-items:center;
            gap:14px;
            font-weight:800;
            letter-spacing:.3px;
            margin-bottom:28px;
        }
        .brand-badge{
            width:48px;height:48px;border-radius:16px;
            background:linear-gradient(135deg,#1db954,#47ff96);
            display:grid;place-items:center;color:#08110d;font-weight:900;
        }
        .nav{
            display:flex;
            flex-direction:column;
            gap:10px;
            margin-top:18px;
        }
        .nav a, .nav button{
            text-decoration:none;
            color:#dce6f2;
            background:rgba(255,255,255,.03);
            border:1px solid rgba(255,255,255,.08);
            padding:14px 16px;
            border-radius:16px;
            text-align:left;
            cursor:pointer;
            font-size:.98rem;
        }
        .nav a:hover, .nav button:hover{
            border-color:rgba(29,185,84,.35);
        }
        .main{
            padding:28px;
        }
        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            margin-bottom:24px;
            flex-wrap:wrap;
        }
        .welcome h1{
            margin:0;
            font-size:2rem;
            letter-spacing:-.03em;
        }
        .welcome p{
            margin:6px 0 0;
            color:#93a4b8;
        }
        .pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:999px;
            border:1px solid rgba(255,255,255,.08);
            background:rgba(255,255,255,.03);
            color:#dce6f2;
        }
        .grid{
            display:grid;
            grid-template-columns:repeat(12,1fr);
            gap:18px;
        }
        .card{
            background:rgba(18,24,33,.92);
            border:1px solid rgba(255,255,255,.08);
            border-radius:24px;
            padding:22px;
            box-shadow:0 20px 60px rgba(0,0,0,.28);
        }
        .card h2{
            margin:0 0 8px;
            font-size:1.2rem;
        }
        .card p{
            margin:0;
            color:#93a4b8;
            line-height:1.6;
        }
        .span-4{grid-column:span 4}
        .span-6{grid-column:span 6}
        .span-8{grid-column:span 8}
        .span-12{grid-column:span 12}

        .section-title{
            margin:0 0 14px;
            font-size:1rem;
            color:#dce6f2;
            font-weight:800;
            letter-spacing:.02em;
        }
        .action-list{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:12px;
            margin-top:16px;
        }
        .action{
            background:rgba(255,255,255,.04);
            border:1px solid rgba(255,255,255,.08);
            border-radius:18px;
            padding:16px;
            min-height:110px;
        }
        .action strong{
            display:block;
            margin-bottom:8px;
        }
        .action span{
            color:#93a4b8;
            font-size:.95rem;
            line-height:1.5;
        }
        .badge-admin{
            display:inline-flex;
            align-items:center;
            padding:8px 12px;
            border-radius:999px;
            background:rgba(29,185,84,.14);
            color:#b8ffd4;
            border:1px solid rgba(29,185,84,.22);
            font-weight:700;
            margin-left:8px;
        }
        .badge-user{
            display:inline-flex;
            align-items:center;
            padding:8px 12px;
            border-radius:999px;
            background:rgba(255,255,255,.06);
            color:#dce6f2;
            border:1px solid rgba(255,255,255,.10);
            font-weight:700;
            margin-left:8px;
        }
        .notice{
            display:none;
            margin-bottom:16px;
            padding:12px 14px;
            border-radius:14px;
            font-size:.95rem;
            line-height:1.5;
        }
        .notice.success{
            display:block;
            background:rgba(29,185,84,.12);
            border:1px solid rgba(29,185,84,.25);
            color:#b8ffd4;
        }
        .notice.error{
            display:block;
            background:rgba(255,92,122,.12);
            border:1px solid rgba(255,92,122,.25);
            color:#ffd3dc;
        }
        .muted{color:#93a4b8}
        .action{
            cursor:pointer;
            transition: all .2s ease;
        }

        .action:hover{
            border-color: rgba(29,185,84,.35);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }

        @media (max-width: 980px){
            .profile-shell{grid-template-columns:1fr}
            .sidebar{border-right:0;border-bottom:1px solid rgba(255,255,255,.08)}
            .span-4,.span-6,.span-8,.span-12{grid-column:span 12}
        }
        @media (max-width: 640px){
            .main{padding:18px}
            .card{padding:18px}
            .action-list{grid-template-columns:1fr}
        }
    </style>
</head>
<body class="profile-body">
<div class="profile-shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-badge">S</div>
            <div>
                <div>SoundWave</div>
                <small style="color:#93a4b8">Panel principal</small>
            </div>
        </div>

        <div id="roleBadge" class="pill">Cargando rol...</div>

        <div class="nav">
            <a href="<?= site_url('perfil') ?>">Inicio</a>
            <a href="<?= site_url('login') ?>">Cambiar sesión</a>
            <button type="button" id="logoutBtn">Cerrar sesión</button>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="welcome">
                <h1>Perfil</h1>
                <p id="profileSubtitle">Cargando información...</p>
            </div>
            <div class="pill" id="emailChip">—</div>
        </div>

        <div id="notice" class="notice"></div>

        <div class="grid">
            <section class="card span-4">
                <h2>Datos de cuenta</h2>
                <p id="fullName">—</p>
                <p class="muted" id="accountEmail">—</p>
            </section>

            <section class="card span-4">
                <h2>Tu acceso</h2>
                <p id="rolesList">—</p>
            </section>

            <section class="card span-4">
                <h2>Recomendación</h2>
                <p id="recoBox">Se generará una playlist basada en tus gustos cuando no tengas una creada.</p>
            </section>

            <section class="card span-12" id="adminSection" style="display:none;">
                <h2>Panel administrador</h2>
                <p>Gestiona el catálogo y el contenido multimedia.</p>

                <div class="action-list">

                    <a href="<?= site_url('admin/canciones') ?>" class="action" style="text-decoration:none; color:inherit;">
                        <strong>Alta de canciones</strong>
                        <span>Sube tracks nuevos, asigna autor, duración, género y archivo de audio.</span>
                    </a>

                    <a href="<?= site_url('admin/generos') ?>" class="action" style="text-decoration:none; color:inherit;">
                        <strong>Géneros</strong>
                        <span>Crea y administra los géneros disponibles para la plataforma.</span>
                    </a>

                    <div class="action">
                        <strong>Portadas</strong>
                        <span>Las portadas se gestionan directamente dentro de canciones.</span>
                    </div>

                    <div class="action" onclick="goTo('<?= site_url('reproductor') ?>')">
                        <strong>Reproductor</strong>
                        <span>Escucha canciones y navega por el catálogo disponible.</span>
                    </div>

                </div>
            </section>

            <section class="card span-12" id="userSection" style="display:none;">
                <h2>Panel de usuario</h2>
                <p>Explora música, crea playlists y recibe sugerencias personalizadas.</p>

                <div class="action-list">
                    <div class="action">
                        <strong>Elegir géneros</strong>
                        <span>Selecciona los géneros disponibles para definir tus preferencias.</span>
                    </div>
                    <div class="action">
                        <strong>Crear playlist</strong>
                        <span>Arma tus propias listas y guarda canciones favoritas.</span>
                    </div>
                    <div class="action">
                        <strong>Playlist automática</strong>
                        <span>Si no tienes una lista creada, OpenAI puede sugerir una según tus gustos.</span>
                    </div>
                    <div class="action">
                        <strong>Escuchar música</strong>
                        <span>Reproduce canciones y navega por el catálogo disponible.</span>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<script>
const notice = document.getElementById('notice');
const token = localStorage.getItem('auth_token');

function showNotice(type, message) {
    notice.className = 'notice ' + type;
    notice.textContent = message;
}

function logout() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('auth_user');
    localStorage.removeItem('auth_roles');
    window.location.href = '<?= site_url('login') ?>';
}

document.getElementById('logoutBtn').addEventListener('click', logout);

async function loadProfile() {
    if (!token) {
        showNotice('error', 'No hay sesión activa. Redirigiendo...');
        setTimeout(() => window.location.href = '<?= site_url('login') ?>', 900);
        return;
    }

    try {
        const res = await fetch('<?= site_url('api/perfil') ?>', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
            showNotice('error', data.error || 'No se pudo cargar el perfil.');
            return;
        }

        const usuario = data.usuario;
        const roles = data.roles || [];
        const roleNames = roles.map(r => r.nombre);

        const fullName = `${usuario.persona_Nombre} ${usuario.persona_ApellidoPaterno} ${usuario.persona_ApellidoMaterno}`;
        document.getElementById('fullName').textContent = fullName;
        document.getElementById('accountEmail').textContent = usuario.email;
        document.getElementById('emailChip').textContent = usuario.email;
        document.getElementById('profileSubtitle').textContent = `Sesión activa como ${roleNames.join(', ') || 'usuario'}.`;
        document.getElementById('rolesList').textContent = roleNames.length ? roleNames.join(' · ') : 'Sin roles';
        document.getElementById('recoBox').textContent = 'Aún no hay playlists automáticas. Cuando el usuario no tenga una creada, se podrá generar una con OpenAI.';
        
        const isAdmin = roleNames.includes('ADMIN');
        document.getElementById('adminSection').style.display = isAdmin ? 'block' : 'none';
        document.getElementById('userSection').style.display = isAdmin ? 'none' : 'block';
        document.getElementById('roleBadge').className = isAdmin ? 'badge-admin' : 'badge-user';
        document.getElementById('roleBadge').textContent = isAdmin ? 'ADMINISTRADOR' : 'USUARIO';

    } catch (err) {
        showNotice('error', 'Error de red o servidor.');
    }
}

loadProfile();

function goTo(url) {
    window.location.href = url;
}
</script>
</body>
</html>