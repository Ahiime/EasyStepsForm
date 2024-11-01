<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.blyd3d.com
 * @since      1.0.0
 *
 * @package    Easystepsform
 * @subpackage Easystepsform/public/partials
 */

class Easy_Steps_Form_Content {

	private $form;

  private $steps = array();

  private $formID;

	public function __construct( $id ) {
    $this->formID = $id;
		$this->form = get_post_meta( $id, 'easy-form-adding', true );

    $steps_data = Easy_Steps_Form_Admin_Tools::get_parse_value( $this->form, 'steps' );

    foreach ($steps_data as $steps) {
      $this->steps[ $steps["stepper"] ] = get_post_meta( $steps["stepper"], 'easy-form-stepper', true );
    }
	}

  public function get_form_header() {
    ?>
      <div class="easy-steps-form-info">
      <h1><?php echo esc_html( $this->form['title'] ?? '' ) ?></h1>
      <span>
        <?php echo esc_html( $this->form['sub-title'] ?? '' ) ?>
        <div class="spoilers">
          <?php echo esc_html( $this->form['description'] ?? '' ) ?>
        </div>
      </span>
    </div>
    <?php
  }

  public function get_modal_info() {
    ob_start();
    ?>
     <!-- Modal -info -->
    <div class="easy-steps-form-container">
      <div id="modal-3" class="modal" data-modal-effect="slide-top">
        <div class="modal-content">
          <h2 class="fs-title">Score Index</h2>
          <h3 class="fs-subtitle">Getting the most out of your data</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce convallis consectetur ligula. Morbi dapibus
            tellus a ipsum sollicitudin aliquet. Phasellus id est lacus. Pellentesque a elementum velit, a tempor nulla.
            Mauris mauris lectus, tincidunt et purus rhoncus, eleifend convallis turpis. Nunc ullamcorper bibendum diam,
            vitae tempus dolor hendrerit iaculis. Phasellus tellus elit, feugiat vel mi et, euismod varius augue. Nulla a
            porttitor sapien. Donec vestibulum ac nisl sed bibendum. Praesent neque ipsum, commodo eget venenatis vel,
            tempus sit amet ante. Curabitur vel odio eget urna dapibus imperdiet sit amet eget felis. Vestibulum eros
            velit, posuere a metus eget, aliquam euismod purus. Class aptent taciti sociosqu ad litora torquent per
            conubia nostra, per inceptos himenaeos.</p>
          <input type="button" name="next" class="next action-button modal-close" value="Got it!">
        </div>
      </div>
    </div>
    <?php

    $content = ob_get_contents();

    ob_clean();

    return $content;
  }

  public function get_input( $type, $name, $id, $required, $options = array(), $default = '', $placeholder = '' ) {
      ob_start();

      switch ($type) {
          case 'text':
          case 'email':
          case 'password':
          case 'url':
          case 'tel':
          case 'hidden':
          case 'datetime-local':
          case 'month':
          case 'week':
          case 'time':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    type="<?php echo esc_attr( $type ) ?>"
                    value="<?php echo esc_attr( $default ) ?>"
                    placeholder="<?php echo esc_attr( $placeholder ) ?>"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please include your <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          case 'number':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    type="number"
                    value="<?php echo esc_attr( $default ) ?>"
                    placeholder="<?php echo esc_attr( $placeholder ) ?>"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please include your <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          case 'textarea':
              ?>
              <textarea id="<?php echo esc_attr( $id ) ?>"
                        name="<?php echo esc_attr( $name ) ?>"
                        <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                        placeholder="<?php echo esc_attr( $placeholder ) ?>"
                        data-rule-required="<?php echo esc_attr( $required ) ?>"
                        data-msg-required="Please include your <?php echo esc_attr( $name ) ?>"><?php echo esc_textarea( $default ); ?></textarea>
              <?php
              break;

          case 'select':
              ?>
              <select id="<?php echo esc_attr( $id ) ?>"
                      name="<?php echo esc_attr( $name ) ?>"
                      <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                      data-rule-required="<?php echo esc_attr( $required ) ?>"
                      data-msg-required="Please select a <?php echo esc_attr( $name ) ?>">
                  <?php foreach ( $options as $option ) : ?>
                      <option value="<?php echo esc_attr( $option['label'] ); ?>" <?php selected( $option['label'], $option['radio'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
                  <?php endforeach; ?>
              </select>
              <?php
              break;

          case 'radio':
          case 'checkbox':
              foreach ( $options as $option ) : 
                $radio_id = uniqid( sanitize_title( $name ) . '-' );
              ?>
                <div class="easy-step-form-radio">
                    <label for="<?php echo esc_attr( $radio_id ); ?>"><?php echo esc_html( $option['label'] ); ?></label>
                    <input type="<?php echo esc_attr( $type ); ?>"
                    id="<?php echo esc_attr( $radio_id ); ?>"
                    name="<?php echo esc_attr( $name ); ?>"
                    value="<?php echo esc_attr( $option['radio'] ); ?>"
                    <?php checked( $default, $option['radio'] ); ?>
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    data-rule-required="<?php echo esc_attr( $required ); ?>"
                    data-msg-required="Please select a <?php echo esc_attr( $name ) ?>">
                </div>
              <?php endforeach;
              break;

          case 'file':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    type="file"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please upload a <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          case 'date':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    type="date"
                    value="<?php echo esc_attr( $default ) ?>"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please select a date for <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          case 'image':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    type="file"
                    accept="image/*"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please upload an image for <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          case 'range':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    <?php echo esc_attr( 'true' === $required ? 'required' : '' ) ?>
                    type="range"
                    value="<?php echo esc_attr( $default ) ?>"
                    placeholder="<?php echo esc_attr( $placeholder ) ?>"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please set a range value for <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          default:
              echo esc_html('');
              break;
      }

      $content = ob_get_contents();
      ob_end_clean();

      return $content;
  }

  public function get_final_content() {
    $pages = count($this->steps);

    $name = sanitize_key( $this->form['additional-note'] );

    $uniq_id = uniqid( $name . '-' );
    $uniq_id2 = uniqid( $name . '-' );
    ob_start();
    ?>
    
      <fieldset>
        <h2 class="fs-title">Etape finale</h2>
        <h3 class="fs-subtitle">Bravo!!, c'est la dernière étape.</h3>

        <div class="form-item field hs-form-field">
          <label for="<?php echo esc_attr( $uniq_id ) ?>">
            <?php echo esc_html( $this->form['additional-note'] ) ?>
          </label>

          <textarea id="<?php echo esc_attr( $uniq_id ) ?>" class="form-text hs-<?php echo esc_attr( $name ) ?>" name="<?php echo esc_attr( $name ) ?>"
            type="text" value="" placeholder="" data-rule-required="false"
            data-msg-required="Please enter a valid text">
            </textarea>
          <span class="error1 easy-steps-form-hidden" style="display: none;">
            <i class="error-log fa fa-exclamation-triangle"></i>
          </span>
        </div>


        <div class="form-item field hs-form-field">
          <label for="<?php echo esc_attr( $uniq_id2 ) ?>">
            <?php echo esc_html( $this->form['pricing-title'] ) ?> *
          </label>
            <?php
            foreach ( $this->form['price-step'] as $option ) : 
                $radio_id = uniqid( sanitize_title( $this->form['pricing-title'] ) . '-' );
              ?>
                <div class="easy-step-form-radio easy-step-pricing-option">
                    <label for="<?php echo esc_attr( $radio_id ); ?>"><?php echo esc_html( $option['name'] ); ?></label>
                    <input type="radio"
                    id="<?php echo esc_attr( $radio_id ); ?>"
                    name="<?php echo esc_attr( sanitize_key( $this->form['pricing-title'] ) ); ?>"
                    value="<?php echo esc_attr( $option['price'] ); ?>"
                    required
                    data-rule-required="true"
                    data-msg-required="Please select a <?php echo esc_attr( $option['name'] ) ?>">
                </div>
              <?php endforeach;
              ?>
          <span class="error1 easy-steps-form-hidden" style="display: none;">
            <i class="error-log fa fa-exclamation-triangle"></i>
          </span>
        </div>

        <?php
        foreach ( $this->form['radio-note'] as $option ) :
          $uniqid = uniqid( sanitize_key( $option['note-name'] ) . '-' );
          $uniqid2 = uniqid( sanitize_key( $option['note-name'] ) . '-' ); 
          $uniqid3 = uniqid( sanitize_key( $option['note-name'] ) . '-' ); 
          ?>
          <div class="form-item field hs-form-field">
            <label for="<?php echo esc_attr( $uniqid ) ?>">
              <?php echo esc_html( $option['note-name'] ) ?> *
            </label>

              <div class="easy-step-form-radio">
                  <label for="<?php echo esc_attr( $uniqid2 ); ?>"><?php echo esc_html( 'Oui' ); ?></label>
                  <input type="radio"
                  id="<?php echo esc_attr( $uniqid2 ); ?>"
                  name="<?php echo esc_attr( sanitize_key( $option['note-name'] ) ); ?>"
                  value="oui"
                  checked
                  required
                  data-rule-required="true"
                  data-msg-required="Please select a <?php echo esc_attr( $option['note-name'] ) ?>">
              </div>
              <div class="easy-step-form-radio">
                  <label for="<?php echo esc_attr( $uniqid3 ); ?>"><?php echo esc_html( 'Non' ); ?></label>
                  <input type="radio"
                  id="<?php echo esc_attr( $uniqid3 ); ?>"
                  name="<?php echo esc_attr( sanitize_key( $option['note-name'] ) ); ?>"
                  value="non"
                  required
                  data-rule-required="true"
                  data-msg-required="Please select a <?php echo esc_attr( $option['note-name'] ) ?>">
              </div>
            <span class="error1 easy-steps-form-hidden" style="display: none;">
              <i class="error-log fa fa-exclamation-triangle"></i>
            </span>
          </div>
          <?php
        endforeach;
        ?>

        <input type="button" data-page="<?php echo esc_attr( $pages ) ?>" name="previous" class="previous action-button" value="Précédent" />
        <input data-page="<?php echo esc_attr( $pages + 1 ) ?>" id="easy-steps-form-submit" class="hs-button primary large action-button next" type="submit" value="Soumettre">
      </fieldset>

      <fieldset>
        <h2 class="fs-title">It's on the way!</h2>
        <h3 class="fs-subtitle">Thank you for trying out our marketing grader, please go check your email for your
          fundraising report card and some helpful tips to improve it!</h3>
        <div class="explanation btn btn-small modal-trigger" data-modal-id="modal-3">Qu'est ce que s'est ?</div>
      </fieldset>
    <?php

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
  }

  public function get_step_content() {
    $compt = 0;
    ?>
      <form id="easy-steps-forms"  class="easy-steps-form-steps" accept-charset="UTF-8" enctype="multipart/form-data" method="POST">
        <ul id="progressbar">
          <?php
            foreach ($this->steps as $step) {
              ?><li class="<?= 0 === $compt ? 'active' : '' ?>"><?php echo esc_html( $step['panel-title'] ?? '' ) ?></li><?php
              $compt++;
            }
          ?>
          <li>Validation</li>
          <li>Merci</li>
        </ul>

        <?php
          $page = 1;
          foreach ($this->steps as $step) {
            ?>
              <fieldset>
                <h2 class="fs-title"><?php echo esc_html( $step['title'] ?? '' ) ?></h2>
                <h3 class="fs-subtitle"><?php echo esc_html( $step['description'] ?? '' ) ?></h3>
                <?php
                  foreach ($step['field'] as $field) {
                    $uniq_key = uniqid( sanitize_key( $field['title'] ) . '-' );
                    
                    ?>
                      <div class="hs_<?php echo esc_attr( $field['title'] ) ?> field hs-form-field">

                        <label for="<?php echo esc_attr( $uniq_key ) ?>"><?php echo esc_html( $field['title'] ) ?> <?php echo esc_html( 'yes' === $field['required'] ? '*' : '' ) ?></label>

                        
                        <?php echo wp_kses( 
                            $this->get_input( 
                            $field['type'], 
                            $field['title'], 
                            $uniq_key, 
                            'yes' === $field['required'] ? 'true' : 'false', 
                            $field['radio'] ?? array(), 
                            $field['default'], 
                            $field['placeholder']
                            ),
                            Easy_Steps_Form_Admin_Tools::get_allowed_tags()
                          ) ?>
                        <span class="error1 easy-steps-form-hidden" style="display: none;">
                          <i class="error-log fa fa-exclamation-triangle"></i>
                        </span>
                      </div>
                    <?php
                  }
                ?>
      
                <!-- End Total Number of Constituents in Your Database Field -->
                 <?php if( $page - 1 > 0) {
                  ?><input type="button" data-page="<?php echo esc_attr( $page - 1 ) ?>" name="previous" class="previous action-button" value="Précédent" /><?php
                 } ?>
                <input type="button" data-page="<?php echo esc_attr( $page ) ?>" name="next" class="next action-button" value="Suivant" />
              </fieldset>
            <?php
            $page++;
          }

          echo wp_kses( $this->get_final_content(), Easy_Steps_Form_Admin_Tools::get_allowed_tags() );
        ?>
        <input type="hidden" name="easy-steps-form-nonce" value="<?php echo esc_attr( wp_create_nonce( 'easy-steps-form-nonce' ) ); ?>"/>
        <input type="hidden" name="link-product" value="<?php echo esc_attr( $this->form['link-product'] ); ?>"/>
      </form>
    <?php
  }

  public function get_content() {
    ob_start();
    ?>
    <div class="easy-steps-form-builder-container">
      <?php
        echo wp_kses( $this->get_form_header(), Easy_Steps_Form_Admin_Tools::get_allowed_tags() );
        echo wp_kses( $this->get_step_content(), Easy_Steps_Form_Admin_Tools::get_allowed_tags() );
      ?>
    </div>
    
    <?php

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
  }
}