(function ($) {
    $.facebox = function (data, klass) {
        $.facebox.loading();
        if (data.ajax) {
            fillFaceboxFromAjax(data.ajax, klass)
        } else {
            if (data.image) {
                fillFaceboxFromImage(data.image, klass)
            } else {
                if (data.div) {
                    fillFaceboxFromHref(data.div, klass)
                } else {
                    if ($.isFunction(data)) {
                        data.call($)
                    } else {
                        $.facebox.reveal(data, klass)
                    }
                }
            }
        }
    };
    $.extend($.facebox, {
        settings: {
            opacity: 0.2,
            overlay: true,
            loadingImage: "/img/facebox/loading.gif",
            closeImage: "/img/facebox/closelabel.png",
            imageTypes: ["png", "jpg", "jpeg", "gif"],
            faceboxHtml: '    <div id="facebox" style="display:none;">       <div class="popup">         <div class="content">         </div>         <a href="#" class="close"><img src="/img/facebox/closelabel.png" title="close" class="close_image" /></a>       </div>     </div>'
        },
        loading: function () {
            init();
            if ($("#facebox .loading").length == 1) {
                return true
            }
            showOverlay();
            $("#facebox .content").empty();
            $("#facebox .body").children().hide().end().append('<div class="loading"><img src="' + $.facebox.settings.loadingImage + '"/></div>');
            $("#facebox").css({
                top: getPageScroll()[1] + (getPageHeight() / 10),
                left: $(window).width() / 2 - 205
            }).show();
            $(document).bind("keydown.facebox", function (e) {
                if (e.keyCode == 27) {
                    $.facebox.close()
                }
                return true
            });
            $(document).trigger("loading.facebox")
        },
        reveal: function (data, klass) {
            $(document).trigger("beforeReveal.facebox");
            if (klass) {
                $("#facebox .content").addClass(klass)
            }
            $("#facebox .content").append(data);
            $("#facebox .loading").remove();
            $("#facebox .body").children().fadeIn("normal");
            $("#facebox").css("left", $(window).width() / 2 - ($("#facebox .popup").width() / 2));
            $(document).trigger("reveal.facebox").trigger("afterReveal.facebox")
        },
        close: function () {
            $(document).trigger("close.facebox");
            return false
        }
    });
    $.fn.facebox = function (settings) {
        if ($(this).length == 0) {
            return
        }
        init(settings);

        function clickHandler() {
            $.facebox.loading(true);
            var klass = this.rel.match(/facebox\[?\.(\w+)\]?/);
            if (klass) {
                klass = klass[1]
            }
            fillFaceboxFromHref(this.href, klass);
            return false
        }
        return this.bind("click.facebox", clickHandler)
    };

    function init(settings) {
        if ($.facebox.settings.inited) {
            return true
        } else {
            $.facebox.settings.inited = true
        }
        $(document).trigger("init.facebox");
        makeCompatible();
        var imageTypes = $.facebox.settings.imageTypes.join("|");
        $.facebox.settings.imageTypesRegexp = new RegExp(".(" + imageTypes + ")$", "i");
        if (settings) {
            $.extend($.facebox.settings, settings)
        }
        $("body").append($.facebox.settings.faceboxHtml);
        var preload = [new Image(), new Image()];
        preload[0].src = $.facebox.settings.closeImage;
        preload[1].src = $.facebox.settings.loadingImage;
        $("#facebox").find(".b:first, .bl").each(function () {
            preload.push(new Image());
            preload.slice(-1).src = $(this).css("background-image").replace(/url\((.+)\)/, "$1")
        });
        $("#facebox .close").click($.facebox.close);
        $("#facebox .close_image").attr("src", $.facebox.settings.closeImage)
    }

    function getPageScroll() {
        var xScroll, yScroll;
        if (self.pageYOffset) {
            yScroll = self.pageYOffset;
            xScroll = self.pageXOffset
        } else {
            if (document.documentElement && document.documentElement.scrollTop) {
                yScroll = document.documentElement.scrollTop;
                xScroll = document.documentElement.scrollLeft
            } else {
                if (document.body) {
                    yScroll = document.body.scrollTop;
                    xScroll = document.body.scrollLeft
                }
            }
        }
        return new Array(xScroll, yScroll)
    }

    function getPageHeight() {
        var windowHeight;
        if (self.innerHeight) {
            windowHeight = self.innerHeight
        } else {
            if (document.documentElement && document.documentElement.clientHeight) {
                windowHeight = document.documentElement.clientHeight
            } else {
                if (document.body) {
                    windowHeight = document.body.clientHeight
                }
            }
        }
        return windowHeight
    }

    function makeCompatible() {
        var $s = $.facebox.settings;
        $s.loadingImage = $s.loading_image || $s.loadingImage;
        $s.closeImage = $s.close_image || $s.closeImage;
        $s.imageTypes = $s.image_types || $s.imageTypes;
        $s.faceboxHtml = $s.facebox_html || $s.faceboxHtml
    }

    function fillFaceboxFromHref(href, klass) {
        if (href.match(/#/)) {
            var url = window.location.href.split("#")[0];
            var target = href.replace(url, "");
            if (target == "#") {
                return
            }
            $.facebox.reveal($(target).html(), klass)
        } else {
            if (href.match($.facebox.settings.imageTypesRegexp)) {
                fillFaceboxFromImage(href, klass)
            } else {
                fillFaceboxFromAjax(href, klass)
            }
        }
    }

    function fillFaceboxFromImage(href, klass) {
        var image = new Image();
        image.onload = function () {
            $.facebox.reveal('<div class="image"><img src="' + image.src + '" /></div>', klass)
        };
        image.src = href
    }

    function fillFaceboxFromAjax(href, klass) {
        $.get(href, function (data) {
            $.facebox.reveal(data, klass)
        })
    }

    function skipOverlay() {
        return $.facebox.settings.overlay == false || $.facebox.settings.opacity === null
    }

    function showOverlay() {
        if (skipOverlay()) {
            return
        }
        if ($("#facebox_overlay").length == 0) {
            $("body").append('<div id="facebox_overlay" class="facebox_hide"></div>')
        }
        $("#facebox_overlay").hide().addClass("facebox_overlayBG").css("opacity", $.facebox.settings.opacity).click(function () {
            $(document).trigger("close.facebox")
        }).fadeIn(200);
        return false
    }

    function hideOverlay() {
        if (skipOverlay()) {
            return
        }
        $("#facebox_overlay").fadeOut(200, function () {
            $("#facebox_overlay").removeClass("facebox_overlayBG");
            $("#facebox_overlay").addClass("facebox_hide");
            $("#facebox_overlay").remove()
        });
        return false
    }
    $(document).bind("close.facebox", function () {
        $(document).unbind("keydown.facebox");
        $("#facebox").fadeOut(function () {
            $("#facebox .content").removeClass().addClass("content");
            $("#facebox .loading").remove();
            $(document).trigger("afterClose.facebox")
        });
        hideOverlay()
    })
})(jQuery);
(function () {
    var $, Chosen, SelectParser, get_side_border_padding, root;
    var __bind = function (fn, me) {
        return function () {
            return fn.apply(me, arguments)
        }
    };
    root = typeof exports !== "undefined" && exports !== null ? exports : this;
    $ = jQuery;
    $.fn.extend({
        chosen: function (data, options) {
            return $(this).each(function (input_field) {
                if (!($(this)).hasClass("chzn-done")) {
                    return new Chosen(this, data, options)
                }
            })
        }
    });
    Chosen = (function () {
        function Chosen(elmn) {
            this.set_default_values();
            this.form_field = elmn;
            this.form_field_jq = $(this.form_field);
            this.is_multiple = this.form_field.multiple;
            this.default_text_default = this.form_field.multiple ? "Sélectionner des options" : "Sélectionner une option";
            this.set_up_html();
            this.register_observers();
            this.form_field_jq.addClass("chzn-done")
        }
        Chosen.prototype.set_default_values = function () {
            this.click_test_action = __bind(function (evt) {
                return this.test_active_click(evt)
            }, this);
            this.active_field = false;
            this.mouse_on_container = false;
            this.results_showing = false;
            this.result_highlighted = null;
            this.result_single_selected = null;
            return this.choices = 0
        };
        Chosen.prototype.set_up_html = function () {
            var container_div, dd_top, dd_width, sf_width;
            this.container_id = this.form_field.id.length ? this.form_field.id.replace(".", "_") : this.generate_field_id();
            this.container_id += "_chzn";
            this.f_width = this.form_field_jq.width();
            this.default_text = this.form_field_jq.data("placeholder") ? this.form_field_jq.data("placeholder") : this.default_text_default;
            container_div = $("<div />", {
                id: this.container_id,
                "class": "chzn-container",
                style: "width: " + this.f_width + "px;"
            });
            if (this.is_multiple) {
                container_div.html('<ul class="chzn-choices"><li class="search-field"><input type="text" value="' + this.default_text + '" class="default" style="width:25px;" /></li></ul><div class="chzn-drop" style="left:-9000px;"><ul class="chzn-results"></ul></div>')
            } else {
                container_div.html('<a href="javascript:void(0)" class="chzn-single"><span>' + this.default_text + '</span><div><b></b></div></a><div class="chzn-drop" style="left:-9000px;"><div class="chzn-search"><input type="text" /></div><ul class="chzn-results"></ul></div>')
            }
            this.form_field_jq.hide().after(container_div);
            this.container = $("#" + this.container_id);
            this.container.addClass("chzn-container-" + (this.is_multiple ? "multi" : "single"));
            this.dropdown = this.container.find("div.chzn-drop").first();
            dd_top = this.container.height();
            dd_width = this.f_width - get_side_border_padding(this.dropdown);
            this.dropdown.css({
                width: dd_width + "px",
                top: dd_top + "px"
            });
            this.search_field = this.container.find("input").first();
            this.search_results = this.container.find("ul.chzn-results").first();
            this.search_field_scale();
            this.search_no_results = this.container.find("li.no-results").first();
            if (this.is_multiple) {
                this.search_choices = this.container.find("ul.chzn-choices").first();
                this.search_container = this.container.find("li.search-field").first()
            } else {
                this.search_container = this.container.find("div.chzn-search").first();
                this.selected_item = this.container.find(".chzn-single").first();
                sf_width = dd_width - get_side_border_padding(this.search_container) - get_side_border_padding(this.search_field);
                this.search_field.css({
                    width: sf_width + "px"
                })
            }
            this.results_build();
            return this.set_tab_index()
        };
        Chosen.prototype.register_observers = function () {
            this.container.click(__bind(function (evt) {
                return this.container_click(evt)
            }, this));
            this.container.mouseenter(__bind(function (evt) {
                return this.mouse_enter(evt)
            }, this));
            this.container.mouseleave(__bind(function (evt) {
                return this.mouse_leave(evt)
            }, this));
            this.search_results.click(__bind(function (evt) {
                return this.search_results_click(evt)
            }, this));
            this.search_results.mouseover(__bind(function (evt) {
                return this.search_results_mouseover(evt)
            }, this));
            this.search_results.mouseout(__bind(function (evt) {
                return this.search_results_mouseout(evt)
            }, this));
            this.form_field_jq.bind("liszt:updated", __bind(function (evt) {
                return this.results_update_field(evt)
            }, this));
            this.search_field.blur(__bind(function (evt) {
                return this.input_blur(evt)
            }, this));
            this.search_field.keyup(__bind(function (evt) {
                return this.keyup_checker(evt)
            }, this));
            this.search_field.keydown(__bind(function (evt) {
                return this.keydown_checker(evt)
            }, this));
            if (this.is_multiple) {
                this.search_choices.click(__bind(function (evt) {
                    return this.choices_click(evt)
                }, this));
                return this.search_field.focus(__bind(function (evt) {
                    return this.input_focus(evt)
                }, this))
            } else {
                return this.selected_item.focus(__bind(function (evt) {
                    return this.activate_field(evt)
                }, this))
            }
        };
        Chosen.prototype.container_click = function (evt) {
            if (evt && evt.type === "click") {
                evt.stopPropagation()
            }
            if (!this.pending_destroy_click) {
                if (!this.active_field) {
                    if (this.is_multiple) {
                        this.search_field.val("")
                    }
                    $(document).click(this.click_test_action);
                    this.results_show()
                } else {
                    if (!this.is_multiple && evt && ($(evt.target) === this.selected_item || $(evt.target).parents("a.chzn-single").length)) {
                        evt.preventDefault();
                        this.results_toggle()
                    }
                }
                return this.activate_field()
            } else {
                return this.pending_destroy_click = false
            }
        };
        Chosen.prototype.mouse_enter = function () {
            return this.mouse_on_container = true
        };
        Chosen.prototype.mouse_leave = function () {
            return this.mouse_on_container = false
        };
        Chosen.prototype.input_focus = function (evt) {
            if (!this.active_field) {
                return setTimeout((__bind(function () {
                    return this.container_click()
                }, this)), 50)
            }
        };
        Chosen.prototype.input_blur = function (evt) {
            if (!this.mouse_on_container) {
                this.active_field = false;
                return setTimeout((__bind(function () {
                    return this.blur_test()
                }, this)), 100)
            }
        };
        Chosen.prototype.blur_test = function (evt) {
            if (!this.active_field && this.container.hasClass("chzn-container-active")) {
                return this.close_field()
            }
        };
        Chosen.prototype.close_field = function () {
            $(document).unbind("click", this.click_test_action);
            if (!this.is_multiple) {
                this.selected_item.attr("tabindex", this.search_field.attr("tabindex"));
                this.search_field.attr("tabindex", -1)
            }
            this.active_field = false;
            this.results_hide();
            this.container.removeClass("chzn-container-active");
            this.winnow_results_clear();
            this.clear_backstroke();
            this.show_search_field_default();
            return this.search_field_scale()
        };
        Chosen.prototype.activate_field = function () {
            if (!this.is_multiple && !this.active_field) {
                this.search_field.attr("tabindex", this.selected_item.attr("tabindex"));
                this.selected_item.attr("tabindex", -1)
            }
            this.container.addClass("chzn-container-active");
            this.active_field = true;
            this.search_field.val(this.search_field.val());
            return this.search_field.focus()
        };
        Chosen.prototype.test_active_click = function (evt) {
            if ($(evt.target).parents("#" + this.container_id).length) {
                return this.active_field = true
            } else {
                return this.close_field()
            }
        };
        Chosen.prototype.results_build = function () {
            var content, data, startTime, _i, _len, _ref;
            startTime = new Date();
            this.parsing = true;
            this.results_data = SelectParser.select_to_array(this.form_field);
            if (this.is_multiple && this.choices > 0) {
                this.search_choices.find("li.search-choice").remove();
                this.choices = 0
            } else {
                if (!this.is_multiple) {
                    this.selected_item.find("span").text(this.default_text)
                }
            }
            content = "";
            _ref = this.results_data;
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                data = _ref[_i];
                if (data.group) {
                    content += this.result_add_group(data)
                } else {
                    if (!data.empty) {
                        content += this.result_add_option(data);
                        if (data.selected && this.is_multiple) {
                            this.choice_build(data)
                        } else {
                            if (data.selected && !this.is_multiple) {
                                this.selected_item.find("span").text(data.text)
                            }
                        }
                    }
                }
            }
            this.show_search_field_default();
            this.search_field_scale();
            this.search_results.html(content);
            return this.parsing = false
        };
        Chosen.prototype.result_add_group = function (group) {
            if (!group.disabled) {
                group.dom_id = this.container_id + "_g_" + group.array_index;
                return '<li id="' + group.dom_id + '" class="group-result">' + $("<div />").text(group.label).html() + "</li>"
            } else {
                return ""
            }
        };
        Chosen.prototype.result_add_option = function (option) {
            var classes;
            if (!option.disabled) {
                option.dom_id = this.container_id + "_o_" + option.array_index;
                classes = option.selected && this.is_multiple ? [] : ["active-result"];
                if (option.selected) {
                    classes.push("result-selected")
                }
                if (option.group_array_index != null) {
                    classes.push("group-option")
                }
                return '<li id="' + option.dom_id + '" class="' + classes.join(" ") + '">' + option.html + "</li>"
            } else {
                return ""
            }
        };
        Chosen.prototype.results_update_field = function () {
            this.result_clear_highlight();
            this.result_single_selected = null;
            return this.results_build()
        };
        Chosen.prototype.result_do_highlight = function (el) {
            var high_bottom, high_top, maxHeight, visible_bottom, visible_top;
            if (el.length) {
                this.result_clear_highlight();
                this.result_highlight = el;
                this.result_highlight.addClass("highlighted");
                maxHeight = parseInt(this.search_results.css("maxHeight"), 10);
                visible_top = this.search_results.scrollTop();
                visible_bottom = maxHeight + visible_top;
                high_top = this.result_highlight.position().top + this.search_results.scrollTop();
                high_bottom = high_top + this.result_highlight.outerHeight();
                if (high_bottom >= visible_bottom) {
                    return this.search_results.scrollTop((high_bottom - maxHeight) > 0 ? high_bottom - maxHeight : 0)
                } else {
                    if (high_top < visible_top) {
                        return this.search_results.scrollTop(high_top)
                    }
                }
            }
        };
        Chosen.prototype.result_clear_highlight = function () {
            if (this.result_highlight) {
                this.result_highlight.removeClass("highlighted")
            }
            return this.result_highlight = null
        };
        Chosen.prototype.results_toggle = function () {
            if (this.results_showing) {
                return this.results_hide()
            } else {
                return this.results_show()
            }
        };
        Chosen.prototype.results_show = function () {
            var dd_top;
            if (!this.is_multiple) {
                this.selected_item.addClass("chzn-single-with-drop");
                if (this.result_single_selected) {
                    this.result_do_highlight(this.result_single_selected)
                }
            }
            dd_top = this.is_multiple ? this.container.height() : this.container.height() - 1;
            this.dropdown.css({
                top: dd_top + "px",
                left: 0
            });
            this.results_showing = true;
            this.search_field.focus();
            this.search_field.val(this.search_field.val());
            return this.winnow_results()
        };
        Chosen.prototype.results_hide = function () {
            if (!this.is_multiple) {
                this.selected_item.removeClass("chzn-single-with-drop")
            }
            this.result_clear_highlight();
            this.dropdown.css({
                left: "-9000px"
            });
            return this.results_showing = false
        };
        Chosen.prototype.set_tab_index = function (el) {
            var ti;
            if (this.form_field_jq.attr("tabindex")) {
                ti = this.form_field_jq.attr("tabindex");
                this.form_field_jq.attr("tabindex", -1);
                if (this.is_multiple) {
                    return this.search_field.attr("tabindex", ti)
                } else {
                    this.selected_item.attr("tabindex", ti);
                    return this.search_field.attr("tabindex", -1)
                }
            }
        };
        Chosen.prototype.show_search_field_default = function () {
            if (this.is_multiple && this.choices < 1 && !this.active_field) {
                this.search_field.val(this.default_text);
                return this.search_field.addClass("default")
            } else {
                this.search_field.val("");
                return this.search_field.removeClass("default")
            }
        };
        Chosen.prototype.search_results_click = function (evt) {
            var target;
            target = $(evt.target).hasClass("active-result") ? $(evt.target) : $(evt.target).parents(".active-result").first();
            if (target.length) {
                this.result_highlight = target;
                return this.result_select()
            }
        };
        Chosen.prototype.search_results_mouseover = function (evt) {
            var target;
            target = $(evt.target).hasClass("active-result") ? $(evt.target) : $(evt.target).parents(".active-result").first();
            if (target) {
                return this.result_do_highlight(target)
            }
        };
        Chosen.prototype.search_results_mouseout = function (evt) {
            if ($(evt.target).hasClass("active-result" || $(evt.target).parents(".active-result").first())) {
                return this.result_clear_highlight()
            }
        };
        Chosen.prototype.choices_click = function (evt) {
            evt.preventDefault();
            if (this.active_field && !($(evt.target).hasClass("search-choice" || $(evt.target).parents(".search-choice").first)) && !this.results_showing) {
                return this.results_show()
            }
        };
        Chosen.prototype.choice_build = function (item) {
            var choice_id, link;
            choice_id = this.container_id + "_c_" + item.array_index;
            this.choices += 1;
            this.search_container.before('<li class="search-choice" id="' + choice_id + '"><span>' + item.html + '</span><a href="javascript:void(0)" class="search-choice-close" rel="' + item.array_index + '"></a></li>');
            link = $("#" + choice_id).find("a").first();
            return link.click(__bind(function (evt) {
                return this.choice_destroy_link_click(evt)
            }, this))
        };
        Chosen.prototype.choice_destroy_link_click = function (evt) {
            evt.preventDefault();
            this.pending_destroy_click = true;
            return this.choice_destroy($(evt.target))
        };
        Chosen.prototype.choice_destroy = function (link) {
            this.choices -= 1;
            this.show_search_field_default();
            if (this.is_multiple && this.choices > 0 && this.search_field.val().length < 1) {
                this.results_hide()
            }
            this.result_deselect(link.attr("rel"));
            return link.parents("li").first().remove()
        };
        Chosen.prototype.result_select = function () {
            var high, high_id, item, position;
            if (this.result_highlight) {
                high = this.result_highlight;
                high_id = high.attr("id");
                this.result_clear_highlight();
                high.addClass("result-selected");
                if (this.is_multiple) {
                    this.result_deactivate(high)
                } else {
                    this.result_single_selected = high
                }
                position = high_id.substr(high_id.lastIndexOf("_") + 1);
                item = this.results_data[position];
                item.selected = true;
                this.form_field.options[item.options_index].selected = true;
                if (this.is_multiple) {
                    this.choice_build(item)
                } else {
                    this.selected_item.find("span").first().text(item.text)
                }
                this.results_hide();
                this.search_field.val("");
                this.form_field_jq.trigger("change");
                return this.search_field_scale()
            }
        };
        Chosen.prototype.result_activate = function (el) {
            return el.addClass("active-result").show()
        };
        Chosen.prototype.result_deactivate = function (el) {
            return el.removeClass("active-result").hide()
        };
        Chosen.prototype.result_deselect = function (pos) {
            var result, result_data;
            result_data = this.results_data[pos];
            result_data.selected = false;
            this.form_field.options[result_data.options_index].selected = false;
            result = $("#" + this.container_id + "_o_" + pos);
            result.removeClass("result-selected").addClass("active-result").show();
            this.result_clear_highlight();
            this.winnow_results();
            this.form_field_jq.trigger("change");
            return this.search_field_scale()
        };
        Chosen.prototype.results_search = function (evt) {
            if (this.results_showing) {
                return this.winnow_results()
            } else {
                return this.results_show()
            }
        };
        Chosen.prototype.winnow_results = function () {
            var found, option, part, parts, regex, result_id, results, searchText, startTime, startpos, text, zregex, _i, _j, _len, _len2, _ref;
            startTime = new Date();
            this.no_results_clear();
            results = 0;
            searchText = this.search_field.val() === this.default_text ? "" : $("<div/>").text($.trim(this.search_field.val())).html();
            regex = new RegExp("^" + searchText.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
            zregex = new RegExp(searchText.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
            _ref = this.results_data;
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                option = _ref[_i];
                if (!option.disabled && !option.empty) {
                    if (option.group) {
                        $("#" + option.dom_id).hide()
                    } else {
                        if (!(this.is_multiple && option.selected)) {
                            found = false;
                            result_id = option.dom_id;
                            if (regex.test(option.html)) {
                                found = true;
                                results += 1
                            } else {
                                if (option.html.indexOf(" ") >= 0 || option.html.indexOf("[") === 0) {
                                    parts = option.html.replace(/\[|\]/g, "").split(" ");
                                    if (parts.length) {
                                        for (_j = 0, _len2 = parts.length; _j < _len2; _j++) {
                                            part = parts[_j];
                                            if (regex.test(part)) {
                                                found = true;
                                                results += 1
                                            }
                                        }
                                    }
                                }
                            } if (found) {
                                if (searchText.length) {
                                    startpos = option.html.search(zregex);
                                    text = option.html.substr(0, startpos + searchText.length) + "</em>" + option.html.substr(startpos + searchText.length);
                                    text = text.substr(0, startpos) + "<em>" + text.substr(startpos)
                                } else {
                                    text = option.html
                                } if ($("#" + result_id).html !== text) {
                                    $("#" + result_id).html(text)
                                }
                                this.result_activate($("#" + result_id));
                                if (option.group_array_index != null) {
                                    $("#" + this.results_data[option.group_array_index].dom_id).show()
                                }
                            } else {
                                if (this.result_highlight && result_id === this.result_highlight.attr("id")) {
                                    this.result_clear_highlight()
                                }
                                this.result_deactivate($("#" + result_id))
                            }
                        }
                    }
                }
            }
            if (results < 1 && searchText.length) {
                return this.no_results(searchText)
            } else {
                return this.winnow_results_set_highlight()
            }
        };
        Chosen.prototype.winnow_results_clear = function () {
            var li, lis, _i, _len, _results;
            this.search_field.val("");
            lis = this.search_results.find("li");
            _results = [];
            for (_i = 0, _len = lis.length; _i < _len; _i++) {
                li = lis[_i];
                li = $(li);
                _results.push(li.hasClass("group-result") ? li.show() : !this.is_multiple || !li.hasClass("result-selected") ? this.result_activate(li) : void 0)
            }
            return _results
        };
        Chosen.prototype.winnow_results_set_highlight = function () {
            var do_high;
            if (!this.result_highlight) {
                do_high = this.search_results.find(".active-result").first();
                if (do_high) {
                    return this.result_do_highlight(do_high)
                }
            }
        };
        Chosen.prototype.no_results = function (terms) {
            var no_results_html;
            no_results_html = $('<li class="no-results">Aucun résultat pour "<span></span>"</li>');
            no_results_html.find("span").first().html(terms);
            return this.search_results.append(no_results_html)
        };
        Chosen.prototype.no_results_clear = function () {
            return this.search_results.find(".no-results").remove()
        };
        Chosen.prototype.keydown_arrow = function () {
            var first_active, next_sib;
            if (!this.result_highlight) {
                first_active = this.search_results.find("li.active-result").first();
                if (first_active) {
                    this.result_do_highlight($(first_active))
                }
            } else {
                if (this.results_showing) {
                    next_sib = this.result_highlight.nextAll("li.active-result").first();
                    if (next_sib) {
                        this.result_do_highlight(next_sib)
                    }
                }
            } if (!this.results_showing) {
                return this.results_show()
            }
        };
        Chosen.prototype.keyup_arrow = function () {
            var prev_sibs;
            if (!this.results_showing && !this.is_multiple) {
                return this.results_show()
            } else {
                if (this.result_highlight) {
                    prev_sibs = this.result_highlight.prevAll("li.active-result");
                    if (prev_sibs.length) {
                        return this.result_do_highlight(prev_sibs.first())
                    } else {
                        if (this.choices > 0) {
                            this.results_hide()
                        }
                        return this.result_clear_highlight()
                    }
                }
            }
        };
        Chosen.prototype.keydown_backstroke = function () {
            if (this.pending_backstroke) {
                this.choice_destroy(this.pending_backstroke.find("a").first());
                return this.clear_backstroke()
            } else {
                this.pending_backstroke = this.search_container.siblings("li.search-choice").last();
                return this.pending_backstroke.addClass("search-choice-focus")
            }
        };
        Chosen.prototype.clear_backstroke = function () {
            if (this.pending_backstroke) {
                this.pending_backstroke.removeClass("search-choice-focus")
            }
            return this.pending_backstroke = null
        };
        Chosen.prototype.keyup_checker = function (evt) {
            var stroke, _ref;
            stroke = (_ref = evt.which) != null ? _ref : evt.keyCode;
            this.search_field_scale();
            switch (stroke) {
            case 8:
                if (this.is_multiple && this.backstroke_length < 1 && this.choices > 0) {
                    return this.keydown_backstroke()
                } else {
                    if (!this.pending_backstroke) {
                        this.result_clear_highlight();
                        return this.results_search()
                    }
                }
                break;
            case 13:
                evt.preventDefault();
                if (this.results_showing) {
                    return this.result_select()
                }
                break;
            case 27:
                if (this.results_showing) {
                    return this.results_hide()
                }
                break;
            case 9:
            case 38:
            case 40:
            case 16:
                break;
            default:
                return this.results_search()
            }
        };
        Chosen.prototype.keydown_checker = function (evt) {
            var stroke, _ref;
            stroke = (_ref = evt.which) != null ? _ref : evt.keyCode;
            this.search_field_scale();
            if (stroke !== 8 && this.pending_backstroke) {
                this.clear_backstroke()
            }
            switch (stroke) {
            case 8:
                this.backstroke_length = this.search_field.val().length;
                break;
            case 9:
                this.mouse_on_container = false;
                break;
            case 13:
                evt.preventDefault();
                break;
            case 38:
                evt.preventDefault();
                this.keyup_arrow();
                break;
            case 40:
                this.keydown_arrow();
                break
            }
        };
        Chosen.prototype.search_field_scale = function () {
            var dd_top, div, h, style, style_block, styles, w, _i, _len;
            if (this.is_multiple) {
                h = 0;
                w = 0;
                style_block = "position:absolute; left: -1000px; top: -1000px; display:none;";
                styles = ["font-size", "font-style", "font-weight", "font-family", "line-height", "text-transform", "letter-spacing"];
                for (_i = 0, _len = styles.length; _i < _len; _i++) {
                    style = styles[_i];
                    style_block += style + ":" + this.search_field.css(style) + ";"
                }
                div = $("<div />", {
                    style: style_block
                });
                div.text(this.search_field.val());
                $("body").append(div);
                w = div.width() + 25;
                div.remove();
                if (w > this.f_width - 10) {
                    w = this.f_width - 10
                }
                this.search_field.css({
                    width: w + "px"
                });
                dd_top = this.container.height();
                return this.dropdown.css({
                    top: dd_top + "px"
                })
            }
        };
        Chosen.prototype.generate_field_id = function () {
            var new_id;
            new_id = this.generate_random_id();
            this.form_field.id = new_id;
            return new_id
        };
        Chosen.prototype.generate_random_id = function () {
            var string;
            string = "sel" + this.generate_random_char() + this.generate_random_char() + this.generate_random_char();
            while ($("#" + string).length > 0) {
                string += this.generate_random_char()
            }
            return string
        };
        Chosen.prototype.generate_random_char = function () {
            var chars, newchar, rand;
            chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
            rand = Math.floor(Math.random() * chars.length);
            return newchar = chars.substring(rand, rand + 1)
        };
        return Chosen
    })();
    get_side_border_padding = function (elmt) {
        var side_border_padding;
        return side_border_padding = elmt.outerWidth() - elmt.width()
    };
    root.get_side_border_padding = get_side_border_padding;
    SelectParser = (function () {
        function SelectParser() {
            this.options_index = 0;
            this.parsed = []
        }
        SelectParser.prototype.add_node = function (child) {
            if (child.nodeName === "OPTGROUP") {
                return this.add_group(child)
            } else {
                return this.add_option(child)
            }
        };
        SelectParser.prototype.add_group = function (group) {
            var group_position, option, _i, _len, _ref, _results;
            group_position = this.parsed.length;
            this.parsed.push({
                array_index: group_position,
                group: true,
                label: group.label,
                children: 0,
                disabled: group.disabled
            });
            _ref = group.childNodes;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                option = _ref[_i];
                _results.push(this.add_option(option, group_position, group.disabled))
            }
            return _results
        };
        SelectParser.prototype.add_option = function (option, group_position, group_disabled) {
            if (option.nodeName === "OPTION") {
                if (option.text !== "") {
                    if (group_position != null) {
                        this.parsed[group_position].children += 1
                    }
                    this.parsed.push({
                        array_index: this.parsed.length,
                        options_index: this.options_index,
                        value: option.value,
                        text: option.text,
                        html: option.innerHTML,
                        selected: option.selected,
                        disabled: group_disabled === true ? group_disabled : option.disabled,
                        group_array_index: group_position
                    })
                } else {
                    this.parsed.push({
                        array_index: this.parsed.length,
                        options_index: this.options_index,
                        empty: true
                    })
                }
                return this.options_index += 1
            }
        };
        return SelectParser
    })();
    SelectParser.select_to_array = function (select) {
        var child, parser, _i, _len, _ref;
        parser = new SelectParser();
        _ref = select.childNodes;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            child = _ref[_i];
            parser.add_node(child)
        }
        return parser.parsed
    };
    root.SelectParser = SelectParser
}).call(this);
jQuery.easing.jswing = jQuery.easing.swing;
jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function (x, t, b, c, d) {
        return jQuery.easing[jQuery.easing.def](x, t, b, c, d)
    },
    easeInQuad: function (x, t, b, c, d) {
        return c * (t /= d) * t + b
    },
    easeOutQuad: function (x, t, b, c, d) {
        return -c * (t /= d) * (t - 2) + b
    },
    easeInOutQuad: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) {
            return c / 2 * t * t + b
        }
        return -c / 2 * ((--t) * (t - 2) - 1) + b
    },
    easeInCubic: function (x, t, b, c, d) {
        return c * (t /= d) * t * t + b
    },
    easeOutCubic: function (x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b
    },
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) {
            return c / 2 * t * t * t + b
        }
        return c / 2 * ((t -= 2) * t * t + 2) + b
    },
    easeInQuart: function (x, t, b, c, d) {
        return c * (t /= d) * t * t * t + b
    },
    easeOutQuart: function (x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b
    },
    easeInOutQuart: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) {
            return c / 2 * t * t * t * t + b
        }
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b
    },
    easeInQuint: function (x, t, b, c, d) {
        return c * (t /= d) * t * t * t * t + b
    },
    easeOutQuint: function (x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t * t * t + 1) + b
    },
    easeInOutQuint: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) {
            return c / 2 * t * t * t * t * t + b
        }
        return c / 2 * ((t -= 2) * t * t * t * t + 2) + b
    },
    easeInSine: function (x, t, b, c, d) {
        return -c * Math.cos(t / d * (Math.PI / 2)) + c + b
    },
    easeOutSine: function (x, t, b, c, d) {
        return c * Math.sin(t / d * (Math.PI / 2)) + b
    },
    easeInOutSine: function (x, t, b, c, d) {
        return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b
    },
    easeInExpo: function (x, t, b, c, d) {
        return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b
    },
    easeOutExpo: function (x, t, b, c, d) {
        return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b
    },
    easeInOutExpo: function (x, t, b, c, d) {
        if (t == 0) {
            return b
        }
        if (t == d) {
            return b + c
        }
        if ((t /= d / 2) < 1) {
            return c / 2 * Math.pow(2, 10 * (t - 1)) + b
        }
        return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b
    },
    easeInCirc: function (x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b
    },
    easeOutCirc: function (x, t, b, c, d) {
        return c * Math.sqrt(1 - (t = t / d - 1) * t) + b
    },
    easeInOutCirc: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) {
            return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b
        }
        return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b
    },
    easeInElastic: function (x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) {
            return b
        }
        if ((t /= d) == 1) {
            return b + c
        }
        if (!p) {
            p = d * 0.3
        }
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4
        } else {
            var s = p / (2 * Math.PI) * Math.asin(c / a)
        }
        return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b
    },
    easeOutElastic: function (x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) {
            return b
        }
        if ((t /= d) == 1) {
            return b + c
        }
        if (!p) {
            p = d * 0.3
        }
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4
        } else {
            var s = p / (2 * Math.PI) * Math.asin(c / a)
        }
        return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b
    },
    easeInOutElastic: function (x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) {
            return b
        }
        if ((t /= d / 2) == 2) {
            return b + c
        }
        if (!p) {
            p = d * (0.3 * 1.5)
        }
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4
        } else {
            var s = p / (2 * Math.PI) * Math.asin(c / a)
        } if (t < 1) {
            return -0.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b
        }
        return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * 0.5 + c + b
    },
    easeInBack: function (x, t, b, c, d, s) {
        if (s == undefined) {
            s = 1.70158
        }
        return c * (t /= d) * t * ((s + 1) * t - s) + b
    },
    easeOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) {
            s = 1.70158
        }
        return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b
    },
    easeInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) {
            s = 1.70158
        }
        if ((t /= d / 2) < 1) {
            return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b
        }
        return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b
    },
    easeInBounce: function (x, t, b, c, d) {
        return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b
    },
    easeOutBounce: function (x, t, b, c, d) {
        if ((t /= d) < (1 / 2.75)) {
            return c * (7.5625 * t * t) + b
        } else {
            if (t < (2 / 2.75)) {
                return c * (7.5625 * (t -= (1.5 / 2.75)) * t + 0.75) + b
            } else {
                if (t < (2.5 / 2.75)) {
                    return c * (7.5625 * (t -= (2.25 / 2.75)) * t + 0.9375) + b
                } else {
                    return c * (7.5625 * (t -= (2.625 / 2.75)) * t + 0.984375) + b
                }
            }
        }
    },
    easeInOutBounce: function (x, t, b, c, d) {
        if (t < d / 2) {
            return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * 0.5 + b
        }
        return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * 0.5 + c * 0.5 + b
    }
});
(function ($) {
    $.fn.ajaxSubmit = function (options) {
        if (!this.length) {
            log("ajaxSubmit: skipping submit process - no element selected");
            return this
        }
        if (typeof options == "function") {
            options = {
                success: options
            }
        }
        var url = $.trim(this.attr("action"));
        if (url) {
            url = (url.match(/^([^#]+)/) || [])[1]
        }
        url = url || window.location.href || "";
        options = $.extend({
            url: url,
            type: this.attr("method") || "GET"
        }, options || {});
        var veto = {};
        this.trigger("form-pre-serialize", [this, options, veto]);
        if (veto.veto) {
            log("ajaxSubmit: submit vetoed via form-pre-serialize trigger");
            return this
        }
        if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
            log("ajaxSubmit: submit aborted via beforeSerialize callback");
            return this
        }
        var a = this.formToArray(options.semantic);
        if (options.data) {
            options.extraData = options.data;
            for (var n in options.data) {
                if (options.data[n] instanceof Array) {
                    for (var k in options.data[n]) {
                        a.push({
                            name: n,
                            value: options.data[n][k]
                        })
                    }
                } else {
                    a.push({
                        name: n,
                        value: options.data[n]
                    })
                }
            }
        }
        if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
            log("ajaxSubmit: submit aborted via beforeSubmit callback");
            return this
        }
        this.trigger("form-submit-validate", [a, this, options, veto]);
        if (veto.veto) {
            log("ajaxSubmit: submit vetoed via form-submit-validate trigger");
            return this
        }
        var q = $.param(a);
        if (options.type.toUpperCase() == "GET") {
            options.url += (options.url.indexOf("?") >= 0 ? "&" : "?") + q;
            options.data = null
        } else {
            options.data = q
        }
        var $form = this,
            callbacks = [];
        if (options.resetForm) {
            callbacks.push(function () {
                $form.resetForm()
            })
        }
        if (options.clearForm) {
            callbacks.push(function () {
                $form.clearForm()
            })
        }
        if (!options.dataType && options.target) {
            var oldSuccess = options.success || function () {};
            callbacks.push(function (data) {
                $(options.target).html(data).each(oldSuccess, arguments)
            })
        } else {
            if (options.success) {
                callbacks.push(options.success)
            }
        }
        options.success = function (data, status) {
            for (var i = 0, max = callbacks.length; i < max; i++) {
                callbacks[i].apply(options, [data, status, $form])
            }
        };
        var files = $("input:file", this).fieldValue();
        var found = false;
        for (var j = 0; j < files.length; j++) {
            if (files[j]) {
                found = true
            }
        }
        var multipart = false;
        if (options.iframe || found || multipart) {
            if (options.closeKeepAlive) {
                $.get(options.closeKeepAlive, fileUpload)
            } else {
                fileUpload()
            }
        } else {
            $.ajax(options)
        }
        this.trigger("form-submit-notify", [this, options]);
        return this;

        function fileUpload() {
            var form = $form[0];
            if ($(":input[name=submit]", form).length) {
                alert('Error: Form elements must not be named "submit".');
                return
            }
            var opts = $.extend({}, $.ajaxSettings, options);
            var s = $.extend(true, {}, $.extend(true, {}, $.ajaxSettings), opts);
            var id = "jqFormIO" + (new Date().getTime());
            var $io = $('<iframe id="' + id + '" name="' + id + '" src="about:blank" />');
            var io = $io[0];
            $io.css({
                position: "absolute",
                top: "-1000px",
                left: "-1000px"
            });
            var xhr = {
                aborted: 0,
                responseText: null,
                responseXML: null,
                status: 0,
                statusText: "n/a",
                getAllResponseHeaders: function () {},
                getResponseHeader: function () {},
                setRequestHeader: function () {},
                abort: function () {
                    this.aborted = 1;
                    $io.attr("src", "about:blank")
                }
            };
            var g = opts.global;
            if (g && !$.active++) {
                $.event.trigger("ajaxStart")
            }
            if (g) {
                $.event.trigger("ajaxSend", [xhr, opts])
            }
            if (s.beforeSend && s.beforeSend(xhr, s) === false) {
                s.global && $.active--;
                return
            }
            if (xhr.aborted) {
                return
            }
            var cbInvoked = 0;
            var timedOut = 0;
            var sub = form.clk;
            if (sub) {
                var n = sub.name;
                if (n && !sub.disabled) {
                    options.extraData = options.extraData || {};
                    options.extraData[n] = sub.value;
                    if (sub.type == "image") {
                        options.extraData[name + ".x"] = form.clk_x;
                        options.extraData[name + ".y"] = form.clk_y
                    }
                }
            }
            setTimeout(function () {
                var t = $form.attr("target"),
                    a = $form.attr("action");
                form.setAttribute("target", id);
                if (form.getAttribute("method") != "POST") {
                    form.setAttribute("method", "POST")
                }
                if (form.getAttribute("action") != opts.url) {
                    form.setAttribute("action", opts.url)
                }
                if (!options.skipEncodingOverride) {
                    $form.attr({
                        encoding: "multipart/form-data",
                        enctype: "multipart/form-data"
                    })
                }
                if (opts.timeout) {
                    setTimeout(function () {
                        timedOut = true;
                        cb()
                    }, opts.timeout)
                }
                var extraInputs = [];
                try {
                    if (options.extraData) {
                        for (var n in options.extraData) {
                            extraInputs.push($('<input type="hidden" name="' + n + '" value="' + options.extraData[n] + '" />').appendTo(form)[0])
                        }
                    }
                    $io.appendTo("body");
                    io.attachEvent ? io.attachEvent("onload", cb) : io.addEventListener("load", cb, false);
                    form.submit()
                } finally {
                    form.setAttribute("action", a);
                    t ? form.setAttribute("target", t) : $form.removeAttr("target");
                    $(extraInputs).remove()
                }
            }, 10);
            var nullCheckFlag = 0;

            function cb() {
                if (cbInvoked++) {
                    return
                }
                io.detachEvent ? io.detachEvent("onload", cb) : io.removeEventListener("load", cb, false);
                var ok = true;
                try {
                    if (timedOut) {
                        throw "timeout"
                    }
                    var data, doc;
                    doc = io.contentWindow ? io.contentWindow.document : io.contentDocument ? io.contentDocument : io.document;
                    if ((doc.body == null || doc.body.innerHTML == "") && !nullCheckFlag) {
                        nullCheckFlag = 1;
                        cbInvoked--;
                        setTimeout(cb, 100);
                        return
                    }
                    xhr.responseText = doc.body ? doc.body.innerHTML : null;
                    xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
                    xhr.getResponseHeader = function (header) {
                        var headers = {
                            "content-type": opts.dataType
                        };
                        return headers[header]
                    };
                    if (opts.dataType == "json" || opts.dataType == "script") {
                        var ta = doc.getElementsByTagName("textarea")[0];
                        xhr.responseText = ta ? ta.value : xhr.responseText
                    } else {
                        if (opts.dataType == "xml" && !xhr.responseXML && xhr.responseText != null) {
                            xhr.responseXML = toXml(xhr.responseText)
                        }
                    }
                    data = $.httpData(xhr, opts.dataType)
                } catch (e) {
                    ok = false;
                    $.handleError(opts, xhr, "error", e)
                }
                if (ok) {
                    opts.success(data, "success");
                    if (g) {
                        $.event.trigger("ajaxSuccess", [xhr, opts])
                    }
                }
                if (g) {
                    $.event.trigger("ajaxComplete", [xhr, opts])
                }
                if (g && !--$.active) {
                    $.event.trigger("ajaxStop")
                }
                if (opts.complete) {
                    opts.complete(xhr, ok ? "success" : "error")
                }
                setTimeout(function () {
                    $io.remove();
                    xhr.responseXML = null
                }, 100)
            }

            function toXml(s, doc) {
                if (window.ActiveXObject) {
                    doc = new ActiveXObject("Microsoft.XMLDOM");
                    doc.async = "false";
                    doc.loadXML(s)
                } else {
                    doc = (new DOMParser()).parseFromString(s, "text/xml")
                }
                return (doc && doc.documentElement && doc.documentElement.tagName != "parsererror") ? doc : null
            }
        }
    };
    $.fn.ajaxForm = function (options) {
        return this.ajaxFormUnbind().bind("submit.form-plugin", function () {
            $(this).ajaxSubmit(options);
            return false
        }).each(function () {
            $(":submit,input:image", this).bind("click.form-plugin", function (e) {
                var form = this.form;
                form.clk = this;
                if (this.type == "image") {
                    if (e.offsetX != undefined) {
                        form.clk_x = e.offsetX;
                        form.clk_y = e.offsetY
                    } else {
                        if (typeof $.fn.offset == "function") {
                            var offset = $(this).offset();
                            form.clk_x = e.pageX - offset.left;
                            form.clk_y = e.pageY - offset.top
                        } else {
                            form.clk_x = e.pageX - this.offsetLeft;
                            form.clk_y = e.pageY - this.offsetTop
                        }
                    }
                }
                setTimeout(function () {
                    form.clk = form.clk_x = form.clk_y = null
                }, 10)
            })
        })
    };
    $.fn.ajaxFormUnbind = function () {
        this.unbind("submit.form-plugin");
        return this.each(function () {
            $(":submit,input:image", this).unbind("click.form-plugin")
        })
    };
    $.fn.formToArray = function (semantic) {
        var a = [];
        if (this.length == 0) {
            return a
        }
        var form = this[0];
        var els = semantic ? form.getElementsByTagName("*") : form.elements;
        if (!els) {
            return a
        }
        for (var i = 0, max = els.length; i < max; i++) {
            var el = els[i];
            var n = el.name;
            if (!n) {
                continue
            }
            if (semantic && form.clk && el.type == "image") {
                if (!el.disabled && form.clk == el) {
                    a.push({
                        name: n,
                        value: $(el).val()
                    });
                    a.push({
                        name: n + ".x",
                        value: form.clk_x
                    }, {
                        name: n + ".y",
                        value: form.clk_y
                    })
                }
                continue
            }
            var v = $.fieldValue(el, true);
            if (v && v.constructor == Array) {
                for (var j = 0, jmax = v.length; j < jmax; j++) {
                    a.push({
                        name: n,
                        value: v[j]
                    })
                }
            } else {
                if (v !== null && typeof v != "undefined") {
                    a.push({
                        name: n,
                        value: v
                    })
                }
            }
        }
        if (!semantic && form.clk) {
            var $input = $(form.clk),
                input = $input[0],
                n = input.name;
            if (n && !input.disabled && input.type == "image") {
                a.push({
                    name: n,
                    value: $input.val()
                });
                a.push({
                    name: n + ".x",
                    value: form.clk_x
                }, {
                    name: n + ".y",
                    value: form.clk_y
                })
            }
        }
        return a
    };
    $.fn.formSerialize = function (semantic) {
        return $.param(this.formToArray(semantic))
    };
    $.fn.fieldSerialize = function (successful) {
        var a = [];
        this.each(function () {
            var n = this.name;
            if (!n) {
                return
            }
            var v = $.fieldValue(this, successful);
            if (v && v.constructor == Array) {
                for (var i = 0, max = v.length; i < max; i++) {
                    a.push({
                        name: n,
                        value: v[i]
                    })
                }
            } else {
                if (v !== null && typeof v != "undefined") {
                    a.push({
                        name: this.name,
                        value: v
                    })
                }
            }
        });
        return $.param(a)
    };
    $.fn.fieldValue = function (successful) {
        for (var val = [], i = 0, max = this.length; i < max; i++) {
            var el = this[i];
            var v = $.fieldValue(el, successful);
            if (v === null || typeof v == "undefined" || (v.constructor == Array && !v.length)) {
                continue
            }
            v.constructor == Array ? $.merge(val, v) : val.push(v)
        }
        return val
    };
    $.fieldValue = function (el, successful) {
        var n = el.name,
            t = el.type,
            tag = el.tagName.toLowerCase();
        if (typeof successful == "undefined") {
            successful = true
        }
        if (successful && (!n || el.disabled || t == "reset" || t == "button" || (t == "checkbox" || t == "radio") && !el.checked || (t == "submit" || t == "image") && el.form && el.form.clk != el || tag == "select" && el.selectedIndex == -1)) {
            return null
        }
        if (tag == "select") {
            var index = el.selectedIndex;
            if (index < 0) {
                return null
            }
            var a = [],
                ops = el.options;
            var one = (t == "select-one");
            var max = (one ? index + 1 : ops.length);
            for (var i = (one ? index : 0); i < max; i++) {
                var op = ops[i];
                if (op.selected) {
                    var v = op.value;
                    if (!v) {
                        v = (op.attributes && op.attributes.value && !(op.attributes.value.specified)) ? op.text : op.value
                    }
                    if (one) {
                        return v
                    }
                    a.push(v)
                }
            }
            return a
        }
        return el.value
    };
    $.fn.clearForm = function () {
        return this.each(function () {
            $("input,select,textarea", this).clearFields()
        })
    };
    $.fn.clearFields = $.fn.clearInputs = function () {
        return this.each(function () {
            var t = this.type,
                tag = this.tagName.toLowerCase();
            if (t == "text" || t == "password" || tag == "textarea") {
                this.value = ""
            } else {
                if (t == "checkbox" || t == "radio") {
                    this.checked = false
                } else {
                    if (tag == "select") {
                        this.selectedIndex = -1
                    }
                }
            }
        })
    };
    $.fn.resetForm = function () {
        return this.each(function () {
            if (typeof this.reset == "function" || (typeof this.reset == "object" && !this.reset.nodeType)) {
                this.reset()
            }
        })
    };
    $.fn.enable = function (b) {
        if (b == undefined) {
            b = true
        }
        return this.each(function () {
            this.disabled = !b
        })
    };
    $.fn.selected = function (select) {
        if (select == undefined) {
            select = true
        }
        return this.each(function () {
            var t = this.type;
            if (t == "checkbox" || t == "radio") {
                this.checked = select
            } else {
                if (this.tagName.toLowerCase() == "option") {
                    var $sel = $(this).parent("select");
                    if (select && $sel[0] && $sel[0].type == "select-one") {
                        $sel.find("option").selected(false)
                    }
                    this.selected = select
                }
            }
        })
    };

    function log() {
        if ($.fn.ajaxSubmit.debug && window.console && window.console.log) {
            window.console.log("[jquery.form] " + Array.prototype.join.call(arguments, ""))
        }
    }
})(jQuery);
(function ($) {
    $.fn.galleryView = function (options) {
        var opts = $.extend($.fn.galleryView.defaults, options);
        var id;
        var iterator = 0;
        var gallery_width;
        var gallery_height;
        var frame_margin = 10;
        var strip_width;
        var wrapper_width;
        var item_count = 0;
        var slide_method;
        var img_path;
        var paused = false;
        var frame_caption_size = 20;
        var frame_margin_top = 5;
        var pointer_width = 2;
        var j_gallery;
        var j_filmstrip;
        var j_frames;
        var j_panels;
        var j_pointer;

        function showItem(i) {
            $("img.nav-next").unbind("click");
            $("img.nav-prev").unbind("click");
            j_frames.unbind("click");
            if (has_panels) {
                if (opts.fade_panels) {
                    j_panels.fadeOut(opts.transition_speed).eq(i % item_count).fadeIn(opts.transition_speed, function () {
                        if (!has_filmstrip) {
                            $("img.nav-prev").click(showPrevItem);
                            $("img.nav-next").click(showNextItem)
                        }
                    })
                }
            }
            if (has_filmstrip) {
                if (slide_method == "strip") {
                    j_filmstrip.stop();
                    var distance = getPos(j_frames[i]).left - (getPos(j_pointer[0]).left + 2);
                    var leftstr = (distance >= 0 ? "-=" : "+=") + Math.abs(distance) + "px";
                    j_filmstrip.animate({
                        left: leftstr
                    }, opts.transition_speed, opts.easing, function () {
                        if (i > item_count) {
                            i = i % item_count;
                            iterator = i;
                            j_filmstrip.css("left", "-" + ((opts.frame_width + frame_margin) * i) + "px")
                        } else {
                            if (i <= (item_count - strip_size)) {
                                i = (i % item_count) + item_count;
                                iterator = i;
                                j_filmstrip.css("left", "-" + ((opts.frame_width + frame_margin) * i) + "px")
                            }
                        } if (!opts.fade_panels) {
                            j_panels.hide().eq(i % item_count).show()
                        }
                        $("img.nav-prev").click(showPrevItem);
                        $("img.nav-next").click(showNextItem);
                        enableFrameClicking()
                    })
                } else {
                    if (slide_method == "pointer") {
                        j_pointer.stop();
                        var pos = getPos(j_frames[i]);
                        j_pointer.animate({
                            left: (pos.left - 2 + "px")
                        }, opts.transition_speed, opts.easing, function () {
                            if (!opts.fade_panels) {
                                j_panels.hide().eq(i % item_count).show()
                            }
                            $("img.nav-prev").click(showPrevItem);
                            $("img.nav-next").click(showNextItem);
                            enableFrameClicking()
                        })
                    }
                } if ($("a", j_frames[i])[0]) {
                    j_pointer.unbind("click").click(function () {
                        var a = $("a", j_frames[i]).eq(0);
                        if (a.attr("target") == "_blank") {
                            window.open(a.attr("href"))
                        } else {
                            location.href = a.attr("href")
                        }
                    })
                }
            }
        }

        function showNextItem() {
            $(document).stopTime("transition");
            if (++iterator == j_frames.length) {
                iterator = 0
            }
            showItem(iterator);
            $(document).everyTime(opts.transition_interval, "transition", function () {
                showNextItem()
            })
        }

        function showPrevItem() {
            $(document).stopTime("transition");
            if (--iterator < 0) {
                iterator = item_count - 1
            }
            showItem(iterator);
            $(document).everyTime(opts.transition_interval, "transition", function () {
                showNextItem()
            })
        }

        function getPos(el) {
            var left = 0,
                top = 0;
            var el_id = el.id;
            if (el.offsetParent) {
                do {
                    left += el.offsetLeft;
                    top += el.offsetTop
                } while (el = el.offsetParent)
            }
            if (el_id == id) {
                return {
                    left: left,
                    top: top
                }
            } else {
                var gPos = getPos(j_gallery[0]);
                var gLeft = gPos.left;
                var gTop = gPos.top;
                return {
                    left: left - gLeft,
                    top: top - gTop
                }
            }
        }

        function enableFrameClicking() {
            j_frames.each(function (i) {
                if ($("a", this).length == 0) {
                    $(this).click(function () {
                        $(document).stopTime("transition");
                        showItem(i);
                        iterator = i;
                        $(document).everyTime(opts.transition_interval, "transition", function () {
                            showNextItem()
                        })
                    })
                }
            })
        }

        function buildPanels() {
            if ($(".panel-overlay").length > 0) {
                j_panels.append('<div class="overlay"></div>')
            }
            if (!has_filmstrip) {
                $("<img />").addClass("nav-next").attr("src", img_path + opts.nav_theme + "/next.png").appendTo(j_gallery).css({
                    zIndex: "1100",
                    cursor: "pointer",
                    "margin-left": "10px",
                    display: "none"
                }).click(showNextItem);
                $("<img />").addClass("nav-prev").attr("src", img_path + opts.nav_theme + "/prev.png").appendTo(j_gallery).css({
                    zIndex: "1100",
                    cursor: "pointer",
                    top: ((opts.panel_height - 22) / 2) + "px",
                    display: "none"
                }).click(showPrevItem);
                $("<img />").addClass("nav-overlay").attr("src", img_path + opts.nav_theme + "/panel-nav-next.gif").appendTo(j_gallery).css({
                    position: "absolute",
                    zIndex: "1099",
                    top: ((opts.panel_height - 22) / 2) - 10 + "px",
                    right: "0",
                    display: "none"
                });
                $("<img />").addClass("nav-overlay").attr("src", img_path + opts.nav_theme + "/panel-nav-prev.gif").appendTo(j_gallery).css({
                    position: "absolute",
                    zIndex: "1099",
                    top: ((opts.panel_height - 22) / 2) - 10 + "px",
                    left: "0",
                    display: "none"
                })
            }
            j_panels.css({
                width: (opts.panel_width - parseInt(j_panels.css("paddingLeft").split("px")[0], 10) - parseInt(j_panels.css("paddingRight").split("px")[0], 10)) + "px",
                height: (opts.panel_height - parseInt(j_panels.css("paddingTop").split("px")[0], 10) - parseInt(j_panels.css("paddingBottom").split("px")[0], 10)) + "px",
                position: "absolute",
                top: (opts.filmstrip_position == "top" ? (opts.frame_height + frame_margin_top + (opts.show_captions ? frame_caption_size : frame_margin_top)) + "px" : "0px"),
                left: "0px",
                overflow: "hidden",
                background: "white",
                display: "none"
            });
            $(".panel-overlay", j_panels).css({
                position: "absolute",
                zIndex: "999",
                width: (opts.panel_width - 20) + "px",
                height: opts.overlay_height + "px",
                top: (opts.overlay_position == "top" ? "0" : opts.panel_height - opts.overlay_height + "px"),
                left: "0",
                padding: "0 10px",
                color: opts.overlay_text_color,
                fontSize: opts.overlay_font_size
            });
            $(".overlay", j_panels).css({
                position: "absolute",
                zIndex: "998",
                width: opts.panel_width + "px",
                height: opts.overlay_height + "px",
                top: (opts.overlay_position == "top" ? "0" : opts.panel_height - opts.overlay_height + "px"),
                left: "0",
                background: opts.overlay_color,
                opacity: opts.overlay_opacity
            });
            $(".panel iframe", j_panels).css({
                width: opts.panel_width + "px",
                height: (opts.panel_height - opts.overlay_height) + "px",
                border: "0"
            })
        }

        function buildFilmstrip() {
            j_filmstrip.wrap('<div class="strip_wrapper"></div>');
            if (slide_method == "strip") {
                j_frames.clone().appendTo(j_filmstrip);
                j_frames.clone().appendTo(j_filmstrip);
                j_frames = $("li", j_filmstrip)
            }
            if (opts.show_captions) {
                j_frames.append('<div class="caption"></div>').each(function (i) {
                    $(this).find(".caption").html($(this).find("img").attr("title"))
                })
            }
            j_filmstrip.css({
                listStyle: "none",
                margin: "0",
                padding: "0",
                width: strip_width + "px",
                position: "absolute",
                zIndex: "900",
                top: "0",
                left: "0",
                height: (opts.frame_height + 10) + "px",
                background: opts.background_color
            });
            j_frames.css({
                "float": "left",
                position: "relative",
                height: opts.frame_height + "px",
                zIndex: "901",
                marginTop: frame_margin_top + "px",
                marginBottom: "0px",
                marginRight: frame_margin + "px",
                padding: "0",
                cursor: "pointer"
            });
            $("img", j_frames).css({
                border: "none"
            });
            $(".strip_wrapper", j_gallery).css({
                position: "absolute",
                top: (opts.filmstrip_position == "top" ? "0px" : opts.panel_height + "px"),
                left: ((gallery_width - wrapper_width) / 2) + "px",
                width: wrapper_width + "px",
                height: (opts.frame_height + frame_margin_top + (opts.show_captions ? frame_caption_size : frame_margin_top)) + "px",
                overflow: "hidden"
            });
            $(".caption", j_gallery).css({
                position: "absolute",
                top: opts.frame_height + "px",
                left: "0",
                margin: "0",
                width: opts.frame_width + "px",
                padding: "0",
                color: opts.caption_text_color,
                textAlign: "center",
                fontSize: "11px",
                height: frame_caption_size + "px",
                lineHeight: frame_caption_size + "px"
            });
            var pointer = $("<div></div>");
            pointer.attr("id", "pointer").appendTo(j_gallery).css({
                position: "absolute",
                zIndex: "1000",
                cursor: "pointer",
                top: getPos(j_frames[0]).top - (pointer_width / 2) + "px",
                left: getPos(j_frames[0]).left - (pointer_width / 2) + "px",
                height: opts.frame_height - pointer_width + "px",
                width: opts.frame_width - pointer_width + "px",
                border: (has_panels ? pointer_width + "px solid " + (opts.nav_theme == "dark" ? "black" : "white") : "none")
            });
            j_pointer = $("#pointer", j_gallery);
            if (has_panels) {
                var pointerArrow = $("<img />");
                pointerArrow.attr("src", img_path + opts.nav_theme + "/pointer" + (opts.filmstrip_position == "top" ? "-down" : "") + ".png").appendTo($("#pointer")).css({
                    position: "absolute",
                    zIndex: "1001",
                    top: (opts.filmstrip_position == "bottom" ? "-" + (10 + pointer_width) + "px" : opts.frame_height + "px"),
                    left: ((opts.frame_width / 2) - 10) + "px"
                })
            }
            if (slide_method == "strip") {
                j_filmstrip.css("left", "-" + ((opts.frame_width + frame_margin) * item_count) + "px");
                iterator = item_count
            }
            if ($("a", j_frames[iterator])[0]) {
                j_pointer.click(function () {
                    var a = $("a", j_frames[iterator]).eq(0);
                    if (a.attr("target") == "_blank") {
                        window.open(a.attr("href"))
                    } else {
                        location.href = a.attr("href")
                    }
                })
            }
            $("<img />").addClass("nav-next").attr("src", img_path + opts.nav_theme + "/next.png").appendTo(j_gallery).css({
                position: "absolute",
                cursor: "pointer",
                top: (opts.filmstrip_position == "top" ? 0 : opts.panel_height) + frame_margin_top + ((opts.frame_height - 22) / 2) + "px",
                right: (gallery_width / 2) - (wrapper_width / 2) - 10 - 22 + "px"
            }).click(showNextItem);
            $("<img />").addClass("nav-prev").attr("src", img_path + opts.nav_theme + "/prev.png").appendTo(j_gallery).css({
                position: "absolute",
                cursor: "pointer",
                top: (opts.filmstrip_position == "top" ? 0 : opts.panel_height) + frame_margin_top + ((opts.frame_height - 22) / 2) + "px",
                left: (gallery_width / 2) - (wrapper_width / 2) - 10 - 22 + "px"
            }).click(showPrevItem)
        }

        function mouseIsOverPanels(x, y) {
            var pos = getPos(j_gallery[0]);
            var top = pos.top;
            var left = pos.left;
            return x > left && x < left + opts.panel_width && y > top && y < top + opts.panel_height
        }
        return this.each(function () {
            j_gallery = $(this);
            $("script").each(function (i) {
                var s = $(this);
                if (s.attr("src") && s.attr("src").match(/jquery\.galleryview/)) {
                    img_path = s.attr("src").split("jquery.galleryview")[0] + "themes/"
                }
            });
            j_gallery.css("visibility", "hidden");
            j_filmstrip = $(".filmstrip", j_gallery);
            j_frames = $("li", j_filmstrip);
            j_panels = $(".panel", j_gallery);
            id = j_gallery.attr("id");
            has_panels = j_panels.length > 0;
            has_filmstrip = j_frames.length > 0;
            if (!has_panels) {
                opts.panel_height = 0
            }
            item_count = has_panels ? j_panels.length : j_frames.length;
            strip_size = has_panels ? Math.floor((opts.panel_width - 64) / (opts.frame_width + frame_margin)) : Math.min(item_count, opts.filmstrip_size);
            if (strip_size >= item_count) {
                slide_method = "pointer";
                strip_size = item_count
            } else {
                slide_method = "strip"
            }
            gallery_width = has_panels ? opts.panel_width : (strip_size * (opts.frame_width + frame_margin)) - frame_margin + 64;
            gallery_height = (has_panels ? opts.panel_height : 0) + (has_filmstrip ? opts.frame_height + frame_margin_top + (opts.show_captions ? frame_caption_size : frame_margin_top) : 0);
            if (slide_method == "pointer") {
                strip_width = (opts.frame_width * item_count) + (frame_margin * (item_count))
            } else {
                strip_width = (opts.frame_width * item_count * 3) + (frame_margin * (item_count * 3))
            }
            wrapper_width = ((strip_size * opts.frame_width) + ((strip_size - 1) * frame_margin));
            j_gallery.css({
                position: "relative",
                margin: "0",
                background: opts.background_color,
                border: opts.border,
                width: gallery_width + "px",
                height: gallery_height + "px"
            });
            if (has_filmstrip) {
                buildFilmstrip()
            }
            if (has_panels) {
                buildPanels()
            }
            if (has_filmstrip) {
                enableFrameClicking()
            }
            $().mousemove(function (e) {
                if (mouseIsOverPanels(e.pageX, e.pageY)) {
                    if (opts.pause_on_hover) {
                        $(document).oneTime(500, "animation_pause", function () {
                            $(document).stopTime("transition");
                            paused = true
                        })
                    }
                    if (has_panels && !has_filmstrip) {
                        $(".nav-overlay").fadeIn("fast");
                        $(".nav-next").fadeIn("fast");
                        $(".nav-prev").fadeIn("fast")
                    }
                } else {
                    if (opts.pause_on_hover) {
                        $(document).stopTime("animation_pause");
                        if (paused) {
                            $(document).everyTime(opts.transition_interval, "transition", function () {
                                showNextItem()
                            });
                            paused = false
                        }
                    }
                    if (has_panels && !has_filmstrip) {
                        $(".nav-overlay").fadeOut("fast");
                        $(".nav-next").fadeOut("fast");
                        $(".nav-prev").fadeOut("fast")
                    }
                }
            });
            j_panels.eq(0).show();
            if (item_count > 1) {
                $(document).everyTime(opts.transition_interval, "transition", function () {
                    showNextItem()
                })
            }
            j_gallery.css("visibility", "visible")
        })
    };
    $.fn.galleryView.defaults = {
        panel_width: 400,
        panel_height: 300,
        frame_width: 80,
        frame_height: 80,
        filmstrip_size: 11,
        overlay_height: 80,
        overlay_font_size: "",
        transition_speed: 400,
        transition_interval: 6000,
        overlay_opacity: 0.7,
        overlay_color: "black",
        background_color: "transparent",
        overlay_text_color: "white",
        caption_text_color: "#333",
        border: "none",
        nav_theme: "light",
        easing: "swing",
        filmstrip_position: "bottom",
        overlay_position: "bottom",
        show_captions: true,
        fade_panels: true,
        pause_on_hover: true
    }
})(jQuery);
(function ($) {
    $.fn.editable = function (target, options) {
        if ("disable" == target) {
            $(this).data("disabled.editable", true);
            return
        }
        if ("enable" == target) {
            $(this).data("disabled.editable", false);
            return
        }
        if ("destroy" == target) {
            $(this).unbind($(this).data("event.editable")).removeData("disabled.editable").removeData("event.editable");
            return
        }
        var settings = $.extend({}, $.fn.editable.defaults, {
            target: target
        }, options);
        var plugin = $.editable.types[settings.type].plugin || function () {};
        var submit = $.editable.types[settings.type].submit || function () {};
        var buttons = $.editable.types[settings.type].buttons || $.editable.types.defaults.buttons;
        var content = $.editable.types[settings.type].content || $.editable.types.defaults.content;
        var element = $.editable.types[settings.type].element || $.editable.types.defaults.element;
        var reset = $.editable.types[settings.type].reset || $.editable.types.defaults.reset;
        var callback = settings.callback || function () {};
        var onedit = settings.onedit || function () {};
        var onsubmit = settings.onsubmit || function () {};
        var onreset = settings.onreset || function () {};
        var onerror = settings.onerror || reset;
        if (settings.tooltip) {
            $(this).attr("title", settings.tooltip)
        }
        settings.autowidth = "auto" == settings.width;
        settings.autoheight = "auto" == settings.height;
        return this.each(function () {
            var self = this;
            var savedwidth = $(self).width();
            var savedheight = $(self).height();
            $(this).data("event.editable", settings.event);
            if (!$.trim($(this).html())) {
                $(this).html(settings.placeholder)
            }
            $(this).bind(settings.event, function (e) {
                if (true === $(this).data("disabled.editable")) {
                    return
                }
                if (self.editing) {
                    return
                }
                if (false === onedit.apply(this, [settings, self])) {
                    return
                }
                e.preventDefault();
                e.stopPropagation();
                if (settings.tooltip) {
                    $(self).removeAttr("title")
                }
                if (0 == $(self).width()) {
                    settings.width = savedwidth;
                    settings.height = savedheight
                } else {
                    if (settings.width != "none") {
                        settings.width = settings.autowidth ? $(self).width() : settings.width
                    }
                    if (settings.height != "none") {
                        settings.height = settings.autoheight ? $(self).height() : settings.height
                    }
                } if ($(this).html().toLowerCase().replace(/(;|")/g, "") == settings.placeholder.toLowerCase().replace(/(;|")/g, "")) {
                    $(this).html("")
                }
                self.editing = true;
                self.revert = $(self).html();
                $(self).html("");
                var form = $("<form />");
                if (settings.cssclass) {
                    if ("inherit" == settings.cssclass) {
                        form.attr("class", $(self).attr("class"))
                    } else {
                        form.attr("class", settings.cssclass)
                    }
                }
                if (settings.style) {
                    if ("inherit" == settings.style) {
                        form.attr("style", $(self).attr("style"));
                        form.css("display", $(self).css("display"))
                    } else {
                        form.attr("style", settings.style)
                    }
                }
                var input = element.apply(form, [settings, self]);
                var input_content;
                if (settings.loadurl) {
                    var t = setTimeout(function () {
                        input.disabled = true;
                        content.apply(form, [settings.loadtext, settings, self])
                    }, 100);
                    var loaddata = {};
                    loaddata[settings.id] = self.id;
                    if ($.isFunction(settings.loaddata)) {
                        $.extend(loaddata, settings.loaddata.apply(self, [self.revert, settings]))
                    } else {
                        $.extend(loaddata, settings.loaddata)
                    }
                    $.ajax({
                        type: settings.loadtype,
                        url: settings.loadurl,
                        data: loaddata,
                        async: false,
                        success: function (result) {
                            window.clearTimeout(t);
                            input_content = result;
                            input.disabled = false
                        }
                    })
                } else {
                    if (settings.data) {
                        input_content = settings.data;
                        if ($.isFunction(settings.data)) {
                            input_content = settings.data.apply(self, [self.revert, settings])
                        }
                    } else {
                        input_content = self.revert
                    }
                }
                content.apply(form, [input_content, settings, self]);
                input.attr("name", settings.name);
                buttons.apply(form, [settings, self]);
                $(self).append(form);
                plugin.apply(form, [settings, self]);
                $(":input:visible:enabled:first", form).focus();
                if (settings.select) {
                    input.select()
                }
                input.keydown(function (e) {
                    if (e.keyCode == 27) {
                        e.preventDefault();
                        reset.apply(form, [settings, self])
                    }
                });
                var t;
                if ("cancel" == settings.onblur) {
                    input.blur(function (e) {
                        t = setTimeout(function () {
                            reset.apply(form, [settings, self])
                        }, 500)
                    })
                } else {
                    if ("submit" == settings.onblur) {
                        input.blur(function (e) {
                            t = setTimeout(function () {
                                form.submit()
                            }, 200)
                        })
                    } else {
                        if ($.isFunction(settings.onblur)) {
                            input.blur(function (e) {
                                settings.onblur.apply(self, [input.val(), settings])
                            })
                        } else {
                            input.blur(function (e) {})
                        }
                    }
                }
                form.submit(function (e) {
                    if (t) {
                        clearTimeout(t)
                    }
                    e.preventDefault();
                    if (false !== onsubmit.apply(form, [settings, self])) {
                        if (false !== submit.apply(form, [settings, self])) {
                            if ($.isFunction(settings.target)) {
                                var str = settings.target.apply(self, [input.val(), settings]);
                                $(self).html(str);
                                self.editing = false;
                                callback.apply(self, [self.innerHTML, settings]);
                                if (!$.trim($(self).html())) {
                                    $(self).html(settings.placeholder)
                                }
                            } else {
                                var submitdata = {};
                                submitdata[settings.name] = input.val();
                                submitdata[settings.id] = self.id;
                                if ($.isFunction(settings.submitdata)) {
                                    $.extend(submitdata, settings.submitdata.apply(self, [self.revert, settings]))
                                } else {
                                    $.extend(submitdata, settings.submitdata)
                                } if ("PUT" == settings.method) {
                                    submitdata._method = "put"
                                }
                                $(self).html(settings.indicator);
                                var ajaxoptions = {
                                    type: "POST",
                                    data: submitdata,
                                    dataType: "html",
                                    url: settings.target,
                                    success: function (result, status) {
                                        if (ajaxoptions.dataType == "html") {
                                            $(self).html(result)
                                        }
                                        self.editing = false;
                                        callback.apply(self, [result, settings]);
                                        if (!$.trim($(self).html())) {
                                            $(self).html(settings.placeholder)
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        onerror.apply(form, [settings, self, xhr])
                                    }
                                };
                                $.extend(ajaxoptions, settings.ajaxoptions);
                                $.ajax(ajaxoptions)
                            }
                        }
                    }
                    $(self).attr("title", settings.tooltip);
                    return false
                })
            });
            this.reset = function (form) {
                if (this.editing) {
                    if (false !== onreset.apply(form, [settings, self])) {
                        $(self).html(self.revert);
                        self.editing = false;
                        if (!$.trim($(self).html())) {
                            $(self).html(settings.placeholder)
                        }
                        if (settings.tooltip) {
                            $(self).attr("title", settings.tooltip)
                        }
                    }
                }
            }
        })
    };
    $.editable = {
        types: {
            defaults: {
                element: function (settings, original) {
                    var input = $('<input type="hidden"></input>');
                    $(this).append(input);
                    return (input)
                },
                content: function (string, settings, original) {
                    $(":input:first", this).val(string)
                },
                reset: function (settings, original) {
                    original.reset(this)
                },
                buttons: function (settings, original) {
                    var form = this;
                    if (settings.submit) {
                        if (settings.submit.match(/>$/)) {
                            var submit = $(settings.submit).click(function () {
                                if (submit.attr("type") != "submit") {
                                    form.submit()
                                }
                            })
                        } else {
                            var submit = $('<button type="submit" />');
                            submit.html(settings.submit)
                        }
                        $(this).append(submit)
                    }
                    if (settings.cancel) {
                        if (settings.cancel.match(/>$/)) {
                            var cancel = $(settings.cancel)
                        } else {
                            var cancel = $('<button type="cancel" />');
                            cancel.html(settings.cancel)
                        }
                        $(this).append(cancel);
                        $(cancel).click(function (event) {
                            if ($.isFunction($.editable.types[settings.type].reset)) {
                                var reset = $.editable.types[settings.type].reset
                            } else {
                                var reset = $.editable.types.defaults.reset
                            }
                            reset.apply(form, [settings, original]);
                            return false
                        })
                    }
                }
            },
            text: {
                element: function (settings, original) {
                    var input = $("<input />");
                    if (settings.width != "none") {
                        input.width(settings.width)
                    }
                    if (settings.height != "none") {
                        input.height(settings.height)
                    }
                    input.attr("autocomplete", "off");
                    $(this).append(input);
                    return (input)
                }
            },
            textarea: {
                element: function (settings, original) {
                    var textarea = $("<textarea />");
                    if (settings.rows) {
                        textarea.attr("rows", settings.rows)
                    } else {
                        if (settings.height != "none") {
                            textarea.height(settings.height)
                        }
                    } if (settings.cols) {
                        textarea.attr("cols", settings.cols)
                    } else {
                        if (settings.width != "none") {
                            textarea.width(settings.width)
                        }
                    }
                    $(this).append(textarea);
                    return (textarea)
                }
            },
            select: {
                element: function (settings, original) {
                    var select = $("<select />");
                    $(this).append(select);
                    return (select)
                },
                content: function (data, settings, original) {
                    if (String == data.constructor) {
                        eval("var json = " + data)
                    } else {
                        var json = data
                    }
                    for (var key in json) {
                        if (!json.hasOwnProperty(key)) {
                            continue
                        }
                        if ("selected" == key) {
                            continue
                        }
                        var option = $("<option />").val(key).append(json[key]);
                        $("select", this).append(option)
                    }
                    $("select", this).children().each(function () {
                        if ($(this).val() == json.selected || $(this).text() == $.trim(original.revert)) {
                            $(this).attr("selected", "selected")
                        }
                    })
                }
            }
        },
        addInputType: function (name, input) {
            $.editable.types[name] = input
        }
    };
    $.fn.editable.defaults = {
        name: "value",
        id: "id",
        type: "text",
        width: "auto",
        height: "auto",
        event: "click.editable",
        onblur: "cancel",
        loadtype: "GET",
        loadtext: "Loading...",
        placeholder: "Click to edit",
        loaddata: {},
        submitdata: {},
        ajaxoptions: {}
    }
})(jQuery);
(function ($) {
    $.jGrowl = function (m, o) {
        if ($("#jGrowl").size() == 0) {
            $('<div id="jGrowl"></div>').addClass($.jGrowl.defaults.position).appendTo("body")
        }
        $("#jGrowl").jGrowl(m, o)
    };
    $.fn.jGrowl = function (m, o) {
        if ($.isFunction(this.each)) {
            var args = arguments;
            return this.each(function () {
                var self = this;
                if ($(this).data("jGrowl.instance") == undefined) {
                    $(this).data("jGrowl.instance", new $.fn.jGrowl());
                    $(this).data("jGrowl.instance").startup(this)
                }
                if ($.isFunction($(this).data("jGrowl.instance")[m])) {
                    $(this).data("jGrowl.instance")[m].apply($(this).data("jGrowl.instance"), $.makeArray(args).slice(1))
                } else {
                    $(this).data("jGrowl.instance").create(m, o)
                }
            })
        }
    };
    $.extend($.fn.jGrowl.prototype, {
        defaults: {
            pool: 0,
            header: "",
            group: "",
            sticky: false,
            position: "top-right",
            glue: "after",
            theme: "default",
            corners: "10px",
            check: 250,
            life: 3000,
            speed: "normal",
            easing: "swing",
            closer: true,
            closeTemplate: "&times;",
            closerTemplate: "<div>[ close all ]</div>",
            log: function (e, m, o) {},
            beforeOpen: function (e, m, o) {},
            open: function (e, m, o) {},
            beforeClose: function (e, m, o) {},
            close: function (e, m, o) {},
            animateOpen: {
                opacity: "show"
            },
            animateClose: {
                opacity: "hide"
            }
        },
        notifications: [],
        element: null,
        interval: null,
        create: function (message, o) {
            var o = $.extend({}, this.defaults, o);
            this.notifications[this.notifications.length] = {
                message: message,
                options: o
            };
            o.log.apply(this.element, [this.element, message, o])
        },
        render: function (notification) {
            var self = this;
            var message = notification.message;
            var o = notification.options;
            var notification = $('<div class="jGrowl-notification' + ((o.group != undefined && o.group != "") ? " " + o.group : "") + '"><div class="close">' + o.closeTemplate + '</div><div class="header">' + o.header + '</div><div class="message">' + message + "</div></div>").data("jGrowl", o).addClass(o.theme).children("div.close").bind("click.jGrowl", function () {
                $(this).parent().trigger("jGrowl.close")
            }).parent();
            (o.glue == "after") ? $("div.jGrowl-notification:last", this.element).after(notification) : $("div.jGrowl-notification:first", this.element).before(notification);
            $(notification).bind("mouseover.jGrowl", function () {
                $(this).data("jGrowl").pause = true
            }).bind("mouseout.jGrowl", function () {
                $(this).data("jGrowl").pause = false
            }).bind("jGrowl.beforeOpen", function () {
                o.beforeOpen.apply(self.element, [self.element, message, o])
            }).bind("jGrowl.open", function () {
                o.open.apply(self.element, [self.element, message, o])
            }).bind("jGrowl.beforeClose", function () {
                o.beforeClose.apply(self.element, [self.element, message, o])
            }).bind("jGrowl.close", function () {
                $(this).trigger("jGrowl.beforeClose").animate(o.animateClose, o.speed, o.easing, function () {
                    $(this).remove();
                    o.close.apply(self.element, [self.element, message, o])
                })
            }).trigger("jGrowl.beforeOpen").animate(o.animateOpen, o.speed, o.easing, function () {
                $(this).data("jGrowl").created = new Date()
            }).trigger("jGrowl.open");
            if ($.fn.corner != undefined) {
                $(notification).corner(o.corners)
            }
            if ($("div.jGrowl-notification:parent", this.element).size() > 1 && $("div.jGrowl-closer", this.element).size() == 0 && this.defaults.closer != false) {
                $(this.defaults.closerTemplate).addClass("jGrowl-closer").addClass(this.defaults.theme).appendTo(this.element).animate(this.defaults.animateOpen, this.defaults.speed, this.defaults.easing).bind("click.jGrowl", function () {
                    $(this).siblings().children("div.close").trigger("click.jGrowl");
                    if ($.isFunction(self.defaults.closer)) {
                        self.defaults.closer.apply($(this).parent()[0], [$(this).parent()[0]])
                    }
                })
            }
        },
        update: function () {
            $(this.element).find("div.jGrowl-notification:parent").each(function () {
                if ($(this).data("jGrowl") != undefined && $(this).data("jGrowl").created != undefined && ($(this).data("jGrowl").created.getTime() + $(this).data("jGrowl").life) < (new Date()).getTime() && $(this).data("jGrowl").sticky != true && ($(this).data("jGrowl").pause == undefined || $(this).data("jGrowl").pause != true)) {
                    $(this).trigger("jGrowl.close")
                }
            });
            if (this.notifications.length > 0 && (this.defaults.pool == 0 || $(this.element).find("div.jGrowl-notification:parent").size() < this.defaults.pool)) {
                this.render(this.notifications.shift())
            }
            if ($(this.element).find("div.jGrowl-notification:parent").size() < 2) {
                $(this.element).find("div.jGrowl-closer").animate(this.defaults.animateClose, this.defaults.speed, this.defaults.easing, function () {
                    $(this).remove()
                })
            }
        },
        startup: function (e) {
            this.element = $(e).addClass("jGrowl").append('<div class="jGrowl-notification"></div>');
            this.interval = setInterval(function () {
                jQuery(e).data("jGrowl.instance").update()
            }, this.defaults.check);
            if ($.browser.msie && parseInt($.browser.version) < 7 && !window.XMLHttpRequest) {
                $(this.element).addClass("ie6")
            }
        },
        shutdown: function () {
            $(this.element).removeClass("jGrowl").find("div.jGrowl-notification").remove();
            clearInterval(this.interval)
        }
    });
    $.jGrowl.defaults = $.fn.jGrowl.prototype.defaults
})(jQuery);
eval(function (p, a, c, k, e, r) {
    e = function (c) {
        return (c < a ? "" : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
    };
    if (!"".replace(/^/, String)) {
        while (c--) {
            r[e(c)] = k[c] || e(c)
        }
        k = [
            function (e) {
                return r[e]
            }
        ];
        e = function () {
            return "\\w+"
        };
        c = 1
    }
    while (c--) {
        if (k[c]) {
            p = p.replace(new RegExp("\\b" + e(c) + "\\b", "g"), k[c])
        }
    }
    return p
}(';(3(){$.1w.1M=3(a){6 2.P(3(){4("1k"!=2.1l.1d()){6}1N l(2,a)})};5 h={2q:"3k",2r:"3l",2s:"3m",1O:"",1x:"",1y:B,1z:C,12:W,1P:B,1e:",",3n:W,3o:W,3p:W,3q:W,3r:W,3s:W,1Q:C};$.1M=3(c,d){4(c.1l.1d()!="1k")6;2.r=$.14({},h,d||{});2.Q=$(c);2.H=2.Q.1A().K("1m");2.m=2.Q.3t("<1R>").3u().R().s("1S").s(2.r.2q);2.7=$("<7 1n=\'y\' />").O(2.m).z("2t","2u").z("1B","").z("15",2.Q.z("15")+2.r.2r);2.L=$("<7 1n=\'L\' />").O(2.m).z("2t","2u").z("1B",2.r.1O).z("15",2.Q.z("15")+2.r.2s);2.16=$("<1R />").O(2.m).s("16");2.o=$("<1R />").O(2.m).s("S-m");2.1T();2.S=$("<2v />").O(2.o);5 e=2;5 f=[];2.H.P(3(){5 a=$.M($(2).y());4(e.r.1Q){f.1o($("<1U />").O(e.S).1C("<1p>"+a+"</1p>").s("D").17("1p").3v())}A{$("<1U />").O(e.S).1C("<1p>"+a+"</1p>").s("D")}});2.x=2.S.1A();4(f.t){f=f.3w(3(a,b){6 a-b});5 g=f[f.t-1]}2.1V=2.x.1W();2.o.s("T");4($.2w.3x){2.m.I({3y:"3z",3A:"0",3B:"0"})}2.12=("3"==3C(2.r.12))?2.r.12:2.12;2.1q=W;2.E=2.Q.z("E");5 e=2;2.m.p("q:U","u");2.1f="3D";4((2.r.1Q)&&(2.o.3E()<g)){2.1f="3F"}2.X("3G");2.1X()};5 l=$.1M;l.1w=l.3H={};l.1w.14=l.14=$.14;l.1w.14({1X:3(){5 a=2;2.16.w("u",3(e){4(!a.m.p("q:F")){a.m.p("q:F",e.1g)}});2.7.w("u",3(e){4(!a.m.p("q:F")){a.m.p("q:F",e.1g)}});2.m.w("u",3(e){4(!a.m.p("q:F")){a.m.p("q:F",e.1g)}});2.16.w("u",3(){4(a.7.z("1Y")){a.7.z("1Y",B)}a.m.p("q:U","u");a.K();a.2x()});2.x.w("2y",3(e){4("3I"==e.Y.3J.1d()){a.1D(e.Y)}A{a.1D($(e.Y).R())}});2.x.w("u",3(e){a.1Z($(e.Y))});2.7.w("2z",3(e){a.m.p("q:U","1E");a.2A(e)});2.7.w("3K",3(e){4(l.V.20==e.1h){e.21()}4(l.V.22==e.1h)e.21()});$(23).w("u",3(e){4((a.16.18(0)==e.Y)||(a.7.18(0)==e.Y))6;a.19()});2.1z();2.2B();2.7.w("u",3(e){a.m.p("q:U","u");a.16.2C("u")});2.m.w("u",3(){a.m.p("q:U","u")});2.7.w("3L",3(e){4(9==e.1h){e.21()}});2.m.w("2z",3(e){5 k=e.1h;Z(1E 3M l.V){4(l.V[1E]==k){6}}a.m.p("q:U","1E")});2.7.w("u",3(){a.m.p("q:U","u")});2.16.w("u",3(e){4(!a.m.p("q:F")){a.m.p("q:F",e.1g)}});2.7.w("u",3(e){4(!a.m.p("q:F")){a.m.p("q:F",e.1g)}});2.m.w("u",3(e){4(!a.m.p("q:F")){a.m.p("q:F",e.1g)}});2.X("1X")},1F:3(){6 2.24("7")},2D:3(){6 2.25("7")},3N:3(){6 2.24("L")},3O:3(){6 2.25("L")},24:3(a){a=2[a];4(!2.E)6 $.M(a.n());5 b=a.n().2E(2.r.1e);5 c=[];Z(5 i=0,J=b.t;i<J;++i){c.1o($.M(b[i]))}c=l.26(c);6 c},25:3(a){a=2[a];4(!2.E)6 $.M(a.n());6 $.M(a.n().2E(2.r.1e).2F())},2x:3(){4(2.2G()){2.19();2.7.28()}A{2.1G();2.7.29();4(2.7.n().t){2.2a(2.7.18(0),0,2.7.n().t)}}},2G:3(){6 2.o.1r("D")},1G:3(){4(!2.x.K(".D").t)6;2.o.G("T").s("D");2.m.I("1i","1H");2.o.I("1i","1H");2.1I();5 a=2.o.1a();5 b=2.m.1a();5 c=2H(2.m.p("q:F"))+b+a;5 d=$(3P).1a()+$(23).1b();4(c>d){2.2b(C)}A{2.2b(B)}4(""==$.M(2.7.n())){2.2I();2.o.1b(0)}A{2.2J()}2.X("1G")},19:3(){4(2.o.1r("T"))6;2.o.G("D").s("T");2.m.I("1i","0");2.o.I("1i","1H");2.X("19")},2c:3(){5 a=2.1V;6 a*2.2d()},2e:3(){5 a=2.2f();4(2.2c()>a)2.o.I(2.1f,"2g");A 2.o.I(2.1f,"L")},1D:3(a){4((l.V.2h==2.1q)||(l.V.2i==2.1q))6;2.x.G("N");$(a).s("N")},1s:3(a,b,c){5 d=2.7.n();5 v="";4(2.E){v=2.1F();4(b)v.2F();v.1o($.M(a));v=l.26(v);v=v.2K(2.r.1e)+2.r.1e}A{v=$.M(a)}2.7.n(v);2.2j(a);2.K();4(c)2.19();2.7.G("1t");4(2.E)2.7.29();4(2.7.n()!=d)2.X("2L")},2j:3(a){5 b=B;a=$.M(a);5 c=2.L.n();4(!2.E){Z(5 i=0,J=2.H.t;i<J;++i){4(a==2.H.11(i).y()){2.L.n(2.H.11(i).n());b=C;1j}}}A{5 d=2.1F();5 e=[];Z(5 i=0,J=d.t;i<J;++i){Z(5 j=0,2M=2.H.t;j<2M;++j){4(d[i]==2.H.11(j).y()){e.1o(2.H.11(j).n())}}}4(e.t){b=C;2.L.n(e.2K(2.r.1e))}}4(!b){2.L.n(2.r.1O)}4(c!=2.L.n())2.X("2N");2.Q.n(2.L.n());2.Q.2C("2N")},1Z:3(a){2.1s(a.y(),C,C);2.2k()},K:3(){4("2O"==2.m.p("q:2l")){5 c=2;2.x.3Q();2.H=2.Q.1A().K("1m");2.H.P(3(){5 a=$.M($(2).y());$("<1U />").O(c.S).y(a).s("D")});2.x=2.S.1A();2.x.w("2y",3(e){c.1D(e.Y)});2.x.w("u",3(e){c.1Z($(e.Y))});c.m.p("q:2l","")}5 d=2.7.n();5 c=2;2.x.P(3(){5 a=$(2);5 b=a.y();4(c.12.2P(c,c.2D(),b,c.1F())){a.G("T").s("D")}A{a.G("D").s("T")}});2.2e();2.1I()},12:3(a,b,c){4("u"==2.m.p("q:U")){6 C}4(!2.E){6 b.1J().3R(a.1J())==0}A{Z(5 i=0,J=c.t;i<J;++i){4(b==c[i]){6 B}}6 b.1J().3S(a.1J())==0}},2f:3(){5 a=2H(2.o.I("3T"),10);4(3U(a)){a=2.1V*10}6 a},1I:3(){5 a=2.2c();5 b=2.2f();5 c=2.o.1a();4(a<c){2.o.1a(a);6 a}A 4(a>c){2.o.1a(2Q.2R(b,a));6 2Q.2R(b,a)}},1c:3(){6 2.x.K(".N")},2A:3(e){2.1q=e.1h;5 k=l.V;3V(e.1h){1u k.20:1u k.22:2.1s(2.1c().y(),C,C);4(!2.E)2.7.28();1j;1u k.2h:2.2S();1j;1u k.2i:2.2T();1j;1u k.2U:2.19();1j;3W:2.2V();1j}},2d:3(){6 2.x.K(".D").t},2V:3(){2.K();4(2.2d()){2.1G();2.2e();2.1I()}A{2.19()}2.2j(2.7.n());2.X("2L")},2I:3(){2.x.G("N").K(".D:11(0)").s("N");2.1y()},2J:3(){2.x.G("N");5 b=$.M(2.7.n());2W{2.x.P(3(){5 a=$(2);4(a.y()==b){a.s("N");2X.o.1b(0);2X.2m()}})}2Y(e){}},2S:3(){5 a=2.1c().2Z();30(a.1r("T")&&a.t){a=a.2Z()}4(a.t){2.x.G("N");a.s("N");2.2m()}},2m:3(){4("2g"!=2.o.I(2.1f))6;5 a=2.2n()+1;5 b=2.x.1W()*a-2.o.1a();4($.2w.3X)b+=a;4(2.o.1b()<b)2.o.1b(b)},2T:3(){5 a=2.1c().31();30(a.t&&a.1r("T"))a=a.31();4(a.t){2.1c().G("N");a.s("N");2.32()}},2n:3(){6 $.3Y(2.1c().18(0),2.x.K(".D").18())},32:3(){4("2g"!=2.o.I(2.1f))6;5 a=2.2n()*2.x.1W();4(2.o.1b()>a){2.o.1b(a)}},2B:3(){4(!2.r.1x.t)6;5 a=2;2.7.w("29",3(){a.2k()}).w("28",3(){a.35()});4(""==2.7.n()){2.7.s("1t").n(2.r.1x)}},2k:3(){4(2.7.1r("1t")){2.7.G("1t").n("")}},35:3(){4(""==2.7.n()){2.7.s("1t").n(2.r.1x)}},1z:3(){4(!2.r.1z)6;5 a=2;2W{2.H.P(3(){4($(2).z("1v")){a.1s($(2).y(),B,C);3Z 1N 41();}})}2Y(e){6}a.1s(2.H.11(0).y(),B,B)},1y:3(){4(!2.r.1y||(l.V.36==2.1q)||2.E)6;5 a=2.7.n();5 b=2.1c().y();2.7.n(b);2.2a(2.7.18(0),a.t,b.t)},2a:3(a,b,c){4(a.37){5 d=a.37();d.42(C);d.43("39",b);d.44("39",c);d.3a()}A 4(a.3b){a.3b(b,c)}A{4(a.3c){a.3c=b;a.45=c}}},1T:3(){4(2.r.1P)2.o.s("S-m-3d");A 2.o.G("S-m-3d")},2b:3(a){2.r.1P=a;2.1T()},X:3(a){4(!$.47(2.r[a+"3e"]))6;2.r[a+"3e"].2P(2)}});l.14({V:{2i:38,2h:40,48:46,22:9,20:13,2U:27,49:4a,4b:33,4c:34,36:8},3f:3(a){5 b=$("#3f");b.1C(b.1C()+a+"<4d />")},3g:3(a){5 b=$("<3a />").O(a.1K).z({15:a.15,2o:a.2o,4e:"1"});4(a.E)b.z("E",C);5 c=a.p;5 d=B;Z(5 i=0,J=c.t;i<J;++i){d=c[i].1v||B;$("<1m />").O(b).z("1B",c[i].1B).y(c[i].y).z("1v",d)}6 b.18(0)},3h:3(b){5 c={15:"",2o:"",p:[],E:B,1K:$(23),1L:"",2p:{}};b=$.14({},c,b||{});4(b.1L){6 $.4f(b.1L,b.2p,3(a){3i b.1L;3i b.2p;b.p=a;6 l.3h(b)})}b.1K=$(b.1K);5 d=l.3g(b);6 1N l(d,b)},4g:3(b){b=$(b);b.P(3(){4("1k"!=2.1l.1d()){6}5 a=$(2);4(!a.R().3j(".1S")){6}})},4h:3(b){b=$(b);b.P(3(){4("1k"!=2.1l.1d()){6}5 a=$(2);4(!a.R().3j(".1S")){6}a.R().17("7[1n=\'y\']").z("1Y",B)})},4i:3(f){f=$(f);f.P(3(){4("1k"!=2.1l.1d()){6}5 a=$(2);5 b=a.R();5 c=b.17("7[1n=\'y\']");5 d=b.17("2v").R();d.G("D").s("T");b.I("1i","0");d.I("1i","1H");c.n("");b.p("q:2l","2O");5 e=a;e.R().17("7[1n=\'y\']").n(e.17("1m:11(0)").y());e.R().p("q:U","u");e.17("1m:11(0)").z(\'1v\',\'1v\')})},26:3(a){5 b=[];Z(5 i=0,J=a.t;i<J;++i){4(""==a[i])4j;b.1o(a[i])}6 b}})})(4k);', 62, 269, "||this|function|if|var|return|input|||||||||||||||wrapper|val|listWrapper|data|sc|config|addClass|length|click||bind|listItems|text|attr|else|false|true|visible|multiple|positionY|removeClass|options|css|len|filter|hidden|trim|active|appendTo|each|selectbox|parent|list|invisible|lastEvent|KEY|null|notify|target|for||eq|filterFn||extend|name|icon|find|get|hideList|height|scrollTop|getActive|toUpperCase|separator|overflowCSS|pageY|keyCode|zIndex|break|SELECT|tagName|option|type|push|span|lastKey|hasClass|setComboValue|empty|case|selected|fn|emptyText|autoFill|triggerSelected|children|value|html|highlight|key|getTextValue|showList|99999|setListHeight|toLowerCase|container|url|sexyCombo|new|initialHiddenValue|dropUp|checkWidth|div|combo|updateDrop|li|singleItemHeight|outerHeight|initEvents|disabled|listItemClick|RETURN|preventDefault|TAB|document|__getValue|__getCurrentValue|normalizeArray||blur|focus|selection|setDropUp|getListItemsHeight|liLen|setOverflow|getListMaxHeight|scroll|DOWN|UP|setHiddenValue|inputFocus|optionsChanged|scrollDown|getActiveIndex|id|ajaxData|skin|suffix|hiddenSuffix|autocomplete|off|ul|browser|iconClick|mouseover|keyup|keyUp|applyEmptyText|trigger|getCurrentTextValue|split|pop|listVisible|parseInt|highlightFirst|highlightSelected|join|textChange|len1|change|yes|call|Math|min|highlightNext|highlightPrev|ESC|inputChanged|try|self|catch|next|while|prev|scrollUp|||inputBlur|BACKSPACE|createTextRange||character|select|setSelectionRange|selectionStart|up|Callback|log|createSelectbox|create|delete|is|sexy|__sexyCombo|__sexyComboHidden|showListCallback|hideListCallback|initCallback|initEventsCallback|changeCallback|textChangeCallback|wrap|hide|outerWidth|sort|opera|position|relative|left|top|typeof|overflowY|innerWidth|overflow|init|prototype|LI|nodeName|keypress|keydown|in|getHiddenValue|getCurrentHiddenValue|window|remove|indexOf|search|maxHeight|isNaN|switch|default|msie|inArray|throw||Exception|collapse|moveStart|moveEnd|selectionEnd||isFunction|DEL|COMMA|188|PAGEUP|PAGEDOWN|br|size|getJSON|deactivate|activate|changeOptions|continue|jQuery".split("|"), 0, {}));
jQuery.fn.extend({
    everyTime: function (interval, label, fn, times, belay) {
        return this.each(function () {
            jQuery.timer.add(this, interval, label, fn, times, belay)
        })
    },
    oneTime: function (interval, label, fn) {
        return this.each(function () {
            jQuery.timer.add(this, interval, label, fn, 1)
        })
    },
    stopTime: function (label, fn) {
        return this.each(function () {
            jQuery.timer.remove(this, label, fn)
        })
    }
});
jQuery.event.special;
jQuery.extend({
    timer: {
        global: [],
        guid: 1,
        dataKey: "jQuery.timer",
        regex: /^([0-9]+(?:\.[0-9]*)?)\s*(.*s)?$/,
        powers: {
            ms: 1,
            cs: 10,
            ds: 100,
            s: 1000,
            das: 10000,
            hs: 100000,
            ks: 1000000
        },
        timeParse: function (value) {
            if (value == undefined || value == null) {
                return null
            }
            var result = this.regex.exec(jQuery.trim(value.toString()));
            if (result[2]) {
                var num = parseFloat(result[1]);
                var mult = this.powers[result[2]] || 1;
                return num * mult
            } else {
                return value
            }
        },
        add: function (element, interval, label, fn, times, belay) {
            var counter = 0;
            if (jQuery.isFunction(label)) {
                if (!times) {
                    times = fn
                }
                fn = label;
                label = interval
            }
            interval = jQuery.timer.timeParse(interval);
            if (typeof interval != "number" || isNaN(interval) || interval <= 0) {
                return
            }
            if (times && times.constructor != Number) {
                belay = !!times;
                times = 0
            }
            times = times || 0;
            belay = belay || false;
            var timers = jQuery.data(element, this.dataKey) || jQuery.data(element, this.dataKey, {});
            if (!timers[label]) {
                timers[label] = {}
            }
            fn.timerID = fn.timerID || this.guid++;
            var handler = function () {
                if (belay && this.inProgress) {
                    return
                }
                this.inProgress = true;
                if ((++counter > times && times !== 0) || fn.call(element, counter) === false) {
                    jQuery.timer.remove(element, label, fn)
                }
                this.inProgress = false
            };
            handler.timerID = fn.timerID;
            if (!timers[label][fn.timerID]) {
                timers[label][fn.timerID] = window.setInterval(handler, interval)
            }
            this.global.push(element)
        },
        remove: function (element, label, fn) {
            var timers = jQuery.data(element, this.dataKey),
                ret;
            if (timers) {
                if (!label) {
                    for (label in timers) {
                        this.remove(element, label, fn)
                    }
                } else {
                    if (timers[label]) {
                        if (fn) {
                            if (fn.timerID) {
                                window.clearInterval(timers[label][fn.timerID]);
                                delete timers[label][fn.timerID]
                            }
                        } else {
                            for (var fn in timers[label]) {
                                window.clearInterval(timers[label][fn]);
                                delete timers[label][fn]
                            }
                        }
                        for (ret in timers[label]) {
                            break
                        }
                        if (!ret) {
                            ret = null;
                            delete timers[label]
                        }
                    }
                }
                for (ret in timers) {
                    break
                }
                if (!ret) {
                    jQuery.removeData(element, this.dataKey)
                }
            }
        }
    }
});
jQuery(window).bind("unload", function () {
    jQuery.each(jQuery.timer.global, function (index, item) {
        jQuery.timer.remove(item)
    })
});
(function (f) {
    function p(a, b, c) {
        var h = c.relative ? a.position().top : a.offset().top,
            e = c.relative ? a.position().left : a.offset().left,
            i = c.position[0];
        h -= b.outerHeight() - c.offset[0];
        e += a.outerWidth() + c.offset[1];
        var j = b.outerHeight() + a.outerHeight();
        if (i == "center") {
            h += j / 2
        }
        if (i == "bottom") {
            h += j
        }
        i = c.position[1];
        a = b.outerWidth() + a.outerWidth();
        if (i == "center") {
            e -= a / 2
        }
        if (i == "left") {
            e -= a
        }
        return {
            top: h,
            left: e
        }
    }

    function t(a, b) {
        var c = this,
            h = a.add(c),
            e, i = 0,
            j = 0,
            m = a.attr("title"),
            q = n[b.effect],
            k, r = a.is(":input"),
            u = r && a.is(":checkbox, :radio, select, :button"),
            s = a.attr("type"),
            l = b.events[s] || b.events[r ? u ? "widget" : "input" : "def"];
        if (!q) {
            throw 'Nonexistent effect "' + b.effect + '"'
        }
        l = l.split(/,\s*/);
        if (l.length != 2) {
            throw "Tooltip: bad events configuration for " + s
        }
        a.bind(l[0], function (d) {
            if (b.predelay) {
                clearTimeout(i);
                j = setTimeout(function () {
                    c.show(d)
                }, b.predelay)
            } else {
                c.show(d)
            }
        }).bind(l[1], function (d) {
            if (b.delay) {
                clearTimeout(j);
                i = setTimeout(function () {
                    c.hide(d)
                }, b.delay)
            } else {
                c.hide(d)
            }
        });
        if (m && b.cancelDefault) {
            a.removeAttr("title");
            a.data("title", m)
        }
        f.extend(c, {
            show: function (d) {
                if (!e) {
                    if (m) {
                        e = f(b.layout).addClass(b.tipClass).appendTo(document.body).hide().append(m)
                    } else {
                        if (b.tip) {
                            e = f(b.tip).eq(0)
                        } else {
                            e = a.next();
                            e.length || (e = a.parent().next())
                        }
                    } if (!e.length) {
                        throw "Cannot find tooltip for " + a
                    }
                }
                if (c.isShown()) {
                    return c
                }
                e.stop(true, true);
                var g = p(a, e, b);
                d = d || f.Event();
                d.type = "onBeforeShow";
                h.trigger(d, [g]);
                if (d.isDefaultPrevented()) {
                    return c
                }
                g = p(a, e, b);
                e.css({
                    position: "absolute",
                    top: g.top,
                    left: g.left
                });
                k = true;
                q[0].call(c, function () {
                    d.type = "onShow";
                    k = "full";
                    h.trigger(d)
                });
                g = b.events.tooltip.split(/,\s*/);
                e.bind(g[0], function () {
                    clearTimeout(i);
                    clearTimeout(j)
                });
                g[1] && !a.is("input:not(:checkbox, :radio), textarea") && e.bind(g[1], function (o) {
                    o.relatedTarget != a[0] && a.trigger(l[1].split(" ")[0])
                });
                return c
            },
            hide: function (d) {
                if (!e || !c.isShown()) {
                    return c
                }
                d = d || f.Event();
                d.type = "onBeforeHide";
                h.trigger(d);
                if (!d.isDefaultPrevented()) {
                    k = false;
                    n[b.effect][1].call(c, function () {
                        d.type = "onHide";
                        k = false;
                        h.trigger(d)
                    });
                    return c
                }
            },
            isShown: function (d) {
                return d ? k == "full" : k
            },
            getConf: function () {
                return b
            },
            getTip: function () {
                return e
            },
            getTrigger: function () {
                return a
            }
        });
        f.each("onHide,onBeforeShow,onShow,onBeforeHide".split(","), function (d, g) {
            f.isFunction(b[g]) && f(c).bind(g, b[g]);
            c[g] = function (o) {
                f(c).bind(g, o);
                return c
            }
        })
    }
    f.tools = f.tools || {
        version: "1.2.1"
    };
    f.tools.tooltip = {
        conf: {
            effect: "toggle",
            fadeOutSpeed: "fast",
            predelay: 0,
            delay: 30,
            opacity: 1,
            tip: 0,
            position: ["top", "center"],
            offset: [0, 0],
            relative: false,
            cancelDefault: true,
            events: {
                def: "mouseenter,mouseleave",
                input: "focus,blur",
                widget: "focus mouseenter,blur mouseleave",
                tooltip: "mouseenter,mouseleave"
            },
            layout: "<div/>",
            tipClass: "tooltip"
        },
        addEffect: function (a, b, c) {
            n[a] = [b, c]
        }
    };
    var n = {
        toggle: [
            function (a) {
                var b = this.getConf(),
                    c = this.getTip();
                b = b.opacity;
                b < 1 && c.css({
                    opacity: b
                });
                c.show();
                a.call()
            },
            function (a) {
                this.getTip().hide();
                a.call()
            }
        ],
        fade: [
            function (a) {
                this.getTip().fadeIn(this.getConf().fadeInSpeed, a)
            },
            function (a) {
                this.getTip().fadeOut(this.getConf().fadeOutSpeed, a)
            }
        ]
    };
    f.fn.tooltip = function (a) {
        var b = this.data("tooltip");
        if (b) {
            return b
        }
        a = f.extend(true, {}, f.tools.tooltip.conf, a);
        if (typeof a.position == "string") {
            a.position = a.position.split(/,?\s/)
        }
        this.each(function () {
            b = new t(f(this), a);
            f(this).data("tooltip", b)
        });
        return a.api ? b : this
    }
})(jQuery);
jQuery.ui || (function (c) {
    var i = c.fn.remove,
        d = c.browser.mozilla && (parseFloat(c.browser.version) < 1.9);
    c.ui = {
        version: "1.7.2",
        plugin: {
            add: function (k, l, n) {
                var m = c.ui[k].prototype;
                for (var j in n) {
                    m.plugins[j] = m.plugins[j] || [];
                    m.plugins[j].push([l, n[j]])
                }
            },
            call: function (j, l, k) {
                var n = j.plugins[l];
                if (!n || !j.element[0].parentNode) {
                    return
                }
                for (var m = 0; m < n.length; m++) {
                    if (j.options[n[m][0]]) {
                        n[m][1].apply(j.element, k)
                    }
                }
            }
        },
        contains: function (k, j) {
            return document.compareDocumentPosition ? k.compareDocumentPosition(j) & 16 : k !== j && k.contains(j)
        },
        hasScroll: function (m, k) {
            if (c(m).css("overflow") == "hidden") {
                return false
            }
            var j = (k && k == "left") ? "scrollLeft" : "scrollTop",
                l = false;
            if (m[j] > 0) {
                return true
            }
            m[j] = 1;
            l = (m[j] > 0);
            m[j] = 0;
            return l
        },
        isOverAxis: function (k, j, l) {
            return (k > j) && (k < (j + l))
        },
        isOver: function (o, k, n, m, j, l) {
            return c.ui.isOverAxis(o, n, j) && c.ui.isOverAxis(k, m, l)
        },
        keyCode: {
            BACKSPACE: 8,
            CAPS_LOCK: 20,
            COMMA: 188,
            CONTROL: 17,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            INSERT: 45,
            LEFT: 37,
            NUMPAD_ADD: 107,
            NUMPAD_DECIMAL: 110,
            NUMPAD_DIVIDE: 111,
            NUMPAD_ENTER: 108,
            NUMPAD_MULTIPLY: 106,
            NUMPAD_SUBTRACT: 109,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SHIFT: 16,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    };
    if (d) {
        var f = c.attr,
            e = c.fn.removeAttr,
            h = "http://www.w3.org/2005/07/aaa",
            a = /^aria-/,
            b = /^wairole:/;
        c.attr = function (k, j, l) {
            var m = l !== undefined;
            return (j == "role" ? (m ? f.call(this, k, j, "wairole:" + l) : (f.apply(this, arguments) || "").replace(b, "")) : (a.test(j) ? (m ? k.setAttributeNS(h, j.replace(a, "aaa:"), l) : f.call(this, k, j.replace(a, "aaa:"))) : f.apply(this, arguments)))
        };
        c.fn.removeAttr = function (j) {
            return (a.test(j) ? this.each(function () {
                this.removeAttributeNS(h, j.replace(a, ""))
            }) : e.call(this, j))
        }
    }
    c.fn.extend({
        remove: function () {
            c("*", this).add(this).each(function () {
                c(this).triggerHandler("remove")
            });
            return i.apply(this, arguments)
        },
        enableSelection: function () {
            return this.attr("unselectable", "off").css("MozUserSelect", "").unbind("selectstart.ui")
        },
        disableSelection: function () {
            return this.attr("unselectable", "on").css("MozUserSelect", "none").bind("selectstart.ui", function () {
                return false
            })
        },
        scrollParent: function () {
            var j;
            if ((c.browser.msie && (/(static|relative)/).test(this.css("position"))) || (/absolute/).test(this.css("position"))) {
                j = this.parents().filter(function () {
                    return (/(relative|absolute|fixed)/).test(c.curCSS(this, "position", 1)) && (/(auto|scroll)/).test(c.curCSS(this, "overflow", 1) + c.curCSS(this, "overflow-y", 1) + c.curCSS(this, "overflow-x", 1))
                }).eq(0)
            } else {
                j = this.parents().filter(function () {
                    return (/(auto|scroll)/).test(c.curCSS(this, "overflow", 1) + c.curCSS(this, "overflow-y", 1) + c.curCSS(this, "overflow-x", 1))
                }).eq(0)
            }
            return (/fixed/).test(this.css("position")) || !j.length ? c(document) : j
        }
    });
    c.extend(c.expr[":"], {
        data: function (l, k, j) {
            return !!c.data(l, j[3])
        },
        focusable: function (k) {
            var l = k.nodeName.toLowerCase(),
                j = c.attr(k, "tabindex");
            return (/input|select|textarea|button|object/.test(l) ? !k.disabled : "a" == l || "area" == l ? k.href || !isNaN(j) : !isNaN(j)) && !c(k)["area" == l ? "parents" : "closest"](":hidden").length
        },
        tabbable: function (k) {
            var j = c.attr(k, "tabindex");
            return (isNaN(j) || j >= 0) && c(k).is(":focusable")
        }
    });

    function g(m, n, o, l) {
        function k(q) {
            var p = c[m][n][q] || [];
            return (typeof p == "string" ? p.split(/,?\s+/) : p)
        }
        var j = k("getter");
        if (l.length == 1 && typeof l[0] == "string") {
            j = j.concat(k("getterSetter"))
        }
        return (c.inArray(o, j) != -1)
    }
    c.widget = function (k, j) {
        var l = k.split(".")[0];
        k = k.split(".")[1];
        c.fn[k] = function (p) {
            var n = (typeof p == "string"),
                o = Array.prototype.slice.call(arguments, 1);
            if (n && p.substring(0, 1) == "_") {
                return this
            }
            if (n && g(l, k, p, o)) {
                var m = c.data(this[0], k);
                return (m ? m[p].apply(m, o) : undefined)
            }
            return this.each(function () {
                var q = c.data(this, k);
                (!q && !n && c.data(this, k, new c[l][k](this, p))._init());
                (q && n && c.isFunction(q[p]) && q[p].apply(q, o))
            })
        };
        c[l] = c[l] || {};
        c[l][k] = function (o, n) {
            var m = this;
            this.namespace = l;
            this.widgetName = k;
            this.widgetEventPrefix = c[l][k].eventPrefix || k;
            this.widgetBaseClass = l + "-" + k;
            this.options = c.extend({}, c.widget.defaults, c[l][k].defaults, c.metadata && c.metadata.get(o)[k], n);
            this.element = c(o).bind("setData." + k, function (q, p, r) {
                if (q.target == o) {
                    return m._setData(p, r)
                }
            }).bind("getData." + k, function (q, p) {
                if (q.target == o) {
                    return m._getData(p)
                }
            }).bind("remove", function () {
                return m.destroy()
            })
        };
        c[l][k].prototype = c.extend({}, c.widget.prototype, j);
        c[l][k].getterSetter = "option"
    };
    c.widget.prototype = {
        _init: function () {},
        destroy: function () {
            this.element.removeData(this.widgetName).removeClass(this.widgetBaseClass + "-disabled " + this.namespace + "-state-disabled").removeAttr("aria-disabled")
        },
        option: function (l, m) {
            var k = l,
                j = this;
            if (typeof l == "string") {
                if (m === undefined) {
                    return this._getData(l)
                }
                k = {};
                k[l] = m
            }
            c.each(k, function (n, o) {
                j._setData(n, o)
            })
        },
        _getData: function (j) {
            return this.options[j]
        },
        _setData: function (j, k) {
            this.options[j] = k;
            if (j == "disabled") {
                this.element[k ? "addClass" : "removeClass"](this.widgetBaseClass + "-disabled " + this.namespace + "-state-disabled").attr("aria-disabled", k)
            }
        },
        enable: function () {
            this._setData("disabled", false)
        },
        disable: function () {
            this._setData("disabled", true)
        },
        _trigger: function (l, m, n) {
            var p = this.options[l],
                j = (l == this.widgetEventPrefix ? l : this.widgetEventPrefix + l);
            m = c.Event(m);
            m.type = j;
            if (m.originalEvent) {
                for (var k = c.event.props.length, o; k;) {
                    o = c.event.props[--k];
                    m[o] = m.originalEvent[o]
                }
            }
            this.element.trigger(m, n);
            return !(c.isFunction(p) && p.call(this.element[0], m, n) === false || m.isDefaultPrevented())
        }
    };
    c.widget.defaults = {
        disabled: false
    };
    c.ui.mouse = {
        _mouseInit: function () {
            var j = this;
            this.element.bind("mousedown." + this.widgetName, function (k) {
                return j._mouseDown(k)
            }).bind("click." + this.widgetName, function (k) {
                if (j._preventClickEvent) {
                    j._preventClickEvent = false;
                    k.stopImmediatePropagation();
                    return false
                }
            });
            if (c.browser.msie) {
                this._mouseUnselectable = this.element.attr("unselectable");
                this.element.attr("unselectable", "on")
            }
            this.started = false
        },
        _mouseDestroy: function () {
            this.element.unbind("." + this.widgetName);
            (c.browser.msie && this.element.attr("unselectable", this._mouseUnselectable))
        },
        _mouseDown: function (l) {
            l.originalEvent = l.originalEvent || {};
            if (l.originalEvent.mouseHandled) {
                return
            }(this._mouseStarted && this._mouseUp(l));
            this._mouseDownEvent = l;
            var k = this,
                m = (l.which == 1),
                j = (typeof this.options.cancel == "string" ? c(l.target).parents().add(l.target).filter(this.options.cancel).length : false);
            if (!m || j || !this._mouseCapture(l)) {
                return true
            }
            this.mouseDelayMet = !this.options.delay;
            if (!this.mouseDelayMet) {
                this._mouseDelayTimer = setTimeout(function () {
                    k.mouseDelayMet = true
                }, this.options.delay)
            }
            if (this._mouseDistanceMet(l) && this._mouseDelayMet(l)) {
                this._mouseStarted = (this._mouseStart(l) !== false);
                if (!this._mouseStarted) {
                    l.preventDefault();
                    return true
                }
            }
            this._mouseMoveDelegate = function (n) {
                return k._mouseMove(n)
            };
            this._mouseUpDelegate = function (n) {
                return k._mouseUp(n)
            };
            c(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate);
            (c.browser.safari || l.preventDefault());
            l.originalEvent.mouseHandled = true;
            return true
        },
        _mouseMove: function (j) {
            if (c.browser.msie && !j.button) {
                return this._mouseUp(j)
            }
            if (this._mouseStarted) {
                this._mouseDrag(j);
                return j.preventDefault()
            }
            if (this._mouseDistanceMet(j) && this._mouseDelayMet(j)) {
                this._mouseStarted = (this._mouseStart(this._mouseDownEvent, j) !== false);
                (this._mouseStarted ? this._mouseDrag(j) : this._mouseUp(j))
            }
            return !this._mouseStarted
        },
        _mouseUp: function (j) {
            c(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate);
            if (this._mouseStarted) {
                this._mouseStarted = false;
                this._preventClickEvent = (j.target == this._mouseDownEvent.target);
                this._mouseStop(j)
            }
            return false
        },
        _mouseDistanceMet: function (j) {
            return (Math.max(Math.abs(this._mouseDownEvent.pageX - j.pageX), Math.abs(this._mouseDownEvent.pageY - j.pageY)) >= this.options.distance)
        },
        _mouseDelayMet: function (j) {
            return this.mouseDelayMet
        },
        _mouseStart: function (j) {},
        _mouseDrag: function (j) {},
        _mouseStop: function (j) {},
        _mouseCapture: function (j) {
            return true
        }
    };
    c.ui.mouse.defaults = {
        cancel: null,
        distance: 1,
        delay: 0
    }
})(jQuery);
(function (a) {
    a.widget("ui.accordion", {
        _init: function () {
            var d = this.options,
                b = this;
            this.running = 0;
            if (d.collapsible == a.ui.accordion.defaults.collapsible && d.alwaysOpen != a.ui.accordion.defaults.alwaysOpen) {
                d.collapsible = !d.alwaysOpen
            }
            if (d.navigation) {
                var c = this.element.find("a").filter(d.navigationFilter);
                if (c.length) {
                    if (c.filter(d.header).length) {
                        this.active = c
                    } else {
                        this.active = c.parent().parent().prev();
                        c.addClass("ui-accordion-content-active")
                    }
                }
            }
            this.element.addClass("ui-accordion ui-widget ui-helper-reset");
            if (this.element[0].nodeName == "UL") {
                this.element.children("li").addClass("ui-accordion-li-fix")
            }
            this.headers = this.element.find(d.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").bind("mouseenter.accordion", function () {
                a(this).addClass("ui-state-hover")
            }).bind("mouseleave.accordion", function () {
                a(this).removeClass("ui-state-hover")
            }).bind("focus.accordion", function () {
                a(this).addClass("ui-state-focus")
            }).bind("blur.accordion", function () {
                a(this).removeClass("ui-state-focus")
            });
            this.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom");
            this.active = this._findActive(this.active || d.active).toggleClass("ui-state-default").toggleClass("ui-state-active").toggleClass("ui-corner-all").toggleClass("ui-corner-top");
            this.active.next().addClass("ui-accordion-content-active");
            a("<span/>").addClass("ui-icon " + d.icons.header).prependTo(this.headers);
            this.active.find(".ui-icon").toggleClass(d.icons.header).toggleClass(d.icons.headerSelected);
            if (a.browser.msie) {
                this.element.find("a").css("zoom", "1")
            }
            this.resize();
            this.element.attr("role", "tablist");
            this.headers.attr("role", "tab").bind("keydown", function (e) {
                return b._keydown(e)
            }).next().attr("role", "tabpanel");
            this.headers.not(this.active || "").attr("aria-expanded", "false").attr("tabIndex", "-1").next().hide();
            if (!this.active.length) {
                this.headers.eq(0).attr("tabIndex", "0")
            } else {
                this.active.attr("aria-expanded", "true").attr("tabIndex", "0")
            } if (!a.browser.safari) {
                this.headers.find("a").attr("tabIndex", "-1")
            }
            if (d.event) {
                this.headers.bind((d.event) + ".accordion", function (e) {
                    return b._clickHandler.call(b, e, this)
                })
            }
        },
        destroy: function () {
            var c = this.options;
            this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role").unbind(".accordion").removeData("accordion");
            this.headers.unbind(".accordion").removeClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("tabindex");
            this.headers.find("a").removeAttr("tabindex");
            this.headers.children(".ui-icon").remove();
            var b = this.headers.next().css("display", "").removeAttr("role").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active");
            if (c.autoHeight || c.fillHeight) {
                b.css("height", "")
            }
        },
        _setData: function (b, c) {
            if (b == "alwaysOpen") {
                b = "collapsible";
                c = !c
            }
            a.widget.prototype._setData.apply(this, arguments)
        },
        _keydown: function (e) {
            var g = this.options,
                f = a.ui.keyCode;
            if (g.disabled || e.altKey || e.ctrlKey) {
                return
            }
            var d = this.headers.length;
            var b = this.headers.index(e.target);
            var c = false;
            switch (e.keyCode) {
            case f.RIGHT:
            case f.DOWN:
                c = this.headers[(b + 1) % d];
                break;
            case f.LEFT:
            case f.UP:
                c = this.headers[(b - 1 + d) % d];
                break;
            case f.SPACE:
            case f.ENTER:
                return this._clickHandler({
                    target: e.target
                }, e.target)
            }
            if (c) {
                a(e.target).attr("tabIndex", "-1");
                a(c).attr("tabIndex", "0");
                c.focus();
                return false
            }
            return true
        },
        resize: function () {
            var e = this.options,
                d;
            if (e.fillSpace) {
                if (a.browser.msie) {
                    var b = this.element.parent().css("overflow");
                    this.element.parent().css("overflow", "hidden")
                }
                d = this.element.parent().height();
                if (a.browser.msie) {
                    this.element.parent().css("overflow", b)
                }
                this.headers.each(function () {
                    d -= a(this).outerHeight()
                });
                var c = 0;
                this.headers.next().each(function () {
                    c = Math.max(c, a(this).innerHeight() - a(this).height())
                }).height(Math.max(0, d - c)).css("overflow", "auto")
            } else {
                if (e.autoHeight) {
                    d = 0;
                    this.headers.next().each(function () {
                        d = Math.max(d, a(this).outerHeight())
                    }).height(d)
                }
            }
        },
        activate: function (b) {
            var c = this._findActive(b)[0];
            this._clickHandler({
                target: c
            }, c)
        },
        _findActive: function (b) {
            return b ? typeof b == "number" ? this.headers.filter(":eq(" + b + ")") : this.headers.not(this.headers.not(b)) : b === false ? a([]) : this.headers.filter(":eq(0)")
        },
        _clickHandler: function (b, f) {
            var d = this.options;
            if (d.disabled) {
                return false
            }
            if (!b.target && d.collapsible) {
                this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").find(".ui-icon").removeClass(d.icons.headerSelected).addClass(d.icons.header);
                this.active.next().addClass("ui-accordion-content-active");
                var h = this.active.next(),
                    e = {
                        options: d,
                        newHeader: a([]),
                        oldHeader: d.active,
                        newContent: a([]),
                        oldContent: h
                    },
                    c = (this.active = a([]));
                this._toggle(c, h, e);
                return false
            }
            var g = a(b.currentTarget || f);
            var i = g[0] == this.active[0];
            if (this.running || (!d.collapsible && i)) {
                return false
            }
            this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").find(".ui-icon").removeClass(d.icons.headerSelected).addClass(d.icons.header);
            this.active.next().addClass("ui-accordion-content-active");
            if (!i) {
                g.removeClass("ui-state-default ui-corner-all").addClass("ui-state-active ui-corner-top").find(".ui-icon").removeClass(d.icons.header).addClass(d.icons.headerSelected);
                g.next().addClass("ui-accordion-content-active")
            }
            var c = g.next(),
                h = this.active.next(),
                e = {
                    options: d,
                    newHeader: i && d.collapsible ? a([]) : g,
                    oldHeader: this.active,
                    newContent: i && d.collapsible ? a([]) : c.find("> *"),
                    oldContent: h.find("> *")
                },
                j = this.headers.index(this.active[0]) > this.headers.index(g[0]);
            this.active = i ? a([]) : g;
            this._toggle(c, h, e, i, j);
            return false
        },
        _toggle: function (b, i, g, j, k) {
            var d = this.options,
                m = this;
            this.toShow = b;
            this.toHide = i;
            this.data = g;
            var c = function () {
                if (!m) {
                    return
                }
                return m._completed.apply(m, arguments)
            };
            this._trigger("changestart", null, this.data);
            this.running = i.size() === 0 ? b.size() : i.size();
            if (d.animated) {
                var f = {};
                if (d.collapsible && j) {
                    f = {
                        toShow: a([]),
                        toHide: i,
                        complete: c,
                        down: k,
                        autoHeight: d.autoHeight || d.fillSpace
                    }
                } else {
                    f = {
                        toShow: b,
                        toHide: i,
                        complete: c,
                        down: k,
                        autoHeight: d.autoHeight || d.fillSpace
                    }
                } if (!d.proxied) {
                    d.proxied = d.animated
                }
                if (!d.proxiedDuration) {
                    d.proxiedDuration = d.duration
                }
                d.animated = a.isFunction(d.proxied) ? d.proxied(f) : d.proxied;
                d.duration = a.isFunction(d.proxiedDuration) ? d.proxiedDuration(f) : d.proxiedDuration;
                var l = a.ui.accordion.animations,
                    e = d.duration,
                    h = d.animated;
                if (!l[h]) {
                    l[h] = function (n) {
                        this.slide(n, {
                            easing: h,
                            duration: e || 700
                        })
                    }
                }
                l[h](f)
            } else {
                if (d.collapsible && j) {
                    b.toggle()
                } else {
                    i.hide();
                    b.show()
                }
                c(true)
            }
            i.prev().attr("aria-expanded", "false").attr("tabIndex", "-1").blur();
            b.prev().attr("aria-expanded", "true").attr("tabIndex", "0").focus()
        },
        _completed: function (b) {
            var c = this.options;
            this.running = b ? 0 : --this.running;
            if (this.running) {
                return
            }
            if (c.clearStyle) {
                this.toShow.add(this.toHide).css({
                    height: "",
                    overflow: ""
                })
            }
            this._trigger("change", null, this.data)
        }
    });
    a.extend(a.ui.accordion, {
        version: "1.7.2",
        defaults: {
            active: null,
            alwaysOpen: true,
            animated: "slide",
            autoHeight: true,
            clearStyle: false,
            collapsible: false,
            event: "click",
            fillSpace: false,
            header: "> li > :first-child,> :not(li):even",
            icons: {
                header: "ui-icon-triangle-1-e",
                headerSelected: "ui-icon-triangle-1-s"
            },
            navigation: false,
            navigationFilter: function () {
                return this.href.toLowerCase() == location.href.toLowerCase()
            }
        },
        animations: {
            slide: function (j, h) {
                j = a.extend({
                    easing: "swing",
                    duration: 300
                }, j, h);
                if (!j.toHide.size()) {
                    j.toShow.animate({
                        height: "show"
                    }, j);
                    return
                }
                if (!j.toShow.size()) {
                    j.toHide.animate({
                        height: "hide"
                    }, j);
                    return
                }
                var c = j.toShow.css("overflow"),
                    g, d = {},
                    f = {},
                    e = ["height", "paddingTop", "paddingBottom"],
                    b;
                var i = j.toShow;
                b = i[0].style.width;
                i.width(parseInt(i.parent().width(), 10) - parseInt(i.css("paddingLeft"), 10) - parseInt(i.css("paddingRight"), 10) - (parseInt(i.css("borderLeftWidth"), 10) || 0) - (parseInt(i.css("borderRightWidth"), 10) || 0));
                a.each(e, function (k, m) {
                    f[m] = "hide";
                    var l = ("" + a.css(j.toShow[0], m)).match(/^([\d+-.]+)(.*)$/);
                    d[m] = {
                        value: l[1],
                        unit: l[2] || "px"
                    }
                });
                j.toShow.css({
                    height: 0,
                    overflow: "hidden"
                }).show();
                j.toHide.filter(":hidden").each(j.complete).end().filter(":visible").animate(f, {
                    step: function (k, l) {
                        if (l.prop == "height") {
                            g = (l.now - l.start) / (l.end - l.start)
                        }
                        j.toShow[0].style[l.prop] = (g * d[l.prop].value) + d[l.prop].unit
                    },
                    duration: j.duration,
                    easing: j.easing,
                    complete: function () {
                        if (!j.autoHeight) {
                            j.toShow.css("height", "")
                        }
                        j.toShow.css("width", b);
                        j.toShow.css({
                            overflow: c
                        });
                        j.complete()
                    }
                })
            },
            bounceslide: function (b) {
                this.slide(b, {
                    easing: b.down ? "easeOutBounce" : "swing",
                    duration: b.down ? 1000 : 200
                })
            },
            easeslide: function (b) {
                this.slide(b, {
                    easing: "easeinout",
                    duration: 700
                })
            }
        }
    })
})(jQuery);
(function (c) {
    var b = {
            dragStart: "start.draggable",
            drag: "drag.draggable",
            dragStop: "stop.draggable",
            maxHeight: "maxHeight.resizable",
            minHeight: "minHeight.resizable",
            maxWidth: "maxWidth.resizable",
            minWidth: "minWidth.resizable",
            resizeStart: "start.resizable",
            resize: "drag.resizable",
            resizeStop: "stop.resizable"
        },
        a = "ui-dialog ui-widget ui-widget-content ui-corner-all ";
    c.widget("ui.dialog", {
        _init: function () {
            this.originalTitle = this.element.attr("title");
            var l = this,
                m = this.options,
                j = m.title || this.originalTitle || "&nbsp;",
                e = c.ui.dialog.getTitleId(this.element),
                k = (this.uiDialog = c("<div/>")).appendTo(document.body).hide().addClass(a + m.dialogClass).css({
                    position: "absolute",
                    overflow: "hidden",
                    zIndex: m.zIndex
                }).attr("tabIndex", -1).css("outline", 0).keydown(function (n) {
                    (m.closeOnEscape && n.keyCode && n.keyCode == c.ui.keyCode.ESCAPE && l.close(n))
                }).attr({
                    role: "dialog",
                    "aria-labelledby": e
                }).mousedown(function (n) {
                    l.moveToTop(false, n)
                }),
                g = this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(k),
                f = (this.uiDialogTitlebar = c("<div></div>")).addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix").prependTo(k),
                i = c('<a href="#"/>').addClass("ui-dialog-titlebar-close ui-corner-all").attr("role", "button").hover(function () {
                    i.addClass("ui-state-hover")
                }, function () {
                    i.removeClass("ui-state-hover")
                }).focus(function () {
                    i.addClass("ui-state-focus")
                }).blur(function () {
                    i.removeClass("ui-state-focus")
                }).mousedown(function (n) {
                    n.stopPropagation()
                }).click(function (n) {
                    l.close(n);
                    return false
                }).appendTo(f),
                h = (this.uiDialogTitlebarCloseText = c("<span/>")).addClass("ui-icon ui-icon-closethick").text(m.closeText).appendTo(i),
                d = c("<span/>").addClass("ui-dialog-title").attr("id", e).html(j).prependTo(f);
            f.find("*").add(f).disableSelection();
            (m.draggable && c.fn.draggable && this._makeDraggable());
            (m.resizable && c.fn.resizable && this._makeResizable());
            this._createButtons(m.buttons);
            this._isOpen = false;
            (m.bgiframe && c.fn.bgiframe && k.bgiframe());
            (m.autoOpen && this.open())
        },
        destroy: function () {
            (this.overlay && this.overlay.destroy());
            this.uiDialog.hide();
            this.element.unbind(".dialog").removeData("dialog").removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body");
            this.uiDialog.remove();
            (this.originalTitle && this.element.attr("title", this.originalTitle))
        },
        close: function (f) {
            var d = this;
            if (false === d._trigger("beforeclose", f)) {
                return
            }(d.overlay && d.overlay.destroy());
            d.uiDialog.unbind("keypress.ui-dialog");
            (d.options.hide ? d.uiDialog.hide(d.options.hide, function () {
                d._trigger("close", f)
            }) : d.uiDialog.hide() && d._trigger("close", f));
            c.ui.dialog.overlay.resize();
            d._isOpen = false;
            if (d.options.modal) {
                var e = 0;
                c(".ui-dialog").each(function () {
                    if (this != d.uiDialog[0]) {
                        e = Math.max(e, c(this).css("z-index"))
                    }
                });
                c.ui.dialog.maxZ = e
            }
        },
        isOpen: function () {
            return this._isOpen
        },
        moveToTop: function (f, e) {
            if ((this.options.modal && !f) || (!this.options.stack && !this.options.modal)) {
                return this._trigger("focus", e)
            }
            if (this.options.zIndex > c.ui.dialog.maxZ) {
                c.ui.dialog.maxZ = this.options.zIndex
            }(this.overlay && this.overlay.$el.css("z-index", c.ui.dialog.overlay.maxZ = ++c.ui.dialog.maxZ));
            var d = {
                scrollTop: this.element.attr("scrollTop"),
                scrollLeft: this.element.attr("scrollLeft")
            };
            this.uiDialog.css("z-index", ++c.ui.dialog.maxZ);
            this.element.attr(d);
            this._trigger("focus", e)
        },
        open: function () {
            if (this._isOpen) {
                return
            }
            var e = this.options,
                d = this.uiDialog;
            this.overlay = e.modal ? new c.ui.dialog.overlay(this) : null;
            (d.next().length && d.appendTo("body"));
            this._size();
            this._position(e.position);
            d.show(e.show);
            this.moveToTop(true);
            (e.modal && d.bind("keypress.ui-dialog", function (h) {
                if (h.keyCode != c.ui.keyCode.TAB) {
                    return
                }
                var g = c(":tabbable", this),
                    i = g.filter(":first")[0],
                    f = g.filter(":last")[0];
                if (h.target == f && !h.shiftKey) {
                    setTimeout(function () {
                        i.focus()
                    }, 1)
                } else {
                    if (h.target == i && h.shiftKey) {
                        setTimeout(function () {
                            f.focus()
                        }, 1)
                    }
                }
            }));
            c([]).add(d.find(".ui-dialog-content :tabbable:first")).add(d.find(".ui-dialog-buttonpane :tabbable:first")).add(d).filter(":first").focus();
            this._trigger("open");
            this._isOpen = true
        },
        _createButtons: function (g) {
            var f = this,
                d = false,
                e = c("<div></div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix");
            this.uiDialog.find(".ui-dialog-buttonpane").remove();
            (typeof g == "object" && g !== null && c.each(g, function () {
                return !(d = true)
            }));
            if (d) {
                c.each(g, function (h, i) {
                    c('<button type="button"></button>').addClass("ui-state-default ui-corner-all").text(h).click(function () {
                        i.apply(f.element[0], arguments)
                    }).hover(function () {
                        c(this).addClass("ui-state-hover")
                    }, function () {
                        c(this).removeClass("ui-state-hover")
                    }).focus(function () {
                        c(this).addClass("ui-state-focus")
                    }).blur(function () {
                        c(this).removeClass("ui-state-focus")
                    }).appendTo(e)
                });
                e.appendTo(this.uiDialog)
            }
        },
        _makeDraggable: function () {
            var d = this,
                f = this.options,
                e;
            this.uiDialog.draggable({
                cancel: ".ui-dialog-content",
                handle: ".ui-dialog-titlebar",
                containment: "document",
                start: function () {
                    e = f.height;
                    c(this).height(c(this).height()).addClass("ui-dialog-dragging");
                    (f.dragStart && f.dragStart.apply(d.element[0], arguments))
                },
                drag: function () {
                    (f.drag && f.drag.apply(d.element[0], arguments))
                },
                stop: function () {
                    c(this).removeClass("ui-dialog-dragging").height(e);
                    (f.dragStop && f.dragStop.apply(d.element[0], arguments));
                    c.ui.dialog.overlay.resize()
                }
            })
        },
        _makeResizable: function (g) {
            g = (g === undefined ? this.options.resizable : g);
            var d = this,
                f = this.options,
                e = typeof g == "string" ? g : "n,e,s,w,se,sw,ne,nw";
            this.uiDialog.resizable({
                cancel: ".ui-dialog-content",
                alsoResize: this.element,
                maxWidth: f.maxWidth,
                maxHeight: f.maxHeight,
                minWidth: f.minWidth,
                minHeight: f.minHeight,
                start: function () {
                    c(this).addClass("ui-dialog-resizing");
                    (f.resizeStart && f.resizeStart.apply(d.element[0], arguments))
                },
                resize: function () {
                    (f.resize && f.resize.apply(d.element[0], arguments))
                },
                handles: e,
                stop: function () {
                    c(this).removeClass("ui-dialog-resizing");
                    f.height = c(this).height();
                    f.width = c(this).width();
                    (f.resizeStop && f.resizeStop.apply(d.element[0], arguments));
                    c.ui.dialog.overlay.resize()
                }
            }).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")
        },
        _position: function (i) {
            var e = c(window),
                f = c(document),
                g = f.scrollTop(),
                d = f.scrollLeft(),
                h = g;
            if (c.inArray(i, ["center", "top", "right", "bottom", "left"]) >= 0) {
                i = [i == "right" || i == "left" ? i : "center", i == "top" || i == "bottom" ? i : "middle"]
            }
            if (i.constructor != Array) {
                i = ["center", "middle"]
            }
            if (i[0].constructor == Number) {
                d += i[0]
            } else {
                switch (i[0]) {
                case "left":
                    d += 0;
                    break;
                case "right":
                    d += e.width() - this.uiDialog.outerWidth();
                    break;
                default:
                case "center":
                    d += (e.width() - this.uiDialog.outerWidth()) / 2
                }
            } if (i[1].constructor == Number) {
                g += i[1]
            } else {
                switch (i[1]) {
                case "top":
                    g += 0;
                    break;
                case "bottom":
                    g += e.height() - this.uiDialog.outerHeight();
                    break;
                default:
                case "middle":
                    g += (e.height() - this.uiDialog.outerHeight()) / 2
                }
            }
            g = Math.max(g, h);
            this.uiDialog.css({
                top: g,
                left: d
            })
        },
        _setData: function (e, f) {
            (b[e] && this.uiDialog.data(b[e], f));
            switch (e) {
            case "buttons":
                this._createButtons(f);
                break;
            case "closeText":
                this.uiDialogTitlebarCloseText.text(f);
                break;
            case "dialogClass":
                this.uiDialog.removeClass(this.options.dialogClass).addClass(a + f);
                break;
            case "draggable":
                (f ? this._makeDraggable() : this.uiDialog.draggable("destroy"));
                break;
            case "height":
                this.uiDialog.height(f);
                break;
            case "position":
                this._position(f);
                break;
            case "resizable":
                var d = this.uiDialog,
                    g = this.uiDialog.is(":data(resizable)");
                (g && !f && d.resizable("destroy"));
                (g && typeof f == "string" && d.resizable("option", "handles", f));
                (g || this._makeResizable(f));
                break;
            case "title":
                c(".ui-dialog-title", this.uiDialogTitlebar).html(f || "&nbsp;");
                break;
            case "width":
                this.uiDialog.width(f);
                break
            }
            c.widget.prototype._setData.apply(this, arguments)
        },
        _size: function () {
            var e = this.options;
            this.element.css({
                height: 0,
                minHeight: 0,
                width: "auto"
            });
            var d = this.uiDialog.css({
                height: "auto",
                width: e.width
            }).height();
            this.element.css({
                minHeight: Math.max(e.minHeight - d, 0),
                height: e.height == "auto" ? "auto" : Math.max(e.height - d, 0)
            })
        }
    });
    c.extend(c.ui.dialog, {
        version: "1.7.2",
        defaults: {
            autoOpen: true,
            bgiframe: false,
            buttons: {},
            closeOnEscape: true,
            closeText: "close",
            dialogClass: "",
            draggable: true,
            hide: null,
            height: "auto",
            maxHeight: false,
            maxWidth: false,
            minHeight: 150,
            minWidth: 150,
            modal: false,
            position: "center",
            resizable: true,
            show: null,
            stack: true,
            title: "",
            width: 300,
            zIndex: 1000
        },
        getter: "isOpen",
        uuid: 0,
        maxZ: 0,
        getTitleId: function (d) {
            return "ui-dialog-title-" + (d.attr("id") || ++this.uuid)
        },
        overlay: function (d) {
            this.$el = c.ui.dialog.overlay.create(d)
        }
    });
    c.extend(c.ui.dialog.overlay, {
        instances: [],
        maxZ: 0,
        events: c.map("focus,mousedown,mouseup,keydown,keypress,click".split(","), function (d) {
            return d + ".dialog-overlay"
        }).join(" "),
        create: function (e) {
            if (this.instances.length === 0) {
                setTimeout(function () {
                    if (c.ui.dialog.overlay.instances.length) {
                        c(document).bind(c.ui.dialog.overlay.events, function (f) {
                            var g = c(f.target).parents(".ui-dialog").css("zIndex") || 0;
                            return (g > c.ui.dialog.overlay.maxZ)
                        })
                    }
                }, 1);
                c(document).bind("keydown.dialog-overlay", function (f) {
                    (e.options.closeOnEscape && f.keyCode && f.keyCode == c.ui.keyCode.ESCAPE && e.close(f))
                });
                c(window).bind("resize.dialog-overlay", c.ui.dialog.overlay.resize)
            }
            var d = c("<div></div>").appendTo(document.body).addClass("ui-widget-overlay").css({
                width: this.width(),
                height: this.height()
            });
            (e.options.bgiframe && c.fn.bgiframe && d.bgiframe());
            this.instances.push(d);
            return d
        },
        destroy: function (d) {
            this.instances.splice(c.inArray(this.instances, d), 1);
            if (this.instances.length === 0) {
                c([document, window]).unbind(".dialog-overlay")
            }
            d.remove();
            var e = 0;
            c.each(this.instances, function () {
                e = Math.max(e, this.css("z-index"))
            });
            this.maxZ = e
        },
        height: function () {
            if (c.browser.msie && c.browser.version < 7) {
                var e = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
                var d = Math.max(document.documentElement.offsetHeight, document.body.offsetHeight);
                if (e < d) {
                    return c(window).height() + "px"
                } else {
                    return e + "px"
                }
            } else {
                return c(document).height() + "px"
            }
        },
        width: function () {
            if (c.browser.msie && c.browser.version < 7) {
                var d = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth);
                var e = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);
                if (d < e) {
                    return c(window).width() + "px"
                } else {
                    return d + "px"
                }
            } else {
                return c(document).width() + "px"
            }
        },
        resize: function () {
            var d = c([]);
            c.each(c.ui.dialog.overlay.instances, function () {
                d = d.add(this)
            });
            d.css({
                width: 0,
                height: 0
            }).css({
                width: c.ui.dialog.overlay.width(),
                height: c.ui.dialog.overlay.height()
            })
        }
    });
    c.extend(c.ui.dialog.overlay.prototype, {
        destroy: function () {
            c.ui.dialog.overlay.destroy(this.$el)
        }
    })
})(jQuery);
(function (a) {
    a.widget("ui.slider", a.extend({}, a.ui.mouse, {
        _init: function () {
            var b = this,
                c = this.options;
            this._keySliding = false;
            this._handleIndex = null;
            this._detectOrientation();
            this._mouseInit();
            this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget ui-widget-content ui-corner-all");
            this.range = a([]);
            if (c.range) {
                if (c.range === true) {
                    this.range = a("<div></div>");
                    if (!c.values) {
                        c.values = [this._valueMin(), this._valueMin()]
                    }
                    if (c.values.length && c.values.length != 2) {
                        c.values = [c.values[0], c.values[0]]
                    }
                } else {
                    this.range = a("<div></div>")
                }
                this.range.appendTo(this.element).addClass("ui-slider-range");
                if (c.range == "min" || c.range == "max") {
                    this.range.addClass("ui-slider-range-" + c.range)
                }
                this.range.addClass("ui-widget-header")
            }
            if (a(".ui-slider-handle", this.element).length == 0) {
                a('<a href="#"></a>').appendTo(this.element).addClass("ui-slider-handle")
            }
            if (c.values && c.values.length) {
                while (a(".ui-slider-handle", this.element).length < c.values.length) {
                    a('<a href="#"></a>').appendTo(this.element).addClass("ui-slider-handle")
                }
            }
            this.handles = a(".ui-slider-handle", this.element).addClass("ui-state-default ui-corner-all");
            this.handle = this.handles.eq(0);
            this.handles.add(this.range).filter("a").click(function (d) {
                d.preventDefault()
            }).hover(function () {
                if (!c.disabled) {
                    a(this).addClass("ui-state-hover")
                }
            }, function () {
                a(this).removeClass("ui-state-hover")
            }).focus(function () {
                if (!c.disabled) {
                    a(".ui-slider .ui-state-focus").removeClass("ui-state-focus");
                    a(this).addClass("ui-state-focus")
                } else {
                    a(this).blur()
                }
            }).blur(function () {
                a(this).removeClass("ui-state-focus")
            });
            this.handles.each(function (d) {
                a(this).data("index.ui-slider-handle", d)
            });
            this.handles.keydown(function (i) {
                var f = true;
                var e = a(this).data("index.ui-slider-handle");
                if (b.options.disabled) {
                    return
                }
                switch (i.keyCode) {
                case a.ui.keyCode.HOME:
                case a.ui.keyCode.END:
                case a.ui.keyCode.UP:
                case a.ui.keyCode.RIGHT:
                case a.ui.keyCode.DOWN:
                case a.ui.keyCode.LEFT:
                    f = false;
                    if (!b._keySliding) {
                        b._keySliding = true;
                        a(this).addClass("ui-state-active");
                        b._start(i, e)
                    }
                    break
                }
                var g, d, h = b._step();
                if (b.options.values && b.options.values.length) {
                    g = d = b.values(e)
                } else {
                    g = d = b.value()
                }
                switch (i.keyCode) {
                case a.ui.keyCode.HOME:
                    d = b._valueMin();
                    break;
                case a.ui.keyCode.END:
                    d = b._valueMax();
                    break;
                case a.ui.keyCode.UP:
                case a.ui.keyCode.RIGHT:
                    if (g == b._valueMax()) {
                        return
                    }
                    d = g + h;
                    break;
                case a.ui.keyCode.DOWN:
                case a.ui.keyCode.LEFT:
                    if (g == b._valueMin()) {
                        return
                    }
                    d = g - h;
                    break
                }
                b._slide(i, e, d);
                return f
            }).keyup(function (e) {
                var d = a(this).data("index.ui-slider-handle");
                if (b._keySliding) {
                    b._stop(e, d);
                    b._change(e, d);
                    b._keySliding = false;
                    a(this).removeClass("ui-state-active")
                }
            });
            this._refreshValue()
        },
        destroy: function () {
            this.handles.remove();
            this.range.remove();
            this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all").removeData("slider").unbind(".slider");
            this._mouseDestroy()
        },
        _mouseCapture: function (d) {
            var e = this.options;
            if (e.disabled) {
                return false
            }
            this.elementSize = {
                width: this.element.outerWidth(),
                height: this.element.outerHeight()
            };
            this.elementOffset = this.element.offset();
            var h = {
                x: d.pageX,
                y: d.pageY
            };
            var j = this._normValueFromMouse(h);
            var c = this._valueMax() - this._valueMin() + 1,
                f;
            var k = this,
                i;
            this.handles.each(function (l) {
                var m = Math.abs(j - k.values(l));
                if (c > m) {
                    c = m;
                    f = a(this);
                    i = l
                }
            });
            if (e.range == true && this.values(1) == e.min) {
                f = a(this.handles[++i])
            }
            this._start(d, i);
            k._handleIndex = i;
            f.addClass("ui-state-active").focus();
            var g = f.offset();
            var b = !a(d.target).parents().andSelf().is(".ui-slider-handle");
            this._clickOffset = b ? {
                left: 0,
                top: 0
            } : {
                left: d.pageX - g.left - (f.width() / 2),
                top: d.pageY - g.top - (f.height() / 2) - (parseInt(f.css("borderTopWidth"), 10) || 0) - (parseInt(f.css("borderBottomWidth"), 10) || 0) + (parseInt(f.css("marginTop"), 10) || 0)
            };
            j = this._normValueFromMouse(h);
            this._slide(d, i, j);
            return true
        },
        _mouseStart: function (b) {
            return true
        },
        _mouseDrag: function (d) {
            var b = {
                x: d.pageX,
                y: d.pageY
            };
            var c = this._normValueFromMouse(b);
            this._slide(d, this._handleIndex, c);
            return false
        },
        _mouseStop: function (b) {
            this.handles.removeClass("ui-state-active");
            this._stop(b, this._handleIndex);
            this._change(b, this._handleIndex);
            this._handleIndex = null;
            this._clickOffset = null;
            return false
        },
        _detectOrientation: function () {
            this.orientation = this.options.orientation == "vertical" ? "vertical" : "horizontal"
        },
        _normValueFromMouse: function (d) {
            var c, h;
            if ("horizontal" == this.orientation) {
                c = this.elementSize.width;
                h = d.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left : 0)
            } else {
                c = this.elementSize.height;
                h = d.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top : 0)
            }
            var f = (h / c);
            if (f > 1) {
                f = 1
            }
            if (f < 0) {
                f = 0
            }
            if ("vertical" == this.orientation) {
                f = 1 - f
            }
            var e = this._valueMax() - this._valueMin(),
                i = f * e,
                b = i % this.options.step,
                g = this._valueMin() + i - b;
            if (b > (this.options.step / 2)) {
                g += this.options.step
            }
            return parseFloat(g.toFixed(5))
        },
        _start: function (d, c) {
            var b = {
                handle: this.handles[c],
                value: this.value()
            };
            if (this.options.values && this.options.values.length) {
                b.value = this.values(c);
                b.values = this.values()
            }
            this._trigger("start", d, b)
        },
        _slide: function (f, e, d) {
            var g = this.handles[e];
            if (this.options.values && this.options.values.length) {
                var b = this.values(e ? 0 : 1);
                if ((this.options.values.length == 2 && this.options.range === true) && ((e == 0 && d > b) || (e == 1 && d < b))) {
                    d = b
                }
                if (d != this.values(e)) {
                    var c = this.values();
                    c[e] = d;
                    var h = this._trigger("slide", f, {
                        handle: this.handles[e],
                        value: d,
                        values: c
                    });
                    var b = this.values(e ? 0 : 1);
                    if (h !== false) {
                        this.values(e, d, (f.type == "mousedown" && this.options.animate), true)
                    }
                }
            } else {
                if (d != this.value()) {
                    var h = this._trigger("slide", f, {
                        handle: this.handles[e],
                        value: d
                    });
                    if (h !== false) {
                        this._setData("value", d, (f.type == "mousedown" && this.options.animate))
                    }
                }
            }
        },
        _stop: function (d, c) {
            var b = {
                handle: this.handles[c],
                value: this.value()
            };
            if (this.options.values && this.options.values.length) {
                b.value = this.values(c);
                b.values = this.values()
            }
            this._trigger("stop", d, b)
        },
        _change: function (d, c) {
            var b = {
                handle: this.handles[c],
                value: this.value()
            };
            if (this.options.values && this.options.values.length) {
                b.value = this.values(c);
                b.values = this.values()
            }
            this._trigger("change", d, b)
        },
        value: function (b) {
            if (arguments.length) {
                this._setData("value", b);
                this._change(null, 0)
            }
            return this._value()
        },
        values: function (b, e, c, d) {
            if (arguments.length > 1) {
                this.options.values[b] = e;
                this._refreshValue(c);
                if (!d) {
                    this._change(null, b)
                }
            }
            if (arguments.length) {
                if (this.options.values && this.options.values.length) {
                    return this._values(b)
                } else {
                    return this.value()
                }
            } else {
                return this._values()
            }
        },
        _setData: function (b, d, c) {
            a.widget.prototype._setData.apply(this, arguments);
            switch (b) {
            case "disabled":
                if (d) {
                    this.handles.filter(".ui-state-focus").blur();
                    this.handles.removeClass("ui-state-hover");
                    this.handles.attr("disabled", "disabled")
                } else {
                    this.handles.removeAttr("disabled")
                }
            case "orientation":
                this._detectOrientation();
                this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation);
                this._refreshValue(c);
                break;
            case "value":
                this._refreshValue(c);
                break
            }
        },
        _step: function () {
            var b = this.options.step;
            return b
        },
        _value: function () {
            var b = this.options.value;
            if (b < this._valueMin()) {
                b = this._valueMin()
            }
            if (b > this._valueMax()) {
                b = this._valueMax()
            }
            return b
        },
        _values: function (b) {
            if (arguments.length) {
                var c = this.options.values[b];
                if (c < this._valueMin()) {
                    c = this._valueMin()
                }
                if (c > this._valueMax()) {
                    c = this._valueMax()
                }
                return c
            } else {
                return this.options.values
            }
        },
        _valueMin: function () {
            var b = this.options.min;
            return b
        },
        _valueMax: function () {
            var b = this.options.max;
            return b
        },
        _refreshValue: function (c) {
            var f = this.options.range,
                d = this.options,
                l = this;
            if (this.options.values && this.options.values.length) {
                var i, h;
                this.handles.each(function (p, n) {
                    var o = (l.values(p) - l._valueMin()) / (l._valueMax() - l._valueMin()) * 100;
                    var m = {};
                    m[l.orientation == "horizontal" ? "left" : "bottom"] = o + "%";
                    a(this).stop(1, 1)[c ? "animate" : "css"](m, d.animate);
                    if (l.options.range === true) {
                        if (l.orientation == "horizontal") {
                            (p == 0) && l.range.stop(1, 1)[c ? "animate" : "css"]({
                                left: o + "%"
                            }, d.animate);
                            (p == 1) && l.range[c ? "animate" : "css"]({
                                width: (o - lastValPercent) + "%"
                            }, {
                                queue: false,
                                duration: d.animate
                            })
                        } else {
                            (p == 0) && l.range.stop(1, 1)[c ? "animate" : "css"]({
                                bottom: (o) + "%"
                            }, d.animate);
                            (p == 1) && l.range[c ? "animate" : "css"]({
                                height: (o - lastValPercent) + "%"
                            }, {
                                queue: false,
                                duration: d.animate
                            })
                        }
                    }
                    lastValPercent = o
                })
            } else {
                var j = this.value(),
                    g = this._valueMin(),
                    k = this._valueMax(),
                    e = k != g ? (j - g) / (k - g) * 100 : 0;
                var b = {};
                b[l.orientation == "horizontal" ? "left" : "bottom"] = e + "%";
                this.handle.stop(1, 1)[c ? "animate" : "css"](b, d.animate);
                (f == "min") && (this.orientation == "horizontal") && this.range.stop(1, 1)[c ? "animate" : "css"]({
                    width: e + "%"
                }, d.animate);
                (f == "max") && (this.orientation == "horizontal") && this.range[c ? "animate" : "css"]({
                    width: (100 - e) + "%"
                }, {
                    queue: false,
                    duration: d.animate
                });
                (f == "min") && (this.orientation == "vertical") && this.range.stop(1, 1)[c ? "animate" : "css"]({
                    height: e + "%"
                }, d.animate);
                (f == "max") && (this.orientation == "vertical") && this.range[c ? "animate" : "css"]({
                    height: (100 - e) + "%"
                }, {
                    queue: false,
                    duration: d.animate
                })
            }
        }
    }));
    a.extend(a.ui.slider, {
        getter: "value values",
        version: "1.7.2",
        eventPrefix: "slide",
        defaults: {
            animate: false,
            delay: 0,
            distance: 0,
            max: 100,
            min: 0,
            orientation: "horizontal",
            range: false,
            step: 1,
            value: 0,
            values: null
        }
    })
})(jQuery);
(function (a) {
    a.widget("ui.tabs", {
        _init: function () {
            if (this.options.deselectable !== undefined) {
                this.options.collapsible = this.options.deselectable
            }
            this._tabify(true)
        },
        _setData: function (b, c) {
            if (b == "selected") {
                if (this.options.collapsible && c == this.options.selected) {
                    return
                }
                this.select(c)
            } else {
                this.options[b] = c;
                if (b == "deselectable") {
                    this.options.collapsible = c
                }
                this._tabify()
            }
        },
        _tabId: function (b) {
            return b.title && b.title.replace(/\s/g, "_").replace(/[^A-Za-z0-9\-_:\.]/g, "") || this.options.idPrefix + a.data(b)
        },
        _sanitizeSelector: function (b) {
            return b.replace(/:/g, "\\:")
        },
        _cookie: function () {
            var b = this.cookie || (this.cookie = this.options.cookie.name || "ui-tabs-" + a.data(this.list[0]));
            return a.cookie.apply(null, [b].concat(a.makeArray(arguments)))
        },
        _ui: function (c, b) {
            return {
                tab: c,
                panel: b,
                index: this.anchors.index(c)
            }
        },
        _cleanup: function () {
            this.lis.filter(".ui-state-processing").removeClass("ui-state-processing").find("span:data(label.tabs)").each(function () {
                var b = a(this);
                b.html(b.data("label.tabs")).removeData("label.tabs")
            })
        },
        _tabify: function (n) {
            this.list = this.element.children("ul:first");
            this.lis = a("li:has(a[href])", this.list);
            this.anchors = this.lis.map(function () {
                return a("a", this)[0]
            });
            this.panels = a([]);
            var p = this,
                d = this.options;
            var c = /^#.+/;
            this.anchors.each(function (r, o) {
                var q = a(o).attr("href");
                var s = q.split("#")[0],
                    u;
                if (s && (s === location.toString().split("#")[0] || (u = a("base")[0]) && s === u.href)) {
                    q = o.hash;
                    o.href = q
                }
                if (c.test(q)) {
                    p.panels = p.panels.add(p._sanitizeSelector(q))
                } else {
                    if (q != "#") {
                        a.data(o, "href.tabs", q);
                        a.data(o, "load.tabs", q.replace(/#.*$/, ""));
                        var w = p._tabId(o);
                        o.href = "#" + w;
                        var v = a("#" + w);
                        if (!v.length) {
                            v = a(d.panelTemplate).attr("id", w).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").insertAfter(p.panels[r - 1] || p.list);
                            v.data("destroy.tabs", true)
                        }
                        p.panels = p.panels.add(v)
                    } else {
                        d.disabled.push(r)
                    }
                }
            });
            if (n) {
                this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all");
                this.list.addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all");
                this.lis.addClass("ui-state-default ui-corner-top");
                this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom");
                if (d.selected === undefined) {
                    if (location.hash) {
                        this.anchors.each(function (q, o) {
                            if (o.hash == location.hash) {
                                d.selected = q;
                                return false
                            }
                        })
                    }
                    if (typeof d.selected != "number" && d.cookie) {
                        d.selected = parseInt(p._cookie(), 10)
                    }
                    if (typeof d.selected != "number" && this.lis.filter(".ui-tabs-selected").length) {
                        d.selected = this.lis.index(this.lis.filter(".ui-tabs-selected"))
                    }
                    d.selected = d.selected || 0
                } else {
                    if (d.selected === null) {
                        d.selected = -1
                    }
                }
                d.selected = ((d.selected >= 0 && this.anchors[d.selected]) || d.selected < 0) ? d.selected : 0;
                d.disabled = a.unique(d.disabled.concat(a.map(this.lis.filter(".ui-state-disabled"), function (q, o) {
                    return p.lis.index(q)
                }))).sort();
                if (a.inArray(d.selected, d.disabled) != -1) {
                    d.disabled.splice(a.inArray(d.selected, d.disabled), 1)
                }
                this.panels.addClass("ui-tabs-hide");
                this.lis.removeClass("ui-tabs-selected ui-state-active");
                if (d.selected >= 0 && this.anchors.length) {
                    this.panels.eq(d.selected).removeClass("ui-tabs-hide");
                    this.lis.eq(d.selected).addClass("ui-tabs-selected ui-state-active");
                    p.element.queue("tabs", function () {
                        p._trigger("show", null, p._ui(p.anchors[d.selected], p.panels[d.selected]))
                    });
                    this.load(d.selected)
                }
                a(window).bind("unload", function () {
                    p.lis.add(p.anchors).unbind(".tabs");
                    p.lis = p.anchors = p.panels = null
                })
            } else {
                d.selected = this.lis.index(this.lis.filter(".ui-tabs-selected"))
            }
            this.element[d.collapsible ? "addClass" : "removeClass"]("ui-tabs-collapsible");
            if (d.cookie) {
                this._cookie(d.selected, d.cookie)
            }
            for (var g = 0, m;
                (m = this.lis[g]); g++) {
                a(m)[a.inArray(g, d.disabled) != -1 && !a(m).hasClass("ui-tabs-selected") ? "addClass" : "removeClass"]("ui-state-disabled")
            }
            if (d.cache === false) {
                this.anchors.removeData("cache.tabs")
            }
            this.lis.add(this.anchors).unbind(".tabs");
            if (d.event != "mouseover") {
                var f = function (o, i) {
                    if (i.is(":not(.ui-state-disabled)")) {
                        i.addClass("ui-state-" + o)
                    }
                };
                var j = function (o, i) {
                    i.removeClass("ui-state-" + o)
                };
                this.lis.bind("mouseover.tabs", function () {
                    f("hover", a(this))
                });
                this.lis.bind("mouseout.tabs", function () {
                    j("hover", a(this))
                });
                this.anchors.bind("focus.tabs", function () {
                    f("focus", a(this).closest("li"))
                });
                this.anchors.bind("blur.tabs", function () {
                    j("focus", a(this).closest("li"))
                })
            }
            var b, h;
            if (d.fx) {
                if (a.isArray(d.fx)) {
                    b = d.fx[0];
                    h = d.fx[1]
                } else {
                    b = h = d.fx
                }
            }

            function e(i, o) {
                i.css({
                    display: ""
                });
                if (a.browser.msie && o.opacity) {
                    i[0].style.removeAttribute("filter")
                }
            }
            var k = h ? function (i, o) {
                a(i).closest("li").removeClass("ui-state-default").addClass("ui-tabs-selected ui-state-active");
                o.hide().removeClass("ui-tabs-hide").animate(h, h.duration || "normal", function () {
                    e(o, h);
                    p._trigger("show", null, p._ui(i, o[0]))
                })
            } : function (i, o) {
                a(i).closest("li").removeClass("ui-state-default").addClass("ui-tabs-selected ui-state-active");
                o.removeClass("ui-tabs-hide");
                p._trigger("show", null, p._ui(i, o[0]))
            };
            var l = b ? function (o, i) {
                i.animate(b, b.duration || "normal", function () {
                    p.lis.removeClass("ui-tabs-selected ui-state-active").addClass("ui-state-default");
                    i.addClass("ui-tabs-hide");
                    e(i, b);
                    p.element.dequeue("tabs")
                })
            } : function (o, i, q) {
                p.lis.removeClass("ui-tabs-selected ui-state-active").addClass("ui-state-default");
                i.addClass("ui-tabs-hide");
                p.element.dequeue("tabs")
            };
            this.anchors.bind(d.event + ".tabs", function () {
                var o = this,
                    r = a(this).closest("li"),
                    i = p.panels.filter(":not(.ui-tabs-hide)"),
                    q = a(p._sanitizeSelector(this.hash));
                if ((r.hasClass("ui-tabs-selected") && !d.collapsible) || r.hasClass("ui-state-disabled") || r.hasClass("ui-state-processing") || p._trigger("select", null, p._ui(this, q[0])) === false) {
                    this.blur();
                    return false
                }
                d.selected = p.anchors.index(this);
                p.abort();
                if (d.collapsible) {
                    if (r.hasClass("ui-tabs-selected")) {
                        d.selected = -1;
                        if (d.cookie) {
                            p._cookie(d.selected, d.cookie)
                        }
                        p.element.queue("tabs", function () {
                            l(o, i)
                        }).dequeue("tabs");
                        this.blur();
                        return false
                    } else {
                        if (!i.length) {
                            if (d.cookie) {
                                p._cookie(d.selected, d.cookie)
                            }
                            p.element.queue("tabs", function () {
                                k(o, q)
                            });
                            p.load(p.anchors.index(this));
                            this.blur();
                            return false
                        }
                    }
                }
                if (d.cookie) {
                    p._cookie(d.selected, d.cookie)
                }
                if (q.length) {
                    if (i.length) {
                        p.element.queue("tabs", function () {
                            l(o, i)
                        })
                    }
                    p.element.queue("tabs", function () {
                        k(o, q)
                    });
                    p.load(p.anchors.index(this))
                } else {
                    throw "jQuery UI Tabs: Mismatching fragment identifier."
                } if (a.browser.msie) {
                    this.blur()
                }
            });
            this.anchors.bind("click.tabs", function () {
                return false
            })
        },
        destroy: function () {
            var b = this.options;
            this.abort();
            this.element.unbind(".tabs").removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible").removeData("tabs");
            this.list.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all");
            this.anchors.each(function () {
                var c = a.data(this, "href.tabs");
                if (c) {
                    this.href = c
                }
                var d = a(this).unbind(".tabs");
                a.each(["href", "load", "cache"], function (e, f) {
                    d.removeData(f + ".tabs")
                })
            });
            this.lis.unbind(".tabs").add(this.panels).each(function () {
                if (a.data(this, "destroy.tabs")) {
                    a(this).remove()
                } else {
                    a(this).removeClass(["ui-state-default", "ui-corner-top", "ui-tabs-selected", "ui-state-active", "ui-state-hover", "ui-state-focus", "ui-state-disabled", "ui-tabs-panel", "ui-widget-content", "ui-corner-bottom", "ui-tabs-hide"].join(" "))
                }
            });
            if (b.cookie) {
                this._cookie(null, b.cookie)
            }
        },
        add: function (e, d, c) {
            if (c === undefined) {
                c = this.anchors.length
            }
            var b = this,
                g = this.options,
                i = a(g.tabTemplate.replace(/#\{href\}/g, e).replace(/#\{label\}/g, d)),
                h = !e.indexOf("#") ? e.replace("#", "") : this._tabId(a("a", i)[0]);
            i.addClass("ui-state-default ui-corner-top").data("destroy.tabs", true);
            var f = a("#" + h);
            if (!f.length) {
                f = a(g.panelTemplate).attr("id", h).data("destroy.tabs", true)
            }
            f.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide");
            if (c >= this.lis.length) {
                i.appendTo(this.list);
                f.appendTo(this.list[0].parentNode)
            } else {
                i.insertBefore(this.lis[c]);
                f.insertBefore(this.panels[c])
            }
            g.disabled = a.map(g.disabled, function (k, j) {
                return k >= c ? ++k : k
            });
            this._tabify();
            if (this.anchors.length == 1) {
                i.addClass("ui-tabs-selected ui-state-active");
                f.removeClass("ui-tabs-hide");
                this.element.queue("tabs", function () {
                    b._trigger("show", null, b._ui(b.anchors[0], b.panels[0]))
                });
                this.load(0)
            }
            this._trigger("add", null, this._ui(this.anchors[c], this.panels[c]))
        },
        remove: function (b) {
            var d = this.options,
                e = this.lis.eq(b).remove(),
                c = this.panels.eq(b).remove();
            if (e.hasClass("ui-tabs-selected") && this.anchors.length > 1) {
                this.select(b + (b + 1 < this.anchors.length ? 1 : -1))
            }
            d.disabled = a.map(a.grep(d.disabled, function (g, f) {
                return g != b
            }), function (g, f) {
                return g >= b ? --g : g
            });
            this._tabify();
            this._trigger("remove", null, this._ui(e.find("a")[0], c[0]))
        },
        enable: function (b) {
            var c = this.options;
            if (a.inArray(b, c.disabled) == -1) {
                return
            }
            this.lis.eq(b).removeClass("ui-state-disabled");
            c.disabled = a.grep(c.disabled, function (e, d) {
                return e != b
            });
            this._trigger("enable", null, this._ui(this.anchors[b], this.panels[b]))
        },
        disable: function (c) {
            var b = this,
                d = this.options;
            if (c != d.selected) {
                this.lis.eq(c).addClass("ui-state-disabled");
                d.disabled.push(c);
                d.disabled.sort();
                this._trigger("disable", null, this._ui(this.anchors[c], this.panels[c]))
            }
        },
        select: function (b) {
            if (typeof b == "string") {
                b = this.anchors.index(this.anchors.filter("[href$=" + b + "]"))
            } else {
                if (b === null) {
                    b = -1
                }
            } if (b == -1 && this.options.collapsible) {
                b = this.options.selected
            }
            this.anchors.eq(b).trigger(this.options.event + ".tabs")
        },
        load: function (e) {
            var c = this,
                g = this.options,
                b = this.anchors.eq(e)[0],
                d = a.data(b, "load.tabs");
            this.abort();
            if (!d || this.element.queue("tabs").length !== 0 && a.data(b, "cache.tabs")) {
                this.element.dequeue("tabs");
                return
            }
            this.lis.eq(e).addClass("ui-state-processing");
            if (g.spinner) {
                var f = a("span", b);
                f.data("label.tabs", f.html()).html(g.spinner)
            }
            this.xhr = a.ajax(a.extend({}, g.ajaxOptions, {
                url: d,
                success: function (i, h) {
                    a(c._sanitizeSelector(b.hash)).html(i);
                    c._cleanup();
                    if (g.cache) {
                        a.data(b, "cache.tabs", true)
                    }
                    c._trigger("load", null, c._ui(c.anchors[e], c.panels[e]));
                    try {
                        g.ajaxOptions.success(i, h)
                    } catch (j) {}
                    c.element.dequeue("tabs")
                }
            }))
        },
        abort: function () {
            this.element.queue([]);
            this.panels.stop(false, true);
            if (this.xhr) {
                this.xhr.abort();
                delete this.xhr
            }
            this._cleanup()
        },
        url: function (c, b) {
            this.anchors.eq(c).removeData("cache.tabs").data("load.tabs", b)
        },
        length: function () {
            return this.anchors.length
        }
    });
    a.extend(a.ui.tabs, {
        version: "1.7.2",
        getter: "length",
        defaults: {
            ajaxOptions: null,
            cache: false,
            cookie: null,
            collapsible: false,
            disabled: [],
            event: "click",
            fx: null,
            idPrefix: "ui-tabs-",
            panelTemplate: "<div></div>",
            spinner: "<em>Loading&#8230;</em>",
            tabTemplate: '<li><a href="#{href}"><span>#{label}</span></a></li>'
        }
    });
    a.extend(a.ui.tabs.prototype, {
        rotation: null,
        rotate: function (d, f) {
            var b = this,
                g = this.options;
            var c = b._rotate || (b._rotate = function (h) {
                clearTimeout(b.rotation);
                b.rotation = setTimeout(function () {
                    var i = g.selected;
                    b.select(++i < b.anchors.length ? i : 0)
                }, d);
                if (h) {
                    h.stopPropagation()
                }
            });
            var e = b._unrotate || (b._unrotate = !f ? function (h) {
                if (h.clientX) {
                    b.rotate(null)
                }
            } : function (h) {
                t = g.selected;
                c()
            });
            if (d) {
                this.element.bind("tabsshow", c);
                this.anchors.bind(g.event + ".tabs", e);
                c()
            } else {
                clearTimeout(b.rotation);
                this.element.unbind("tabsshow", c);
                this.anchors.unbind(g.event + ".tabs", e);
                delete this._rotate;
                delete this._unrotate
            }
        }
    })
})(jQuery);
(function (a) {
    a.widget("ui.progressbar", {
        _init: function () {
            this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
                role: "progressbar",
                "aria-valuemin": this._valueMin(),
                "aria-valuemax": this._valueMax(),
                "aria-valuenow": this._value()
            });
            this.valueDiv = a('<div class="ui-progressbar-value ui-widget-header ui-corner-left"></div>').appendTo(this.element);
            this._refreshValue()
        },
        destroy: function () {
            this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow").removeData("progressbar").unbind(".progressbar");
            this.valueDiv.remove();
            a.widget.prototype.destroy.apply(this, arguments)
        },
        value: function (b) {
            if (b === undefined) {
                return this._value()
            }
            this._setData("value", b);
            return this
        },
        _setData: function (b, c) {
            switch (b) {
            case "value":
                this.options.value = c;
                this._refreshValue();
                this._trigger("change", null, {});
                break
            }
            a.widget.prototype._setData.apply(this, arguments)
        },
        _value: function () {
            var b = this.options.value;
            if (b < this._valueMin()) {
                b = this._valueMin()
            }
            if (b > this._valueMax()) {
                b = this._valueMax()
            }
            return b
        },
        _valueMin: function () {
            var b = 0;
            return b
        },
        _valueMax: function () {
            var b = 100;
            return b
        },
        _refreshValue: function () {
            var b = this.value();
            this.valueDiv[b == this._valueMax() ? "addClass" : "removeClass"]("ui-corner-right");
            this.valueDiv.width(b + "%");
            this.element.attr("aria-valuenow", b)
        }
    });
    a.extend(a.ui.progressbar, {
        version: "1.7.2",
        defaults: {
            value: 0
        }
    })
})(jQuery);
jQuery.effects || (function (d) {
    d.effects = {
        version: "1.7.2",
        save: function (g, h) {
            for (var f = 0; f < h.length; f++) {
                if (h[f] !== null) {
                    g.data("ec.storage." + h[f], g[0].style[h[f]])
                }
            }
        },
        restore: function (g, h) {
            for (var f = 0; f < h.length; f++) {
                if (h[f] !== null) {
                    g.css(h[f], g.data("ec.storage." + h[f]))
                }
            }
        },
        setMode: function (f, g) {
            if (g == "toggle") {
                g = f.is(":hidden") ? "show" : "hide"
            }
            return g
        },
        getBaseline: function (g, h) {
            var i, f;
            switch (g[0]) {
            case "top":
                i = 0;
                break;
            case "middle":
                i = 0.5;
                break;
            case "bottom":
                i = 1;
                break;
            default:
                i = g[0] / h.height
            }
            switch (g[1]) {
            case "left":
                f = 0;
                break;
            case "center":
                f = 0.5;
                break;
            case "right":
                f = 1;
                break;
            default:
                f = g[1] / h.width
            }
            return {
                x: f,
                y: i
            }
        },
        createWrapper: function (f) {
            if (f.parent().is(".ui-effects-wrapper")) {
                return f.parent()
            }
            var g = {
                width: f.outerWidth(true),
                height: f.outerHeight(true),
                "float": f.css("float")
            };
            f.wrap('<div class="ui-effects-wrapper" style="font-size:100%;background:transparent;border:none;margin:0;padding:0"></div>');
            var j = f.parent();
            if (f.css("position") == "static") {
                j.css({
                    position: "relative"
                });
                f.css({
                    position: "relative"
                })
            } else {
                var i = f.css("top");
                if (isNaN(parseInt(i, 10))) {
                    i = "auto"
                }
                var h = f.css("left");
                if (isNaN(parseInt(h, 10))) {
                    h = "auto"
                }
                j.css({
                    position: f.css("position"),
                    top: i,
                    left: h,
                    zIndex: f.css("z-index")
                }).show();
                f.css({
                    position: "relative",
                    top: 0,
                    left: 0
                })
            }
            j.css(g);
            return j
        },
        removeWrapper: function (f) {
            if (f.parent().is(".ui-effects-wrapper")) {
                return f.parent().replaceWith(f)
            }
            return f
        },
        setTransition: function (g, i, f, h) {
            h = h || {};
            d.each(i, function (k, j) {
                unit = g.cssUnit(j);
                if (unit[0] > 0) {
                    h[j] = unit[0] * f + unit[1]
                }
            });
            return h
        },
        animateClass: function (h, i, k, j) {
            var f = (typeof k == "function" ? k : (j ? j : null));
            var g = (typeof k == "string" ? k : null);
            return this.each(function () {
                var q = {};
                var o = d(this);
                var p = o.attr("style") || "";
                if (typeof p == "object") {
                    p = p.cssText
                }
                if (h.toggle) {
                    o.hasClass(h.toggle) ? h.remove = h.toggle : h.add = h.toggle
                }
                var l = d.extend({}, (document.defaultView ? document.defaultView.getComputedStyle(this, null) : this.currentStyle));
                if (h.add) {
                    o.addClass(h.add)
                }
                if (h.remove) {
                    o.removeClass(h.remove)
                }
                var m = d.extend({}, (document.defaultView ? document.defaultView.getComputedStyle(this, null) : this.currentStyle));
                if (h.add) {
                    o.removeClass(h.add)
                }
                if (h.remove) {
                    o.addClass(h.remove)
                }
                for (var r in m) {
                    if (typeof m[r] != "function" && m[r] && r.indexOf("Moz") == -1 && r.indexOf("length") == -1 && m[r] != l[r] && (r.match(/color/i) || (!r.match(/color/i) && !isNaN(parseInt(m[r], 10)))) && (l.position != "static" || (l.position == "static" && !r.match(/left|top|bottom|right/)))) {
                        q[r] = m[r]
                    }
                }
                o.animate(q, i, g, function () {
                    if (typeof d(this).attr("style") == "object") {
                        d(this).attr("style")["cssText"] = "";
                        d(this).attr("style")["cssText"] = p
                    } else {
                        d(this).attr("style", p)
                    } if (h.add) {
                        d(this).addClass(h.add)
                    }
                    if (h.remove) {
                        d(this).removeClass(h.remove)
                    }
                    if (f) {
                        f.apply(this, arguments)
                    }
                })
            })
        }
    };

    function c(g, f) {
        var i = g[1] && g[1].constructor == Object ? g[1] : {};
        if (f) {
            i.mode = f
        }
        var h = g[1] && g[1].constructor != Object ? g[1] : (i.duration ? i.duration : g[2]);
        h = d.fx.off ? 0 : typeof h === "number" ? h : d.fx.speeds[h] || d.fx.speeds._default;
        var j = i.callback || (d.isFunction(g[1]) && g[1]) || (d.isFunction(g[2]) && g[2]) || (d.isFunction(g[3]) && g[3]);
        return [g[0], i, h, j]
    }
    d.fn.extend({
        _show: d.fn.show,
        _hide: d.fn.hide,
        __toggle: d.fn.toggle,
        _addClass: d.fn.addClass,
        _removeClass: d.fn.removeClass,
        _toggleClass: d.fn.toggleClass,
        effect: function (g, f, h, i) {
            return d.effects[g] ? d.effects[g].call(this, {
                method: g,
                options: f || {},
                duration: h,
                callback: i
            }) : null
        },
        show: function () {
            if (!arguments[0] || (arguments[0].constructor == Number || (/(slow|normal|fast)/).test(arguments[0]))) {
                return this._show.apply(this, arguments)
            } else {
                return this.effect.apply(this, c(arguments, "show"))
            }
        },
        hide: function () {
            if (!arguments[0] || (arguments[0].constructor == Number || (/(slow|normal|fast)/).test(arguments[0]))) {
                return this._hide.apply(this, arguments)
            } else {
                return this.effect.apply(this, c(arguments, "hide"))
            }
        },
        toggle: function () {
            if (!arguments[0] || (arguments[0].constructor == Number || (/(slow|normal|fast)/).test(arguments[0])) || (d.isFunction(arguments[0]) || typeof arguments[0] == "boolean")) {
                return this.__toggle.apply(this, arguments)
            } else {
                return this.effect.apply(this, c(arguments, "toggle"))
            }
        },
        addClass: function (g, f, i, h) {
            return f ? d.effects.animateClass.apply(this, [{
                    add: g
                },
                f, i, h
            ]) : this._addClass(g)
        },
        removeClass: function (g, f, i, h) {
            return f ? d.effects.animateClass.apply(this, [{
                    remove: g
                },
                f, i, h
            ]) : this._removeClass(g)
        },
        toggleClass: function (g, f, i, h) {
            return ((typeof f !== "boolean") && f) ? d.effects.animateClass.apply(this, [{
                    toggle: g
                },
                f, i, h
            ]) : this._toggleClass(g, f)
        },
        morph: function (f, h, g, j, i) {
            return d.effects.animateClass.apply(this, [{
                    add: h,
                    remove: f
                },
                g, j, i
            ])
        },
        switchClass: function () {
            return this.morph.apply(this, arguments)
        },
        cssUnit: function (f) {
            var g = this.css(f),
                h = [];
            d.each(["em", "px", "%", "pt"], function (j, k) {
                if (g.indexOf(k) > 0) {
                    h = [parseFloat(g), k]
                }
            });
            return h
        }
    });
    d.each(["backgroundColor", "borderBottomColor", "borderLeftColor", "borderRightColor", "borderTopColor", "color", "outlineColor"], function (g, f) {
        d.fx.step[f] = function (h) {
            if (h.state == 0) {
                h.start = e(h.elem, f);
                h.end = b(h.end)
            }
            h.elem.style[f] = "rgb(" + [Math.max(Math.min(parseInt((h.pos * (h.end[0] - h.start[0])) + h.start[0], 10), 255), 0), Math.max(Math.min(parseInt((h.pos * (h.end[1] - h.start[1])) + h.start[1], 10), 255), 0), Math.max(Math.min(parseInt((h.pos * (h.end[2] - h.start[2])) + h.start[2], 10), 255), 0)].join(",") + ")"
        }
    });

    function b(g) {
        var f;
        if (g && g.constructor == Array && g.length == 3) {
            return g
        }
        if (f = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(g)) {
            return [parseInt(f[1], 10), parseInt(f[2], 10), parseInt(f[3], 10)]
        }
        if (f = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(g)) {
            return [parseFloat(f[1]) * 2.55, parseFloat(f[2]) * 2.55, parseFloat(f[3]) * 2.55]
        }
        if (f = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(g)) {
            return [parseInt(f[1], 16), parseInt(f[2], 16), parseInt(f[3], 16)]
        }
        if (f = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(g)) {
            return [parseInt(f[1] + f[1], 16), parseInt(f[2] + f[2], 16), parseInt(f[3] + f[3], 16)]
        }
        if (f = /rgba\(0, 0, 0, 0\)/.exec(g)) {
            return a.transparent
        }
        return a[d.trim(g).toLowerCase()]
    }

    function e(h, f) {
        var g;
        do {
            g = d.curCSS(h, f);
            if (g != "" && g != "transparent" || d.nodeName(h, "body")) {
                break
            }
            f = "backgroundColor"
        } while (h = h.parentNode);
        return b(g)
    }
    var a = {
        aqua: [0, 255, 255],
        azure: [240, 255, 255],
        beige: [245, 245, 220],
        black: [0, 0, 0],
        blue: [0, 0, 255],
        brown: [165, 42, 42],
        cyan: [0, 255, 255],
        darkblue: [0, 0, 139],
        darkcyan: [0, 139, 139],
        darkgrey: [169, 169, 169],
        darkgreen: [0, 100, 0],
        darkkhaki: [189, 183, 107],
        darkmagenta: [139, 0, 139],
        darkolivegreen: [85, 107, 47],
        darkorange: [255, 140, 0],
        darkorchid: [153, 50, 204],
        darkred: [139, 0, 0],
        darksalmon: [233, 150, 122],
        darkviolet: [148, 0, 211],
        fuchsia: [255, 0, 255],
        gold: [255, 215, 0],
        green: [0, 128, 0],
        indigo: [75, 0, 130],
        khaki: [240, 230, 140],
        lightblue: [173, 216, 230],
        lightcyan: [224, 255, 255],
        lightgreen: [144, 238, 144],
        lightgrey: [211, 211, 211],
        lightpink: [255, 182, 193],
        lightyellow: [255, 255, 224],
        lime: [0, 255, 0],
        magenta: [255, 0, 255],
        maroon: [128, 0, 0],
        navy: [0, 0, 128],
        olive: [128, 128, 0],
        orange: [255, 165, 0],
        pink: [255, 192, 203],
        purple: [128, 0, 128],
        violet: [128, 0, 128],
        red: [255, 0, 0],
        silver: [192, 192, 192],
        white: [255, 255, 255],
        yellow: [255, 255, 0],
        transparent: [255, 255, 255]
    };
    d.easing.jswing = d.easing.swing;
    d.extend(d.easing, {
        def: "easeOutQuad",
        swing: function (g, h, f, j, i) {
            return d.easing[d.easing.def](g, h, f, j, i)
        },
        easeInQuad: function (g, h, f, j, i) {
            return j * (h /= i) * h + f
        },
        easeOutQuad: function (g, h, f, j, i) {
            return -j * (h /= i) * (h - 2) + f
        },
        easeInOutQuad: function (g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h + f
            }
            return -j / 2 * ((--h) * (h - 2) - 1) + f
        },
        easeInCubic: function (g, h, f, j, i) {
            return j * (h /= i) * h * h + f
        },
        easeOutCubic: function (g, h, f, j, i) {
            return j * ((h = h / i - 1) * h * h + 1) + f
        },
        easeInOutCubic: function (g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h * h + f
            }
            return j / 2 * ((h -= 2) * h * h + 2) + f
        },
        easeInQuart: function (g, h, f, j, i) {
            return j * (h /= i) * h * h * h + f
        },
        easeOutQuart: function (g, h, f, j, i) {
            return -j * ((h = h / i - 1) * h * h * h - 1) + f
        },
        easeInOutQuart: function (g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h * h * h + f
            }
            return -j / 2 * ((h -= 2) * h * h * h - 2) + f
        },
        easeInQuint: function (g, h, f, j, i) {
            return j * (h /= i) * h * h * h * h + f
        },
        easeOutQuint: function (g, h, f, j, i) {
            return j * ((h = h / i - 1) * h * h * h * h + 1) + f
        },
        easeInOutQuint: function (g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h * h * h * h + f
            }
            return j / 2 * ((h -= 2) * h * h * h * h + 2) + f
        },
        easeInSine: function (g, h, f, j, i) {
            return -j * Math.cos(h / i * (Math.PI / 2)) + j + f
        },
        easeOutSine: function (g, h, f, j, i) {
            return j * Math.sin(h / i * (Math.PI / 2)) + f
        },
        easeInOutSine: function (g, h, f, j, i) {
            return -j / 2 * (Math.cos(Math.PI * h / i) - 1) + f
        },
        easeInExpo: function (g, h, f, j, i) {
            return (h == 0) ? f : j * Math.pow(2, 10 * (h / i - 1)) + f
        },
        easeOutExpo: function (g, h, f, j, i) {
            return (h == i) ? f + j : j * (-Math.pow(2, -10 * h / i) + 1) + f
        },
        easeInOutExpo: function (g, h, f, j, i) {
            if (h == 0) {
                return f
            }
            if (h == i) {
                return f + j
            }
            if ((h /= i / 2) < 1) {
                return j / 2 * Math.pow(2, 10 * (h - 1)) + f
            }
            return j / 2 * (-Math.pow(2, -10 * --h) + 2) + f
        },
        easeInCirc: function (g, h, f, j, i) {
            return -j * (Math.sqrt(1 - (h /= i) * h) - 1) + f
        },
        easeOutCirc: function (g, h, f, j, i) {
            return j * Math.sqrt(1 - (h = h / i - 1) * h) + f
        },
        easeInOutCirc: function (g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return -j / 2 * (Math.sqrt(1 - h * h) - 1) + f
            }
            return j / 2 * (Math.sqrt(1 - (h -= 2) * h) + 1) + f
        },
        easeInElastic: function (g, i, f, m, l) {
            var j = 1.70158;
            var k = 0;
            var h = m;
            if (i == 0) {
                return f
            }
            if ((i /= l) == 1) {
                return f + m
            }
            if (!k) {
                k = l * 0.3
            }
            if (h < Math.abs(m)) {
                h = m;
                var j = k / 4
            } else {
                var j = k / (2 * Math.PI) * Math.asin(m / h)
            }
            return -(h * Math.pow(2, 10 * (i -= 1)) * Math.sin((i * l - j) * (2 * Math.PI) / k)) + f
        },
        easeOutElastic: function (g, i, f, m, l) {
            var j = 1.70158;
            var k = 0;
            var h = m;
            if (i == 0) {
                return f
            }
            if ((i /= l) == 1) {
                return f + m
            }
            if (!k) {
                k = l * 0.3
            }
            if (h < Math.abs(m)) {
                h = m;
                var j = k / 4
            } else {
                var j = k / (2 * Math.PI) * Math.asin(m / h)
            }
            return h * Math.pow(2, -10 * i) * Math.sin((i * l - j) * (2 * Math.PI) / k) + m + f
        },
        easeInOutElastic: function (g, i, f, m, l) {
            var j = 1.70158;
            var k = 0;
            var h = m;
            if (i == 0) {
                return f
            }
            if ((i /= l / 2) == 2) {
                return f + m
            }
            if (!k) {
                k = l * (0.3 * 1.5)
            }
            if (h < Math.abs(m)) {
                h = m;
                var j = k / 4
            } else {
                var j = k / (2 * Math.PI) * Math.asin(m / h)
            } if (i < 1) {
                return -0.5 * (h * Math.pow(2, 10 * (i -= 1)) * Math.sin((i * l - j) * (2 * Math.PI) / k)) + f
            }
            return h * Math.pow(2, -10 * (i -= 1)) * Math.sin((i * l - j) * (2 * Math.PI) / k) * 0.5 + m + f
        },
        easeInBack: function (g, h, f, k, j, i) {
            if (i == undefined) {
                i = 1.70158
            }
            return k * (h /= j) * h * ((i + 1) * h - i) + f
        },
        easeOutBack: function (g, h, f, k, j, i) {
            if (i == undefined) {
                i = 1.70158
            }
            return k * ((h = h / j - 1) * h * ((i + 1) * h + i) + 1) + f
        },
        easeInOutBack: function (g, h, f, k, j, i) {
            if (i == undefined) {
                i = 1.70158
            }
            if ((h /= j / 2) < 1) {
                return k / 2 * (h * h * (((i *= (1.525)) + 1) * h - i)) + f
            }
            return k / 2 * ((h -= 2) * h * (((i *= (1.525)) + 1) * h + i) + 2) + f
        },
        easeInBounce: function (g, h, f, j, i) {
            return j - d.easing.easeOutBounce(g, i - h, 0, j, i) + f
        },
        easeOutBounce: function (g, h, f, j, i) {
            if ((h /= i) < (1 / 2.75)) {
                return j * (7.5625 * h * h) + f
            } else {
                if (h < (2 / 2.75)) {
                    return j * (7.5625 * (h -= (1.5 / 2.75)) * h + 0.75) + f
                } else {
                    if (h < (2.5 / 2.75)) {
                        return j * (7.5625 * (h -= (2.25 / 2.75)) * h + 0.9375) + f
                    } else {
                        return j * (7.5625 * (h -= (2.625 / 2.75)) * h + 0.984375) + f
                    }
                }
            }
        },
        easeInOutBounce: function (g, h, f, j, i) {
            if (h < i / 2) {
                return d.easing.easeInBounce(g, h * 2, 0, j, i) * 0.5 + f
            }
            return d.easing.easeOutBounce(g, h * 2 - i, 0, j, i) * 0.5 + j * 0.5 + f
        }
    })
})(jQuery);
(function (a) {
    a.effects.blind = function (b) {
        return this.queue(function () {
            var d = a(this),
                c = ["position", "top", "left"];
            var h = a.effects.setMode(d, b.options.mode || "hide");
            var g = b.options.direction || "vertical";
            a.effects.save(d, c);
            d.show();
            var j = a.effects.createWrapper(d).css({
                overflow: "hidden"
            });
            var e = (g == "vertical") ? "height" : "width";
            var i = (g == "vertical") ? j.height() : j.width();
            if (h == "show") {
                j.css(e, 0)
            }
            var f = {};
            f[e] = h == "show" ? i : 0;
            j.animate(f, b.duration, b.options.easing, function () {
                if (h == "hide") {
                    d.hide()
                }
                a.effects.restore(d, c);
                a.effects.removeWrapper(d);
                if (b.callback) {
                    b.callback.apply(d[0], arguments)
                }
                d.dequeue()
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.bounce = function (b) {
        return this.queue(function () {
            var e = a(this),
                l = ["position", "top", "left"];
            var k = a.effects.setMode(e, b.options.mode || "effect");
            var n = b.options.direction || "up";
            var c = b.options.distance || 20;
            var d = b.options.times || 5;
            var g = b.duration || 250;
            if (/show|hide/.test(k)) {
                l.push("opacity")
            }
            a.effects.save(e, l);
            e.show();
            a.effects.createWrapper(e);
            var f = (n == "up" || n == "down") ? "top" : "left";
            var p = (n == "up" || n == "left") ? "pos" : "neg";
            var c = b.options.distance || (f == "top" ? e.outerHeight({
                margin: true
            }) / 3 : e.outerWidth({
                margin: true
            }) / 3);
            if (k == "show") {
                e.css("opacity", 0).css(f, p == "pos" ? -c : c)
            }
            if (k == "hide") {
                c = c / (d * 2)
            }
            if (k != "hide") {
                d--
            }
            if (k == "show") {
                var h = {
                    opacity: 1
                };
                h[f] = (p == "pos" ? "+=" : "-=") + c;
                e.animate(h, g / 2, b.options.easing);
                c = c / 2;
                d--
            }
            for (var j = 0; j < d; j++) {
                var o = {},
                    m = {};
                o[f] = (p == "pos" ? "-=" : "+=") + c;
                m[f] = (p == "pos" ? "+=" : "-=") + c;
                e.animate(o, g / 2, b.options.easing).animate(m, g / 2, b.options.easing);
                c = (k == "hide") ? c * 2 : c / 2
            }
            if (k == "hide") {
                var h = {
                    opacity: 0
                };
                h[f] = (p == "pos" ? "-=" : "+=") + c;
                e.animate(h, g / 2, b.options.easing, function () {
                    e.hide();
                    a.effects.restore(e, l);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            } else {
                var o = {},
                    m = {};
                o[f] = (p == "pos" ? "-=" : "+=") + c;
                m[f] = (p == "pos" ? "+=" : "-=") + c;
                e.animate(o, g / 2, b.options.easing).animate(m, g / 2, b.options.easing, function () {
                    a.effects.restore(e, l);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            }
            e.queue("fx", function () {
                e.dequeue()
            });
            e.dequeue()
        })
    }
})(jQuery);
(function (a) {
    a.effects.clip = function (b) {
        return this.queue(function () {
            var f = a(this),
                j = ["position", "top", "left", "height", "width"];
            var i = a.effects.setMode(f, b.options.mode || "hide");
            var k = b.options.direction || "vertical";
            a.effects.save(f, j);
            f.show();
            var c = a.effects.createWrapper(f).css({
                overflow: "hidden"
            });
            var e = f[0].tagName == "IMG" ? c : f;
            var g = {
                size: (k == "vertical") ? "height" : "width",
                position: (k == "vertical") ? "top" : "left"
            };
            var d = (k == "vertical") ? e.height() : e.width();
            if (i == "show") {
                e.css(g.size, 0);
                e.css(g.position, d / 2)
            }
            var h = {};
            h[g.size] = i == "show" ? d : 0;
            h[g.position] = i == "show" ? 0 : d / 2;
            e.animate(h, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function () {
                    if (i == "hide") {
                        f.hide()
                    }
                    a.effects.restore(f, j);
                    a.effects.removeWrapper(f);
                    if (b.callback) {
                        b.callback.apply(f[0], arguments)
                    }
                    f.dequeue()
                }
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.drop = function (b) {
        return this.queue(function () {
            var e = a(this),
                d = ["position", "top", "left", "opacity"];
            var i = a.effects.setMode(e, b.options.mode || "hide");
            var h = b.options.direction || "left";
            a.effects.save(e, d);
            e.show();
            a.effects.createWrapper(e);
            var f = (h == "up" || h == "down") ? "top" : "left";
            var c = (h == "up" || h == "left") ? "pos" : "neg";
            var j = b.options.distance || (f == "top" ? e.outerHeight({
                margin: true
            }) / 2 : e.outerWidth({
                margin: true
            }) / 2);
            if (i == "show") {
                e.css("opacity", 0).css(f, c == "pos" ? -j : j)
            }
            var g = {
                opacity: i == "show" ? 1 : 0
            };
            g[f] = (i == "show" ? (c == "pos" ? "+=" : "-=") : (c == "pos" ? "-=" : "+=")) + j;
            e.animate(g, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function () {
                    if (i == "hide") {
                        e.hide()
                    }
                    a.effects.restore(e, d);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    e.dequeue()
                }
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.explode = function (b) {
        return this.queue(function () {
            var k = b.options.pieces ? Math.round(Math.sqrt(b.options.pieces)) : 3;
            var e = b.options.pieces ? Math.round(Math.sqrt(b.options.pieces)) : 3;
            b.options.mode = b.options.mode == "toggle" ? (a(this).is(":visible") ? "hide" : "show") : b.options.mode;
            var h = a(this).show().css("visibility", "hidden");
            var l = h.offset();
            l.top -= parseInt(h.css("marginTop"), 10) || 0;
            l.left -= parseInt(h.css("marginLeft"), 10) || 0;
            var g = h.outerWidth(true);
            var c = h.outerHeight(true);
            for (var f = 0; f < k; f++) {
                for (var d = 0; d < e; d++) {
                    h.clone().appendTo("body").wrap("<div></div>").css({
                        position: "absolute",
                        visibility: "visible",
                        left: -d * (g / e),
                        top: -f * (c / k)
                    }).parent().addClass("ui-effects-explode").css({
                        position: "absolute",
                        overflow: "hidden",
                        width: g / e,
                        height: c / k,
                        left: l.left + d * (g / e) + (b.options.mode == "show" ? (d - Math.floor(e / 2)) * (g / e) : 0),
                        top: l.top + f * (c / k) + (b.options.mode == "show" ? (f - Math.floor(k / 2)) * (c / k) : 0),
                        opacity: b.options.mode == "show" ? 0 : 1
                    }).animate({
                        left: l.left + d * (g / e) + (b.options.mode == "show" ? 0 : (d - Math.floor(e / 2)) * (g / e)),
                        top: l.top + f * (c / k) + (b.options.mode == "show" ? 0 : (f - Math.floor(k / 2)) * (c / k)),
                        opacity: b.options.mode == "show" ? 1 : 0
                    }, b.duration || 500)
                }
            }
            setTimeout(function () {
                b.options.mode == "show" ? h.css({
                    visibility: "visible"
                }) : h.css({
                    visibility: "visible"
                }).hide();
                if (b.callback) {
                    b.callback.apply(h[0])
                }
                h.dequeue();
                a("div.ui-effects-explode").remove()
            }, b.duration || 500)
        })
    }
})(jQuery);
(function (a) {
    a.effects.fold = function (b) {
        return this.queue(function () {
            var e = a(this),
                k = ["position", "top", "left"];
            var h = a.effects.setMode(e, b.options.mode || "hide");
            var o = b.options.size || 15;
            var n = !(!b.options.horizFirst);
            var g = b.duration ? b.duration / 2 : a.fx.speeds._default / 2;
            a.effects.save(e, k);
            e.show();
            var d = a.effects.createWrapper(e).css({
                overflow: "hidden"
            });
            var i = ((h == "show") != n);
            var f = i ? ["width", "height"] : ["height", "width"];
            var c = i ? [d.width(), d.height()] : [d.height(), d.width()];
            var j = /([0-9]+)%/.exec(o);
            if (j) {
                o = parseInt(j[1], 10) / 100 * c[h == "hide" ? 0 : 1]
            }
            if (h == "show") {
                d.css(n ? {
                    height: 0,
                    width: o
                } : {
                    height: o,
                    width: 0
                })
            }
            var m = {},
                l = {};
            m[f[0]] = h == "show" ? c[0] : o;
            l[f[1]] = h == "show" ? c[1] : 0;
            d.animate(m, g, b.options.easing).animate(l, g, b.options.easing, function () {
                if (h == "hide") {
                    e.hide()
                }
                a.effects.restore(e, k);
                a.effects.removeWrapper(e);
                if (b.callback) {
                    b.callback.apply(e[0], arguments)
                }
                e.dequeue()
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.highlight = function (b) {
        return this.queue(function () {
            var e = a(this),
                d = ["backgroundImage", "backgroundColor", "opacity"];
            var h = a.effects.setMode(e, b.options.mode || "show");
            var c = b.options.color || "#ffff99";
            var g = e.css("backgroundColor");
            a.effects.save(e, d);
            e.show();
            e.css({
                backgroundImage: "none",
                backgroundColor: c
            });
            var f = {
                backgroundColor: g
            };
            if (h == "hide") {
                f.opacity = 0
            }
            e.animate(f, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function () {
                    if (h == "hide") {
                        e.hide()
                    }
                    a.effects.restore(e, d);
                    if (h == "show" && a.browser.msie) {
                        this.style.removeAttribute("filter")
                    }
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    e.dequeue()
                }
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.pulsate = function (b) {
        return this.queue(function () {
            var d = a(this);
            var g = a.effects.setMode(d, b.options.mode || "show");
            var f = b.options.times || 5;
            var e = b.duration ? b.duration / 2 : a.fx.speeds._default / 2;
            if (g == "hide") {
                f--
            }
            if (d.is(":hidden")) {
                d.css("opacity", 0);
                d.show();
                d.animate({
                    opacity: 1
                }, e, b.options.easing);
                f = f - 2
            }
            for (var c = 0; c < f; c++) {
                d.animate({
                    opacity: 0
                }, e, b.options.easing).animate({
                    opacity: 1
                }, e, b.options.easing)
            }
            if (g == "hide") {
                d.animate({
                    opacity: 0
                }, e, b.options.easing, function () {
                    d.hide();
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            } else {
                d.animate({
                    opacity: 0
                }, e, b.options.easing).animate({
                    opacity: 1
                }, e, b.options.easing, function () {
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            }
            d.queue("fx", function () {
                d.dequeue()
            });
            d.dequeue()
        })
    }
})(jQuery);
(function (a) {
    a.effects.puff = function (b) {
        return this.queue(function () {
            var f = a(this);
            var c = a.extend(true, {}, b.options);
            var h = a.effects.setMode(f, b.options.mode || "hide");
            var g = parseInt(b.options.percent, 10) || 150;
            c.fade = true;
            var e = {
                height: f.height(),
                width: f.width()
            };
            var d = g / 100;
            f.from = (h == "hide") ? e : {
                height: e.height * d,
                width: e.width * d
            };
            c.from = f.from;
            c.percent = (h == "hide") ? g : 100;
            c.mode = h;
            f.effect("scale", c, b.duration, b.callback);
            f.dequeue()
        })
    };
    a.effects.scale = function (b) {
        return this.queue(function () {
            var g = a(this);
            var d = a.extend(true, {}, b.options);
            var j = a.effects.setMode(g, b.options.mode || "effect");
            var h = parseInt(b.options.percent, 10) || (parseInt(b.options.percent, 10) == 0 ? 0 : (j == "hide" ? 0 : 100));
            var i = b.options.direction || "both";
            var c = b.options.origin;
            if (j != "effect") {
                d.origin = c || ["middle", "center"];
                d.restore = true
            }
            var f = {
                height: g.height(),
                width: g.width()
            };
            g.from = b.options.from || (j == "show" ? {
                height: 0,
                width: 0
            } : f);
            var e = {
                y: i != "horizontal" ? (h / 100) : 1,
                x: i != "vertical" ? (h / 100) : 1
            };
            g.to = {
                height: f.height * e.y,
                width: f.width * e.x
            };
            if (b.options.fade) {
                if (j == "show") {
                    g.from.opacity = 0;
                    g.to.opacity = 1
                }
                if (j == "hide") {
                    g.from.opacity = 1;
                    g.to.opacity = 0
                }
            }
            d.from = g.from;
            d.to = g.to;
            d.mode = j;
            g.effect("size", d, b.duration, b.callback);
            g.dequeue()
        })
    };
    a.effects.size = function (b) {
        return this.queue(function () {
            var c = a(this),
                n = ["position", "top", "left", "width", "height", "overflow", "opacity"];
            var m = ["position", "top", "left", "overflow", "opacity"];
            var j = ["width", "height", "overflow"];
            var p = ["fontSize"];
            var k = ["borderTopWidth", "borderBottomWidth", "paddingTop", "paddingBottom"];
            var f = ["borderLeftWidth", "borderRightWidth", "paddingLeft", "paddingRight"];
            var g = a.effects.setMode(c, b.options.mode || "effect");
            var i = b.options.restore || false;
            var e = b.options.scale || "both";
            var o = b.options.origin;
            var d = {
                height: c.height(),
                width: c.width()
            };
            c.from = b.options.from || d;
            c.to = b.options.to || d;
            if (o) {
                var h = a.effects.getBaseline(o, d);
                c.from.top = (d.height - c.from.height) * h.y;
                c.from.left = (d.width - c.from.width) * h.x;
                c.to.top = (d.height - c.to.height) * h.y;
                c.to.left = (d.width - c.to.width) * h.x
            }
            var l = {
                from: {
                    y: c.from.height / d.height,
                    x: c.from.width / d.width
                },
                to: {
                    y: c.to.height / d.height,
                    x: c.to.width / d.width
                }
            };
            if (e == "box" || e == "both") {
                if (l.from.y != l.to.y) {
                    n = n.concat(k);
                    c.from = a.effects.setTransition(c, k, l.from.y, c.from);
                    c.to = a.effects.setTransition(c, k, l.to.y, c.to)
                }
                if (l.from.x != l.to.x) {
                    n = n.concat(f);
                    c.from = a.effects.setTransition(c, f, l.from.x, c.from);
                    c.to = a.effects.setTransition(c, f, l.to.x, c.to)
                }
            }
            if (e == "content" || e == "both") {
                if (l.from.y != l.to.y) {
                    n = n.concat(p);
                    c.from = a.effects.setTransition(c, p, l.from.y, c.from);
                    c.to = a.effects.setTransition(c, p, l.to.y, c.to)
                }
            }
            a.effects.save(c, i ? n : m);
            c.show();
            a.effects.createWrapper(c);
            c.css("overflow", "hidden").css(c.from);
            if (e == "content" || e == "both") {
                k = k.concat(["marginTop", "marginBottom"]).concat(p);
                f = f.concat(["marginLeft", "marginRight"]);
                j = n.concat(k).concat(f);
                c.find("*[width]").each(function () {
                    child = a(this);
                    if (i) {
                        a.effects.save(child, j)
                    }
                    var q = {
                        height: child.height(),
                        width: child.width()
                    };
                    child.from = {
                        height: q.height * l.from.y,
                        width: q.width * l.from.x
                    };
                    child.to = {
                        height: q.height * l.to.y,
                        width: q.width * l.to.x
                    };
                    if (l.from.y != l.to.y) {
                        child.from = a.effects.setTransition(child, k, l.from.y, child.from);
                        child.to = a.effects.setTransition(child, k, l.to.y, child.to)
                    }
                    if (l.from.x != l.to.x) {
                        child.from = a.effects.setTransition(child, f, l.from.x, child.from);
                        child.to = a.effects.setTransition(child, f, l.to.x, child.to)
                    }
                    child.css(child.from);
                    child.animate(child.to, b.duration, b.options.easing, function () {
                        if (i) {
                            a.effects.restore(child, j)
                        }
                    })
                })
            }
            c.animate(c.to, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function () {
                    if (g == "hide") {
                        c.hide()
                    }
                    a.effects.restore(c, i ? n : m);
                    a.effects.removeWrapper(c);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    c.dequeue()
                }
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.shake = function (b) {
        return this.queue(function () {
            var e = a(this),
                l = ["position", "top", "left"];
            var k = a.effects.setMode(e, b.options.mode || "effect");
            var n = b.options.direction || "left";
            var c = b.options.distance || 20;
            var d = b.options.times || 3;
            var g = b.duration || b.options.duration || 140;
            a.effects.save(e, l);
            e.show();
            a.effects.createWrapper(e);
            var f = (n == "up" || n == "down") ? "top" : "left";
            var p = (n == "up" || n == "left") ? "pos" : "neg";
            var h = {},
                o = {},
                m = {};
            h[f] = (p == "pos" ? "-=" : "+=") + c;
            o[f] = (p == "pos" ? "+=" : "-=") + c * 2;
            m[f] = (p == "pos" ? "-=" : "+=") + c * 2;
            e.animate(h, g, b.options.easing);
            for (var j = 1; j < d; j++) {
                e.animate(o, g, b.options.easing).animate(m, g, b.options.easing)
            }
            e.animate(o, g, b.options.easing).animate(h, g / 2, b.options.easing, function () {
                a.effects.restore(e, l);
                a.effects.removeWrapper(e);
                if (b.callback) {
                    b.callback.apply(this, arguments)
                }
            });
            e.queue("fx", function () {
                e.dequeue()
            });
            e.dequeue()
        })
    }
})(jQuery);
(function (a) {
    a.effects.slide = function (b) {
        return this.queue(function () {
            var e = a(this),
                d = ["position", "top", "left"];
            var i = a.effects.setMode(e, b.options.mode || "show");
            var h = b.options.direction || "left";
            a.effects.save(e, d);
            e.show();
            a.effects.createWrapper(e).css({
                overflow: "hidden"
            });
            var f = (h == "up" || h == "down") ? "top" : "left";
            var c = (h == "up" || h == "left") ? "pos" : "neg";
            var j = b.options.distance || (f == "top" ? e.outerHeight({
                margin: true
            }) : e.outerWidth({
                margin: true
            }));
            if (i == "show") {
                e.css(f, c == "pos" ? -j : j)
            }
            var g = {};
            g[f] = (i == "show" ? (c == "pos" ? "+=" : "-=") : (c == "pos" ? "-=" : "+=")) + j;
            e.animate(g, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function () {
                    if (i == "hide") {
                        e.hide()
                    }
                    a.effects.restore(e, d);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    e.dequeue()
                }
            })
        })
    }
})(jQuery);
(function (a) {
    a.effects.transfer = function (b) {
        return this.queue(function () {
            var f = a(this),
                h = a(b.options.to),
                e = h.offset(),
                g = {
                    top: e.top,
                    left: e.left,
                    height: h.innerHeight(),
                    width: h.innerWidth()
                },
                d = f.offset(),
                c = a('<div class="ui-effects-transfer"></div>').appendTo(document.body).addClass(b.options.className).css({
                    top: d.top,
                    left: d.left,
                    height: f.innerHeight(),
                    width: f.innerWidth(),
                    position: "absolute"
                }).animate(g, b.duration, b.options.easing, function () {
                    c.remove();
                    (b.callback && b.callback.apply(f[0], arguments));
                    f.dequeue()
                })
        })
    }
})(jQuery);
gaProperty = "UA-11059857-1";
var disableStr = "ga-disable-" + gaProperty;

function getCookieExpireDate() {
    var cookieTimeout = 34214400000;
    var date = new Date();
    date.setTime(date.getTime() + cookieTimeout);
    var expires = "; expires=" + date.toGMTString();
    return expires
}

function askConsent() {
    var bodytag = document.getElementsByTagName("body")[0];
    var div = document.createElement("div");
    div.setAttribute("id", "cookie-banner");
    div.setAttribute("width", "70%");
    div.innerHTML = '<div>Ce site utilise des cookies pour assurer son bon fonctionnement. 	En poursuivant votre navigation, vous acceptez l\'utilisation des cookies.     <a href="javascript:validate()" class="cookie-banner-validate">OK</a>	<a href="/mentions-legales" class="cookie-banner-link">En savoir plus</a>.</div>';
    bodytag.insertBefore(div, bodytag.firstChild);
    document.getElementsByTagName("body")[0].className += " cookiebanner"
}

function getCookie(NomDuCookie) {
    if (document.cookie.length > 0) {
        begin = document.cookie.indexOf(NomDuCookie + "=");
        if (begin != -1) {
            begin += NomDuCookie.length + 1;
            end = document.cookie.indexOf(";", begin);
            if (end == -1) {
                end = document.cookie.length
            }
            return unescape(document.cookie.substring(begin, end))
        }
    }
    return null
}

function validate() {
    document.cookie = disableStr + "=false;" + getCookieExpireDate() + " ; path=/";
    document.cookie = "hasConsent=true;" + getCookieExpireDate() + " ; path=/";
    var div = document.getElementById("cookie-banner");
    if (div != null) {
        div.style.display = "none"
    }
    window[disableStr] = false
}
var consentCookie = getCookie("notFirstTime");
if (!consentCookie) {
    var referrer_host = document.referrer.split("/")[2];
    if (referrer_host != document.location.hostname) {
        window[disableStr] = true;
        window.onload = askConsent
    } else {
        document.cookie = "notFirstTime=true; " + getCookieExpireDate() + " ; path=/"
    }
} else {
    consentCookie = getCookie("hasConsent");
    if (!consentCookie) {
        window.onload = askConsent
    }
};
