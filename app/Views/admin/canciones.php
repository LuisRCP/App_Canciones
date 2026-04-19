<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar canciones</title>
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
            grid-template-columns: 420px 1fr;
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
        input, select, textarea{
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
        textarea{min-height:110px; resize:vertical}
        input:focus, select:focus, textarea:focus{
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
            min-width:980px;
        }
        th, td{
            text-align:left;
            padding:14px 12px;
            border-bottom:1px solid var(--line);
            vertical-align:top;
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
            flex-wrap:wrap;
        }
        .row-inline .btn{padding:10px 12px;font-size:.92rem}
        .thumb{
            width:64px;
            height:64px;
            border-radius:14px;
            object-fit:cover;
            border:1px solid var(--line);
            background:#10161f;
        }
        .mini{
            color:var(--muted);
            font-size:.9rem;
        }
        .span-2{grid-column:span 2}
        @media (max-width: 1100px){
            .grid{grid-template-columns:1fr}
            .span-2{grid-column:span 1}
        }
        @media (max-width: 980px){
            .shell{grid-template-columns:1fr}
            .sidebar{border-right:0;border-bottom:1px solid var(--line)}
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
                <small style="color:var(--muted)">Admin · Canciones</small>
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
                <h1>Administrar canciones</h1>
                <p>Alta, edición y eliminación del catálogo musical.</p>
            </div>
            <div class="pill" id="emailChip">—</div>
        </div>

        <div id="notice" class="notice"></div>

        <div class="grid">
            <section class="card">
                <h2 id="formTitle">Nueva canción</h2>
                <p class="muted">Sube audio y portada, o pega rutas si lo prefieres.</p>

                <form id="songForm" enctype="multipart/form-data">
                    <input type="hidden" id="cancion_Id" value="">

                    <div class="form-group">
                        <label for="cancion_Nombre">Nombre de la canción</label>
                        <input type="text" id="cancion_Nombre" placeholder="Mi canción" required>
                    </div>

                    <div class="form-group">
                        <label for="autor">Autor</label>
                        <input type="text" id="autor" placeholder="Artista" required>
                    </div>

                    <div class="form-group">
                        <label for="genero_Id">Género</label>
                        <select id="genero_Id">
                            <option value="">Cargando géneros...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_lanzamiento">Fecha de lanzamiento</label>
                        <input type="date" id="fecha_lanzamiento">
                    </div>

                    <div class="form-group">
                        <label for="duracion">Duración (segundos)</label>
                        <input type="number" id="duracion" min="0" step="1" placeholder="180">
                    </div>

                    <div class="form-group">
                        <label for="imagen">Portada (archivo)</label>
                        <input type="file" id="imagen" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="audio">Audio (archivo)</label>
                        <input type="file" id="audio" accept="audio/*">
                    </div>

                    <div class="form-group">
                        <label for="archivo_url">Ruta de audio alternativa</label>
                        <input type="text" id="archivo_url" placeholder="uploads/canciones/archivo.mp3">
                        <div class="mini">Usa este campo solo si no vas a subir archivo.</div>
                    </div>

                    <div class="form-group">
                        <label for="imagen_url">Ruta de portada alternativa</label>
                        <input type="text" id="imagen_url" placeholder="uploads/portadas/imagen.jpg">
                    </div>

                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <select id="activo">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit" id="saveBtn">Guardar</button>
                        <button class="btn btn-secondary" type="button" id="cancelBtn" style="display:none;">Cancelar</button>
                    </div>
                </form>
            </section>

            <section class="card span-2">
                <h2>Listado de canciones</h2>
                <p class="muted">Gestiona el catálogo y revisa portada, género y archivo.</p>

                <div class="table-wrap" style="margin-top:16px;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Portada</th>
                                <th>Nombre</th>
                                <th>Autor</th>
                                <th>Género</th>
                                <th>Duración</th>
                                <th>Archivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="songTableBody">
                            <tr><td colspan="9" class="empty">Cargando...</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<script>
const token = localStorage.getItem('auth_token');
const notice = document.getElementById('notice');
const body = document.getElementById('songTableBody');
const form = document.getElementById('songForm');
const cancelBtn = document.getElementById('cancelBtn');
const formTitle = document.getElementById('formTitle');
const saveBtn = document.getElementById('saveBtn');
const genreSelect = document.getElementById('genero_Id');

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

    const contentType = res.headers.get('content-type') || '';
    let data = null;

    if (contentType.includes('application/json')) {
        data = await res.json();
    } else {
        data = await res.text();
    }

    return { res, data };
}

function resetForm() {
    form.reset();
    document.getElementById('cancion_Id').value = '';
    document.getElementById('archivo_url').value = '';
    document.getElementById('imagen_url').value = '';
    formTitle.textContent = 'Nueva canción';
    saveBtn.textContent = 'Guardar';
    cancelBtn.style.display = 'none';
}

function fillForm(song) {
    document.getElementById('cancion_Id').value = song.cancion_Id;
    document.getElementById('cancion_Nombre').value = song.cancion_Nombre || '';
    document.getElementById('autor').value = song.autor || '';
    document.getElementById('genero_Id').value = song.genero_Id || '';
    document.getElementById('fecha_lanzamiento').value = song.fecha_lanzamiento || '';
    document.getElementById('duracion').value = song.duracion || '';
    document.getElementById('archivo_url').value = song.archivo_url || '';
    document.getElementById('imagen_url').value = song.imagen || '';
    document.getElementById('activo').value = String(song.activo ?? 1);
    formTitle.textContent = 'Editar canción';
    saveBtn.textContent = 'Actualizar';
    cancelBtn.style.display = 'inline-block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function loadGenres() {
    const { res, data } = await api('<?= site_url('api/generos') ?>');

    if (!res.ok) {
        genreSelect.innerHTML = '<option value="">Error al cargar géneros</option>';
        return;
    }

    const generos = data.generos || [];
    if (!generos.length) {
        genreSelect.innerHTML = '<option value="">Sin géneros</option>';
        return;
    }

    genreSelect.innerHTML = '<option value="">Selecciona un género</option>' + generos.map(g => `
        <option value="${g.genero_Id}">${escapeHtml(g.genero_Nombre)}</option>
    `).join('');
}

async function loadSongs() {
    body.innerHTML = '<tr><td colspan="9" class="empty">Cargando...</td></tr>';

    const { res, data } = await api('<?= site_url('api/canciones') ?>');

    if (!res.ok) {
        body.innerHTML = '<tr><td colspan="9" class="empty">No se pudieron cargar las canciones.</td></tr>';
        showNotice('error', data.error || 'Error al cargar canciones');
        return;
    }

    const canciones = data.canciones || [];

    if (!canciones.length) {
        body.innerHTML = '<tr><td colspan="9" class="empty">No hay canciones registradas.</td></tr>';
        return;
    }

    body.innerHTML = canciones.map(c => `
        <tr>
            <td>${c.cancion_Id}</td>
            <td>
                ${c.imagen ? `<img class="thumb" src="${assetUrl(c.imagen)}" alt="Portada">` : '<div class="mini">Sin imagen</div>'}
            </td>
            <td>${escapeHtml(c.cancion_Nombre || '')}</td>
            <td>${escapeHtml(c.autor || '')}</td>
            <td>${escapeHtml(c.genero_Nombre || '—')}</td>
            <td>${formatDuration(c.duracion)}</td>
            <td>
                ${c.archivo_url ? `<a href="${assetUrl(c.archivo_url)}" target="_blank" style="color:#1ed760;text-decoration:none;">Abrir</a>` : '—'}
            </td>
            <td>${Number(c.activo) === 1 ? 'Activo' : 'Inactivo'}</td>
            <td>
                <div class="row-inline">
                    <button class="btn btn-secondary" type="button" onclick='editSong(${JSON.stringify(c).replace(/'/g, "&apos;")})'>Editar</button>
                    <button class="btn btn-danger" type="button" onclick="deleteSong(${c.cancion_Id})">Eliminar</button>
                </div>
            </td>
        </tr>
    `).join('');
}

window.editSong = function(song) {
    fillForm(song);
}

async function deleteSong(id) {
    if (!confirm('¿Eliminar esta canción?')) return;

    const { res, data } = await api(`<?= site_url('api/admin/canciones') ?>/${id}`, {
        method: 'DELETE'
    });

    if (!res.ok) {
        showNotice('error', data.error || 'No se pudo eliminar');
        return;
    }

    showNotice('success', 'Canción eliminada correctamente');
    resetForm();
    loadSongs();
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const id = document.getElementById('cancion_Id').value;
    const url = id
        ? `<?= site_url('api/admin/canciones') ?>/${id}`
        : '<?= site_url('api/admin/canciones') ?>';

    const formData = new FormData();
    formData.append('cancion_Nombre', document.getElementById('cancion_Nombre').value.trim());
    formData.append('autor', document.getElementById('autor').value.trim());
    formData.append('genero_Id', document.getElementById('genero_Id').value);
    formData.append('fecha_lanzamiento', document.getElementById('fecha_lanzamiento').value);
    formData.append('duracion', document.getElementById('duracion').value);
    formData.append('archivo_url', document.getElementById('archivo_url').value.trim());
    formData.append('imagen', document.getElementById('imagen_url').value.trim());
    formData.append('activo', document.getElementById('activo').value);

    const audioFile = document.getElementById('audio').files[0];
    const imageFile = document.getElementById('imagen').files[0];

    if (audioFile) formData.append('audio', audioFile);
    if (imageFile) formData.append('imagen', imageFile);

    const { res, data } = await api(url, {
        method: id ? 'POST' : 'POST',
        body: formData
    });

    if (!res.ok) {
        showNotice('error', data.error || 'No se pudo guardar');
        return;
    }

    showNotice('success', data.message || 'Canción guardada');
    resetForm();
    loadSongs();
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

function assetUrl(path) {
    if (!path) return '';
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return '<?= base_url() ?>' + path.replace(/^\/+/, '');
}

function formatDuration(sec) {
    const n = Number(sec || 0);
    const m = Math.floor(n / 60);
    const s = n % 60;
    return `${m}:${String(s).padStart(2, '0')}`;
}

loadGenres();
loadSongs();
</script>
</body>
</html>