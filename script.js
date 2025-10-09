document.addEventListener('DOMContentLoaded', () => {
  // ========== NAVBAR ACTIVE + TOMBOL MASUK ==========
  const currentLocation = location.href;
  const menuItems = document.querySelectorAll('.nav-links a');
  const body = document.body;

  menuItems.forEach(link => {
    if (link.href === currentLocation) {
      link.style.color = '#FFBC00';
      link.style.fontWeight = '600';
    }
  });

  const masukBtn = document.querySelector('.btn-masuk');
  if (masukBtn) {
    masukBtn.addEventListener('mousedown', () => {
      masukBtn.style.color = '#213C29';
    });
    masukBtn.addEventListener('mouseup', () => {
      masukBtn.style.color = 'white';
    });
  }

  // ========== EVENT PAGE FEATURE ==========
  const eventList = document.getElementById('eventList');
  if (eventList) {
    const events = [
      { title: "Seminar Kecerdasan Buatan", category: "seminar" },
      { title: "Workshop Desain UI/UX", category: "workshop" },
      { title: "Lomba Karya Tulis Ilmiah", category: "lomba" },
      { title: "Pendaftaran UKM Musik", category: "ukm" },
      { title: "Seminar Technopreneurship", category: "seminar" },
      { title: "Workshop Public Speaking", category: "workshop" },
    ];

    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');

    function renderEvents(filteredEvents) {
      eventList.innerHTML = "";
      filteredEvents.forEach(ev => {
        const card = document.createElement('div');
        card.classList.add('event-card');
        card.innerHTML = `<h3>${ev.title}</h3><p>Kategori: ${ev.category}</p>`;
        eventList.appendChild(card);
      });
    }

    // tampilkan semua di awal
    renderEvents(events);

    // filter kategori
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelector('.filter-btn.active').classList.remove('active');
        btn.classList.add('active');
        const category = btn.dataset.category;
        const filtered = category === 'all'
          ? events
          : events.filter(ev => ev.category === category);
        renderEvents(filtered);
      });
    });

    // fitur search
    searchInput.addEventListener('input', e => {
      const keyword = e.target.value.toLowerCase();
      const activeCategory = document.querySelector('.filter-btn.active').dataset.category;
      const filtered = events.filter(ev => {
        const matchKeyword = ev.title.toLowerCase().includes(keyword);
        const matchCategory = activeCategory === 'all' || ev.category === activeCategory;
        return matchKeyword && matchCategory;
      });
      renderEvents(filtered);
    });
  }
});
