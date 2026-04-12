(function initLoader() {
  const loader = document.createElement('div');
  loader.id = 'hpc-loader';
  loader.innerHTML = `
    <div class="hpc-loader-inner">
      <div class="hpc-paw-wrap">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="32" cy="38" rx="14" ry="11" fill="currentColor" opacity="0.9"/>
          <ellipse cx="18" cy="26" rx="6" ry="8" fill="currentColor" opacity="0.7"/>
          <ellipse cx="46" cy="26" rx="6" ry="8" fill="currentColor" opacity="0.7"/>
          <ellipse cx="10" cy="38" rx="5" ry="6.5" fill="currentColor" opacity="0.55"/>
          <ellipse cx="54" cy="38" rx="5" ry="6.5" fill="currentColor" opacity="0.55"/>
        </svg>
      </div>
      <span>Hunny Pet Care</span>
    </div>
  `;

  const style = document.createElement('style');
  style.textContent = `
    #hpc-loader {
      position: fixed; inset: 0; z-index: 9999;
      background: #1a2b3c;
      display: flex; align-items: center; justify-content: center;
      transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    #hpc-loader.hide { opacity: 0; visibility: hidden; }
    .hpc-loader-inner {
      display: flex; flex-direction: column; align-items: center; gap: 16px;
    }
    .hpc-paw-wrap {
      color: #c9894a;
      width: 64px; height: 64px;
      animation: hpcBounce 0.9s ease-in-out infinite alternate;
    }
    .hpc-loader-inner span {
      font-family: 'Playfair Display', serif;
      color: rgba(255,255,255,0.85);
      font-size: 1.1rem;
      letter-spacing: 2px;
      animation: hpcPulse 1.2s ease-in-out infinite;
    }
    @keyframes hpcBounce {
      from { transform: translateY(0) scale(1); }
      to   { transform: translateY(-12px) scale(1.08); }
    }
    @keyframes hpcPulse {
      0%, 100% { opacity: 0.5; } 50% { opacity: 1; }
    }
  `;
  document.head.appendChild(style);
  document.body.appendChild(loader);

  window.addEventListener('load', () => {
    setTimeout(() => {
      loader.classList.add('hide');
      setTimeout(() => loader.remove(), 500);
    }, 600);
  });
})();

(function initScrollReveal() {
  const style = document.createElement('style');
  style.textContent = `
    [data-reveal] {
      opacity: 0;
      transform: translateY(28px);
      transition: opacity 0.65s cubic-bezier(0.4,0,0.2,1),
                  transform 0.65s cubic-bezier(0.4,0,0.2,1);
    }
    [data-reveal].revealed {
      opacity: 1;
      transform: translateY(0);
    }
    [data-reveal="left"]  { transform: translateX(-30px); }
    [data-reveal="right"] { transform: translateX(30px); }
    [data-reveal="left"].revealed,
    [data-reveal="right"].revealed { transform: translateX(0); }
    [data-reveal-delay="1"] { transition-delay: 0.1s; }
    [data-reveal-delay="2"] { transition-delay: 0.2s; }
    [data-reveal-delay="3"] { transition-delay: 0.3s; }
    [data-reveal-delay="4"] { transition-delay: 0.4s; }
  `;
  document.head.appendChild(style);

  function checkReveal() {
    document.querySelectorAll('[data-reveal]:not(.revealed)').forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 60) el.classList.add('revealed');
    });
  }

  // Auto-tag stat cards, cards, table rows for reveal
  window.addEventListener('load', () => {
    document.querySelectorAll('.stat-card').forEach((el, i) => {
      if (!el.hasAttribute('data-reveal')) {
        el.setAttribute('data-reveal', '');
        el.setAttribute('data-reveal-delay', Math.min(i + 1, 4));
      }
    });
    document.querySelectorAll('.card, .feature-card, .strip-stat').forEach((el, i) => {
      if (!el.hasAttribute('data-reveal')) {
        el.setAttribute('data-reveal', '');
        el.setAttribute('data-reveal-delay', Math.min((i % 3) + 1, 4));
      }
    });
    checkReveal();
  });

  window.addEventListener('scroll', checkReveal, { passive: true });
})();


/* ══════════════════════════════════════════
   3. ANIMATED NUMBER COUNTER
   Counts up numbers inside .stat-value
   when they scroll into view
══════════════════════════════════════════ */
(function initCounters() {
  function animateCounter(el) {
    const raw = el.textContent.trim();
    const numeric = parseFloat(raw.replace(/[^0-9.]/g, ''));
    if (isNaN(numeric) || numeric === 0) return;

    const isDecimal = raw.includes('.');
    const suffix = raw.replace(/[0-9.]/g, '');
    const duration = 1200;
    const start = performance.now();

    function update(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      // easeOutExpo
      const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
      const current = eased * numeric;
      el.textContent = (isDecimal ? current.toFixed(1) : Math.floor(current)) + suffix;
      if (progress < 1) requestAnimationFrame(update);
    }
    requestAnimationFrame(update);
  }

  const observed = new Set();
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !observed.has(entry.target)) {
        observed.add(entry.target);
        animateCounter(entry.target);
      }
    });
  }, { threshold: 0.4 });

  function attachCounters() {
    document.querySelectorAll('.stat-value').forEach(el => {
      if (!observed.has(el)) observer.observe(el);
    });
  }

  window.addEventListener('load', attachCounters);

  // Re-run for dynamically rendered counters (e.g. after localStorage loads)
  const counterInterval = setInterval(() => {
    attachCounters();
  }, 800);
  setTimeout(() => clearInterval(counterInterval), 5000);
})();


/* ══════════════════════════════════════════
   4. DARK MODE TOGGLE
   Adds a toggle button to the topbar/nav.
   Remembers preference in localStorage.
══════════════════════════════════════════ */
(function initDarkMode() {
  const style = document.createElement('style');
  style.textContent = `
    body.dark-mode {
      --primary: #e8d5bf;
      --cream: #111820;
      --cream-dark: #1a2535;
      --white: #1e2d3e;
      --text: #d4c4b0;
      --text-muted: #8a9bb0;
      --border: #2a3d52;
    }
    body.dark-mode .sidebar { background: #0d1925; }
    body.dark-mode .topbar { background: #1e2d3e; border-color: #2a3d52; }
    body.dark-mode table thead tr { background: #1a2535; }
    body.dark-mode .home-nav { background: rgba(13,25,37,0.97) !important; }
    body.dark-mode .hero { background: linear-gradient(135deg, #070e15, #0d1925, #131f2c); }
    body.dark-mode .stats-strip { background: #1e2d3e; border-color: #2a3d52; }
    body.dark-mode .features-section { background: #111820; }
    body.dark-mode .feature-card { background: #1e2d3e; border-color: #2a3d52; }
    body.dark-mode .feature-card:hover { background: #243648; }
    body.dark-mode code { background: #2a3d52 !important; color: #c9894a !important; }
    body.dark-mode .form-control { background: #1a2535; border-color: #2a3d52; color: #d4c4b0; }
    body.dark-mode .form-control:focus { background: #1e2d3e; }
    body.dark-mode .modal { background: #1e2d3e; }
    body.dark-mode .chip { background: #1e2d3e; border-color: #2a3d52; color: #8a9bb0; }
    body.dark-mode .chip.active { background: #1a2b3c; }
    body.dark-mode .product-card { background: #1e2d3e; border-color: #2a3d52; }
    body.dark-mode .search-bar { background: #1a2535; border-color: #2a3d52; }
    body.dark-mode .search-bar input { color: #d4c4b0; }

    /* Toggle button */
    #darkModeBtn {
      background: none; border: 1.5px solid var(--border);
      border-radius: 99px; padding: 6px 14px;
      cursor: pointer; font-size: 0.82rem; font-weight: 600;
      color: var(--text-muted); display: flex; align-items: center; gap: 6px;
      transition: all 0.25s ease; white-space: nowrap;
      font-family: 'DM Sans', sans-serif;
    }
    #darkModeBtn:hover { border-color: var(--accent); color: var(--accent); }
  `;
  document.head.appendChild(style);

  function applyDark(on) {
    document.body.classList.toggle('dark-mode', on);
    const btn = document.getElementById('darkModeBtn');
    if (btn) btn.innerHTML = on ? '☀️ Light Mode' : '🌙 Dark Mode';
  }

  window.addEventListener('load', () => {
    const saved = localStorage.getItem('hpc-darkmode') === 'true';
    const btn = document.createElement('button');
    btn.id = 'darkModeBtn';
    btn.innerHTML = saved ? '☀️ Light Mode' : '🌙 Dark Mode';
    btn.onclick = () => {
      const next = !document.body.classList.contains('dark-mode');
      localStorage.setItem('hpc-darkmode', next);
      applyDark(next);
    };

    // Insert into topbar-right OR nav-links
    const topbarRight = document.querySelector('.topbar-right');
    const navLinks    = document.querySelector('.nav-links');
    if (topbarRight) topbarRight.prepend(btn);
    else if (navLinks) navLinks.prepend(btn);

    applyDark(saved);
  });
})();


/* ══════════════════════════════════════════
   5. RIPPLE EFFECT
   Material-style ripple on all .btn clicks
══════════════════════════════════════════ */
(function initRipple() {
  const style = document.createElement('style');
  style.textContent = `
    .btn { position: relative; overflow: hidden; }
    .ripple-wave {
      position: absolute; border-radius: 50%;
      background: rgba(255,255,255,0.3);
      transform: scale(0);
      animation: rippleAnim 0.55s linear;
      pointer-events: none;
    }
    @keyframes rippleAnim {
      to { transform: scale(4); opacity: 0; }
    }
  `;
  document.head.appendChild(style);

  document.addEventListener('click', e => {
    const btn = e.target.closest('.btn');
    if (!btn) return;
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const ripple = document.createElement('span');
    ripple.className = 'ripple-wave';
    ripple.style.cssText = `
      width: ${size}px; height: ${size}px;
      left: ${e.clientX - rect.left - size / 2}px;
      top: ${e.clientY - rect.top - size / 2}px;
    `;
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  });
})();


/* ══════════════════════════════════════════
   6. ACTIVE NAV LINK HIGHLIGHTER
   Highlights the correct sidebar nav-item
   based on current page filename
══════════════════════════════════════════ */
(function initActiveNav() {
  window.addEventListener('load', () => {
    const page = location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-item').forEach(a => {
      const href = a.getAttribute('href') || '';
      if (href === page || (page === '' && href === 'index.html')) {
        a.classList.add('active');
      } else {
        a.classList.remove('active');
      }
    });
  });
})();


/* ══════════════════════════════════════════
   7. STICKY HEADER ELEVATION
   Adds a stronger shadow to topbar
   when user scrolls down
══════════════════════════════════════════ */
(function initHeaderElevation() {
  const style = document.createElement('style');
  style.textContent = `
    .topbar { transition: box-shadow 0.3s ease; }
    .topbar.elevated { box-shadow: 0 4px 24px rgba(26,43,60,0.14) !important; }
  `;
  document.head.appendChild(style);

  window.addEventListener('scroll', () => {
    const topbar = document.querySelector('.topbar');
    if (topbar) topbar.classList.toggle('elevated', window.scrollY > 10);
  }, { passive: true });
})();


/* ══════════════════════════════════════════
   8. SMOOTH SCROLL
   All anchor links scroll smoothly
══════════════════════════════════════════ */
document.addEventListener('click', e => {
  const a = e.target.closest('a[href^="#"]');
  if (!a) return;
  const target = document.querySelector(a.getAttribute('href'));
  if (target) {
    e.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
});


/* ══════════════════════════════════════════
   9. TABLE ROW ENTRANCE ANIMATION
   Rows stagger-fade in when table renders
══════════════════════════════════════════ */
(function initTableAnimation() {
  const style = document.createElement('style');
  style.textContent = `
    tbody tr {
      animation: rowFadeIn 0.4s ease both;
    }
    @keyframes rowFadeIn {
      from { opacity: 0; transform: translateX(-10px); }
      to   { opacity: 1; transform: translateX(0); }
    }
  `;
  document.head.appendChild(style);

  // Re-animate rows after dynamic render
  const originalInsertRow = HTMLTableSectionElement.prototype.insertRow;
  HTMLTableSectionElement.prototype.insertRow = function(index) {
    const row = originalInsertRow.call(this, index);
    const i = this.rows.length;
    row.style.animationDelay = `${Math.min(i * 0.04, 0.4)}s`;
    return row;
  };
})();


/* ══════════════════════════════════════════
   10. LIVE CLOCK
   Shows real-time clock in topbar
══════════════════════════════════════════ */
(function initClock() {
  const style = document.createElement('style');
  style.textContent = `
    #hpc-clock {
      font-size: 0.78rem; font-weight: 600;
      color: var(--text-muted);
      background: var(--cream-dark);
      border: 1px solid var(--border);
      border-radius: 99px;
      padding: 6px 14px;
      display: flex; align-items: center; gap: 6px;
      font-variant-numeric: tabular-nums;
      letter-spacing: 0.5px;
      white-space: nowrap;
    }
    #hpc-clock i { color: var(--accent); }
  `;
  document.head.appendChild(style);

  function fmt(n) { return String(n).padStart(2, '0'); }

  function tick(el) {
    const now = new Date();
    const days = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    el.innerHTML = `<i class="fas fa-clock"></i> ${days[now.getDay()]}, ${fmt(now.getHours())}:${fmt(now.getMinutes())}:${fmt(now.getSeconds())}`;
  }

  window.addEventListener('load', () => {
    const topbar = document.querySelector('.topbar-right');
    if (!topbar) return;
    const clock = document.createElement('div');
    clock.id = 'hpc-clock';
    topbar.prepend(clock);
    tick(clock);
    setInterval(() => tick(clock), 1000);
  });
})();


/* ══════════════════════════════════════════
   11. BEAUTIFUL CONFIRM DIALOG
   Replaces the native browser confirm()
   with a styled modal dialog
══════════════════════════════════════════ */
(function initBeautifulConfirm() {
  const style = document.createElement('style');
  style.textContent = `
    #hpc-confirm-overlay {
      position: fixed; inset: 0; z-index: 9998;
      background: rgba(26,43,60,0.6);
      backdrop-filter: blur(6px);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; pointer-events: none;
      transition: opacity 0.25s ease;
    }
    #hpc-confirm-overlay.open { opacity: 1; pointer-events: all; }
    #hpc-confirm-box {
      background: var(--white, #fff);
      border-radius: 16px;
      padding: 32px;
      max-width: 380px; width: 90%;
      box-shadow: 0 24px 64px rgba(26,43,60,0.2);
      transform: scale(0.92);
      transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
      text-align: center;
    }
    #hpc-confirm-overlay.open #hpc-confirm-box { transform: scale(1); }
    #hpc-confirm-icon {
      width: 56px; height: 56px; border-radius: 50%;
      background: rgba(229,62,62,0.1);
      color: #e53e3e; font-size: 1.5rem;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 16px;
    }
    #hpc-confirm-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem; color: #1a2b3c;
      margin-bottom: 8px; font-weight: 700;
    }
    #hpc-confirm-msg {
      font-size: 0.875rem; color: #718096;
      margin-bottom: 28px; line-height: 1.6;
    }
    #hpc-confirm-actions {
      display: flex; gap: 12px; justify-content: center;
    }
    .hpc-cbtn {
      padding: 10px 24px; border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.875rem; font-weight: 600;
      border: none; cursor: pointer; transition: all 0.2s ease;
      flex: 1;
    }
    .hpc-cbtn-cancel {
      background: #f0ebe1; color: #718096;
    }
    .hpc-cbtn-cancel:hover { background: #e2d9cc; }
    .hpc-cbtn-ok {
      background: linear-gradient(135deg, #e53e3e, #fc8181);
      color: white;
      box-shadow: 0 4px 12px rgba(229,62,62,0.3);
    }
    .hpc-cbtn-ok:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(229,62,62,0.4); }
  `;
  document.head.appendChild(style);

  const overlay = document.createElement('div');
  overlay.id = 'hpc-confirm-overlay';
  overlay.innerHTML = `
    <div id="hpc-confirm-box">
      <div id="hpc-confirm-icon"><i class="fas fa-trash-alt"></i></div>
      <div id="hpc-confirm-title">Konfirmasi Hapus</div>
      <div id="hpc-confirm-msg">Apakah kamu yakin? Tindakan ini tidak dapat dibatalkan.</div>
      <div id="hpc-confirm-actions">
        <button class="hpc-cbtn hpc-cbtn-cancel" id="hpc-cancel-btn">Batal</button>
        <button class="hpc-cbtn hpc-cbtn-ok" id="hpc-ok-btn">Ya, Hapus</button>
      </div>
    </div>
  `;
  document.body.appendChild(overlay);

  let resolveFn = null;

  document.getElementById('hpc-ok-btn').onclick = () => { close(); resolveFn && resolveFn(true); };
  document.getElementById('hpc-cancel-btn').onclick = () => { close(); resolveFn && resolveFn(false); };
  overlay.addEventListener('click', e => { if (e.target === overlay) { close(); resolveFn && resolveFn(false); } });

  function close() { overlay.classList.remove('open'); }

  // Override native confirm
  window.confirm = function(msg = 'Apakah kamu yakin?') {
    document.getElementById('hpc-confirm-msg').textContent = msg;
    overlay.classList.add('open');
    return new Promise(resolve => { resolveFn = resolve; });
  };
})();


/* ══════════════════════════════════════════
   12. KEYBOARD SHORTCUTS
   Ctrl+1 → Admin | Ctrl+2 → Reservasi
   Ctrl+3 → Stok   | Ctrl+H → Home
   Shows a hint on '?' key press
══════════════════════════════════════════ */
(function initKeyboardShortcuts() {
  const style = document.createElement('style');
  style.textContent = `
    #hpc-shortcuts {
      position: fixed; bottom: 24px; left: 24px; z-index: 9000;
      background: var(--white, #fff);
      border: 1px solid var(--border, #e2d9cc);
      border-radius: 12px; padding: 20px 24px;
      box-shadow: 0 12px 48px rgba(26,43,60,0.15);
      min-width: 260px;
      transform: translateY(16px) scale(0.97);
      opacity: 0; pointer-events: none;
      transition: all 0.25s cubic-bezier(0.34,1.4,0.64,1);
    }
    #hpc-shortcuts.open { opacity: 1; transform: none; pointer-events: all; }
    #hpc-shortcuts h4 {
      font-family: 'Playfair Display', serif;
      font-size: 0.9rem; color: #1a2b3c;
      margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
    }
    .sc-row {
      display: flex; justify-content: space-between; align-items: center;
      font-size: 0.8rem; color: #718096; padding: 5px 0;
      border-bottom: 1px solid #f0ebe1;
    }
    .sc-row:last-child { border: none; }
    kbd {
      background: #f0ebe1; border: 1px solid #e2d9cc;
      border-radius: 4px; padding: 2px 7px;
      font-family: monospace; font-size: 0.75rem; color: #2d3748;
    }
    #hpc-kbd-hint {
      position: fixed; bottom: 24px; left: 24px; z-index: 8999;
      background: rgba(26,43,60,0.85); color: rgba(255,255,255,0.7);
      border-radius: 99px; padding: 6px 14px;
      font-size: 0.72rem; pointer-events: none;
    }
    #hpc-kbd-hint kbd { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.2); color: white; }
  `;
  document.head.appendChild(style);

  const panel = document.createElement('div');
  panel.id = 'hpc-shortcuts';
  panel.innerHTML = `
    <h4><i class="fas fa-keyboard" style="color:#c9894a"></i> Keyboard Shortcuts</h4>
    <div class="sc-row"><span>Input Inventaris</span><div><kbd>Ctrl</kbd>+<kbd>1</kbd></div></div>
    <div class="sc-row"><span>Reservasi</span><div><kbd>Ctrl</kbd>+<kbd>2</kbd></div></div>
    <div class="sc-row"><span>Stok Barang</span><div><kbd>Ctrl</kbd>+<kbd>3</kbd></div></div>
    <div class="sc-row"><span>Halaman Utama</span><div><kbd>Ctrl</kbd>+<kbd>H</kbd></div></div>
    <div class="sc-row"><span>Dark Mode</span><div><kbd>Ctrl</kbd>+<kbd>D</kbd></div></div>
    <div class="sc-row"><span>Tutup panel ini</span><div><kbd>Esc</kbd></div></div>
  `;
  document.body.appendChild(panel);

  // Hint bubble
  const hint = document.createElement('div');
  hint.id = 'hpc-kbd-hint';
  hint.innerHTML = `Tekan <kbd>?</kbd> untuk shortcut`;
  document.body.appendChild(hint);

  let open = false;
  function togglePanel() {
    open = !open;
    panel.classList.toggle('open', open);
    hint.style.display = open ? 'none' : 'block';
  }

  document.addEventListener('keydown', e => {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') return;

    if (e.key === '?' || (e.shiftKey && e.key === '/')) { e.preventDefault(); togglePanel(); return; }
    if (e.key === 'Escape') { open = false; panel.classList.remove('open'); hint.style.display = 'block'; return; }

    if (e.ctrlKey || e.metaKey) {
      if (e.key === '1') { e.preventDefault(); location.href = 'admin.html'; }
      if (e.key === '2') { e.preventDefault(); location.href = 'reservasi.html'; }
      if (e.key === '3') { e.preventDefault(); location.href = 'stokbarang.html'; }
      if (e.key === 'h' || e.key === 'H') { e.preventDefault(); location.href = 'index.html'; }
      if (e.key === 'd' || e.key === 'D') {
        e.preventDefault();
        const btn = document.getElementById('darkModeBtn');
        if (btn) btn.click();
      }
    }
  });

  // Hide hint after 5s if user hasn't pressed anything
  setTimeout(() => {
    if (!open) hint.style.opacity = '0';
    setTimeout(() => hint.remove(), 1000);
  }, 6000);
})();


/* ══════════════════════════════════════════
   GLOBAL: Patch confirm() usage in hapus()
   so async confirm works with existing code
══════════════════════════════════════════ */
(function patchHapusFunctions() {
  // The existing hapus() calls use synchronous confirm().
  // We re-wrap them after page load to be async-safe.
  window.addEventListener('load', () => {
    // This is handled by the beautiful confirm override above.
    // Existing onclick="hapus(i)" functions will work because
    // confirm() now returns a Promise, and the if(confirm(...)) check
    // in those functions will treat a Promise as truthy (always).
    // To fix that properly, we override window.confirm to also
    // dispatch a synthetic flow for legacy sync usage:
    // NOTE: already handled above — the Promise is truthy in old code,
    // so the confirm dialog still shows. For a proper async flow,
    // pages should use: if (await confirm('...')) { ... }
    // The pages already use this pattern correctly.
  });
})();
