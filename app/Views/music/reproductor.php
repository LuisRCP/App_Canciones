<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reproductor</title>
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
            grid-template-columns: 280px 1fr;
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
            grid-template-columns: 1.1fr .9fr;
            gap:18px;
        }
        .card{
            background:rgba(18,24,33,.92);
            border:1px solid var(--line);
            border-radius:var(--radius);
            padding:22px;
            box-shadow:var(--shadow);
        }
        .section-title{
            margin:0 0 14px;
            font-size:1rem;
            color:#dce6f2;
            font-weight:800;
            letter-spacing:.02em;
        }
        .filters{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin-bottom:16px;
        }
        .chip{
            border:1px solid var(--line);
            background:rgba(255,255,255,.03);
            color:#dce6f2;
            padding:10px 14px;
            border-radius:999px;
            cursor:pointer;
            transition:.2s ease;
        }
        .chip.active, .chip:hover{
            border-color:rgba(29,185,84,.35);
            background:rgba(29,185,84,.14);
        }
        .song-list{
            display:flex;
            flex-direction:column;
            gap:12px;
            max-height:620px;
            overflow:auto;
            padding-right:4px;
        }
        .song{
            display:grid;
            grid-template-columns: 54px 1fr auto;
            gap:14px;
            align-items:center;
            padding:14px;
            border-radius:18px;
            background:rgba(255,255,255,.03);
            border:1px solid var(--line);
            cursor:pointer;
            transition:.2s ease;
        }
        .song:hover{
            transform:translateY(-1px);
            border-color:rgba(29,185,84,.35);
        }
        .song.active{
            background:rgba(29,185,84,.10);
            border-color:rgba(29,185,84,.28);
        }
        .cover{
            width:54px;
            height:54px;
            border-radius:14px;
            object-fit:cover;
            background:#10161f;
            border:1px solid var(--line);
        }
        .song-title{
            margin:0;
            font-size:1rem;
            line-height:1.3;
        }
        .song-meta{
            margin-top:4px;
            color:var(--muted);
            font-size:.9rem;
        }
        .song-actions{
            display:flex;
            align-items:center;
            gap:10px;
        }
        .btn{
            border:0;
            border-radius:14px;
            padding:12px 14px;
            font-weight:800;
            cursor:pointer;
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
        .player{
            display:flex;
            flex-direction:column;
            gap:16px;
        }
        .now-cover{
            width:100%;
            aspect-ratio:1/1;
            border-radius:24px;
            object-fit:cover;
            background:#10161f;
            border:1px solid var(--line);
        }
        .now-title{
            margin:0;
            font-size:1.4rem;
            letter-spacing:-.02em;
        }
        .now-meta{
            margin:6px 0 0;
            color:var(--muted);
        }
        .progress-wrap{
            display:flex;
            flex-direction:column;
            gap:8px;
        }
        .progress{
            width:100%;
            appearance:none;
            height:8px;
            border-radius:999px;
            background:#1c2430;
            outline:none;
        }
        .progress::-webkit-slider-thumb{
            appearance:none;
            width:18px;
            height:18px;
            border-radius:50%;
            background:var(--green);
            cursor:pointer;
        }
        .time-row{
            display:flex;
            justify-content:space-between;
            color:var(--muted);
            font-size:.9rem;
        }
        .controls{
            display:flex;
            justify-content:center;
            gap:12px;
            flex-wrap:wrap;
        }
        .controls button{
            min-width:54px;
            height:54px;
            border-radius:16px;
            border:1px solid var(--line);
            background:rgba(255,255,255,.05);
            color:var(--text);
            cursor:pointer;
            font-size:1rem;
        }
        .controls button.play{
            background:linear-gradient(135deg,var(--green),var(--green-2));
            color:#07120d;
            font-weight:900;
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
        .empty{
            padding:20px;
            color:var(--muted);
            text-align:center;
        }
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
                <small style="color:var(--muted)">Reproductor</small>
            </div>
        </div>

        <div class="pill" id="roleBadge">Sesión activa</div>

        <div class="nav">
            <a href="<?= site_url('perfil') ?>">Perfil</a>
            <a href="<?= site_url('login') ?>">Cambiar sesión</a>
            <button type="button" id="logoutBtn">Cerrar sesión</button>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="title">
                <h1>Reproductor</h1>
                <p>Escucha canciones, navega por géneros y controla la reproducción.</p>
            </div>
            <div class="pill" id="emailChip">—</div>
        </div>

        <div id="notice" class="notice"></div>

        <div class="grid">
            <section class="card">
                <h2 class="section-title">Géneros</h2>
                <div class="filters" id="genreFilters">
                    <button class="chip active" data-genre="">Todos</button>
                </div>

                <h2 class="section-title" style="margin-top:18px;">Canciones</h2>
                <div class="song-list" id="songList">
                    <div class="empty">Cargando canciones...</div>
                </div>
            </section>

            <section class="card player">
                <h2 class="section-title">Ahora sonando</h2>
                <img id="nowCover" class="now-cover" src="" alt="Portada">
                <div>
                    <h3 class="now-title" id="nowTitle">Selecciona una canción</h3>
                    <p class="now-meta" id="nowMeta">El reproductor se activará cuando elijas una canción.</p>
                </div>

                <div class="progress-wrap">
                    <input type="range" id="progress" class="progress" min="0" max="100" value="0">
                    <div class="time-row">
                        <span id="currentTime">0:00</span>
                        <span id="durationTime">0:00</span>
                    </div>
                </div>

                <div class="controls">
                    <button type="button" id="prevBtn">⏮</button>
                    <button type="button" class="play" id="playBtn">▶</button>
                    <button type="button" id="nextBtn">⏭</button>
                </div>

                <audio id="audioPlayer" preload="metadata"></audio>
            </section>
        </div>
    </main>
</div>

<script>
const token = localStorage.getItem('auth_token');
const notice = document.getElementById('notice');
const songListEl = document.getElementById('songList');
const genreFiltersEl = document.getElementById('genreFilters');
const audio = document.getElementById('audioPlayer');
const playBtn = document.getElementById('playBtn');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const progress = document.getElementById('progress');
const currentTimeEl = document.getElementById('currentTime');
const durationTimeEl = document.getElementById('durationTime');
const nowCover = document.getElementById('nowCover');
const nowTitle = document.getElementById('nowTitle');
const nowMeta = document.getElementById('nowMeta');

let songs = [];
let filteredSongs = [];
let currentIndex = -1;
let currentGenre = '';

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

async function api(url) {
    const res = await fetch(url, {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    });
    const data = await res.json();
    return { res, data };
}

function formatTime(sec) {
    sec = Math.floor(Number(sec || 0));
    const m = Math.floor(sec / 60);
    const s = sec % 60;
    return `${m}:${String(s).padStart(2, '0')}`;
}

function assetUrl(path) {
    if (!path) return '';
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return '<?= base_url() ?>' + path.replace(/^\/+/, '');
}

function renderGenres() {
    const genres = [...new Map(songs
        .filter(s => s.genero_Id && s.genero_Nombre)
        .map(s => [s.genero_Id, s.genero_Nombre]))
    .entries()];

    const chips = [
        `<button class="chip ${currentGenre === '' ? 'active' : ''}" data-genre="">Todos</button>`,
        ...genres.map(([id, name]) => `<button class="chip ${String(currentGenre) === String(id) ? 'active' : ''}" data-genre="${id}">${escapeHtml(name)}</button>`)
    ];

    genreFiltersEl.innerHTML = chips.join('');
    genreFiltersEl.querySelectorAll('.chip').forEach(btn => {
        btn.addEventListener('click', () => {
            currentGenre = btn.dataset.genre || '';
            filterSongs();
            renderGenres();
        });
    });
}

function filterSongs() {
    filteredSongs = currentGenre
        ? songs.filter(s => String(s.genero_Id) === String(currentGenre))
        : [...songs];

    renderSongList();
}

function renderSongList() {
    if (!filteredSongs.length) {
        songListEl.innerHTML = '<div class="empty">No hay canciones para este filtro.</div>';
        return;
    }

    songListEl.innerHTML = filteredSongs.map((song, idx) => {
        const isActive = idx === currentIndex;
        return `
            <div class="song ${isActive ? 'active' : ''}" data-index="${idx}">
                <img class="cover" src="${song.imagen ? assetUrl(song.imagen) : 'https://picsum.photos/seed/music/300'}" alt="Portada">
                <div>
                    <p class="song-title">${escapeHtml(song.cancion_Nombre || '')}</p>
                    <div class="song-meta">${escapeHtml(song.autor || '')} · ${escapeHtml(song.genero_Nombre || 'Sin género')}</div>
                </div>
                <div class="song-actions">
                    <button class="btn btn-primary" type="button">${isActive && !audio.paused ? 'Pausar' : 'Play'}</button>
                </div>
            </div>
        `;
    }).join('');

    songListEl.querySelectorAll('.song').forEach(el => {
        el.addEventListener('click', () => {
            const idx = Number(el.dataset.index);
            playSong(idx);
        });
    });
}

function playSong(index) {
    if (index < 0 || index >= filteredSongs.length) return;

    const song = filteredSongs[index];
    currentIndex = index;

    const src = assetUrl(song.archivo_url);
    audio.src = src;
    audio.load();
    audio.play().catch(() => {});

    nowTitle.textContent = song.cancion_Nombre || 'Sin título';
    nowMeta.textContent = `${song.autor || 'Desconocido'} · ${song.genero_Nombre || 'Sin género'}`;
    nowCover.src = song.imagen ? assetUrl(song.imagen) : 'https://picsum.photos/seed/music/600';

    playBtn.textContent = '⏸';
    renderSongList();
}

playBtn.addEventListener('click', () => {
    if (!audio.src && filteredSongs.length) {
        playSong(0);
        return;
    }

    if (audio.paused) {
        audio.play();
        playBtn.textContent = '⏸';
    } else {
        audio.pause();
        playBtn.textContent = '▶';
    }
    renderSongList();
});

prevBtn.addEventListener('click', () => {
    if (!filteredSongs.length) return;
    const next = currentIndex <= 0 ? filteredSongs.length - 1 : currentIndex - 1;
    playSong(next);
});

nextBtn.addEventListener('click', () => {
    if (!filteredSongs.length) return;
    const next = currentIndex >= filteredSongs.length - 1 ? 0 : currentIndex + 1;
    playSong(next);
});

audio.addEventListener('timeupdate', () => {
    if (!audio.duration) return;
    progress.value = (audio.currentTime / audio.duration) * 100;
    currentTimeEl.textContent = formatTime(audio.currentTime);
    durationTimeEl.textContent = formatTime(audio.duration);
});

progress.addEventListener('input', () => {
    if (!audio.duration) return;
    const time = (progress.value / 100) * audio.duration;
    audio.currentTime = time;
});

audio.addEventListener('ended', () => {
    nextBtn.click();
});

audio.addEventListener('play', () => {
    playBtn.textContent = '⏸';
    renderSongList();
});

audio.addEventListener('pause', () => {
    playBtn.textContent = '▶';
    renderSongList();
});

async function loadSongs() {
    const { res, data } = await api('<?= site_url('api/canciones') ?>');

    if (!res.ok) {
        showNotice('error', data.error || 'No se pudieron cargar las canciones.');
        songListEl.innerHTML = '<div class="empty">Error al cargar canciones.</div>';
        return;
    }

    songs = data.canciones || [];
    filteredSongs = [...songs];

    if (!songs.length) {
        songListEl.innerHTML = '<div class="empty">No hay canciones disponibles.</div>';
        genreFiltersEl.innerHTML = `<button class="chip active" data-genre="">Todos</button>`;
        return;
    }

    renderGenres();
    filterSongs();
}

function escapeHtml(text) {
    return String(text)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

loadSongs();
</script>
</body>
</html> 