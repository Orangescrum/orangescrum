(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function($) {
    var methods = {
        options: {
            "optionClass": "",
            "dropdownClass": "",
            "autoinit": false,
            "callback": false,
            "search":false,
            "onSelected": false,
            "dynamicOptLabel": "Add a new option..."
        },
        init: function(options) {
            if (options) {
                options = $.extend(methods.options, options);
            } else {
                options = methods.options;
            }
            function initElement($select) {
                if ($select.data("dropdownjs") || !$select.is("select")) {
                    if($select.hasClass('remove-dp')){
                        $select.next('.dropdownjs').remove();
                    }else{
                        return false;
                }
                }
                var multi = $select.attr("multiple");
                var dynamicOptions = $select.attr("data-dynamic-opts")
                  , $dynamicInput = $();
                var $dropdown = $("<div></div>");
                $dropdown.addClass("dropdownjs").addClass(options.dropdownStyle);
                $dropdown.data("select", $select);
                var $input = $("<input type=text readonly class=fakeinput>");
                if ($.material) {
                    $input.data("mdproc", true);
                }
                $dropdown.append($input);
                var $ul = $("<ul></ul>");
                $ul.data("select", $select);
                $dropdown.append($ul);
                $input.attr("placeholder", $select.attr("placeholder"));
                
                $select.find("option").each(function() {
                    var $this = $(this);
                    methods._addOption($ul, $this);
                });
                if(options.search){
                     $dynamicInput1 = $("<li class=dropdownjs-search></li>");
                        $dynamicInput1.append("<input>");
                        $dynamicInput1.find("input").attr("placeholder", _("Search"));
                        $ul.prepend($dynamicInput1);
                 }
                if (dynamicOptions) {
                    $dynamicInput = $("<li class=dropdownjs-add></li>");
                    $dynamicInput.append("<input>");
                    $dynamicInput.find("input").attr("placeholder", options.dynamicOptLabel);
                    $ul.append($dynamicInput);
                }
                var selectOptions = $dropdown.find("li");
                if (!multi) {
                    var $selected;
                    if ($select.find(":selected").length) {
                        $selected = $select.find(":selected").last();
                    } else {
                        $selected = $select.find("option, li").first();
                    }
                    methods._select($dropdown, $selected);
                } else {
                    var selectors = []
                      , val = $select.val()
                    for (var i in val) {
                        selectors.push('li[value=' + val[i] + ']')
                    }
                    if (selectors.length > 0) {
                        methods._select($dropdown, $dropdown.find(selectors.join(',')));
                    }
                }
                $input.addClass($select[0].className);
                $select.hide().attr("data-dropdownjs", true);
                $select.after($dropdown);
                if (options.callback) {
                    options.callback($dropdown);
                }
                $ul.on("click", "li:not(.dropdownjs-add,.dropdownjs-search)", function(e) {
                    methods._select($dropdown, $(this));
                    $select.change();
                });
                $ul.on("keydown", "li:not(.dropdownjs-add,.dropdownjs-search)", function(e) {
                    if (e.which === 27) {
                        $(".dropdownjs > ul > li").attr("tabindex", -1);
                        return $input.removeClass("focus").blur();
                    }
                    if (e.which === 32 && !$(e.target).is("input")) {
                        methods._select($dropdown, $(this));
                        return false;
                    }
                });
                $ul.on("focus", "li:not(.dropdownjs-add,.dropdownjs-search)", function() {
                    if ($select.is(":disabled")) {
                        return;
                    }
                    $input.addClass("focus");
                });
                if (dynamicOptions && dynamicOptions.length) {
                    $dynamicInput.on("keydown", function(e) {
                        if (e.which !== 13)
                            return;
                        var $option = $("<option>")
                          , val = $dynamicInput.find("input").val();
                        setTimeout(function() {
                            $dynamicInput.find("input").val("");
                        }, 1000);
                        $option.attr("value", val);
                        $option.text(val);
                        $select.append($option);
                    });
                }
                $select.on("DOMNodeInserted", function(e) {
                    var $this = $(e.target);
                    if (!$this.val().length)
                        return;
                    methods._addOption($ul, $this);
                    $ul.find("li").not(".dropdownjs-add,.dropdownjs-search").attr("tabindex", 0);
                });
                $select.on("change", function(e) {
                    var $this = $(e.target);
                    if (!$this.val().length)
                        return;
                    if (!multi) {
                        var $selected;
                        if ($select.find(":selected").length) {
                            $selected = $select.find(":selected").last();
                        } else {
                            $selected = $select.find("option, li").first();
                        }
                        methods._select($dropdown, $selected);
                    } else {
                        methods._select($dropdown, $select.find(":selected"));
                    }
                });
                $input.on("click focus", function(e) {
                    e.stopPropagation();
                    if ($select.is(":disabled")) {
                        return;
                    }
                    $(".dropdownjs > ul > li").attr("tabindex", -1);
                    $(".dropdownjs > input").not($(this)).removeClass("focus").blur();
                    $(".dropdownjs > ul > li").not(".dropdownjs-add,.dropdownjs-search").attr("tabindex", 0);
                    var coords = {
                        top: $(this).offset().top - $(document).scrollTop(),
                        left: $(this).offset().left - $(document).scrollLeft(),
                        bottom: $(window).height() - ($(this).offset().top - $(document).scrollTop()),
                        right: $(window).width() - ($(this).offset().left - $(document).scrollLeft())
                    };
                    var height = coords.bottom;
                    if (height < 200 && coords.top > coords.bottom) {
                        height = coords.top;
                        $ul.attr("placement", "top-left");
                    } else {
                        $ul.attr("placement", "bottom-left");
                    }
                    $(this).next("ul").css("max-height", height - 20);
                    $(this).addClass("focus");
                    $('.dropdownjs-add,.dropdownjs-search').find('input').val('');
                    $(".dropdownjs > ul > li").not(".dropdownjs-add,.dropdownjs-search").show();
                });
                $(document).on("click", function(e) {
                    if (multi && $(e.target).parents(".dropdownjs").length)
                        return;
                    if ($(e.target).parents(".dropdownjs-add").length || $(e.target).is(".dropdownjs-add"))
                        return;
                    if ($(e.target).parents(".dropdownjs-search").length || $(e.target).is(".dropdownjs-search"))
                        return;
                    $(".dropdownjs > ul > li").attr("tabindex", -1);
                    $input.removeClass("focus");
                });
            }
            if (options.autoinit) {
                $(document).on("DOMNodeInserted", function(e) {
                    var $this = $(e.target);
                    if (!$this.is("select")) {
                        $this = $this.find('select');
                    }
                    if ($this.is(options.autoinit)) {
                        $this.each(function() {
                            initElement($(this));
                        });
                    }
                });
            }
            $(this).each(function() {
                initElement($(this));
            });
        },
        select: function(target) {
            var $target = $(this).find("[value=\"" + target + "\"]");
            methods._select($(this), $target);
        },
        _select: function($dropdown, $target) {
            if ($target.is(".dropdownjs-add"))
                return;
            if ($target.is(".dropdownjs-search"))
                return;
            var $select = $dropdown.data("select")
              , $input = $dropdown.find("input.fakeinput");
            var multi = $select.attr("multiple");
            var selectOptions = $dropdown.find("li");
            if (multi) {
                $target.toggleClass("selected");
                $target.each(function() {
                    var $selected = $select.find("[value=\"" + $(this).attr("value") + "\"]");
                    $selected.prop("selected", $(this).hasClass("selected"));
                })
                var text = [];
                selectOptions.each(function() {
                    if ($(this).hasClass("selected")) {
                        text.push($(this).text());
                    }
                });
                $input.val(text.join(", "));
            }
            if (!multi) {
                if ($target.is("li")) {
                    selectOptions.not($target).removeClass("selected");
                }
                $target.addClass("selected");
                $select.val($target.attr("value"));
                $input.val($target.text().trim());
            }
            if ($.material) {
                if ($input.val().trim()) {
                    $select.removeClass("empty");
                } else {
                    $select.addClass("empty");
                }
            }
            if (this.options.onSelected) {
                this.options.onSelected($target.attr("value"));
            }
        },
        _addOption: function($ul, $this) {
            var $option = $("<li></li>");
            $option.addClass(this.options.optionStyle);
            if ($this.text()) {
                $option.text($this.text());
            } else {
                $option.html("&nbsp;");
            }
            $option.attr("value", $this.val());
            if ($ul.data("select").attr("data-dynamic-opts")) {
                $option.append("<span class=close></span>");
                $option.find(".close").on("click", function() {
                    $option.remove();
                    $this.remove();
                });
            }
            if ($this.prop("selected")) {
                $option.attr("selected", true);
                $option.addClass("selected");
            }
            if ($ul.find(".dropdownjs-add").length) {
                $ul.find(".dropdownjs-add").after($option);
            }else if($ul.find(".dropdownjs-search").length){
               // $ul.find(".dropdownjs-search").after($option);
            }else {
                $ul.append($option);
            }
        }
    };
    $.fn.dropdown = function(params) {
        if (methods[params]) {
            return methods[params].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof params === "object" | !params) {
            return methods.init.apply(this, arguments);
        } else {
            $.error("Method " + params + " does not exists on jQuery.dropdown");
        }
    }
    ;
}));
