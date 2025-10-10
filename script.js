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
  { 
    title: "MULTIMEDIA IN ACTION", 
    category: "lomba", 
    poster: "assets/multimedia-action.png", 
    desc: "Lomba UI/UX & WEB Dev | Tutup pendaftaran: 17 Oktober 2025", 
    benefit: "Total Hadiah Jutaan Rupiah",
    registerLink: "https://www.mia2025.com",
    detailLink: "https://www.mia2025.com"
  },
  { 
    title: "WORKSHOP CYBER SECURITY", 
    category: "workshop", 
    poster: "assets/fikfair.png", 
    desc: "Belajar desain Cyber Security dari pakarnya | Tutup pendaftaran: 18 Oktober 2025", 
    benefit: "Gratis",
    registerLink: "http://bit.ly/WorkshopCyberFIKFairRegistration2025",
    detailLink: "https://www.instagram.com/fik.fair?igsh=MThiN201NDlxNDVzNA=="
  },
  { 
    title: "KISAHKU", 
    category: "seminar", 
    poster: "assets/kisahku.png", 
    desc: "Seminar karir mahasiwa | Slot Terbatas", 
    benefit: "E-Certificate & Doorprize",
    registerLink: "http://bit.ly/RegistrasiPesertaSeminarKisahku2025",
    detailLink: "https://www.instagram.com/kisahku.upnvj?igsh=MTNxeDB4d2U1c3B3Yw=="
  },
  { 
    title: "DONOR DARAH", 
    category: "sosial", 
    poster: "assets/donordarah.png", 
    desc: "Terbuka untuk semua mahasiswa aktifUPNVJ | 17 September 2025", 
    benefit: "Gratis",
    registerLink: "https://bit.ly/PendaftaranSatuKarsa2025",
    detailLink: "https://www.instagram.com/fikupnvj?igsh=MW45MGJrNHlwbzNwaQ=="
  },
];

    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');

   function renderEvents(filteredEvents) {
  eventList.innerHTML = "";
  filteredEvents.forEach(ev => {
    const card = document.createElement('div');
    card.classList.add('event-card');
    card.dataset.category = ev.category;

    card.innerHTML = `
  <img src="${ev.poster}" alt="${ev.title}">
  <div class="event-info">
    <h3 class="event-title">${ev.title}</h3>
    <p class="event-desc">${ev.desc}</p>
    <p class="event-benefit">${ev.benefit}</p>
    <div class="event-buttons">
      <a href="${ev.detailLink}" class="btn">Detail</a>
      <a href="${ev.registerLink}" class="btn-outline">Daftar</a>
    </div>
  </div>
`;



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
