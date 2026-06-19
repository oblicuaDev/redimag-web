<?php get_header(); ?>

  <?php
  $banners      = get_posts( [
      'post_type'      => 'banner',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'rand',
  ] );
  $fallback_img = get_template_directory_uri() . '/images/CowGrass wide.png';
  $catalogo_url = get_post_type_archive_link( 'producto' );
  ?>

  <section class="home-hero" id="hero-slider">

    <?php if ( $banners ) : ?>

      <?php foreach ( $banners as $i => $banner ) :
        $copy    = get_field( 'banner_copy',         $banner->ID );
        $desc    = get_field( 'banner_descripcion',  $banner->ID );
        $imagen  = get_field( 'banner_imagen',       $banner->ID );
        $cta_txt = get_field( 'banner_cta_texto',    $banner->ID );
        $cta_url = get_field( 'banner_cta_enlace',   $banner->ID );
        $img_url = $imagen['url'] ?? $fallback_img;
        $img_alt = $imagen['alt'] ?? 'Banner REDIMAG';
      ?>
      <div class="hero-slide<?php echo $i === 0 ? ' is-active' : ''; ?>"
           aria-hidden="<?php echo $i === 0 ? 'false' : 'true'; ?>">
        <img class="home-hero-bg" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" />
        <div class="container hero-grid">
          <div class="hero-copy">
            <?php if ( $copy ) : ?>
              <h1><?php echo esc_html( $copy ); ?></h1>
            <?php endif; ?>
            <?php if ( $desc ) : ?>
              <p><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
            <?php if ( $cta_txt && $cta_url ) : ?>
              <div class="button-row">
                <a class="btn btn-primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_txt ); ?></a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <?php if ( count( $banners ) > 1 ) : ?>
      <div class="slider-bullets" role="tablist" aria-label="Navegación del banner">
        <?php foreach ( $banners as $i => $banner ) : ?>
          <button class="slider-bullet<?php echo $i === 0 ? ' is-active' : ''; ?>"
                  data-slide="<?php echo $i; ?>"
                  role="tab"
                  aria-label="Slide <?php echo $i + 1; ?>"
                  aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"></button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

    <?php else : ?>

      <div class="hero-slide is-active" aria-hidden="false">
        <img class="home-hero-bg" src="<?php echo esc_url( $fallback_img ); ?>" alt="Bovinos en campo productivo" />
        <div class="container hero-grid">
          <div class="hero-copy">
            <h1>Insumos veterinarios para animales domésticos y de producción</h1>
            <p>Soluciones en salud, reproducción, nutrición y equipamiento animal con asesoría directa por WhatsApp.</p>
            <div class="button-row">
              <a class="btn btn-primary" href="<?php echo esc_url( $catalogo_url ); ?>">Ver catálogo</a>
            </div>
          </div>
        </div>
      </div>

    <?php endif; ?>

  </section>

  <section class="section home-about">
    <div class="container split-intro">
      <div>
        <span class="eyebrow">Quiénes somos</span>
        <h2><?php echo esc_html( get_field( 'inicio_titulo_redimag', 6 ) ?: 'REDIMAG conecta productos veterinarios confiables con asesoría clara.' ); ?></h2>
      </div>
      <p><?php echo esc_html( get_field( 'inicio_desc_redimag', 6 ) ?: 'Acompañamos a veterinarios, productores y responsables de animales domésticos y de producción con un catálogo organizado por líneas técnicas y una ruta de contacto directa por WhatsApp.' ); ?></p>
    </div>
  </section>

  <?php
  $badge_map = [
      'consumibles'        => 'badge-yellow',
      'medicamentos'       => 'badge-red',
      'reproduccion-animal'=> 'badge-blue',
  ];

  $destacados = get_posts( [
      'post_type'      => 'producto',
      'posts_per_page' => 4,
      'orderby'        => 'rand',
      'post_status'    => 'publish',
      'meta_query'     => [ [
          'key'   => 'producto_destacado',
          'value' => '1',
      ] ],
  ] );
  ?>

  <?php if ( $destacados ) : ?>
  <section class="section home-featured">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Selección REDIMAG</span>
        <h2>Productos del día</h2>
      </div>
      <div class="catalog-grid">
        <?php foreach ( $destacados as $producto ) :
          $cats     = get_the_terms( $producto->ID, 'category' );
          $cat_obj  = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0] : null;
          $cat_slug = $cat_obj ? $cat_obj->slug : '';
          $cat_name = $cat_obj ? $cat_obj->name : '';
          $badge    = $badge_map[ $cat_slug ] ?? 'badge-green';
        ?>
        <a class="product-card" href="<?php echo esc_url( get_permalink( $producto->ID ) ); ?>">
          <?php if ( has_post_thumbnail( $producto->ID ) ) : ?>
            <?php echo get_the_post_thumbnail( $producto->ID, 'medium', [ 'class' => 'product-image' ] ); ?>
          <?php else : ?>
            <img class="product-image"
                 src="<?php echo esc_url( get_template_directory_uri() . '/images/product.png' ); ?>"
                 alt="<?php echo esc_attr( $producto->post_title ); ?>" />
          <?php endif; ?>
          <?php if ( $cat_name ) : ?>
            <span class="category-badge <?php echo esc_attr( $badge ); ?>"><?php echo esc_html( $cat_name ); ?></span>
          <?php endif; ?>
          <h3><?php echo esc_html( $producto->post_title ); ?></h3>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="section compact-lines">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Líneas de producto</span>
        <h2>Elige la línea que quieres explorar</h2>
      </div>
      <?php
      $color_map = [
          'consumibles'        => 'line-yellow',
          'medicamentos'       => 'line-red',
          'reproduccion-animal'=> 'line-blue',
      ];
      $lineas = get_terms( [
          'taxonomy'   => 'category',
          'hide_empty' => false,
          'exclude'    => [ 1 ],
          'orderby'    => 'name',
      ] );
      $catalogo_url = get_post_type_archive_link( 'producto' );
      ?>
      <div class="lines-grid lines-grid--3 image-lines">
        <?php foreach ( $lineas as $linea ) :
          $color     = $color_map[ $linea->slug ] ?? 'line-green';
          $img_field = get_field( 'categoria_imagen', 'category_' . $linea->term_id );
          $img_url   = $img_field['url'] ?? '';
          $img_alt   = $img_field['alt'] ?? esc_attr( $linea->name );
        ?>
        <a class="line-card <?php echo esc_attr( $color ); ?>"
           href="<?php echo esc_url( $catalogo_url . '?linea=' . $linea->slug ); ?>">
          <?php if ( $img_url ) : ?>
            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" />
          <?php else : ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/images/product.png' ); ?>" alt="<?php echo esc_attr( $linea->name ); ?>" />
          <?php endif; ?>
          <h3><?php echo esc_html( $linea->name ); ?></h3>
          <p><?php echo esc_html( $linea->description ?: 'Explora los productos de esta línea.' ); ?></p>
          <span class="line-link">VER PRODUCTOS</span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php
  $aliados = get_posts( [
      'post_type'      => 'aliado',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
  ] );
  ?>
  <?php if ( $aliados ) : ?>
  <section class="section home-partners">
    <div class="container">
      <div class="section-heading" style="text-align:center; margin-inline: auto;">
        <span class="eyebrow">Marcas que distribuimos</span>
        <h2>Aliados comerciales</h2>
      </div>
      <div class="partners-grid">
        <?php foreach ( $aliados as $aliado ) : ?>
          <?php if ( has_post_thumbnail( $aliado->ID ) ) : ?>
          <div class="partner-logo">
            <?php echo get_the_post_thumbnail( $aliado->ID, 'medium', [
                'alt'     => esc_attr( $aliado->post_title ),
                'loading' => 'lazy',
            ] ); ?>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="page-hero catalog-home-band">
    <div class="container page-hero-grid">
      <div>
        <h2><?php echo esc_html( get_field( 'inicio_titulo_catalogo', 6 ) ?: 'Explora todo el catálogo REDIMAG por línea y necesidad' ); ?></h2>
        <p><?php echo esc_html( get_field( 'inicio_desc_catalogo', 6 ) ?: 'Navega productos por línea y especie, revisa la ficha interna y consulta por WhatsApp solo cuando tengas claro el producto que necesitas.' ); ?></p>
        <a class="btn btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'producto' ) ); ?>">EXPLORA NUESTRO CATÁLOGO</a>
      </div>
      <?php
      $img_catalogo = get_field( 'inicio_imagen_catalogo', 6 );
      $img_src      = $img_catalogo['url']  ?? get_template_directory_uri() . '/images/cow.png';
      $img_alt      = $img_catalogo['alt']  ?? 'Catálogo REDIMAG';
      ?>
      <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" />
    </div>
  </section>

<?php get_footer(); ?>
