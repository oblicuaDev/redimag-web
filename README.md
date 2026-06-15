# REDIMAG — Theme WordPress

Theme personalizado para el sitio web de **REDIMAG** (Red Especializada de Insumos Médicos y Agropecuarios), empresa colombiana especializada en insumos veterinarios y agropecuarios.

---

## Stack técnico

| Componente | Versión |
|---|---|
| WordPress | 6.8+ |
| PHP | 8.0+ (probado en 8.3) |
| Advanced Custom Fields (ACF) | 6.x |
| Google Tag Manager | GTM-TZTT3Z2M |
| Tipografía | Montserrat (Google Fonts) |

---

## Estructura de archivos

```
redimag-theme/
├── css/
│   └── styles.css           # Hoja de estilos principal (design system completo)
├── images/                  # Imágenes estáticas del theme
├── inc/
│   └── class-nav-walker.php # Walker personalizado para menú de navegación
├── js/
│   └── main.js              # JavaScript del frontend (filtros, slider, formulario)
├── archive-producto.php     # Archivo del CPT Productos (catálogo)
├── footer.php               # Footer del sitio
├── front-page.php           # Página de inicio
├── functions.php            # Registro de CPTs, ACF, hooks, REST API, SEO
├── header.php               # Header + GTM + menú de navegación
├── index.php                # Fallback requerido por WordPress
├── page-contacto.php        # Página de contacto con formulario
├── page-nosotros.php        # Página Quiénes somos
├── single-producto.php      # Vista individual de producto
├── style.css                # Header del theme (requerido por WordPress)
└── FIELDS.md                # Referencia de todos los campos ACF registrados
```

---

## Custom Post Types

### `banner`
Banners del hero slider del inicio.

| Campo ACF | Descripción |
|---|---|
| `banner_copy` | Titular principal (máx. 160 chars) |
| `banner_descripcion` | Descripción corta bajo el titular (máx. 280 chars) |
| `banner_imagen` | Imagen de fondo del banner |
| `banner_cta_texto` | Texto del botón CTA |
| `banner_cta_enlace` | URL del CTA |

### `producto`
Catálogo de productos con archive en `/catalogo/`.

| Campo ACF | Descripción |
|---|---|
| `producto_sku` | Código de referencia |
| `producto_keywords` | Palabras clave separadas por coma |
| `producto_especies` | Relación con CPT Especie |
| `producto_destacado` | Toggle: aparece en "Productos del día" del inicio |
| `producto_precio` | Precio de venta al público (opcional) |
| `producto_imagen_1` a `_4` | Galería de hasta 4 imágenes |

Taxonomía: **category** (Consumibles, Medicamentos, Reproducción Animal).

### `especie`
Especies animales para filtrado del catálogo (bovino, equino, canino, etc.).

### `diferenciador`
Puntos diferenciadores mostrados en la página Nosotros. Usa `post_title` y `post_content`, ordenados por `menu_order`.

### `lead` *(privado)*
Registro de consultas recibidas por el formulario de contacto.

| Campo ACF | Descripción |
|---|---|
| `lead_telefono` | Teléfono del solicitante |
| `lead_tipo` | Tipo de consulta |
| `lead_mensaje` | Mensaje libre |

---

## Campos ACF por página

### Página Inicio (ID 6)
| Campo | Descripción |
|---|---|
| `inicio_titulo_redimag` | Titular de la sección "Quiénes somos" |
| `inicio_desc_redimag` | Descripción de la sección "Quiénes somos" |
| `inicio_titulo_catalogo` | Titular de la franja del catálogo |
| `inicio_desc_catalogo` | Descripción de la franja del catálogo |
| `inicio_imagen_catalogo` | Imagen decorativa de la franja catálogo |

### Página Nosotros (ID 9)
| Campo | Descripción |
|---|---|
| `nosotros_titulo_banner` | Titular del hero banner |
| `nosotros_descripcion` | Descripción introductoria del hero |
| `nosotros_imagen_banner` | Imagen del hero (upload, recomendado 1440×480 px) |

### Página Contacto (ID 11)
| Campo | Descripción |
|---|---|
| `contacto_descripcion` | Texto enriquecido sobre el formulario |
| `contacto_email` | Correo electrónico de contacto |
| `contacto_whatsapp` | Número WhatsApp (formato internacional sin +) |
| `contacto_telefono` | Líneas telefónicas |
| `contacto_instagram` | URL Instagram |
| `contacto_facebook` | URL Facebook |

### Categorías (taxonomy: category)
| Campo | Descripción |
|---|---|
| `categoria_imagen` | Imagen representativa de la línea |
| `categoria_banner` | Banner horizontal (recomendado 1440×400 px) |

### SEO (páginas y productos)
| Campo | Descripción |
|---|---|
| `seo_titulo` | Override del `<title>` y `og:title` (máx. 60 chars) |
| `seo_descripcion` | Meta description (máx. 160 chars) |
| `seo_imagen_og` | Imagen para Open Graph (recomendado 1200×630 px) |

---

## SEO

Implementado directamente en el theme sin plugins adicionales. Genera en `wp_head`:

- `<meta name="description">`
- `<link rel="canonical">`
- Open Graph: `og:type`, `og:title`, `og:description`, `og:url`, `og:image`, `og:locale`, `og:site_name`
- Twitter Card: `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`

El `<title>` se controla mediante el filtro `pre_get_document_title`. Los valores se pueden sobreescribir por entrada desde el campo `seo_titulo`. Si no se define, se usan el título de la página y el extracto como fallback. Todos los productos y páginas existentes tienen sus campos SEO pre-cargados.

---

## REST API

### `POST /redimag/v1/lead`

Endpoint para el formulario de contacto. Crea una entrada del CPT `lead`.

**Headers requeridos:**
```
X-WP-Nonce: <nonce wp_rest>
Content-Type: application/json
```

**Body:**
```json
{
  "nombre": "string (requerido)",
  "telefono": "string (requerido)",
  "tipo": "string (requerido)",
  "mensaje": "string (opcional)"
}
```

**Respuesta exitosa:**
```json
{ "success": true, "id": 123 }
```

---

## Frontend — `main.js`

### Hero Slider (`setupHeroSlider`)
- Banners renderizados en PHP desde el CPT `banner`, consultados en orden aleatorio.
- Transición por opacidad con `position: absolute` entre slides apilados.
- Rotación automática cada 5 segundos con `setInterval`.
- Navegación por bullets inferiores; cada clic reinicia el temporizador.
- Sin flechas de navegación.

### Filtros del catálogo (`setupCatalogFilters`)
- Filtrado 100% client-side sobre los productos ya renderizados en el DOM.
- Filtros por **Línea de producto** (checkbox) y **Especie** (checkbox).
- Búsqueda por texto en tiempo real.
- **Smart filter disabling**: deshabilita automáticamente las opciones de filtro que producirían cero resultados dada la selección actual.
- Paginación lazy por bloques de 15 productos con botón "Mostrar más".
- Contadores `X de Y productos` actualizados en tiempo real.

### Formulario de contacto (`setupContactForm`)
- Envío vía `fetch` al endpoint REST `POST /redimag/v1/lead`.
- Estado de carga: spinner + botón deshabilitado durante el envío.
- Modal de confirmación al recibir respuesta exitosa.
- Gestión de errores con mensaje inline.

---

## Menús de WordPress

| Location | Slug | Uso |
|---|---|---|
| Menú principal (header) | `menu-principal` | Navegación del sitio, soporta 2 niveles |
| Menú footer | `menu-footer` | Links del pie de página |

---

## Google Tag Manager

Integrado en `header.php`:
- Script asíncrono en `<head>` (ID: `GTM-TZTT3Z2M`).
- Iframe noscript inmediatamente después de la apertura de `<body>`.

---

## Plugins requeridos

| Plugin | Uso |
|---|---|
| Advanced Custom Fields (ACF) | Campos personalizados para CPTs y páginas |
| XML Sitemap Generator for Google | Generación automática de sitemap XML |

Los campos ACF se registran vía `acf_add_local_field_group()` en `functions.php`, sin necesidad de importar archivos JSON ni activar ACF Pro.

---

## Requisitos de instalación

1. WordPress 6.0 o superior con PHP 8.0+.
2. Plugins requeridos instalados y activados.
3. Permalinks configurados en modo **Nombre de entrada** (`/%postname%/`).
4. Página de inicio estática asignada a la página **Inicio**.
5. Los menús `menu-principal` y `menu-footer` asignados desde **Apariencia → Menús**.

---

## Paleta de colores

| Variable CSS | Color | Uso |
|---|---|---|
| `--navy` | `#1B2D4F` | Color principal, headings, CTAs |
| `--green` | `#4A7C59` | Acento secundario |
| `--gold` | `#C8923A` | Acento terciario, badges |
| `--gray` | `#F4F4F2` | Fondos suaves |
| `--text` | `#2C2C2C` | Texto de cuerpo |
| `--white` | `#FFFFFF` | Fondos y textos sobre oscuro |

---

## Nota sobre conversión

El sitio no incluye carrito, checkout ni pasarela de pagos. Es un **catálogo consultivo**: la conversión principal es la consulta directa por WhatsApp o mediante el formulario de contacto, que queda registrado en el CPT `lead` dentro del admin de WordPress.

---

## Desarrollado por

**Oblicua** — [oblicua.co](https://oblicua.co)  
Cliente: REDIMAG — Red Especializada de Insumos Médicos y Agropecuarios
