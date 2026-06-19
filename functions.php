<?php

require_once get_template_directory() . '/inc/class-nav-walker.php';

// ─── Assets ───────────────────────────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'redimag-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'redimag-styles',
        get_template_directory_uri() . '/css/styles.css',
        [ 'redimag-fonts' ],
        wp_get_theme()->get( 'Version' )
    );
    wp_enqueue_script(
        'redimag-credits',
        'https://lab.oblicua.co/credits/credits.js',
        [],
        null,
        true
    );
    wp_enqueue_script(
        'redimag-main',
        get_template_directory_uri() . '/js/main.js',
        [ 'redimag-credits' ],
        wp_get_theme()->get( 'Version' ),
        true
    );
    wp_localize_script( 'redimag-main', 'REDIMAG', [
        'restUrl'     => esc_url_raw( rest_url( 'wp/v2/producto' ) ),
        'leadUrl'     => esc_url_raw( rest_url( 'redimag/v1/lead' ) ),
        'nonce'       => wp_create_nonce( 'wp_rest' ),
        'placeholder' => esc_url( get_template_directory_uri() . '/images/product.png' ),
    ] );
} );

// ─── Theme supports ───────────────────────────────────────────────────────────

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( [
        'menu-principal' => 'Menú principal (header)',
        'menu-footer'    => 'Menú footer',
    ] );
} );

// ─── Custom Post Types ────────────────────────────────────────────────────────

add_action( 'init', function () {

    register_post_type( 'banner', [
        'labels'      => [
            'name'          => 'Banners principales',
            'singular_name' => 'Banner',
            'add_new_item'  => 'Añadir banner',
            'edit_item'     => 'Editar banner',
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-image-rotate',
        'supports'     => [ 'title', 'thumbnail' ],
    ] );

    register_post_type( 'especie', [
        'labels'      => [
            'name'          => 'Especies',
            'singular_name' => 'Especie',
            'add_new_item'  => 'Añadir especie',
            'edit_item'     => 'Editar especie',
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-leaf',
        'supports'     => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
    ] );

    register_post_type( 'producto', [
        'labels'      => [
            'name'          => 'Productos',
            'singular_name' => 'Producto',
            'add_new_item'  => 'Añadir producto',
            'edit_item'     => 'Editar producto',
        ],
        'public'       => true,
        'has_archive'  => 'catalogo',
        'rewrite'      => [ 'slug' => 'catalogo' ],
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-cart',
        'supports'     => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
        'taxonomies'   => [ 'category' ],
    ] );

    register_post_type( 'lead', [
        'labels'      => [
            'name'          => 'Leads',
            'singular_name' => 'Lead',
            'add_new_item'  => 'Añadir lead',
            'edit_item'     => 'Ver lead',
            'all_items'     => 'Todos los leads',
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'menu_icon'           => 'dashicons-email-alt',
        'supports'            => [ 'title' ],
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
    ] );

    register_post_type( 'diferenciador', [
        'labels'      => [
            'name'          => 'Diferenciadores',
            'singular_name' => 'Diferenciador',
            'add_new_item'  => 'Añadir diferenciador',
            'edit_item'     => 'Editar diferenciador',
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
    ] );

    register_post_type( 'aliado', [
        'labels'      => [
            'name'          => 'Aliados comerciales',
            'singular_name' => 'Aliado',
            'add_new_item'  => 'Añadir aliado',
            'edit_item'     => 'Editar aliado',
            'all_items'     => 'Todos los aliados',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-building',
        'supports'     => [ 'title', 'thumbnail' ],
    ] );

} );

// ─── ACF Field Groups ─────────────────────────────────────────────────────────

add_action( 'acf/init', function () {

    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // 1. Banners principales
    acf_add_local_field_group( [
        'key'      => 'group_banners',
        'title'    => 'Banners principales',
        'location' => [ [ [
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'banner',
        ] ] ],
        'fields'   => [
            [
                'key'        => 'field_banner_copy',
                'label'      => 'Copy',
                'name'       => 'banner_copy',
                'type'       => 'text',
                'required'   => 1,
                'maxlength'  => 160,
            ],
            [
                'key'          => 'field_banner_imagen',
                'label'        => 'Imagen',
                'name'         => 'banner_imagen',
                'type'         => 'image',
                'required'     => 1,
                'return_format'=> 'array',
                'preview_size' => 'medium',
                'mime_types'   => 'jpg,jpeg,png,webp',
                'instructions' => 'Máximo 300 KB.',
            ],
            [
                'key'        => 'field_banner_descripcion',
                'label'      => 'Descripción corta',
                'name'       => 'banner_descripcion',
                'type'       => 'textarea',
                'required'   => 0,
                'rows'       => 3,
                'maxlength'  => 280,
                'instructions' => 'Texto breve que aparece bajo el título en el hero del inicio.',
            ],
            [
                'key'       => 'field_banner_cta_texto',
                'label'     => 'Texto del CTA',
                'name'      => 'banner_cta_texto',
                'type'      => 'text',
                'required'  => 1,
                'maxlength' => 60,
            ],
            [
                'key'      => 'field_banner_cta_enlace',
                'label'    => 'Enlace del CTA',
                'name'     => 'banner_cta_enlace',
                'type'     => 'url',
                'required' => 1,
            ],
        ],
    ] );

    // 2. Productos
    acf_add_local_field_group( [
        'key'      => 'group_productos',
        'title'    => 'Datos del producto',
        'location' => [ [ [
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'producto',
        ] ] ],
        'fields'   => [
            [
                'key'       => 'field_producto_sku',
                'label'     => 'SKU',
                'name'      => 'producto_sku',
                'type'      => 'text',
                'required'  => 1,
            ],
            [
                'key'          => 'field_producto_keywords',
                'label'        => 'Palabras clave',
                'name'         => 'producto_keywords',
                'type'         => 'text',
                'instructions' => 'Separadas por coma.',
            ],
            [
                'key'           => 'field_producto_especies',
                'label'         => 'Especies relacionadas',
                'name'          => 'producto_especies',
                'type'          => 'relationship',
                'post_type'     => [ 'especie' ],
                'filters'       => [ 'search' ],
                'return_format' => 'object',
                'multiple'      => 1,
            ],
            [
                'key'           => 'field_producto_destacado',
                'label'         => 'Destacado en el home',
                'name'          => 'producto_destacado',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui'            => 1,
                'ui_on_text'    => 'Sí',
                'ui_off_text'   => 'No',
                'instructions'  => 'Activa para incluir este producto en la franja "Productos del día" del inicio.',
            ],
            [
                'key'      => 'field_producto_precio',
                'label'    => 'Precio de venta al público',
                'name'     => 'producto_precio',
                'type'     => 'number',
                'required' => 0,
                'min'      => 0,
                'step'     => 1,
            ],
            [
                'key'           => 'field_producto_imagen_1',
                'label'         => 'Imagen 1',
                'name'          => 'producto_imagen_1',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
            [
                'key'           => 'field_producto_imagen_2',
                'label'         => 'Imagen 2',
                'name'          => 'producto_imagen_2',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
            [
                'key'           => 'field_producto_imagen_3',
                'label'         => 'Imagen 3',
                'name'          => 'producto_imagen_3',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
            [
                'key'           => 'field_producto_imagen_4',
                'label'         => 'Imagen 4',
                'name'          => 'producto_imagen_4',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
        ],
    ] );

    // 3. Página Inicio (post ID 6)
    acf_add_local_field_group( [
        'key'      => 'group_inicio',
        'title'    => 'Contenido — Inicio',
        'location' => [ [ [
            'param'    => 'post',
            'operator' => '==',
            'value'    => '6',
        ] ] ],
        'fields'   => [
            [
                'key'   => 'field_inicio_titulo_redimag',
                'label' => 'Título presentando a Redimag',
                'name'  => 'inicio_titulo_redimag',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_inicio_desc_redimag',
                'label' => 'Descripción corta de Redimag',
                'name'  => 'inicio_desc_redimag',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'   => 'field_inicio_titulo_catalogo',
                'label' => 'Título del catálogo de productos',
                'name'  => 'inicio_titulo_catalogo',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_inicio_desc_catalogo',
                'label' => 'Descripción corta del catálogo',
                'name'  => 'inicio_desc_catalogo',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'           => 'field_inicio_imagen_catalogo',
                'label'         => 'Imagen del catálogo',
                'name'          => 'inicio_imagen_catalogo',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
        ],
    ] );

    // 4. Página Nosotros (post ID 9)
    acf_add_local_field_group( [
        'key'      => 'group_nosotros',
        'title'    => 'Contenido — Nosotros',
        'location' => [ [ [
            'param'    => 'post',
            'operator' => '==',
            'value'    => '9',
        ] ] ],
        'fields'   => [
            [
                'key'   => 'field_nosotros_titulo_banner',
                'label' => 'Título banner principal',
                'name'  => 'nosotros_titulo_banner',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_nosotros_descripcion',
                'label' => 'Descripción introductoria',
                'name'  => 'nosotros_descripcion',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'           => 'field_nosotros_imagen_banner',
                'label'         => 'Imagen banner horizontal',
                'name'          => 'nosotros_imagen_banner',
                'type'          => 'image',
                'required'      => 0,
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg,jpeg,png,webp',
                'instructions'  => 'Imagen apaisada para el banner de la página Nosotros. Recomendado: 1440×480 px.',
            ],
        ],
    ] );

    // 5. Categorías de entrada — imagen representativa
    acf_add_local_field_group( [
        'key'      => 'group_categoria_imagen',
        'title'    => 'Imagen de categoría',
        'location' => [ [ [
            'param'    => 'taxonomy',
            'operator' => '==',
            'value'    => 'category',
        ] ] ],
        'fields'   => [
            [
                'key'           => 'field_categoria_imagen',
                'label'         => 'Imagen representativa',
                'name'          => 'categoria_imagen',
                'type'          => 'image',
                'required'      => 0,
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg,jpeg,png,webp',
            ],
            [
                'key'           => 'field_categoria_banner',
                'label'         => 'Banner horizontal',
                'name'          => 'categoria_banner',
                'type'          => 'image',
                'required'      => 0,
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'mime_types'    => 'jpg,jpeg,png,webp',
                'instructions'  => 'Imagen apaisada para el encabezado de la página de línea. Recomendado: 1440×400 px.',
            ],
        ],
    ] );

    // 7. Leads
    acf_add_local_field_group( [
        'key'      => 'group_leads',
        'title'    => 'Datos del lead',
        'location' => [ [ [
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'lead',
        ] ] ],
        'fields'   => [
            [
                'key'      => 'field_lead_telefono',
                'label'    => 'Teléfono',
                'name'     => 'lead_telefono',
                'type'     => 'text',
                'required' => 1,
            ],
            [
                'key'   => 'field_lead_tipo',
                'label' => 'Tipo de consulta',
                'name'  => 'lead_tipo',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_lead_mensaje',
                'label'=> 'Mensaje',
                'name' => 'lead_mensaje',
                'type' => 'textarea',
                'rows' => 4,
            ],
        ],
    ] );

    // 6. Página Contacto (post ID 11)
    acf_add_local_field_group( [
        'key'      => 'group_contacto',
        'title'    => 'Datos de contacto',
        'location' => [ [ [
            'param'    => 'post',
            'operator' => '==',
            'value'    => '11',
        ] ] ],
        'fields'   => [
            [
                'key'          => 'field_contacto_descripcion',
                'label'        => 'Descripción de formulario',
                'name'         => 'contacto_descripcion',
                'type'         => 'wysiwyg',
                'tabs'         => 'all',
                'toolbar'      => 'basic',
                'media_upload' => 0,
            ],
            [
                'key'   => 'field_contacto_email',
                'label' => 'Correo electrónico del formulario',
                'name'  => 'contacto_email',
                'type'  => 'email',
            ],
            [
                'key'          => 'field_contacto_whatsapp',
                'label'        => 'Número de WhatsApp',
                'name'         => 'contacto_whatsapp',
                'type'         => 'text',
                'instructions' => 'Formato internacional sin + ni espacios. Ej: 573188057688',
            ],
            [
                'key'   => 'field_contacto_telefono',
                'label' => 'Líneas telefónicas',
                'name'  => 'contacto_telefono',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_contacto_instagram',
                'label' => 'Instagram',
                'name'  => 'contacto_instagram',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_contacto_facebook',
                'label' => 'Facebook',
                'name'  => 'contacto_facebook',
                'type'  => 'url',
            ],
        ],
    ] );

    // 8. SEO — páginas y productos
    acf_add_local_field_group( [
        'key'        => 'group_seo',
        'title'      => 'SEO',
        'menu_order' => 100,
        'location'   => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ] ],
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'producto' ] ],
        ],
        'fields' => [
            [
                'key'          => 'field_seo_titulo',
                'label'        => 'Título SEO',
                'name'         => 'seo_titulo',
                'type'         => 'text',
                'maxlength'    => 60,
                'instructions' => 'Máximo 60 caracteres. Si se deja vacío se usa el título de la página.',
            ],
            [
                'key'          => 'field_seo_descripcion',
                'label'        => 'Meta descripción',
                'name'         => 'seo_descripcion',
                'type'         => 'textarea',
                'rows'         => 3,
                'maxlength'    => 160,
                'instructions' => 'Máximo 160 caracteres. Aparece en resultados de Google.',
            ],
            [
                'key'           => 'field_seo_imagen_og',
                'label'         => 'Imagen Open Graph',
                'name'          => 'seo_imagen_og',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'instructions'  => 'Para redes sociales (Facebook, WhatsApp, LinkedIn). Recomendado: 1200×630 px. Si se deja vacío se usa la imagen destacada.',
            ],
        ],
    ] );

} );

// ─── SEO: metatags, Open Graph y Twitter Card ─────────────────────────────────

remove_action( 'wp_head', 'rel_canonical' );

add_filter( 'pre_get_document_title', function ( $title ) {
    if ( is_front_page() ) {
        $seo = get_field( 'seo_titulo', 6 );
        return $seo ?: $title;
    }
    if ( is_post_type_archive( 'producto' ) ) {
        return 'Catálogo de productos — ' . get_bloginfo( 'name' );
    }
    if ( is_singular( 'producto' ) || is_page() ) {
        $seo = get_field( 'seo_titulo', get_the_ID() );
        return $seo ?: $title;
    }
    return $title;
} );

add_action( 'wp_head', function () {
    $site_name     = get_bloginfo( 'name' );
    $default_image = get_template_directory_uri() . '/images/logo.png';

    $title       = '';
    $description = '';
    $image_url   = '';
    $canonical   = '';
    $og_type     = 'website';

    if ( is_front_page() ) {
        $pid         = 6;
        $title       = get_field( 'seo_titulo', $pid )
                       ?: $site_name . ' — Insumos médicos y agropecuarios';
        $description = get_field( 'seo_descripcion', $pid )
                       ?: get_field( 'inicio_desc_redimag', $pid );
        $og_img      = get_field( 'seo_imagen_og', $pid );
        $image_url   = $og_img ? $og_img['url'] : ( get_the_post_thumbnail_url( $pid, 'large' ) ?: '' );
        $canonical   = home_url( '/' );

    } elseif ( is_singular( 'producto' ) ) {
        $pid         = get_the_ID();
        $title       = get_field( 'seo_titulo', $pid )
                       ?: ( get_the_title( $pid ) . ' — ' . $site_name );
        $description = get_field( 'seo_descripcion', $pid )
                       ?: wp_strip_all_tags( get_the_excerpt() );
        $og_img      = get_field( 'seo_imagen_og', $pid );
        $image_url   = $og_img ? $og_img['url'] : ( get_the_post_thumbnail_url( $pid, 'large' ) ?: '' );
        $canonical   = get_permalink( $pid );
        $og_type     = 'article';

    } elseif ( is_post_type_archive( 'producto' ) ) {
        $title       = 'Catálogo de productos — ' . $site_name;
        $description = 'Catálogo consultivo de insumos veterinarios y agropecuarios. Medicamentos, consumibles y productos de reproducción animal para campo y clínica.';
        $image_url   = get_the_post_thumbnail_url( 6, 'large' ) ?: '';
        $canonical   = get_post_type_archive_link( 'producto' );

    } elseif ( is_page() ) {
        $pid         = get_the_ID();
        $title       = get_field( 'seo_titulo', $pid )
                       ?: ( get_the_title( $pid ) . ' — ' . $site_name );
        $description = get_field( 'seo_descripcion', $pid )
                       ?: wp_strip_all_tags( get_the_excerpt() );
        $og_img      = get_field( 'seo_imagen_og', $pid );
        $image_url   = $og_img ? $og_img['url'] : ( get_the_post_thumbnail_url( $pid, 'large' ) ?: '' );
        $canonical   = get_permalink( $pid );

    } else {
        $title     = $site_name . ' — ' . get_bloginfo( 'description' );
        $canonical = home_url( '/' );
    }

    if ( ! $description ) {
        $description = 'REDIMAG es la Red Especializada de Insumos Médicos y Agropecuarios. Catálogo consultivo de productos veterinarios disponibles para pedidos.';
    }
    if ( ! $image_url ) {
        $image_url = $default_image;
    }

    $description = wp_strip_all_tags( $description );
    if ( mb_strlen( $description ) > 160 ) {
        $description = mb_substr( $description, 0, 157 ) . '...';
    }
    ?>
<!-- SEO -->
<meta name="description" content="<?php echo esc_attr( $description ); ?>" />
<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>" />
<!-- Open Graph -->
<meta property="og:type"        content="<?php echo esc_attr( $og_type ); ?>" />
<meta property="og:site_name"   content="<?php echo esc_attr( $site_name ); ?>" />
<meta property="og:title"       content="<?php echo esc_attr( $title ); ?>" />
<meta property="og:description" content="<?php echo esc_attr( $description ); ?>" />
<meta property="og:url"         content="<?php echo esc_url( $canonical ); ?>" />
<meta property="og:locale"      content="es_CO" />
<meta property="og:image"       content="<?php echo esc_url( $image_url ); ?>" />
<meta property="og:image:width"  content="1200" />
<meta property="og:image:height" content="630" />
<!-- Twitter Card -->
<meta name="twitter:card"        content="summary_large_image" />
<meta name="twitter:title"       content="<?php echo esc_attr( $title ); ?>" />
<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>" />
<meta name="twitter:image"       content="<?php echo esc_url( $image_url ); ?>" />
<?php
}, 2 );

// ─── Cargar todos los productos en el archivo (paginación client-side) ────────

add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'producto' ) ) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
} );

// ─── REST endpoint: crear lead desde formulario de contacto ───────────────────

add_action( 'rest_api_init', function () {
    register_rest_route( 'redimag/v1', '/lead', [
        'methods'             => 'POST',
        'callback'            => 'redimag_create_lead',
        'permission_callback' => '__return_true',
    ] );
} );

function redimag_create_lead( WP_REST_Request $request ) {
    $nonce = $request->get_header( 'X-WP-Nonce' );
    if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
        return new WP_Error( 'invalid_nonce', 'Nonce inválido.', [ 'status' => 403 ] );
    }

    $nombre   = sanitize_text_field( $request->get_param( 'nombre' ) );
    $telefono = sanitize_text_field( $request->get_param( 'telefono' ) );
    $tipo     = sanitize_text_field( $request->get_param( 'tipo' ) );
    $mensaje  = sanitize_textarea_field( $request->get_param( 'mensaje' ) );

    if ( ! $nombre || ! $telefono || ! $tipo ) {
        return new WP_Error( 'missing_fields', 'Nombre, teléfono y tipo de consulta son requeridos.', [ 'status' => 400 ] );
    }

    $post_id = wp_insert_post( [
        'post_type'   => 'lead',
        'post_title'  => $nombre,
        'post_status' => 'publish',
    ] );

    if ( is_wp_error( $post_id ) ) {
        return new WP_Error( 'insert_failed', 'Error al guardar la consulta.', [ 'status' => 500 ] );
    }

    update_field( 'lead_telefono', $telefono, $post_id );
    update_field( 'lead_tipo',     $tipo,     $post_id );
    update_field( 'lead_mensaje',  $mensaje,  $post_id );

    return rest_ensure_response( [ 'success' => true, 'id' => $post_id ] );
}
