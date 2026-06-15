<?php
/**
 * Template Name: Contacto
 */
get_header();

$wa_raw      = get_field( 'contacto_whatsapp',    11 );
$telefono    = get_field( 'contacto_telefono',    11 );
$email       = get_field( 'contacto_email',       11 );
$descripcion = get_field( 'contacto_descripcion', 11 );
$wa_href     = $wa_raw ? 'https://wa.me/' . esc_attr( $wa_raw ) : '#';
?>

  <section class="section contact-section contact-first-section">
    <div class="container contact-grid">

      <div class="contact-info">
        <span class="eyebrow">Datos de contacto</span>
        <h2><?php echo esc_html( get_the_title( 11 ) ); ?></h2>
        <?php if ( $descripcion ) : ?>
          <div class="contact-description"><?php echo wp_kses_post( $descripcion ); ?></div>
        <?php endif; ?>
        <ul class="contact-list">
          <?php if ( $wa_raw ) : ?>
          <li><strong>WhatsApp:</strong> <a class="js-whatsapp" href="<?php echo esc_url( $wa_href ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $wa_raw ); ?></a></li>
          <?php endif; ?>
          <?php if ( $telefono ) : ?>
          <li><strong>Teléfono:</strong> <?php echo esc_html( $telefono ); ?></li>
          <?php endif; ?>
          <?php if ( $email ) : ?>
          <li><strong>Correo:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
          <?php endif; ?>
          <li><strong>Ubicación:</strong> Colombia, atención nacional</li>
        </ul>
      </div>

      <form class="contact-form" id="contact-form" novalidate>
        <label for="cf-name">Nombre</label>
        <input id="cf-name" name="nombre" type="text" placeholder="Tu nombre completo" required />

        <label for="cf-phone">Teléfono</label>
        <input id="cf-phone" name="telefono" type="tel" placeholder="+57 300 000 0000" required />

        <label for="cf-topic">Tipo de consulta</label>
        <select id="cf-topic" name="tipo" required>
          <option value="">Selecciona una opción</option>
          <option>Fármacos y medicamentos</option>
          <option>Reproducción animal</option>
          <option>Nutrición</option>
          <option>Accesorios y equipamiento</option>
          <option>Asesoría general</option>
        </select>

        <label for="cf-message">Mensaje</label>
        <textarea id="cf-message" name="mensaje" rows="5" placeholder="Cuéntanos qué producto o línea necesitas consultar"></textarea>

        <button class="btn btn-primary contact-submit" type="submit">
          <span class="submit-label">Enviar consulta</span>
          <span class="submit-spinner" hidden aria-hidden="true"></span>
        </button>

        <p class="form-error" id="form-error" role="alert" hidden></p>
      </form>
    </div>
  </section>

  <!-- Modal confirmación -->
  <div class="modal-overlay" id="lead-modal" hidden role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-box">
      <div class="modal-icon" aria-hidden="true">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="24" cy="24" r="24" fill="#c90511"/>
          <path d="M13 25l8 8L35 16" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <h3 id="modal-title">¡Mensaje recibido!</h3>
      <p>Gracias por contactarte con REDIMAG. Un asesor se comunicará contigo pronto al número que nos dejaste.</p>
      <button class="btn btn-primary" id="modal-close">Entendido</button>
    </div>
  </div>

<?php get_footer(); ?>
