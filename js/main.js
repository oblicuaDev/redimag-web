const WHATSAPP_NUMBER = "573000000000";
const GENERAL_MESSAGE = "Hola, quiero recibir asesoría sobre productos veterinarios REDIMAG.";
const PRODUCTS = [
  {
    slug: "antibiotico-veterinario-amplio-espectro",
    code: "Rx",
    visual: "visual-red",
    badge: "badge-red",
    category: "Fármacos y medicamentos",
    name: "Antibiótico veterinario de amplio espectro",
    description: "Soporte terapéutico para consulta profesional en animales de producción y clínica.",
    application: "Manejo clínico bajo criterio veterinario.",
    species: "Bovinos, campo y clínica veterinaria"
  },
  {
    slug: "antiinflamatorio-veterinario",
    code: "AI",
    visual: "visual-red",
    badge: "badge-red",
    category: "Fármacos y medicamentos",
    name: "Antiinflamatorio veterinario",
    description: "Producto de apoyo para procesos inflamatorios y bienestar animal.",
    application: "Soporte en dolor e inflamación.",
    species: "Bovinos, mascotas y clínica veterinaria"
  },
  {
    slug: "desparasitante-veterinario",
    code: "Dp",
    visual: "visual-red",
    badge: "badge-red",
    category: "Fármacos y medicamentos",
    name: "Desparasitante veterinario",
    description: "Producto de referencia para programas de control sanitario en animales domésticos.",
    application: "Planes preventivos y seguimiento veterinario.",
    species: "Mascotas y clínica veterinaria"
  },
  {
    slug: "kit-inseminacion-artificial",
    code: "IA",
    visual: "visual-blue",
    badge: "badge-blue",
    category: "Reproducción animal",
    name: "Kit de inseminación artificial",
    description: "Conjunto de insumos para apoyar procedimientos reproductivos en campo.",
    application: "Manejo reproductivo en sistemas productivos.",
    species: "Bovinos y producción de campo"
  },
  {
    slug: "guantes-palpacion-veterinaria",
    code: "GP",
    visual: "visual-blue",
    badge: "badge-blue",
    category: "Reproducción animal",
    name: "Guantes de palpación veterinaria",
    description: "Implemento de protección para procedimientos técnicos de campo y clínica.",
    application: "Higiene y seguridad durante la atención.",
    species: "Bovinos, campo y clínica veterinaria"
  },
  {
    slug: "cateter-reproductivo-bovino",
    code: "Cr",
    visual: "visual-blue",
    badge: "badge-blue",
    category: "Reproducción animal",
    name: "Catéter reproductivo bovino",
    description: "Insumo técnico para protocolos reproductivos y asistencia en finca.",
    application: "Soporte operativo en reproducción bovina.",
    species: "Bovinos y producción de campo"
  },
  {
    slug: "suplemento-mineral-bovinos",
    code: "Mn",
    visual: "visual-green",
    badge: "badge-green",
    category: "Nutrición",
    name: "Suplemento mineral para bovinos",
    description: "Soporte nutricional para sistemas ganaderos enfocados en bienestar y rendimiento.",
    application: "Complemento mineral para producción bovina.",
    species: "Bovinos y producción de campo"
  },
  {
    slug: "alimento-nutricional-mascotas",
    code: "Pet",
    visual: "visual-green",
    badge: "badge-green",
    category: "Nutrición",
    name: "Alimento nutricional para mascotas",
    description: "Producto de apoyo para cuidado diario y nutrición de animales de compañía.",
    application: "Soporte de bienestar y condición corporal.",
    species: "Mascotas y clínica veterinaria"
  },
  {
    slug: "bloque-nutricional-ganadero",
    code: "Bg",
    visual: "visual-green",
    badge: "badge-green",
    category: "Nutrición",
    name: "Bloque nutricional ganadero",
    description: "Apoyo alimentario para temporadas de mayor demanda productiva.",
    application: "Soporte de consumo y condición en finca.",
    species: "Bovinos y producción de campo"
  },
  {
    slug: "jeringa-dosificadora-veterinaria",
    code: "ml",
    visual: "visual-yellow",
    badge: "badge-yellow",
    category: "Accesorios y equipamiento",
    name: "Jeringa dosificadora veterinaria",
    description: "Herramienta práctica para dosificación y operación veterinaria controlada.",
    application: "Administración precisa en campo o clínica.",
    species: "Bovinos, campo y clínica veterinaria"
  },
  {
    slug: "bebedero-comedero-ganadero",
    code: "Ag",
    visual: "visual-yellow",
    badge: "badge-yellow",
    category: "Accesorios y equipamiento",
    name: "Bebedero o comedero ganadero",
    description: "Equipamiento para mejorar rutinas de suministro en sistemas de producción.",
    application: "Operación más ordenada en finca.",
    species: "Bovinos y producción de campo"
  },
  {
    slug: "maletin-veterinario-campo",
    code: "Eq",
    visual: "visual-yellow",
    badge: "badge-yellow",
    category: "Accesorios y equipamiento",
    name: "Maletín veterinario de campo",
    description: "Organización de implementos para jornadas de atención y visitas productivas.",
    application: "Transporte y orden de herramientas clínicas.",
    species: "Mascotas, campo y clínica veterinaria"
  }
];

const buildWhatsappUrl = (message) => {
  return `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(message)}`;
};

const setGeneralWhatsappLinks = () => {
  document.querySelectorAll(".js-whatsapp").forEach((link) => {
    link.href = buildWhatsappUrl(GENERAL_MESSAGE);
  });
};

const setProductWhatsappLinks = () => {
  const link = document.querySelector(".product-detail-whatsapp");
  const name = document.querySelector("#detail-name")?.textContent.trim();
  const category = document.querySelector("#detail-category")?.textContent.trim();

  if (link && name && category) {
    const message = `Hola, quiero consultar sobre el producto: ${name} de la línea ${category}.`;
    link.href = buildWhatsappUrl(message);
    link.setAttribute("aria-label", `Consultar por WhatsApp sobre ${name}`);
  }
};

const setupMobileMenu = () => {
  const toggle = document.querySelector(".menu-toggle");
  const nav = document.querySelector(".main-nav");

  if (!toggle || !nav) return;

  const closeMenu = () => {
    document.body.classList.remove("menu-open");
    nav.classList.remove("is-open");
    toggle.setAttribute("aria-expanded", "false");
    toggle.setAttribute("aria-label", "Abrir menú");
  };

  toggle.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("is-open");
    document.body.classList.toggle("menu-open", isOpen);
    toggle.setAttribute("aria-expanded", String(isOpen));
    toggle.setAttribute("aria-label", isOpen ? "Cerrar menú" : "Abrir menú");
  });

  nav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeMenu);
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > 820) closeMenu();
  });
};

const PAGE_SIZE = 15;

const setupCatalogFilters = () => {
  const productCards  = document.querySelectorAll(".product-card");
  const searchInput   = document.querySelector(".header-search-input");
  const lineFilters   = document.querySelectorAll(".line-filter");
  const speciesFilters = document.querySelectorAll(".species-filter");
  const resetButton   = document.querySelector(".reset-filters");
  const countLabel    = document.querySelector("#result-count");
  const totalLabel    = document.querySelector("#total-count");
  const emptyState    = document.querySelector("#empty-state");
  const loadMoreWrap  = document.querySelector("#load-more-wrap");
  const loadMoreBtn   = document.querySelector("#load-more-btn");

  if (!productCards.length) return;

  const params = new URLSearchParams(window.location.search);
  const activeLine    = params.get("linea") || "";
  const activeEspecie = params.get("especie") || "";

  if (activeLine) {
    const matchingLine = document.querySelector(`.line-filter[value="${activeLine}"]`);
    if (matchingLine) matchingLine.checked = true;
  }
  if (activeEspecie) {
    const matchingEsp = document.querySelector(`.species-filter[value="${activeEspecie}"]`);
    if (matchingEsp) matchingEsp.checked = true;
  }
  if (searchInput) searchInput.value = params.get("buscar") || "";

  const getCheckedValues = (controls) =>
    Array.from(controls).filter((c) => c.checked).map((c) => c.value);

  const cards = Array.from(productCards);
  let visibleWindow = PAGE_SIZE;

  const updateFilterAvailability = (selectedLines, selectedSpecies) => {
    lineFilters.forEach((filter) => {
      if (filter.checked) {
        filter.disabled = false;
        filter.closest("label").classList.remove("filter-disabled");
        return;
      }
      const count = cards.filter((card) => {
        const speciesText = card.dataset.species || "";
        return (
          card.dataset.category === filter.value &&
          (selectedSpecies.length === 0 || selectedSpecies.some((s) => speciesText.includes(s)))
        );
      }).length;
      filter.disabled = count === 0;
      filter.closest("label").classList.toggle("filter-disabled", count === 0);
    });

    speciesFilters.forEach((filter) => {
      if (filter.checked) {
        filter.disabled = false;
        filter.closest("label").classList.remove("filter-disabled");
        return;
      }
      const count = cards.filter((card) => {
        const speciesText = card.dataset.species || "";
        return (
          speciesText.includes(filter.value) &&
          (selectedLines.length === 0 || selectedLines.includes(card.dataset.category))
        );
      }).length;
      filter.disabled = count === 0;
      filter.closest("label").classList.toggle("filter-disabled", count === 0);
    });
  };

  const updateResults = () => {
    const query          = (searchInput?.value || "").trim().toLowerCase();
    const selectedLines   = getCheckedValues(lineFilters);
    const selectedSpecies = getCheckedValues(speciesFilters);

    const filtered = cards.filter((card) => {
      const cardText    = card.textContent.toLowerCase();
      const speciesText = card.dataset.species || "";
      return (
        (selectedLines.length === 0 || selectedLines.includes(card.dataset.category)) &&
        (selectedSpecies.length === 0 || selectedSpecies.some((s) => speciesText.includes(s))) &&
        (!query || cardText.includes(query))
      );
    });

    cards.forEach((card) => { card.hidden = true; });
    filtered.slice(0, visibleWindow).forEach((card) => { card.hidden = false; });

    const showing = Math.min(filtered.length, visibleWindow);
    const total   = filtered.length;

    if (countLabel) countLabel.textContent = String(showing);
    if (totalLabel) totalLabel.textContent  = String(total);
    if (emptyState) emptyState.hidden       = total !== 0;

    if (loadMoreWrap) loadMoreWrap.hidden = total <= visibleWindow;

    updateFilterAvailability(selectedLines, selectedSpecies);
  };

  loadMoreBtn?.addEventListener("click", () => {
    visibleWindow += PAGE_SIZE;
    updateResults();
  });

  searchInput?.addEventListener("input", () => {
    visibleWindow = PAGE_SIZE;
    updateResults();
  });

  [...lineFilters, ...speciesFilters].forEach((control) => {
    control.addEventListener("change", () => {
      visibleWindow = PAGE_SIZE;
      updateResults();
    });
  });

  resetButton?.addEventListener("click", () => {
    if (searchInput) searchInput.value = "";
    [...lineFilters, ...speciesFilters].forEach((control) => {
      control.checked  = false;
      control.disabled = false;
      control.closest("label").classList.remove("filter-disabled");
    });
    visibleWindow = PAGE_SIZE;
    updateResults();
  });

  updateResults();
};

const setupHeaderSearch = () => {
  const form = document.querySelector(".header-search");
  const input = document.querySelector(".header-search-input");
  const isCatalogPage = document.querySelector(".catalog-page");

  if (!form || !input) return;

  form.addEventListener("submit", (event) => {
    const query = input.value.trim();
    if (!isCatalogPage) return;

    event.preventDefault();
    const url = new URL(window.location.href);
    if (query) {
      url.searchParams.set("buscar", query);
    } else {
      url.searchParams.delete("buscar");
    }
    history.replaceState(null, "", url);
    input.dispatchEvent(new Event("input", { bubbles: true }));
  });
};

const setupProductCardNavigation = () => {
  document.querySelectorAll(".product-card[data-slug]").forEach((card) => {
    card.setAttribute("tabindex", "0");
    card.setAttribute("role", "link");
    card.setAttribute("aria-label", `Ver detalle de ${card.querySelector("h3")?.textContent.trim() || "producto"}`);

    const goToProduct = () => {
      window.location.href = `producto.html?producto=${card.dataset.slug}`;
    };

    card.addEventListener("click", () => {
      goToProduct();
    });

    card.addEventListener("keydown", (event) => {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        goToProduct();
      }
    });
  });
};

const setupProductDetail = () => {
  const detail = document.querySelector("#product-detail");
  if (!detail) return;

  const slug = new URLSearchParams(window.location.search).get("producto");
  const product = PRODUCTS.find((item) => item.slug === slug) || PRODUCTS[0];
  const image = document.querySelector("#detail-image");
  const category = document.querySelector("#detail-category");

  document.title = `${product.name} | REDIMAG`;
  document.querySelector("#detail-name").textContent = product.name;
  document.querySelector("#detail-description").textContent = product.description;
  document.querySelector("#detail-application").textContent = product.application;
  document.querySelector("#detail-line").textContent = product.category;
  document.querySelector("#detail-species").textContent = product.species;

  category.textContent = product.category;
  category.className = `category-badge ${product.badge}`;
  image.alt = product.name;
  setProductWhatsappLinks();
};

const setupContactForm = () => {
  const form      = document.querySelector("#contact-form");
  const errorBox  = document.querySelector("#form-error");
  const modal     = document.querySelector("#lead-modal");
  const modalClose = document.querySelector("#modal-close");
  const submitBtn = form?.querySelector(".contact-submit");
  const submitLabel  = submitBtn?.querySelector(".submit-label");
  const submitSpinner = submitBtn?.querySelector(".submit-spinner");

  if (!form || !modal || typeof REDIMAG === "undefined") return;

  const setLoading = (on) => {
    submitBtn.disabled = on;
    submitLabel.hidden = on;
    submitSpinner.hidden = !on;
    submitSpinner.setAttribute("aria-hidden", String(!on));
  };

  const showError = (msg) => {
    errorBox.textContent = msg;
    errorBox.hidden = false;
  };

  const clearError = () => {
    errorBox.hidden = true;
    errorBox.textContent = "";
  };

  const openModal = () => {
    modal.hidden = false;
    document.body.classList.add("modal-open");
    modalClose?.focus();
  };

  const closeModal = () => {
    modal.hidden = true;
    document.body.classList.remove("modal-open");
  };

  modalClose?.addEventListener("click", closeModal);
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.hidden) closeModal();
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    clearError();

    const data = Object.fromEntries(new FormData(form));

    if (!data.nombre?.trim() || !data.telefono?.trim() || !data.tipo?.trim()) {
      showError("Por favor completa Nombre, Teléfono y Tipo de consulta.");
      return;
    }

    setLoading(true);
    try {
      const res = await fetch(REDIMAG.leadUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": REDIMAG.nonce,
        },
        body: JSON.stringify({
          nombre:   data.nombre.trim(),
          telefono: data.telefono.trim(),
          tipo:     data.tipo.trim(),
          mensaje:  (data.mensaje || "").trim(),
        }),
      });

      const json = await res.json();

      if (!res.ok) {
        throw new Error(json.message || "Error al enviar.");
      }

      form.reset();
      openModal();
    } catch (err) {
      showError(err.message || "Ocurrió un error. Intenta de nuevo o contáctanos por WhatsApp.");
    } finally {
      setLoading(false);
    }
  });
};

const setupHeroSlider = () => {
  const slider  = document.getElementById("hero-slider");
  if (!slider) return;

  const slides  = Array.from(slider.querySelectorAll(".hero-slide"));
  const bullets = Array.from(slider.querySelectorAll(".slider-bullet"));
  if (slides.length <= 1) return;

  let current = 0;
  let timer   = null;

  const goTo = (index) => {
    slides[current].classList.remove("is-active");
    slides[current].setAttribute("aria-hidden", "true");
    if (bullets[current]) {
      bullets[current].classList.remove("is-active");
      bullets[current].setAttribute("aria-selected", "false");
    }

    current = ((index % slides.length) + slides.length) % slides.length;

    slides[current].classList.add("is-active");
    slides[current].setAttribute("aria-hidden", "false");
    if (bullets[current]) {
      bullets[current].classList.add("is-active");
      bullets[current].setAttribute("aria-selected", "true");
    }
  };

  const startAuto = () => {
    if (timer !== null) clearInterval(timer);
    timer = setInterval(() => goTo(current + 1), 5000);
  };

  bullets.forEach((btn) => {
    btn.addEventListener("click", () => {
      goTo(Number(btn.dataset.slide));
      startAuto();
    });
  });

  startAuto();
};

const setupFooterYear = () => {
  const year = document.querySelector("#year");
  if (year) year.textContent = new Date().getFullYear();
};

const setupCredits = () => {
  try {
    if (typeof window.setCredits === "function") {
      window.setCredits("#c90511", "Redimag");
    }
  } catch (error) {
    console.warn("No se pudieron inicializar los créditos externos.", error);
  }
};

const setupSearchAutocomplete = () => {
  const input     = document.querySelector(".header-search-input");
  const dropdown  = document.getElementById("search-autocomplete");

  if ( !input || !dropdown || typeof REDIMAG === "undefined" ) return;

  let debounceTimer;

  const closeDropdown = () => {
    dropdown.hidden = true;
    dropdown.innerHTML = "";
  };

  const renderResults = (products) => {
    if ( !products.length ) {
      dropdown.innerHTML = '<p class="autocomplete-empty">Sin resultados</p>';
      dropdown.hidden = false;
      return;
    }

    dropdown.innerHTML = products.map( (p) => {
      const thumb = p._embedded?.["wp:featuredmedia"]?.[0]?.media_details?.sizes?.thumbnail?.source_url
                 || p._embedded?.["wp:featuredmedia"]?.[0]?.source_url
                 || REDIMAG.placeholder;
      const title = p.title?.rendered ?? "";
      const link  = p.link ?? "#";
      return `
        <a class="autocomplete-item" href="${link}">
          <img class="autocomplete-thumb" src="${thumb}" alt="${title}" />
          <span class="autocomplete-name">${title}</span>
        </a>`;
    }).join("");

    dropdown.hidden = false;
  };

  const search = async (query) => {
    if ( query.length < 2 ) { closeDropdown(); return; }
    try {
      const url  = `${REDIMAG.restUrl}?search=${encodeURIComponent(query)}&per_page=6&_embed=wp:featuredmedia`;
      const res  = await fetch( url, { headers: { "X-WP-Nonce": REDIMAG.nonce } } );
      const data = await res.json();
      renderResults( data );
    } catch {
      closeDropdown();
    }
  };

  input.addEventListener("input", () => {
    clearTimeout( debounceTimer );
    debounceTimer = setTimeout( () => search( input.value.trim() ), 280 );
  });

  document.addEventListener("click", (e) => {
    if ( !e.target.closest(".header-search-wrap") ) closeDropdown();
  });

  input.addEventListener("keydown", (e) => {
    if ( e.key === "Escape" ) closeDropdown();
  });
};

document.addEventListener("DOMContentLoaded", () => {
  setGeneralWhatsappLinks();
  setupHeaderSearch();
  setupMobileMenu();
  setupHeroSlider();
  setupCatalogFilters();
  setupProductCardNavigation();
  setupProductDetail();
  setupContactForm();
  setupFooterYear();
  setupCredits();
  setupSearchAutocomplete();
});
