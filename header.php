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
  <link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() . '/images/favicon.png' ); ?>" />
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
        $telefono  = get_field( 'contacto_telefono', 11 );
        $whatsapp  = get_field( 'contacto_whatsapp', 11 );
        $instagram = get_field( 'contacto_instagram', 11 );
        $facebook  = get_field( 'contacto_facebook', 11 );
        $wa_url    = 'https://wa.me/' . esc_attr( $whatsapp ) . '?text=' . rawurlencode( 'Hola, quiero recibir asesoría REDIMAG.' );
      ?>
      <?php if ( $telefono ) : ?>
        <span>Llámanos: <strong><?php echo esc_html( $telefono ); ?></strong></span>
      <?php endif; ?>
      <?php if ( $whatsapp ) : ?>
        <a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener">
          Escríbenos por WhatsApp
        </a>
      <?php endif; ?>
      <?php if ( $instagram ) : ?>
        <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener" aria-label="Instagram de REDIMAG">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.265.07 1.645.07 4.851s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.265.058-1.645.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.013 8.332 0 8.741 0 12c0 3.259.013 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038.059-1.28.072-1.689.072-4.948s-.013-3.668-.072-4.948c-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
        </a>
      <?php endif; ?>
      <?php if ( $facebook ) : ?>
        <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener" aria-label="Facebook de REDIMAG">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.235 2.686.235v2.97h-1.514c-1.491 0-1.956.93-1.956 1.886v2.269h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
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
