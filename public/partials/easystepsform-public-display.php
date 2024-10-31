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
                    required="<?php echo esc_attr( $required ) ?>"
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
                    required="<?php echo esc_attr( $required ) ?>"
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
                        required="<?php echo esc_attr( $required ) ?>"
                        placeholder="<?php echo esc_attr( $placeholder ) ?>"
                        data-rule-required="<?php echo esc_attr( $required ) ?>"
                        data-msg-required="Please include your <?php echo esc_attr( $name ) ?>"><?php echo esc_textarea( $default ); ?></textarea>
              <?php
              break;

          case 'select':
              ?>
              <select id="<?php echo esc_attr( $id ) ?>"
                      name="<?php echo esc_attr( $name ) ?>"
                      required="<?php echo esc_attr( $required ) ?>"
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
                    <input type="radio"
                    id="<?php echo esc_attr( $radio_id ); ?>"
                    name="<?php echo esc_attr( $name ); ?>"
                    value="<?php echo esc_attr( $option['radio'] ); ?>"
                    <?php checked( $default, $option['radio'] ); ?>
                    required="<?php echo esc_attr( $required ); ?>"
                    data-rule-required="<?php echo esc_attr( $required ); ?>"
                    data-msg-required="Please select a <?php echo esc_attr( $name ) ?>">
                </div>
              <?php endforeach;
              break;

          case 'file':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    required="<?php echo esc_attr( $required ) ?>"
                    type="file"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please upload a <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          case 'date':
              ?>
              <input id="<?php echo esc_attr( $id ) ?>"
                    name="<?php echo esc_attr( $name ) ?>"
                    required="<?php echo esc_attr( $required ) ?>"
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
                    required="<?php echo esc_attr( $required ) ?>"
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
                    required="<?php echo esc_attr( $required ) ?>"
                    type="range"
                    value="<?php echo esc_attr( $default ) ?>"
                    placeholder="<?php echo esc_attr( $placeholder ) ?>"
                    data-rule-required="<?php echo esc_attr( $required ) ?>"
                    data-msg-required="Please set a range value for <?php echo esc_attr( $name ) ?>">
              <?php
              break;

          default:
              echo '';
              break;
      }

      $content = ob_get_contents();
      ob_end_clean();

      return $content;
  }

  public function get_final_content() {
    $pages = count($this->steps);

    ob_start();
    ?>
    
      <fieldset>
        <h2 class="fs-title">Final etape</h2>
        <h3 class="fs-subtitle">Pay and submit form</h3>

        <div
          class="form-item webform-component webform-component-textfield field hs-form-field"
          id="webform-component-retention--amount-1">

          <label
            for=" edit-submitted-retention-amount-1 number_of_donors_in_year_1-99a6d115-5e68-4355-a7d0-529207feb0b3_2983">What
            was your total number of donors who gave in year 1? *</label>

          <input id="edit-submitted-retention-amount-1" class="form-text hs-input" name="number_of_donors_in_year_1"
            required="required" size="60" maxlength="128" type="number" value="" placeholder="" data-rule-required="true"
            data-msg-required="Please enter a valid number">
          <span class="error1 easy-steps-form-hidden" style="display: none;">
            <i class="error-log fa fa-exclamation-triangle"></i>
          </span>
        </div>

        <!-- Begin Final Calc -->
        <div class="form-item webform-component webform-component-textfield hs_fundraising_400_index field hs-form-field"
          id="webform-component-final-grade--grade">

          <label for="fundraising_400_index-99a6d115-5e68-4355-a7d0-529207feb0b3_2983">Fundraising 400 Index
            Score</label>

          <input id="edit-submitted-final-grade-grade" class="form-text hs-input" name="fundraising_400_index"
            readonly="readonly" size="60" maxlength="128" type="text" value="" placeholder="0">
        </div>
        <!-- End Final Calc -->
        <input type="button" data-page="<?php echo esc_attr( $pages ) ?>" name="previous" class="previous action-button" value="Previous" />
        <input id="easy-steps-form-submit" class="hs-button primary large action-button next" type="submit" value="Validate">
        <div class="explanation btn btn-small modal-trigger" data-modal-id="modal-3">What Is This?</div>
      </fieldset>

      <fieldset>
        <h2 class="fs-title">It's on the way!</h2>
        <h3 class="fs-subtitle">Thank you for trying out our marketing grader, please go check your email for your
          fundraising report card and some helpful tips to improve it!</h3>
        <div class="explanation btn btn-small modal-trigger" data-modal-id="modal-3">What Is This?</div>
      </fieldset>
    <?php

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
  }

  public function get_step_content() {
    $compt = 0;
    ?>
      <form class="easy-steps-form-steps" accept-charset="UTF-8" enctype="multipart/form-data" novalidate="" method="POST">
        <ul id="progressbar">
          <?php
            foreach ($this->steps as $step) {
              ?><li class="<?= 0 === $compt ? 'active' : '' ?>"><?php echo esc_html( $step['panel-title'] ?? '' ) ?></li><?php
              $compt++;
            }
          ?>
          <li>Validation</li>
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

                        
                        <?php echo $this->get_input( 
                          $field['type'], 
                          $field['title'], 
                          $uniq_key, 
                          'yes' === $field['required'], 
                          $field['radio'] ?? array(), 
                          $field['default'], 
                          $field['placeholder']
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
                  ?><input type="button" data-page="<?php echo esc_attr( $page - 1 ) ?>" name="previous" class="previous action-button" value="Previous" /><?php
                 } ?>
                <input type="button" data-page="<?php echo esc_attr( $page ) ?>" name="next" class="next action-button" value="Next" />
                <div class="explanation btn btn-small modal-trigger" data-modal-id="modal-3"><i
                    class="question-log fa fa-question-circle"></i> What Is This?</div>
              </fieldset>
            <?php
            $page++;
          }

          echo $this->get_final_content();
        ?>
      </form>
    <?php
  }

  public function get_content() {
    ob_start();

    echo $this->get_modal_info();

    ?>
    <div class="easy-steps-form-builder-container">
      <?php
        echo $this->get_form_header();
        echo $this->get_step_content();
      ?>
    </div>
    
    <?php

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
  }
}