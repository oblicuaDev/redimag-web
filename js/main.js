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

const setupCatalogFilters = () => {
  const productCards = document.querySelectorAll(".product-card");
  const searchInput = document.querySelector(".header-search-input");
  const lineFilters = document.querySelectorAll(".line-filter");
  const speciesFilters = document.querySelectorAll(".species-filter");
  const resetButton = document.querySelector(".reset-filters");
  const countLabel = document.querySelector("#result-count");
  const emptyState = document.querySelector("#empty-state");

  if (!productCards.length) return;

  const params = new URLSearchParams(window.location.search);
  const activeLine = params.get("linea") || "";
  const allowedLines = ["todos", "farmacos", "reproduccion", "nutricion", "equipamiento"];
  if (allowedLines.includes(activeLine) && activeLine !== "todos") {
    const matchingLine = document.querySelector(`.line-filter[value="${activeLine}"]`);
    if (matchingLine) matchingLine.checked = true;
  }
  if (searchInput) searchInput.value = params.get("buscar") || "";

  const getCheckedValues = (controls) => {
    return Array.from(controls)
      .filter((control) => control.checked)
      .map((control) => control.value);
  };

  const updateResults = () => {
    const query = (searchInput?.value || "").trim().toLowerCase();
    const selectedLines = getCheckedValues(lineFilters);
    const selectedSpecies = getCheckedValues(speciesFilters);
    let visibleCount = 0;

    productCards.forEach((card) => {
      const cardText = card.textContent.toLowerCase();
      const speciesText = card.dataset.species || "";
      const matchesLine = selectedLines.length === 0 || selectedLines.includes(card.dataset.category);
      const matchesSearch = !query || cardText.includes(query);
      const matchesSpecies =
        selectedSpecies.length === 0 || selectedSpecies.some((species) => speciesText.includes(species));
      const shouldShow = matchesLine && matchesSearch && matchesSpecies;

      card.hidden = !shouldShow;
      if (shouldShow) visibleCount += 1;
    });

    if (countLabel) countLabel.textContent = String(visibleCount);
    if (emptyState) emptyState.hidden = visibleCount !== 0;
  };

  searchInput?.addEventListener("input", updateResults);
  [...lineFilters, ...speciesFilters].forEach((control) => control.addEventListener("change", updateResults));

  resetButton?.addEventListener("click", () => {
    if (searchInput) searchInput.value = "";
    [...lineFilters, ...speciesFilters].forEach((control) => {
      control.checked = false;
    });
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
  const form = document.querySelector("#contact-form");
  const status = document.querySelector("#form-status");

  if (!form || !status) return;

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    status.textContent =
      "Gracias. Tu consulta está lista para ser enviada. También puedes escribirnos directamente por WhatsApp.";
    form.reset();
  });
};

const setupFooterYear = () => {
  const year = document.querySelector("#year");
  if (year) year.textContent = new Date().getFullYear();
};

const setupCredits = () => {
  try {
    if (typeof window.setCredits === "function") {
      window.setCredits("#1f3f68", "Redimag");
    }
  } catch (error) {
    console.warn("No se pudieron inicializar los créditos externos.", error);
  }
};

document.addEventListener("DOMContentLoaded", () => {
  setGeneralWhatsappLinks();
  setupHeaderSearch();
  setupMobileMenu();
  setupCatalogFilters();
  setupProductCardNavigation();
  setupProductDetail();
  setupContactForm();
  setupFooterYear();
  setupCredits();
});
