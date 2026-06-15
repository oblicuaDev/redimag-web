<?php
/**
 * Template Name: Nosotros
 */
get_header(); ?>

  <?php
  $titulo    = get_field( 'nosotros_titulo_banner', 9 );
  $desc      = get_field( 'nosotros_descripcion',   9 );
  $imagen    = get_field( 'nosotros_imagen_banner', 9 );
  $img_url   = is_array( $imagen ) ? $imagen['url'] : '';
  $img_alt   = is_array( $imagen ) ? $imagen['alt'] : 'REDIMAG Nosotros';
  $img_src   = $img_url ?: get_template_directory_uri() . '/images/CowGrass wide.png';
  $wa_num    = get_field( 'contacto_whatsapp', 11 );
  $wa_url    = $wa_num ? 'https://wa.me/' . esc_attr( $wa_num ) . '?text=' . rawurlencode( 'Hola, quiero recibir asesoría REDIMAG.' ) : '#';
  ?>

  <section class="home-hero nosotros-hero">
    <div class="hero-slide is-active">
      <img class="home-hero-bg" src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" />
      <div class="container hero-grid">
        <div class="hero-copy">
          <?php if ( $titulo ) : ?>
            <h1><?php echo esc_html( $titulo ); ?></h1>
          <?php endif; ?>
          <?php if ( $desc ) : ?>
            <p><?php echo esc_html( $desc ); ?></p>
          <?php endif; ?>
          <div class="button-row">
            <a class="btn btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'producto' ) ); ?>">Explorar catálogo</a>
            <a class="btn btn-whatsapp" href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener">Hablar con un asesor</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $diferenciadores = get_posts( [
      'post_type'      => 'diferenciador',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
  ] );
  ?>
  <?php if ( $diferenciadores ) : ?>
  <section class="section">
    <div class="container impact-grid">
      <?php foreach ( $diferenciadores as $i => $dif ) : ?>
      <article>
        <span><?php echo str_pad( $i + 1, 2, '0', STR_PAD_LEFT ); ?></span>
        <h2><?php echo esc_html( $dif->post_title ); ?></h2>
        <p><?php echo esc_html( $dif->post_content ); ?></p>
      </article>
      <?php endforeach; ?>
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
      $lineas       = get_terms( [
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

<?php get_footer(); ?>
