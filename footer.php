</main>

<footer class="site-footer">
  <div class="container footer-grid footer-grid-compact">

    <div>
      <h2>Menú rápido</h2>
      <?php
      wp_nav_menu( [
          'theme_location' => 'menu-footer',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'depth'          => 1,
          'fallback_cb'    => false,
          'walker'         => new Redimag_Nav_Walker(),
      ] );
      ?>
    </div>

    <div>
      <h2>Líneas de producto</h2>
      <?php
      $categorias = get_terms( [
          'taxonomy'   => 'category',
          'hide_empty' => false,
          'exclude'    => [ 1 ],
          'orderby'    => 'name',
          'order'      => 'ASC',
      ] );
      $catalogo_url = get_post_type_archive_link( 'producto' );
      if ( $categorias && ! is_wp_error( $categorias ) ) :
          foreach ( $categorias as $cat ) : ?>
            <a href="<?php echo esc_url( $catalogo_url . '?linea=' . $cat->slug ); ?>">
              <?php echo esc_html( $cat->name ); ?>
            </a>
          <?php endforeach;
      endif;
      ?>
    </div>

  </div>
  <div class="container footer-bottom">
    <p>© <span id="year"></span> REDIMAG. Todos los derechos reservados.</p>
  </div>
</footer>

<a class="floating-whatsapp js-whatsapp" href="#" target="_blank" rel="noopener" aria-label="Consultar por WhatsApp">WA</a>

<?php wp_footer(); ?>
</body>
</html>
