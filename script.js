document.addEventListener("DOMContentLoaded", () => {
  // ====== KONFIG BASIC PATH ======
  const BASE_PATH     = "/UPNext";                     // sesuaikan kalau nama folder project beda
  const HOME_PAGE     = `${BASE_PATH}/index.php`;
  const LOGIN_PAGE    = `${BASE_PATH}/pages/login.html`;
  const DEFAULT_PHOTO = `${BASE_PATH}/assets/foto profile.png`;

  // ====== NAVBAR: ACTIVE LINK ======
  const currentLocation = location.href;
  const menuItems = document.querySelectorAll(".nav-links a");
  menuItems.forEach((link) => {
    if (link.href === currentLocation) {
      link.style.color = "#FFBC00";
      link.style.fontWeight = "600";
    }
  });

  // ====== AMBIL DATA USER DARI LOCALSTORAGE ======
  let user = null;
  try {
    const raw = localStorage.getItem("user");
    user = raw ? JSON.parse(raw) : null;
  } catch (e) {
    user = null;
  }

  const navbar   = document.querySelector(".navbar");
  const masukBtn = document.querySelector(".btn-masuk");
  let   navProfileImg = document.querySelector(".navbar-profile"); // bisa sudah ada di HTML (mis. profile.html)

  // ====== GANTI TOMBOL MASUK JADI FOTO PROFIL (KALAU ADA USER) ======
  if (user) {
    // kalau ada tombol "Masuk" di navbar -> ganti jadi foto profil
    if (masukBtn && navbar) {
      masukBtn.remove();
      const img = document.createElement("img");
      img.src = user.photo || DEFAULT_PHOTO;
      img.alt = "Profile";
      img.classList.add("navbar-profile");
      navbar.appendChild(img);
      navProfileImg = img; // update referensi
    }

    // isi info user di sidebar kalau elemen ada
    const sidebarName  = document.getElementById("sidebar-name");
    const sidebarEmail = document.getElementById("sidebar-email");
    const sidebarPhoto = document.getElementById("sidebar-photo");

    if (sidebarName)  sidebarName.textContent  = user.name  || "Nama pengguna";
    if (sidebarEmail) sidebarEmail.textContent = user.email || "Email pengguna";
    if (sidebarPhoto) sidebarPhoto.src         = user.photo || DEFAULT_PHOTO;
  }

  // ====== HANDLE SIDEBAR (PROFILE, OVERLAY, LOGOUT) ======
  const sidebar  = document.getElementById("sidebar");
  const overlay  = document.getElementById("overlay");
  const logoutBtn = document.getElementById("logoutBtn");

  // buka sidebar kalau foto profil di navbar diklik
  if (navProfileImg && sidebar && overlay) {
    navProfileImg.addEventListener("click", (e) => {
      e.preventDefault();
      sidebar.classList.add("active");
      overlay.classList.add("active");
    });
  }

  // tutup sidebar kalau klik overlay
  if (overlay && sidebar) {
    overlay.addEventListener("click", () => {
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });
  }

  // tombol logout
  if (logoutBtn) {
    logoutBtn.addEventListener("click", (e) => {
      e.preventDefault();
      localStorage.removeItem("user");
      localStorage.removeItem("isLoggedIn");
      window.location.href = HOME_PAGE;
    });
  }

  // ====== DATA EVENT DARI PHP ======
  const events = Array.isArray(window.eventsFromDb) ? window.eventsFromDb : [];

  // ====== HALAMAN ACARA (DAFTAR EVENT PENUH) ======
  const eventList = document.getElementById("eventList");
  if (eventList) {
    renderEvents(events, eventList);
  }

  // ====== UPCOMING EVENT (HOME PAGE) ======
  const upcomingList = document.getElementById("upcomingList");
  if (upcomingList && events.length) {
    const latestEvents = events.slice(-3).reverse(); // 3 terakhir
    renderEvents(latestEvents, upcomingList);

    const seeAllBtn = document.createElement("a");
    seeAllBtn.href = `${BASE_PATH}/acara.php`;
    seeAllBtn.textContent = "Lihat Semua Event";
    seeAllBtn.classList.add("btn-upcoming");
    upcomingList.appendChild(seeAllBtn);
  }

  // ====== HALAMAN BOOKMARK ======
  const bookmarkList = document.getElementById("bookmarkList");
  if (bookmarkList) {
    const bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];

    if (!bookmarks.length) {
      bookmarkList.innerHTML = `
        <div class="empty-bookmark">
          <p>Belum ada event yang kamu simpan</p>
        </div>
      `;
    } else {
      const filtered = events.filter((ev) =>
        bookmarks.some((b) => b.title === ev.title)
      );
      renderEvents(filtered, bookmarkList, true);
    }
  }

  // ====== FUNGSI RENDER CARD EVENT ======
  function renderEvents(list, container, isBookmarkPage = false) {
    if (!container) return;

    container.innerHTML = "";
    const bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];

    list.forEach((ev) => {
      const isBookmarked = bookmarks.some((b) => b.title === ev.title);

      const card = document.createElement("div");
      card.classList.add("event-card");
      card.dataset.category = ev.category || "";

      card.innerHTML = `
        <div class="poster-container" style="position: relative;">
          <img src="${ev.poster}" alt="${ev.title}">
          <button class="bookmark-btn" data-title="${ev.title}" data-poster="${ev.poster}"
            style="position: absolute; top: 10px; right: 10px;
                   background-color: white; border: none; border-radius: 50%;
                   width: 36px; height: 36px; display: flex; align-items: center;
                   justify-content: center; cursor: pointer;">
            <i class="${isBookmarked ? "fa-solid" : "fa-regular"} fa-bookmark"
               style="color: ${isBookmarked ? "#ffbc00" : "#444"}; font-size: 18px;"></i>
          </button>
        </div>
        <h3 class="event-title">${ev.title}</h3>
        <p class="event-desc">${ev.desc}</p>
        <p class="event-benefit">${ev.benefit || ""}</p>
        <div class="event-actions">
    <a href="${ev.detailLink || '#'}" target="_blank" class="btn-detail">Detail</a>
    <a href="${ev.registerLink || '#'}" target="_blank" class="btn-register">Daftar</a>
    <a href="${BASE_PATH}/download.php?file=${encodeURIComponent(ev.poster)}" class="btn-download">
      <i class="fa-solid fa-download"></i> Download
    </a>
  </div>
      `;

      container.appendChild(card);
    });

    // handle klik bookmark
    document.querySelectorAll(".bookmark-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        const title = btn.dataset.title;
        const poster = btn.dataset.poster;
        const icon = btn.querySelector("i");
        const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

        if (!isLoggedIn) {
          alert("Kamu harus login dulu untuk menyimpan event!");
          window.location.href = LOGIN_PAGE;
          return;
        }

        let bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];
        const already = bookmarks.some((b) => b.title === title);

        if (already) {
          bookmarks = bookmarks.filter((b) => b.title !== title);
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

  // ====== SEARCH DI HALAMAN ACARA ======
  const searchInput = document.getElementById("searchInput");
  if (searchInput && eventList) {
    searchInput.addEventListener("input", (e) => {
      const searchTerm = e.target.value.toLowerCase();
      const filtered = events.filter((ev) =>
        (ev.title || "").toLowerCase().includes(searchTerm) ||
        (ev.category || "").toLowerCase().includes(searchTerm) ||
        (ev.desc || "").toLowerCase().includes(searchTerm)
      );
      renderEvents(filtered, eventList);
    });
  }

  // ====== FILTER BUTTONS DI HALAMAN ACARA ======
  const filterButtons = document.querySelectorAll(".filter-btn");
  if (filterButtons.length && eventList) {
    filterButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        filterButtons.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        const category = btn.dataset.category;
        const filtered =
          category === "all"
            ? events
            : events.filter((ev) => ev.category === category);
        renderEvents(filtered, eventList);
      });
    });
  }

  // ====== HAMBURGER MENU (MOBILE NAV) ======
  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("navLinks");

  if (hamburger && navLinks) {
    hamburger.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });
  }
});
