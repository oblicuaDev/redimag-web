<?php
get_header();
the_post();

$sku      = get_field( 'producto_sku' );
$keywords = get_field( 'producto_keywords' );
$especies = get_field( 'producto_especies' );  // array de WP_Post
$precio   = get_field( 'producto_precio' );

$whatsapp = get_field( 'contacto_whatsapp', 11 );
$wa_msg   = 'Hola, quiero consultar sobre el producto: ' . get_the_title() . ' (SKU: ' . $sku . ').';
$wa_url   = 'https://wa.me/' . esc_attr( $whatsapp ) . '?text=' . rawurlencode( $wa_msg );

$categorias = get_the_terms( get_the_ID(), 'category' );
$cat_nombre = ( $categorias && ! is_wp_error( $categorias ) ) ? $categorias[0]->name : 'Catálogo REDIMAG';

$badge_map = [
    'Consumibles'         => 'badge-yellow',
    'Reproducción Animal' => 'badge-blue',
    'Medicamentos'        => 'badge-red',
];
$badge_class = $badge_map[ $cat_nombre ] ?? 'badge-green';

$especies_nombres = [];
if ( $especies ) {
    foreach ( $especies as $esp ) {
        $especies_nombres[] = esc_html( $esp->post_title );
    }
}
?>

  <section class="section product-detail-section">
    <div class="container">
      <a class="back-link" href="<?php echo esc_url( get_post_type_archive_link( 'producto' ) ); ?>">← Volver al catálogo</a>

      <article class="product-detail">
        <div class="product-detail-media">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'large', [ 'class' => 'product-detail-image' ] ); ?>
          <?php else : ?>
            <img class="product-detail-image"
                 src="<?php echo esc_url( get_template_directory_uri() . '/images/product.png' ); ?>"
                 alt="<?php the_title_attribute(); ?>" />
          <?php endif; ?>
        </div>

        <div class="product-detail-copy">
          <span class="category-badge <?php echo esc_attr( $badge_class ); ?>">
            <?php echo esc_html( $cat_nombre ); ?>
          </span>

          <h1><?php the_title(); ?></h1>

          <?php if ( get_the_excerpt() ) : ?>
            <p><?php the_excerpt(); ?></p>
          <?php endif; ?>

          <?php if ( $precio ) : ?>
          <div class="product-price">
            <span class="product-price__label">Precio de venta al público</span>
            <strong class="product-price__value">$<?php echo number_format( (int) $precio, 0, ',', '.' ); ?></strong>
          </div>
          <?php endif; ?>

          <div class="detail-info-grid">
            <?php if ( $sku ) : ?>
            <div>
              <strong>SKU</strong>
              <span><?php echo esc_html( $sku ); ?></span>
            </div>
            <?php endif; ?>

            <div>
              <strong>Línea</strong>
              <span><?php echo esc_html( $cat_nombre ); ?></span>
            </div>

            <?php if ( $especies_nombres ) : ?>
            <div>
              <strong>Especie</strong>
              <span><?php echo implode( ', ', $especies_nombres ); ?></span>
            </div>
            <?php endif; ?>

          </div>

          <a class="btn btn-whatsapp" href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener">
            Consultar este producto por WhatsApp
          </a>

          <div class="detail-advice">
            <h2>Asesoría antes de elegir</h2>
            <p>
              Esta ficha funciona como referencia de catálogo. Para disponibilidad, presentación
              y recomendación de uso, consulta con un asesor REDIMAG por WhatsApp.
            </p>
          </div>
        </div>
      </article>
    </div>
  </section>

  <?php
  $cat_id           = ( $categorias && ! is_wp_error( $categorias ) ) ? $categorias[0]->term_id : 0;
  $relacionados     = $cat_id ? new WP_Query( [
      'post_type'           => 'producto',
      'posts_per_page'      => 4,
      'post__not_in'        => [ get_the_ID() ],
      'category__in'        => [ $cat_id ],
      'ignore_sticky_posts' => true,
      'orderby'             => 'rand',
  ] ) : null;
  ?>

  <?php if ( $relacionados && $relacionados->have_posts() ) : ?>
  <section class="section related-products">
    <div class="container">
      <div class="section-heading">
        <span class="eyebrow">Catálogo</span>
        <h2>Otros productos que te pueden interesar</h2>
      </div>
      <div class="lines-grid related-grid">
        <?php while ( $relacionados->have_posts() ) : $relacionados->the_post();
          $r_cats    = get_the_terms( get_the_ID(), 'category' );
          $r_cat     = ( $r_cats && ! is_wp_error( $r_cats ) ) ? $r_cats[0]->name : '';
          $r_badge   = $badge_map[ $r_cat ] ?? 'badge-green';
        ?>
        <a class="product-card" href="<?php the_permalink(); ?>">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium', [ 'class' => 'product-image' ] ); ?>
          <?php else : ?>
            <img class="product-image"
                 src="<?php echo esc_url( get_template_directory_uri() . '/images/product.png' ); ?>"
                 alt="<?php the_title_attribute(); ?>" />
          <?php endif; ?>
          <?php if ( $r_cat ) : ?>
            <span class="category-badge <?php echo esc_attr( $r_badge ); ?>">
              <?php echo esc_html( $r_cat ); ?>
            </span>
          <?php endif; ?>
          <h3><?php the_title(); ?></h3>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

<?php get_footer(); ?>
