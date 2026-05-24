<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rick & Morty — Personagens</title>
  <link href="https://fonts.googleapis.com/css2?family=Get+Schwifty&family=Nunito:wght@400;600;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green:   #97c13a;
      --green-d: #5a7a1e;
      --cyan:    #4ecdc4;
      --cyan-d:  #2a8a84;
      --dark:    #0b0c10;
      --panel:   #1a1d26;
      --card:    #22263a;
      --border:  #2e3350;
      --text:    #e8ecf4;
      --muted:   #7a809e;
      --alive:   #4ade80;
      --dead:    #f87171;
      --unknown: #94a3b8;
    }

    body {
      background: var(--dark);
      color: var(--text);
      font-family: 'Nunito', sans-serif;
      min-height: 100vh;
    }

    /* ── Header ── */
    header {
      text-align: center;
      padding: 3rem 1rem 2rem;
      position: relative;
      overflow: hidden;
    }
    header::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(78,205,196,.15) 0%, transparent 70%);
      pointer-events: none;
    }
    header h1 {
      font-family: 'Get Schwifty', cursive;
      font-size: clamp(2.4rem, 6vw, 4.5rem);
      background: linear-gradient(135deg, var(--green) 0%, var(--cyan) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: 2px;
      line-height: 1.1;
      filter: drop-shadow(0 0 18px rgba(78,205,196,.45));
    }
    header p {
      margin-top: .6rem;
      color: var(--muted);
      font-size: .95rem;
      letter-spacing: .5px;
    }

    /* ── Controls ── */
    .controls {
      display: flex;
      flex-wrap: wrap;
      gap: .75rem;
      align-items: center;
      justify-content: center;
      padding: 1rem 1.5rem 1.5rem;
      max-width: 1100px;
      margin: 0 auto;
    }
    .search-wrap {
      position: relative;
      flex: 1;
      min-width: 220px;
      max-width: 380px;
    }
    .search-wrap svg {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      pointer-events: none;
    }
    .controls input[type="text"] {
      width: 100%;
      padding: .55rem .75rem .55rem 2.4rem;
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 999px;
      color: var(--text);
      font-family: inherit;
      font-size: .9rem;
      outline: none;
      transition: border-color .2s;
    }
    .controls input[type="text"]:focus { border-color: var(--cyan); }
    .controls select {
      padding: .55rem 1rem;
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 999px;
      color: var(--text);
      font-family: inherit;
      font-size: .9rem;
      outline: none;
      cursor: pointer;
      transition: border-color .2s;
    }
    .controls select:focus { border-color: var(--cyan); }

    /* ── Stats bar ── */
    .stats {
      display: flex;
      justify-content: center;
      gap: 2rem;
      padding: 0 1.5rem .75rem;
      font-size: .8rem;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .stats span { display: flex; align-items: center; gap: .4rem; }
    .dot { width: 8px; height: 8px; border-radius: 50%; }
    .dot.alive  { background: var(--alive); }
    .dot.dead   { background: var(--dead); }
    .dot.unknown{ background: var(--unknown); }

    /* ── Grid ── */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.25rem;
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 1.5rem 4rem;
    }

    /* ── Card ── */
    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease;
      cursor: pointer;
      animation: fadeUp .4s ease both;
    }
    .card:hover {
      transform: translateY(-5px);
      border-color: var(--cyan);
      box-shadow: 0 8px 32px rgba(78,205,196,.18);
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .card img {
      width: 100%;
      aspect-ratio: 1;
      object-fit: cover;
      display: block;
      filter: brightness(.9);
      transition: filter .22s;
    }
    .card:hover img { filter: brightness(1.05); }
    .card-body { padding: .9rem 1rem; }
    .card-name {
      font-size: 1rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: .45rem;
      color: var(--text);
    }
    .card-meta {
      display: flex;
      align-items: center;
      gap: .5rem;
      font-size: .78rem;
      color: var(--muted);
      margin-bottom: .3rem;
    }
    .status-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      flex-shrink: 0;
    }
    .status-alive   .status-dot { background: var(--alive); }
    .status-dead    .status-dot { background: var(--dead); }
    .status-unknown .status-dot { background: var(--unknown); }
    .card-location {
      font-size: .77rem;
      color: var(--muted);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* ── States ── */
    .state {
      text-align: center;
      padding: 5rem 1rem;
      color: var(--muted);
    }
    .state svg { margin-bottom: 1rem; opacity: .35; }
    .state p { font-size: 1rem; }

    /* ── Pagination ── */
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: .75rem;
      padding: 0 1rem 3.5rem;
    }
    .page-btn {
      padding: .5rem 1.25rem;
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 999px;
      color: var(--text);
      font-family: inherit;
      font-size: .88rem;
      font-weight: 600;
      cursor: pointer;
      transition: background .18s, border-color .18s;
    }
    .page-btn:hover:not(:disabled) {
      background: var(--cyan);
      border-color: var(--cyan);
      color: var(--dark);
    }
    .page-btn:disabled { opacity: .3; cursor: not-allowed; }
    .page-info { color: var(--muted); font-size: .88rem; }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--dark); }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
  </style>
</head>
<body>

<header>
  <h1>Rick &amp; Morty</h1>
  <p>Explore todos os personagens do multiverso</p>
</header>

<div class="controls">
  <div class="search-wrap">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
    </svg>
    <input type="text" id="search" placeholder="Buscar personagem…" autocomplete="off"/>
  </div>
  <select id="filter-status">
    <option value="">Todos os status</option>
    <option value="alive">Vivo</option>
    <option value="dead">Morto</option>
    <option value="unknown">Desconhecido</option>
  </select>
  <select id="filter-species">
    <option value="">Todas as espécies</option>
    <option value="human">Human</option>
    <option value="alien">Alien</option>
    <option value="humanoid">Humanoid</option>
    <option value="robot">Robot</option>
    <option value="animal">Animal</option>
    <option value="mythological creature">Mythological Creature</option>
    <option value="poopybutthole">Poopybutthole</option>
    <option value="cronenberg">Cronenberg</option>
  </select>
</div>

<div class="stats" id="stats"></div>
<div class="grid"  id="grid"></div>
<div class="pagination" id="pagination"></div>

<script>
  const API = '/api/characters';
  let currentPage = 1;
  let pageInfo    = {};
  let searchTimer;

  const grid       = document.getElementById('grid');
  const pagination = document.getElementById('pagination');
  const stats      = document.getElementById('stats');
  const searchEl   = document.getElementById('search');
  const statusEl   = document.getElementById('filter-status');
  const speciesEl  = document.getElementById('filter-species');

  function buildUrl(page) {
    const name    = searchEl.value.trim();
    const status  = statusEl.value;
    const species = speciesEl.value;
    const params  = new URLSearchParams({ page });
    if (name)    params.set('name', name);
    if (status)  params.set('status', status);
    if (species) params.set('species', species);
    return `${API}?${params}`;
  }

  async function load(page = 1) {
    currentPage = page;
    grid.innerHTML = `<div class="state" style="grid-column:1/-1">
      <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path d="M12 2a10 10 0 1 0 10 10"/>
        <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur=".8s" repeatCount="indefinite"/>
      </svg>
      <p>Carregando personagens…</p>
    </div>`;
    pagination.innerHTML = '';
    stats.innerHTML = '';

    try {
      const res  = await fetch(buildUrl(page));
      const data = await res.json();

      if (!data.results || data.results.length === 0) {
        grid.innerHTML = `<div class="state" style="grid-column:1/-1">
          <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><path d="M8 15s1.5-2 4-2 4 2 4 2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>
          </svg>
          <p>Nenhum personagem encontrado.</p>
        </div>`;
        return;
      }

      pageInfo = data.info || {};
      renderStats(data.results);
      renderCards(data.results);
      renderPagination();
    } catch (e) {
      grid.innerHTML = `<div class="state" style="grid-column:1/-1"><p>Erro ao carregar dados. Verifique o servidor Laravel.</p></div>`;
    }
  }

  function renderStats(results) {
    const alive   = results.filter(c => c.status.toLowerCase() === 'alive').length;
    const dead    = results.filter(c => c.status.toLowerCase() === 'dead').length;
    const unk     = results.filter(c => !['alive','dead'].includes(c.status.toLowerCase())).length;
    stats.innerHTML = `
      <span><span class="dot alive"></span>${alive} vivos</span>
      <span><span class="dot dead"></span>${dead} mortos</span>
      <span><span class="dot unknown"></span>${unk} desconhecidos</span>
      <span style="margin-left:.5rem">— Total no multiverso: <strong style="color:var(--text)">${pageInfo.count ?? '?'}</strong></span>
    `;
  }

  function renderCards(chars) {
    grid.innerHTML = chars.map((c, i) => {
      const st  = c.status.toLowerCase().replace(' ','');
      const cls = ['alive','dead'].includes(st) ? st : 'unknown';
      const delay = (i % 20) * 30;
      return `
        <div class="card status-${cls}" style="animation-delay:${delay}ms">
          <img src="${c.image}" alt="${c.name}" loading="lazy"/>
          <div class="card-body">
            <p class="card-name">${c.name}</p>
            <div class="card-meta">
              <span class="status-dot"></span>
              <span>${c.status} — ${c.species}</span>
            </div>
            <p class="card-location" title="${c.location?.name ?? ''}">
              📍 ${c.location?.name ?? 'Desconhecida'}
            </p>
          </div>
        </div>`;
    }).join('');
  }

  function renderPagination() {
    const total = pageInfo.pages ?? 1;
    if (total <= 1) return;
    pagination.innerHTML = `
      <button class="page-btn" id="btn-prev" ${currentPage <= 1 ? 'disabled' : ''}>← Anterior</button>
      <span class="page-info">Página ${currentPage} de ${total}</span>
      <button class="page-btn" id="btn-next" ${currentPage >= total ? 'disabled' : ''}>Próxima →</button>
    `;
    document.getElementById('btn-prev').onclick = () => load(currentPage - 1);
    document.getElementById('btn-next').onclick = () => load(currentPage + 1);
  }

  searchEl.addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => load(1), 400);
  });
  statusEl.addEventListener('change',  () => load(1));
  speciesEl.addEventListener('change', () => load(1));

  load(1);
</script>
</body>
</html>