<?php
get_header();

$badge_map = [
    'consumibles'       => 'badge-yellow',
    'medicamentos'      => 'badge-red',
    'reproduccion-animal' => 'badge-blue',
];

$categorias_sidebar = get_terms( [
    'taxonomy'   => 'category',
    'hide_empty' => false,
    'exclude'    => [ 1 ],
    'orderby'    => 'name',
] );

$especies_sidebar = get_posts( [
    'post_type'      => 'especie',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
] );
?>

  <section class="section catalog-page catalog-first-section">
    <div class="container catalog-layout">

      <aside class="catalog-sidebar" aria-label="Filtros del catálogo">
        <div class="filter-panel">
          <h2>Filtrar catálogo</h2>

          <fieldset class="checkbox-group">
            <legend>Línea de producto</legend>
            <?php foreach ( $categorias_sidebar as $cat ) : ?>
              <label>
                <input class="line-filter" type="checkbox" value="<?php echo esc_attr( $cat->slug ); ?>" />
                <?php echo esc_html( $cat->name ); ?>
              </label>
            <?php endforeach; ?>
          </fieldset>

          <fieldset class="checkbox-group">
            <legend>Especie</legend>
            <?php foreach ( $especies_sidebar as $esp ) : ?>
              <label>
                <input class="species-filter" type="checkbox" value="<?php echo esc_attr( strtolower( $esp->post_title ) ); ?>" />
                <?php echo esc_html( $esp->post_title ); ?>
              </label>
            <?php endforeach; ?>
          </fieldset>

          <button class="btn btn-secondary reset-filters" type="button">Limpiar filtros</button>
        </div>
      </aside>

      <div class="catalog-content">
        <div class="catalog-toolbar">
          <div>
            <span class="eyebrow">Catálogo</span>
            <h2>Productos disponibles para pedidos</h2>
          </div>
          <p><strong id="result-count">0</strong> de <strong id="total-count">0</strong> productos</p>
        </div>

        <div class="catalog-grid">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            $cats      = get_the_terms( get_the_ID(), 'category' );
            $cat_obj   = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0] : null;
            $cat_slug  = $cat_obj ? $cat_obj->slug : '';
            $cat_name  = $cat_obj ? $cat_obj->name : 'Catálogo';
            $badge     = $badge_map[ $cat_slug ] ?? 'badge-green';

            $especies  = get_field( 'producto_especies' );
            $esp_slugs = '';
            if ( $especies ) {
                $esp_slugs = implode( ' ', array_map(
                    fn( $e ) => strtolower( $e->post_title ),
                    $especies
                ) );
            }
          ?>
          <article class="product-card"
            data-slug="<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>"
            data-category="<?php echo esc_attr( $cat_slug ); ?>"
            data-species="<?php echo esc_attr( $esp_slugs ); ?>">

            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium', [ 'class' => 'product-image' ] ); ?>
            <?php else : ?>
              <img class="product-image"
                   src="<?php echo esc_url( get_template_directory_uri() . '/images/product.png' ); ?>"
                   alt="<?php the_title_attribute(); ?>" />
            <?php endif; ?>

            <span class="category-badge <?php echo esc_attr( $badge ); ?>">
              <?php echo esc_html( $cat_name ); ?>
            </span>
            <h3><?php the_title(); ?></h3>
          </article>
          <?php endwhile; endif; ?>
        </div>

        <p class="empty-state" id="empty-state" hidden>
          No encontramos productos con esos filtros. Prueba otra línea o consulta por WhatsApp.
        </p>

        <div class="load-more-wrap" id="load-more-wrap" hidden>
          <button class="btn btn-secondary" id="load-more-btn" type="button">Mostrar más productos</button>
        </div>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
