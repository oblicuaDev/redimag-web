<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-TZTT3Z2M');</script>
  <!-- End Google Tag Manager -->
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZTT3Z2M"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>

<header class="site-header">
  <div class="topbar">
    <div class="container topbar-inner">
      <?php
        $telefono = get_field( 'contacto_telefono', 11 );
        $whatsapp = get_field( 'contacto_whatsapp', 11 );
        $wa_url   = 'https://wa.me/' . esc_attr( $whatsapp ) . '?text=' . rawurlencode( 'Hola, quiero recibir asesoría REDIMAG.' );
      ?>
      <?php if ( $telefono ) : ?>
        <span>Llámanos: <strong><?php echo esc_html( $telefono ); ?></strong></span>
      <?php endif; ?>
      <?php if ( $whatsapp ) : ?>
        <a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener">
          Escríbenos por WhatsApp
        </a>
      <?php endif; ?>
    </div>
  </div>
  <div class="container header-inner">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Ir al inicio de REDIMAG">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo.png' ); ?>" alt="REDIMAG" />
    </a>
    <div class="header-search-wrap">
      <form class="header-search" role="search" action="<?php echo esc_url( get_post_type_archive_link( 'producto' ) ); ?>">
        <label class="sr-only" for="site-search">Buscar en el catálogo</label>
        <input class="header-search-input" id="site-search" name="buscar" type="search" placeholder="Buscar producto o línea" autocomplete="off" />
        <button type="submit" aria-label="Buscar en el catálogo"><span aria-hidden="true">⌕</span></button>
      </form>
      <div class="search-autocomplete" id="search-autocomplete" hidden></div>
    </div>
    <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <?php
    wp_nav_menu( [
        'theme_location'  => 'menu-principal',
        'container'       => 'nav',
        'container_class' => 'main-nav',
        'container_id'    => 'main-nav',
        'container_aria_label' => 'Navegación principal',
        'items_wrap'      => '%3$s',
        'menu_class'      => '',
        'depth'           => 2,
        'fallback_cb'     => false,
        'walker'          => new Redimag_Nav_Walker(),
    ] );
    ?>
  </div>
</header>

<main>
