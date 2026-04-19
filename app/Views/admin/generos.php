<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar géneros</title>
    <style>
        :root{
            --bg:#0b0f14;
            --panel:#121821;
            --panel-2:#0f141b;
            --text:#f4f7fb;
            --muted:#93a4b8;
            --line:rgba(255,255,255,.08);
            --green:#1db954;
            --green-2:#1ed760;
            --red:#ff5c7a;
            --shadow:0 20px 60px rgba(0,0,0,.45);
            --radius:24px;
        }
        *{box-sizing:border-box}
        html,body{height:100%}
        body{
            margin:0;
            font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
            color:var(--text);
            background:
                radial-gradient(circle at top left, rgba(29,185,84,.18), transparent 35%),
                radial-gradient(circle at bottom right, rgba(30,215,96,.10), transparent 28%),
                linear-gradient(180deg, #090d12 0%, #0b0f14 100%);
            min-height:100vh;
        }
        .shell{
            display:grid;
            grid-template-columns: 260px 1fr;
            min-height:100vh;
        }
        .sidebar{
            padding:24px;
            border-right:1px solid var(--line);
            background:rgba(8,12,17,.72);
            backdrop-filter: blur(14px);
        }
        .brand{
            display:flex;
            align-items:center;
            gap:14px;
            font-weight:800;
            margin-bottom:28px;
        }
        .brand-badge{
            width:48px;height:48px;border-radius:16px;
            background:linear-gradient(135deg,var(--green),#47ff96);
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
            border:1px solid var(--line);
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
            flex-wrap:wrap;
            margin-bottom:24px;
        }
        .title h1{
            margin:0;
            font-size:2rem;
            letter-spacing:-.03em;
        }
        .title p{
            margin:6px 0 0;
            color:var(--muted);
        }
        .pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 14px;
            border-radius:999px;
            border:1px solid var(--line);
            background:rgba(255,255,255,.03);
            color:#dce6f2;
        }
        .grid{
            display:grid;
            grid-template-columns: 360px 1fr;
            gap:18px;
        }
        .card{
            background:rgba(18,24,33,.92);
            border:1px solid var(--line);
            border-radius:var(--radius);
            padding:22px;
            box-shadow:var(--shadow);
        }
        .card h2{
            margin:0 0 12px;
            font-size:1.2rem;
        }
        .muted{color:var(--muted)}
        .form-group{margin-bottom:14px}
        label{
            display:block;
            margin-bottom:8px;
            color:#dfe8f4;
            font-size:.93rem;
            font-weight:600;
        }
        input, textarea{
            width:100%;
            border:1px solid rgba(255,255,255,.10);
            background:var(--panel-2);
            color:var(--text);
            border-radius:16px;
            padding:14px 16px;
            outline:none;
            transition:.2s ease;
            font-size:1rem;
        }
        input:focus, textarea:focus{
            border-color:rgba(29,185,84,.65);
            box-shadow:0 0 0 4px rgba(29,185,84,.12);
        }
        .btn{
            border:0;
            border-radius:16px;
            padding:14px 16px;
            font-weight:800;
            font-size:1rem;
            cursor:pointer;
            transition:.2s ease;
        }
        .btn-primary{
            background:linear-gradient(135deg,var(--green),var(--green-2));
            color:#07120d;
            width:100%;
        }
        .btn-secondary{
            background:rgba(255,255,255,.06);
            color:var(--text);
            border:1px solid var(--line);
        }
        .btn-danger{
            background:rgba(255,92,122,.12);
            color:#ffd3dc;
            border:1px solid rgba(255,92,122,.22);
        }
        .btn:hover{transform:translateY(-1px)}
        .actions{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }
        .table-wrap{
            overflow:auto;
            border-radius:18px;
        }
        table{
            width:100%;
            border-collapse:collapse;
            min-width:620px;
        }
        th, td{
            text-align:left;
            padding:14px 12px;
            border-bottom:1px solid var(--line);
        }
        th{
            color:#dfe8f4;
            font-size:.92rem;
            text-transform:uppercase;
            letter-spacing:.04em;
        }
        td{color:#e9f0f8}
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
        .empty{
            padding:18px;
            color:var(--muted);
            text-align:center;
        }
        .row-inline{
            display:flex;
            gap:10px;
            align-items:center;
        }
        .row-inline .btn{padding:10px 12px;font-size:.92rem}
        @media (max-width: 980px){
            .shell{grid-template-columns:1fr}
            .sidebar{border-right:0;border-bottom:1px solid var(--line)}
            .grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-badge">S</div>
            <div>
                <div>SoundWave</div>
                <small style="color:var(--muted)">Admin · Géneros</small>
            </div>
        </div>

        <div class="pill" id="roleBadge">ADMIN</div>

        <div class="nav">
            <a href="<?= site_url('perfil') ?>">Perfil</a>
            <a href="<?= site_url('login') ?>">Cambiar sesión</a>
            <button type="button" id="logoutBtn">Cerrar sesión</button>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="title">
                <h1>Administrar géneros</h1>
                <p>Crear, editar y eliminar géneros disponibles en la plataforma.</p>
            </div>
            <div class="pill" id="emailChip">—</div>
        </div>

        <div id="notice" class="notice"></div>

        <div class="grid">
            <section class="card">
                <h2 id="formTitle">Nuevo género</h2>
                <p class="muted">Captura un nombre único para el catálogo.</p>

                <form id="genreForm">
                    <input type="hidden" id="genero_Id" value="">
                    <div class="form-group">
                        <label for="genero_Nombre">Nombre del género</label>
                        <input type="text" id="genero_Nombre" placeholder="Rock Alternativo" required>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit" id="saveBtn">Guardar</button>
                        <button class="btn btn-secondary" type="button" id="cancelBtn" style="display:none;">Cancelar</button>
                    </div>
                </form>
            </section>

            <section class="card">
                <h2>Listado de géneros</h2>
                <p class="muted">Selecciona editar o eliminar desde aquí.</p>

                <div class="table-wrap" style="margin-top:16px;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="genreTableBody">
                            <tr><td colspan="3" class="empty">Cargando...</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<script>
const token = localStorage.getItem('auth_token');
const roles = JSON.parse(localStorage.getItem('auth_roles') || '[]');
const notice = document.getElementById('notice');
const body = document.getElementById('genreTableBody');
const form = document.getElementById('genreForm');
const cancelBtn = document.getElementById('cancelBtn');
const formTitle = document.getElementById('formTitle');
const saveBtn = document.getElementById('saveBtn');

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

if (!token) {
    window.location.href = '<?= site_url('login') ?>';
}

async function api(url, options = {}) {
    const res = await fetch(url, {
        ...options,
        headers: {
            ...(options.headers || {}),
            'Authorization': 'Bearer ' + token
        }
    });
    const data = await res.json();
    return { res, data };
}

function resetForm() {
    form.reset();
    document.getElementById('genero_Id').value = '';
    formTitle.textContent = 'Nuevo género';
    saveBtn.textContent = 'Guardar';
    cancelBtn.style.display = 'none';
}

function fillForm(genero) {
    document.getElementById('genero_Id').value = genero.genero_Id;
    document.getElementById('genero_Nombre').value = genero.genero_Nombre;
    formTitle.textContent = 'Editar género';
    saveBtn.textContent = 'Actualizar';
    cancelBtn.style.display = 'inline-block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function loadGenres() {
    body.innerHTML = '<tr><td colspan="3" class="empty">Cargando...</td></tr>';

    const { res, data } = await api('<?= site_url('api/generos') ?>');

    if (!res.ok) {
        body.innerHTML = '<tr><td colspan="3" class="empty">No se pudieron cargar los géneros.</td></tr>';
        showNotice('error', data.error || 'Error al cargar géneros');
        return;
    }

    const generos = data.generos || [];

    if (!generos.length) {
        body.innerHTML = '<tr><td colspan="3" class="empty">No hay géneros registrados.</td></tr>';
        return;
    }

    body.innerHTML = generos.map(g => `
        <tr>
            <td>${g.genero_Id}</td>
            <td>${escapeHtml(g.genero_Nombre)}</td>
            <td>
                <div class="row-inline">
                    <button class="btn btn-secondary" type="button" onclick='editGenre(${JSON.stringify(g).replace(/'/g, "&apos;")})'>Editar</button>
                    <button class="btn btn-danger" type="button" onclick="deleteGenre(${g.genero_Id})">Eliminar</button>
                </div>
            </td>
        </tr>
    `).join('');
}

window.editGenre = function(genero) {
    fillForm(genero);
}

async function deleteGenre(id) {
    if (!confirm('¿Eliminar este género?')) return;

    const { res, data } = await api(`<?= site_url('api/admin/generos') ?>/${id}`, {
        method: 'DELETE'
    });

    if (!res.ok) {
        showNotice('error', data.error || 'No se pudo eliminar');
        return;
    }

    showNotice('success', 'Género eliminado correctamente');
    resetForm();
    loadGenres();
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const id = document.getElementById('genero_Id').value;
    const payload = {
        genero_Nombre: document.getElementById('genero_Nombre').value.trim()
    };

    const method = id ? 'PUT' : 'POST';
    const url = id
        ? `<?= site_url('api/admin/generos') ?>/${id}`
        : '<?= site_url('api/admin/generos') ?>';

    const { res, data } = await api(url, {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    });

    if (!res.ok) {
        showNotice('error', data.error || 'No se pudo guardar');
        return;
    }

    showNotice('success', data.message || 'Género guardado');
    resetForm();
    loadGenres();
});

cancelBtn.addEventListener('click', resetForm);

function escapeHtml(text) {
    return String(text)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

loadGenres();
</script>
</body>
</html>