/* Fundraising Grader
*
* Generic Copyright, yadda yadd yadda
*
* Plug-ins: jQuery Validate, jQuery 
* Easing
*/

(function ($) {
    'use strict';

    $(document).ready(function () {

        var current_fs, next_fs, previous_fs;
        var animating;

        $("#progressbar li").css("width", (100 / $("#progressbar li").length) + '%')

        $(".easy-steps-form-steps").validate({
            errorClass: 'invalid',
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.insertAfter(element.next('span').children());
            },
            highlight: function (element) {
                $(element).next('span').removeClass('easy-steps-form-hidden');
                $(element).next('span').addClass('easy-steps-form-show');
            },
            unhighlight: function (element) {
                $(element).next('span').removeClass('easy-steps-form-show');
                $(element).next('span').addClass('easy-steps-form-hidden');
            }
        });

        $(".next").on('click', function () {
            $(".easy-steps-form-steps").validate({
                errorClass: 'invalid',
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.insertAfter(element.next('span').children());
                },
                highlight: function (element) {
                    $(element).next('span').removeClass('easy-steps-form-hidden');
                    $(element).next('span').addClass('easy-steps-form-show');
                },
                unhighlight: function (element) {
                    $(element).next('span').removeClass('easy-steps-form-show');
                    $(element).next('span').addClass('easy-steps-form-hidden');
                }
            });

            if ((!$('.easy-steps-form-steps').valid())) {
                return true;
            }

          
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            next_fs.removeClass('easy-steps-form-hidden');
            next_fs.addClass('easy-steps-form-show');

            current_fs.removeClass('easy-steps-form-show');
            current_fs.addClass('easy-steps-form-hidden');
        });

        $(".submit").on('click', function () {
            $(".easy-steps-form-steps").validate({
                errorClass: 'invalid',
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.insertAfter(element.next('span').children());
                },
                highlight: function (element) {
                    $(element).next('span').show();
                },
                unhighlight: function (element) {
                    $(element).next('span').hide();
                }
            });

            if ((!$('.easy-steps-form-steps').valid())) {
                return false;
            }
       
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.removeClass('easy-steps-form-hidden');
            next_fs.addClass('easy-steps-form-show');

            current_fs.removeClass('easy-steps-form-show');
            current_fs.addClass('easy-steps-form-hidden');
        });

        $(".previous").click(function () {
          
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            previous_fs.removeClass('easy-steps-form-hidden');
            previous_fs.addClass('easy-steps-form-show');

            current_fs.removeClass('easy-steps-form-show');
            current_fs.addClass('easy-steps-form-hidden');
        });

        var modules = {
            $window: $(window),
            $html: $('html'),
            $body: $('body'),
            $container: $('.easy-steps-form-container'),
            init: function () {
                modules.modals.init();
            },
            modals: {
                trigger: $('.explanation'),
                modal: $('.modal'),
                scrollTopPosition: null,
                init: function () {
                    var self = this;
                    if (self.trigger.length > 0 && self.modal.length > 0) {
                        modules.$body.append('<div class="modal-overlay"></div>');
                        self.triggers();
                    }
                },
                triggers: function () {
                    var self = this;
                    self.trigger.on('click', function (e) {
                        e.preventDefault();
                        var $trigger = $(this);
                        self.openModal($trigger, $trigger.data('modalId'));
                    });
                    $('.modal-overlay').on('click', function (e) {
                        e.preventDefault();
                        self.closeModal();
                    });
                    modules.$body.on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            self.closeModal();
                        }
                    });
                    $('.modal-close').on('click', function (e) {
                        e.preventDefault();
                        self.closeModal();
                    });
                },
                openModal: function (_trigger, _modalId) {
                    var self = this,
                        scrollTopPosition = modules.$window.scrollTop(),
                        $targetModal = $('#' + _modalId);
                    self.scrollTopPosition = scrollTopPosition;
                    modules.$html.addClass('modal-show').attr('data-modal-effect', $targetModal.data('modal-effect'));
                    $targetModal.addClass('modal-show');
                    modules.$container.scrollTop(scrollTopPosition);
                },
                closeModal: function () {
                    var self = this;
                    $('.modal-show').removeClass('modal-show');
                    modules.$html.removeClass('modal-show').removeAttr('data-modal-effect');
                    modules.$window.scrollTop(self.scrollTopPosition);
                }
            }
        }

        modules.init();

    });
})(jQuery);