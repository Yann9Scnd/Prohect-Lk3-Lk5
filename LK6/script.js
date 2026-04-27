document.addEventListener('DOMContentLoaded', () => {

  /* ================= TYPEWRITER ================= */
  const roles = [
    'UI/UX Designer',
    'Fullstack Developer',
    'IT Influencer',
    'Problem Solver'
  ];

  let ri = 0,
      ci = 0,
      del = false;

  const el = document.getElementById('typed');

  function type() {
    if (!el) return;

    const cur = roles[ri];

    if (!del) {
      el.textContent = cur.slice(0, ci + 1);
      ci++;

      if (ci === cur.length) {
        del = true;
        setTimeout(type, 1600);
        return;
      }
    } else {
      el.textContent = cur.slice(0, ci - 1);
      ci--;

      if (ci === 0) {
        del = false;
        ri = (ri + 1) % roles.length;
      }
    }

    setTimeout(type, del ? 60 : 100);
  }

  type();

  /* ================= INTERSECTION OBSERVER ================= */
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');

        e.target.querySelectorAll('.skill-bar-fill').forEach(b => {
          b.style.width = b.dataset.width + '%';
        });

        e.target.querySelectorAll('.stat-num').forEach(n => {
          const target = +n.dataset.count;
          let cur = 0;

          const step = Math.ceil(target / 30);

          const t = setInterval(() => {
            cur = Math.min(cur + step, target);
            n.textContent = cur + '+';

            if (cur >= target) clearInterval(t);
          }, 50);
        });
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('section').forEach(s => io.observe(s));

  /* ================= SCROLL ================= */
  window.addEventListener('scroll', () => {
    const st = document.getElementById('scrollTop');
    if (st) st.classList.toggle('show', window.scrollY > 300);

    document.querySelectorAll('.nav-menu a').forEach(a => {
      const sec = document.querySelector(a.getAttribute('href'));

      if (sec) {
        const r = sec.getBoundingClientRect();
        a.classList.toggle('active', r.top <= 100 && r.bottom > 100);
      }
    });
  });

  /* ================= FORM ================= */
  window.sendMsg = function () {
    const btn = document.getElementById('send-btn');
    const n  = document.getElementById('f-name').value;
    const em = document.getElementById('f-email').value;
    const m  = document.getElementById('f-msg').value;

    if (!n || !em || !m) {
      btn.style.background = '#ef4444';
      btn.textContent = 'Lengkapi form!';

      setTimeout(() => {
        btn.style.background = '';
        btn.textContent = 'Kirim Pesan ✉️';
      }, 2000);

      return;
    }

    btn.textContent = 'Mengirim...';
    btn.disabled = true;

    setTimeout(() => {
      btn.classList.add('sent');
      btn.textContent = 'Terkirim! ✅';

      document.getElementById('f-name').value = '';
      document.getElementById('f-email').value = '';
      document.getElementById('f-msg').value = '';

      setTimeout(() => {
        btn.classList.remove('sent');
        btn.textContent = 'Kirim Pesan ✉️';
        btn.disabled = false;
      }, 3000);
    }, 1000);
  };

  /* ================= PARTICLES ================= */
  const canvas = document.getElementById('particles');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');

  let W, H,
      dots = [];

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }

  resize();
  window.addEventListener('resize', resize);

  for (let i = 0; i < 60; i++) {
    dots.push({
      x: Math.random() * W,
      y: Math.random() * H,
      r: Math.random() * 1.5 + 0.5,
      vx: (Math.random() - 0.5) * 0.3,
      vy: (Math.random() - 0.5) * 0.3,
      o: Math.random() * 0.4 + 0.1
    });
  }

  function animate() {
    ctx.clearRect(0, 0, W, H);

    dots.forEach(d => {
      d.x += d.vx;
      d.y += d.vy;

      if (d.x < 0 || d.x > W) d.vx *= -1;
      if (d.y < 0 || d.y > H) d.vy *= -1;

      ctx.beginPath();
      ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);

      ctx.fillStyle = `rgba(56,189,248,${d.o})`;
      ctx.fill();
    });

    requestAnimationFrame(animate);
  }

  animate();

});