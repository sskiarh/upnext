document.addEventListener("DOMContentLoaded", () => {
  // ========== NAVBAR ACTIVE + TOMBOL MASUK ==========
  const currentLocation = location.href;
  const menuItems = document.querySelectorAll('.nav-links a');
  menuItems.forEach(link => {
    if (link.href === currentLocation) {
      link.style.color = '#FFBC00';
      link.style.fontWeight = '600';
    }
  });

  // === GANTI TOMBOL MASUK JADI FOTO PROFIL ===
  const user = JSON.parse(localStorage.getItem("user"));
  const masukBtn = document.querySelector(".btn-masuk");
  const navbar = document.querySelector(".navbar");

  if (user && masukBtn) {
    masukBtn.remove();

    const profileImg = document.createElement("img");
    profileImg.src = user.photo;
    profileImg.alt = "Profile";
    profileImg.classList.add("navbar-profile");
    navbar.appendChild(profileImg);

    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const logoutBtn = document.getElementById("logoutBtn");

    document.getElementById("sidebar-name").textContent = user.name;
    document.getElementById("sidebar-email").textContent = user.email;
    document.getElementById("sidebar-photo").src = user.photo;

    profileImg.addEventListener("click", (e) => {
      e.preventDefault();
      sidebar.classList.add("active");
      overlay.classList.add("active");
    });

    overlay.addEventListener("click", () => {
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });

    logoutBtn.addEventListener("click", (e) => {
      e.preventDefault();
      localStorage.removeItem("user");
      localStorage.removeItem("isLoggedIn");
      window.location.href = "index.html";
    });
  }

  // ==== DATA EVENT ====
  const events = [
    { title: "MULTIMEDIA IN ACTION", category: "lomba", poster: "assets/multimedia-action.png", desc: "Lomba UI/UX & WEB Dev | Tutup pendaftaran: 17 Oktober 2025", benefit: "Total Hadiah Jutaan Rupiah", registerLink: "https://www.mia2025.com", detailLink: "https://www.mia2025.com" },
    { title: "WORKSHOP CYBER SECURITY", category: "workshop", poster: "assets/fikfair.png", desc: "Belajar desain Cyber Security dari pakarnya | Tutup pendaftaran: 18 Oktober 2025", benefit: "Gratis", registerLink: "http://bit.ly/WorkshopCyberFIKFairRegistration2025", detailLink: "https://www.instagram.com/fik.fair" },
    { title: "KISAHKU", category: "seminar", poster: "assets/kisahku.png", desc: "Seminar karir mahasiswa | Slot Terbatas", benefit: "E-Certificate & Doorprize", registerLink: "http://bit.ly/RegistrasiPesertaSeminarKisahku2025", detailLink: "https://www.instagram.com/kisahku.upnvj" },
    { title: "DONOR DARAH", category: "sosial", poster: "assets/donordarah.png", desc: "Terbuka untuk semua mahasiswa aktif UPNVJ | 17 September 2025", benefit: "Gratis", registerLink: "https://bit.ly/PendaftaranSatuKarsa2025", detailLink: "https://www.instagram.com/fikupnvj" }
  ];

  // ==== EVENT PAGE ====
  const eventList = document.getElementById('eventList');
  if (eventList) renderEvents(events, eventList);

  // ==== UPCOMING EVENT (HOME PAGE) ====
const upcomingList = document.getElementById("upcomingList");
if (upcomingList && typeof events !== "undefined") {
  // ambil 3 event terbaru
  const latestEvents = events.slice(-3).reverse();
  renderEvents(latestEvents, upcomingList); // pakai fungsi renderEvents yang sama

  // tombol lihat semua
  const seeAllBtn = document.createElement("a");
  seeAllBtn.href = "acara.html";
  seeAllBtn.textContent = "Lihat Semua Event";
  seeAllBtn.classList.add("btn-upcoming"); // pakai CSS tombol kuning
  upcomingList.appendChild(seeAllBtn);
}

  // ==== BOOKMARK PAGE ====
  const bookmarkList = document.getElementById('bookmarkList');
  if (bookmarkList) {
    const bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];

    if (bookmarks.length === 0) {
      bookmarkList.innerHTML = `
        <div class="empty-bookmark">
          <p>Belum ada event yang kamu simpan</p>
        </div>
      `;
    } else {
      const filtered = events.filter(ev => 
        bookmarks.some(b => b.title === ev.title)
      );
      renderEvents(filtered, bookmarkList, true);
    }
  }

  // ==== FUNGSI RENDER CARD ====
  function renderEvents(list, container, isBookmarkPage = false) {
    container.innerHTML = "";
    const bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];

    list.forEach(ev => {
      const isBookmarked = bookmarks.some(b => b.title === ev.title);
      const card = document.createElement("div");
      card.classList.add("event-card");
      card.dataset.category = ev.category;

      card.innerHTML = `
        <div class="poster-container" style="position: relative;">
          <img src="${ev.poster}" alt="${ev.title}">
          <button class="bookmark-btn" data-title="${ev.title}" data-poster="${ev.poster}"
            style="position: absolute; top: 10px; right: 10px; 
                   background-color: white; border: none; border-radius: 50%; 
                   width: 36px; height: 36px; display: flex; align-items: center; 
                   justify-content: center; cursor: pointer;">
            <i class="${isBookmarked ? 'fa-solid' : 'fa-regular'} fa-bookmark" 
               style="color: ${isBookmarked ? '#ffbc00' : '#444'}; font-size: 18px;"></i>
          </button>
        </div>
        <h3 class="event-title">${ev.title}</h3>
        <p class="event-desc">${ev.desc}</p>
        <p class="event-benefit">${ev.benefit}</p>
        <div class="event-buttons">
          <a href="${ev.detailLink}" class="btn">Detail</a>
          <a href="${ev.registerLink}" class="btn-outline">Daftar</a>
        </div>
      `;

      container.appendChild(card);
    });

    // ==== HANDLE BOOKMARK ====
    document.querySelectorAll(".bookmark-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const title = btn.dataset.title;
        const poster = btn.dataset.poster;
        const icon = btn.querySelector("i");
        const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

        if (!isLoggedIn) {
          alert("Kamu harus login dulu untuk menyimpan event!");
          window.location.href = "login.html";
          return;
        }

        let bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];
        const alreadyBookmarked = bookmarks.some(b => b.title === title);

        if (alreadyBookmarked) {
          bookmarks = bookmarks.filter(b => b.title !== title);
          icon.classList.replace("fa-solid", "fa-regular");
          icon.style.color = "#444";
        } else {
          bookmarks.push({ title, poster });
          icon.classList.replace("fa-regular", "fa-solid");
          icon.style.color = "#FFD700";
        }

        localStorage.setItem("bookmarks", JSON.stringify(bookmarks));
        if (isBookmarkPage) location.reload();
      });
    });
  }

  // ==== HANDLE SEARCH ====
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      const searchTerm = e.target.value.toLowerCase();
      const filtered = events.filter(ev =>
        ev.title.toLowerCase().includes(searchTerm) ||
        ev.category.toLowerCase().includes(searchTerm) ||
        ev.desc.toLowerCase().includes(searchTerm)
      );
      renderEvents(filtered, eventList);
    });
  }

  // ==== HANDLE FILTER BUTTONS ====
  document.querySelectorAll(".filter-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      document.querySelectorAll(".filter-btn").forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const category = btn.dataset.category;
      const filtered = category === "all" 
        ? events 
        : events.filter(ev => ev.category === category);
      renderEvents(filtered, eventList);
    });
  });

  // === HANDLE SIDEBAR ===
  const profileImg = document.querySelector(".navbar-profile");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const logoutBtn = document.getElementById("logoutBtn");

  if (user) {
    document.getElementById("sidebar-name").textContent = user.name;
    document.getElementById("sidebar-email").textContent = user.email;
    document.getElementById("sidebar-photo").src = user.photo;
  }

  profileImg?.addEventListener("click", (e) => {
    e.preventDefault();
    sidebar.classList.add("active");
    overlay.classList.add("active");
  });

  overlay?.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
  });

  logoutBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    localStorage.removeItem("user");
    localStorage.removeItem("isLoggedIn");
    window.location.href = "index.html";
  });
});

const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('active');
});
