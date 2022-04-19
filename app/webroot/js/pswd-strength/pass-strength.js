/* 
This is a simple implementation of the password_strength.js plugin, that does not use jQuery Widget Factory.
If you a going to extend plugin with addition functionality it will be better to use password_strength.js 
because jQuery Widget Factory allows to build complex, stateful plugins based on object-oriented principles.

Dependencies: 
1. jQuery
*/

;(function ( $, window, document, undefined ) {
    var upperCase = new RegExp('[A-Z]');
    var lowerCase = new RegExp('[a-z]');
    var numbers = new RegExp('[0-9]');
		var special_char = new RegExp('[\{\}\|\.\+:;"<>,!@#\$%&\*\?~`\^\(\)_\-]');

    var pluginName = 'strength_meter',
        defaults = {
            strengthWrapperClass: 'strength_wrapper',
            inputClass: 'strength_input',
            strengthMeterClass: 'strength_meter',
            toggleButtonClass: 'button_strength',

            showPasswordText: 'Show Password',
            hidePasswordText: 'Hide Password'
        };

    function Plugin( element, options ) {
        this.element = $(element);
        this.options = $.extend( {}, defaults, options) ;
        
        this._create();
    }

    Plugin.prototype._create = function () {
        var 
            options = this.options;
				var fieldId = (typeof options.id !='undefined')?options.id:'password';

        //Note. Instead of this you can use templating. I did not want to have addition dependencies.
        this.element.addClass(options.strengthWrapperClass);
        this.element.append('<input type="password" id="'+fieldId+'" name="data[User][newpass]" placeholder="Set your password"  maxlength=30 autocomplete="off" class="inp_fld ' + options.inputClass + '" "/>');
        this.element.append('<input type="text" id="'+fieldId+'_txt" name="data[User][newpass]" placeholder="Set your password"  maxlength=30 autocomplete="off" class="inp_fld ' + options.inputClass + '" style="display:none"/>');
        this.element.append('<a href="" class="' + options.toggleButtonClass + '">' + options.showPasswordText + '</a>');
        this.element.append('<div class="' + options.strengthMeterClass + '"><div><p></p></div></div>');
        this.element.append(
            '<div class="pswd_info" style="display: none;"> \
            <h4>Your password strength:</h4> \
            <ul> \
            <li data-criterion="length" class="valid">8-30 <strong>Characters</strong></li> \
            <li data-criterion="capital" class="valid">At least <strong>one capital letter</strong></li> \
						<li data-criterion="special" class="valid">At least <strong>one special chars</strong></li> \
            <li data-criterion="number" class="valid">At least <strong>one number</strong></li> \
            <li data-criterion="letter" class="valid">No spaces</li> \
            </ul> \
            </div>');

        //this object contain all main inner elements which will be used in strength meter.
        this.content = {};

        this.content.$textInput = this.element.find('input[type="text"]');
        this.content.$passwordInput = this.element.find('input[type="password"]');
        this.content.$toggleButton = this.element.find('a');
        this.content.$pswdInfo = this.element.find('.pswd_info');
        this.content.$strengthMeter = this.element.find("." + options.strengthMeterClass);
        this.content.$dataMeter = this.content.$strengthMeter.find("div");
        
        this._sync_inputs(this.content.$passwordInput, this.content.$textInput);
        this._sync_inputs(this.content.$textInput, this.content.$passwordInput);

        this._bind_input_events(this.content.$passwordInput);
        this._bind_input_events(this.content.$textInput);

        var that = this;
        this.content.$toggleButton.bind("click", function(e){
            e.preventDefault();

            that._toggle_input(that.content.$textInput);
            that._toggle_input(that.content.$passwordInput);

            var text = that.content.$passwordInput.is(":visible") ? that.options.showPasswordText: that.options.hidePasswordText;
            $(event.target).text(text);
						if(that.content.$passwordInput.is(":visible")){
							$(event.target).removeClass('show');									
						}else{
							$(event.target).addClass('show');
						}
        });
    },

    //Toggle active inputs.
    Plugin.prototype._toggle_input = function($element){
        $element.toggle();

        if($element.is(":visible")){
            $element.focus();
        }
    },

    //Copy value from active input inside hidden.
    Plugin.prototype._sync_inputs = function($s, $t){
        $s.bind('keyup', function () {
            var password = $s.val();
            $t.val(password);
        });
    },

    Plugin.prototype._bind_input_events = function($s) {
        var that = this;
        $s.bind('keyup', function () {
            var password = $s.val();

            var characters = (password.length >= 8);
            var capitalletters = password.match(upperCase) ? 1 : 0;
            var loweletters = password.match(lowerCase) ? 1 : 0;
            var number = password.match(numbers) ? 1 : 0;
            var special_chars = password.match(special_char) ? 1 : 0;
            var containWhiteSpace = password.indexOf(" ") >= 0 ? 1 : 0;
            var total = characters + capitalletters + loweletters + number + special_chars;
            that._update_indicator(total);

            that._update_info('length', password.length >= 8 && password.length <= 30);
            that._update_info('capital', capitalletters);
						that._update_info('special', special_chars);
            that._update_info('number', number);
            that._update_info('letter', !containWhiteSpace);
        }).focus(function () {
            that.content.$pswdInfo.show();
        }).blur(function () {
            that.content.$pswdInfo.hide();
        });
    },

    Plugin.prototype._update_indicator = function(total) {
        var meter = this.content.$dataMeter;

        meter.removeClass();
        if (total === 0) {
            meter.html('');
        } else if (total === 1) {
            meter.addClass('veryweak').html('<p>very weak</p>');
        } else if (total === 2) {
            meter.addClass('weak').html('<p>weak</p>');
        } else if (total === 3 || total === 4) {
            meter.addClass('medium').html('<p>medium</p>');
        } else {
            meter.addClass('strong').html('<p>strong</p>');
        }
    },

    Plugin.prototype._update_info = function(criterion, isValid) {
        var $passwordCriteria = this.element.find('li[data-criterion="' + criterion + '"]');
        if (isValid) {
            $passwordCriteria.removeClass('invalid').addClass('valid');
        } else {
            $passwordCriteria.removeClass('valid').addClass('invalid');
						//this.element.find('input[id="password"]').addClass('invalid');
        }				
    },

    // A really lightweight plugin wrapper around the constructor, 
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, 
                new Plugin( this, options ));
            }
        });
    }

})( jQuery, window, document );
