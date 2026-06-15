# ACF Field Reference — Redimag Theme

Referencia de todos los grupos de campos y sus keys/names para uso en templates.
Función de acceso: `get_field( 'field_name' )` o `get_field( 'field_name', $post_id )`.

---

## Custom Post Types registrados

| Label               | Slug            |
|---------------------|-----------------|
| Banners principales | `banner`        |
| Especies            | `especie`       |
| Productos           | `producto`      |
| Diferenciadores     | `diferenciador` |

---

## Grupo: Banners principales

**Key de grupo:** `group_banners`
**Aplica a:** CPT `banner`

| Label           | Field name            | Field key                  | Tipo    | Notas                        |
|-----------------|-----------------------|----------------------------|---------|------------------------------|
| Copy            | `banner_copy`         | `field_banner_copy`        | text    | maxlength 160                |
| Imagen          | `banner_imagen`       | `field_banner_imagen`      | image   | return: array — máx. 300 KB  |
| Texto del CTA   | `banner_cta_texto`    | `field_banner_cta_texto`   | text    | maxlength 60                 |
| Enlace del CTA  | `banner_cta_enlace`   | `field_banner_cta_enlace`  | url     | validado como URL            |

### Uso en template

```php
$copy       = get_field( 'banner_copy' );
$imagen     = get_field( 'banner_imagen' );   // array: url, width, height, alt
$cta_texto  = get_field( 'banner_cta_texto' );
$cta_enlace = get_field( 'banner_cta_enlace' );
```

---

## Grupo: Datos del producto

**Key de grupo:** `group_productos`
**Aplica a:** CPT `producto`

| Label                      | Field name              | Field key                      | Tipo         | Notas                              |
|----------------------------|-------------------------|--------------------------------|--------------|------------------------------------|
| SKU                        | `producto_sku`          | `field_producto_sku`           | text         | requerido                          |
| Palabras clave             | `producto_keywords`     | `field_producto_keywords`      | text         | separadas por coma                 |
| Especies relacionadas      | `producto_especies`     | `field_producto_especies`      | relationship | post_type: especie — return: object — múltiple |
| Precio de venta al público | `producto_precio`       | `field_producto_precio`        | number       | entero, mín. 0                     |
| Imagen 1                   | `producto_imagen_1`     | `field_producto_imagen_1`      | image        | return: array                      |
| Imagen 2                   | `producto_imagen_2`     | `field_producto_imagen_2`      | image        | return: array                      |
| Imagen 3                   | `producto_imagen_3`     | `field_producto_imagen_3`      | image        | return: array                      |
| Imagen 4                   | `producto_imagen_4`     | `field_producto_imagen_4`      | image        | return: array                      |

### Uso en template

```php
$sku      = get_field( 'producto_sku' );
$keywords = get_field( 'producto_keywords' );         // string — explotar con explode(',', $keywords)
$especies = get_field( 'producto_especies' );         // array de WP_Post objects
$precio   = get_field( 'producto_precio' );           // int
$img1     = get_field( 'producto_imagen_1' );         // array: url, width, height, alt
$img2     = get_field( 'producto_imagen_2' );
$img3     = get_field( 'producto_imagen_3' );
$img4     = get_field( 'producto_imagen_4' );

// Iterar imágenes
$imagenes = [ $img1, $img2, $img3, $img4 ];
foreach ( array_filter( $imagenes ) as $img ) {
    echo '<img src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $img['alt'] ) . '">';
}

// Iterar especies
foreach ( (array) $especies as $especie ) {
    echo '<a href="' . get_permalink( $especie ) . '">' . esc_html( $especie->post_title ) . '</a>';
}
```

---

## Grupo: Contenido — Inicio

**Key de grupo:** `group_inicio`
**Aplica a:** Página con post ID `6`

| Label                            | Field name                    | Field key                           | Tipo     |
|----------------------------------|-------------------------------|-------------------------------------|----------|
| Título presentando a Redimag     | `inicio_titulo_redimag`       | `field_inicio_titulo_redimag`       | text     |
| Descripción corta de Redimag     | `inicio_desc_redimag`         | `field_inicio_desc_redimag`         | textarea |
| Título del catálogo de productos | `inicio_titulo_catalogo`      | `field_inicio_titulo_catalogo`      | text     |
| Descripción corta del catálogo   | `inicio_desc_catalogo`        | `field_inicio_desc_catalogo`        | textarea |
| Imagen del catálogo              | `inicio_imagen_catalogo`      | `field_inicio_imagen_catalogo`      | image    |

### Uso en template

```php
// Desde front-page.php o page-inicio.php usando el ID fijo
$titulo_redimag  = get_field( 'inicio_titulo_redimag',  6 );
$desc_redimag    = get_field( 'inicio_desc_redimag',    6 );
$titulo_catalogo = get_field( 'inicio_titulo_catalogo', 6 );
$desc_catalogo   = get_field( 'inicio_desc_catalogo',   6 );
$img_catalogo    = get_field( 'inicio_imagen_catalogo', 6 );  // array: url, width, height, alt

// O dentro del loop de la propia página (sin ID)
$titulo_redimag  = get_field( 'inicio_titulo_redimag' );
```

---

## Grupo: Contenido — Nosotros

**Key de grupo:** `group_nosotros`
**Aplica a:** Página con post ID `9`

| Label                       | Field name                   | Field key                          | Tipo     |
|-----------------------------|------------------------------|------------------------------------|----------|
| Título banner principal     | `nosotros_titulo_banner`     | `field_nosotros_titulo_banner`     | text     |
| Descripción introductoria   | `nosotros_descripcion`       | `field_nosotros_descripcion`       | textarea |
| Imagen banner horizontal    | `nosotros_imagen_banner`     | `field_nosotros_imagen_banner`     | url      |

### Uso en template

```php
$titulo_banner = get_field( 'nosotros_titulo_banner',  9 );
$descripcion   = get_field( 'nosotros_descripcion',    9 );
$imagen_banner = get_field( 'nosotros_imagen_banner',  9 );  // string URL
```

---

## Grupo: Imagen de categoría

**Key de grupo:** `group_categoria_imagen`
**Aplica a:** Taxonomía `category` (categorías nativas de WordPress)

| Label                  | Field name          | Field key                   | Tipo  | Notas          |
|------------------------|---------------------|-----------------------------|-------|----------------|
| Imagen representativa  | `categoria_imagen`  | `field_categoria_imagen`    | image | return: array  |

### Uso en template

```php
// Desde cualquier template pasando el term_id
$term    = get_queried_object();          // en archive de categoría
$imagen  = get_field( 'categoria_imagen', 'category_' . $term->term_id );
// $imagen es un array: url, width, height, alt

// O con term_id explícito
$imagen = get_field( 'categoria_imagen', 'category_3' ); // Consumibles
$imagen = get_field( 'categoria_imagen', 'category_4' ); // Reproducción Animal
$imagen = get_field( 'categoria_imagen', 'category_5' ); // Medicamentos
```

> **Nota:** Para campos en términos de taxonomía, ACF requiere el prefijo `category_` seguido del `term_id` como segundo argumento de `get_field()`.

---

## Grupo: Datos de contacto

**Key de grupo:** `group_contacto`
**Aplica a:** Página con post ID `11`

| Label                              | Field name              | Field key                    | Tipo  | Valor actual                          |
|------------------------------------|-------------------------|------------------------------|-------|---------------------------------------|
| Correo electrónico del formulario  | `contacto_email`        | `field_contacto_email`       | email | rbuitragoh@redimagsas.com             |
| Número de WhatsApp                 | `contacto_whatsapp`     | `field_contacto_whatsapp`    | text  | 573188057688 (sin + ni espacios)      |
| Líneas telefónicas                 | `contacto_telefono`     | `field_contacto_telefono`    | text  | 3188057688                            |
| Instagram                          | `contacto_instagram`    | `field_contacto_instagram`   | url   | https://www.instagram.com/redimagsas… |
| Facebook                           | `contacto_facebook`     | `field_contacto_facebook`    | url   | https://www.facebook.com/share/…      |

### Uso en template

```php
$email     = get_field( 'contacto_email',     11 );
$whatsapp  = get_field( 'contacto_whatsapp',  11 );  // usar en: https://wa.me/{$whatsapp}
$telefono  = get_field( 'contacto_telefono',  11 );
$instagram = get_field( 'contacto_instagram', 11 );
$facebook  = get_field( 'contacto_facebook',  11 );

// Construir enlace WhatsApp
$wa_url = 'https://wa.me/' . $whatsapp . '?text=' . urlencode( 'Hola, quiero recibir asesoría REDIMAG.' );
```

---

## CPTs sin campos ACF adicionales

| CPT             | Campos disponibles (nativos WordPress)              |
|-----------------|-----------------------------------------------------|
| `especie`       | `post_title`, `post_content`, `post_excerpt`, imagen destacada (`get_the_post_thumbnail_url()`) |
| `diferenciador` | `post_title`, `post_content`, `post_excerpt`, imagen destacada (`get_the_post_thumbnail_url()`) |

---

## Notas generales

- Siempre escapar salidas: `esc_html()` para texto, `esc_url()` para URLs, `esc_attr()` para atributos.
- Los campos de imagen retornan `array` — acceder con `$img['url']`, `$img['alt']`, `$img['width']`, `$img['height']`.
- El campo `producto_keywords` es un string plano; usar `array_map( 'trim', explode( ',', $keywords ) )` para obtener un array limpio.
- Los campos de páginas (Inicio, Nosotros) pueden llamarse sin ID dentro del loop de su propia página template.
