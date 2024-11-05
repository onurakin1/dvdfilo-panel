let header_height
let header_top_height
let initialTheme = JSON.parse(localStorage.getItem('initialTheme')) ?? false;
$(window).on("load scroll", function () {

    var scrollPosition = window.pageYOffset;
    var windowSize = window.innerHeight;
    var bodyHeight = document.body.offsetHeight;
    var bottom_distance = Math.max(bodyHeight - (scrollPosition + windowSize), 0)
    if ($(".sidebar.add").hasClass("detail")) {
        if ($(window).scrollTop() < 600) {
            $('.sidebar.add.detail').css('top', (780 - $(window).scrollTop()) + 'px')
        } else if (bottom_distance < 500) {
            $('.sidebar.add.detail').css('top', - (280 - bottom_distance) + 'px')
        } else {
            $('.sidebar.add.detail').css('top', '180px')
        }
    } else {
        if (bottom_distance < 500) {
            $('.sidebar.add').css('top', - (280 - bottom_distance) + 'px')
        } else {
            $('.sidebar.add').css('top', '180px')
        }
    }



    set_color(initialTheme);
    $('.profile-dropdown').removeClass('show')
    $('.profile-dropdown').removeAttr('style')
    $('.login').removeClass('show')
    header_top_height = $('#header .header-top').outerHeight()
    header_height = $('#header .header-top').outerHeight() + $('#header .header-bottom').outerHeight()

    $('.header_padding').css('padding-top', header_height)
    $(window).resize(function () {
        if ($(window).width() >= 980) {

            $(".navbar .dropdown-toggle").hover(function () {
                $(this).parent().toggleClass("show");
                $(this).parent().find(".dropdown-menu").toggleClass("show");
            });

            $(".navbar .dropdown-menu").mouseleave(function () {
                $(this).removeClass("show");
            });
        }
    });

    if (screen.width >= 1366) {

        $('#header .dropdown-link').click(function (e) {
            window.location.href = e.target.href;
        })
        $('.header-bottom').css('top', header_top_height - $(window).scrollTop());
        if ($(document).scrollTop() <= header_top_height) {
            $('#header .header-bottom').removeClass('fixed')
            $('#header .header-bottom .fixed-items').removeAttr('style');
        } else {
            $('#header .header-bottom .fixed-items').css('width', '365px');
            $('#header .header-bottom .fixed-items.logout').css('width', '295px');
            $('#header .header-bottom').addClass('fixed')
        }
    }
    $('.thumbnail-wrapper').each(function () {
        if ($(this).isOnScreen()) {
            setTimeout(() => {
                $(this).addClass("loaded");
            }, 250);
        }
    });
    $('#header .nav-item').each(function () {
        let el = $(this)
        href = el.find("a").first().attr("href")
        el.removeClass("active")
        if (href === window.location.pathname) {
            el.addClass("active")
        }
    })
    $('#header .dropdown .item').each(function () {
        let el = $(this)
        href = el.attr("href")
        el.removeClass("active")
        if (href === window.location.pathname) {
            el.addClass("active")
        }
    })
    if ($(window).height() <= $(window).scrollTop() * 2) {
        $('.go_top').css('transform', 'translateY(0)')
    } else {
        $('.go_top').css('transform', 'translateY(300%)')
    }
    if (screen.width <= 1200) {

        if ($(".navbar-collapse").hasClass("show")) {
            if ($(document).scrollTop() == 0) {
                $('#header').addClass('fixed')
                $('.navbar-brand img').attr('src', black_logo)
            }
        }
    }
});
if ($('.phone').length > 0) {
    $('.phone').mask('(000) 000 0000');
}
$(".go_top").click(function () {
    $(" body, html ").animate({
        scrollTop: 0
    });
});

new Swiper("#body .nav_tabs_slider .swiper-container", {
    observer: true,
    observeParents: true,
    slidesPerView: 3,
    spaceBetween: 12,
    autoplay: false
})

new Swiper('#body .section_3 .swiper-container', {
    observer: true,
    observeParents: true,
    speed: 1000,
    lazy: true,
    autoplay: {
        delay: 9500,
        disableOnInteraction: false,
    },
    pagination: {
        el: "#body .section_3 .swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        768: {
            slidesPerView: 1,
            spaceBetween: 12,
            navigation: false,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 12,
            navigation: {
                nextEl: '#body .section_3 .swiper-button.next',
                prevEl: '#body .section_3 .swiper-button.prev',
            },
        },
    },
});

new Swiper('#body .main_categories .swiper-container', {
    observer: true,
    observeParents: true,
    speed: 1000,
    lazy: true,
    navigation: false,
    pagination: false,
    breakpoints: {
        768: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        1024: {
            touchRatio: 0,
            slidesPerView: 3,
            spaceBetween: 20,
        },
    },
});
$(".dark-mode").on('click', function () {
    initialTheme = !initialTheme;
    localStorage.setItem('initialTheme', initialTheme)
    set_color(initialTheme)

})
function set_color(initialTheme) {
    const root = document.documentElement;
    let logo = $('.navbar-brand img')
    if (initialTheme) {
        $('.toggle').removeClass('active')
        root.style.setProperty('--second_color', '#47515a');
        root.style.setProperty('--body_color', '#fff');
        root.style.setProperty('--hover_color', '#eee');
        root.style.setProperty('--border_color', '#eee');
        logo.attr("src", logo.data('white'))
    } else {
        $('.toggle').addClass('active')
        root.style.setProperty('--second_color', '#fff');
        root.style.setProperty('--body_color', '#131313');
        root.style.setProperty('--hover_color', '#404040');
        root.style.setProperty('--border_color', '#303030');
        logo.attr("src", logo.data('dark'))
    }
}
$.fn.isOnScreen = function (e) {
    var win = $(window);

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();


    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};
$('.search_button').click(function () {
    $('#search_input').toggleClass('active')
    $('.search_button').toggleClass('d-none')
    $('.remove_button').toggleClass('d-none')
})
$('.remove_button').click(function () {
    $('#search_input').toggleClass('active')
    $('.search_button').toggleClass('d-none')
    $('.remove_button').toggleClass('d-none')
})
$.fancybox.defaults.animationEffect = "fade";
let click_count = false;


function ajaxService(ajaxUrl, postParam, type, callback = false, async = true) {

    var response = {};

    if ($('*').is('#csrf-token')) {
        postParam['_token'] = $('#csrf-token')[0].content;
    }

    $.ajax({
        url: ajaxUrl,
        data: postParam,
        dataType: 'json',
        async: async,
        type: type,
        mimeType: 'multipart/form-data',
        success: function (response) {
            if (callback) {
                callback(response);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

            if (xhr.status == 422) { // when status code is 422, it's a validation issue
                console.log(xhr.responseJSON);

                // you can loop through the errors object and show it to the user
                console.warn(xhr.responseJSON.errors);
                // display errors on each form field
                $.each(xhr.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="'+i+'"]');
                    el.after($('<span style="color: red;">'+error[0]+'</span>'));
                });
            }

        }
    });
}

$('.more-item a').click(function () {
    let count = $(".add_wrapper .small-items .reference-item").length
    let id = $(this).data('id')
    let type = $(this).data('type')
    $.ajax({
        url: `/get-more/${count}/${id}/${type}`,
        success: function (html) {
            $('.add_wrapper .small-items').append(html)
        }
    });
})
$('.edit_comment').focus(function () {
    let button = $(this).data('button')
    $('.comment_buttons').addClass('d-none')
    $(`#${button}`).removeClass('d-none')
})


$('.reply').click(function () {
    $('html,body').animate({
        scrollTop: $("#comment_form").offset().top - 150
    }, 'slow');
})
$('#message').keyup(function (e) {
    let length = e.target.value.length;
    $('.count').html(`(${length})`)
    if (length >= 30) {
        $('.form_send').prop("disabled", false);
    } else {
        $('.form_send').prop("disabled", true);
    }
});
$('.nickname_visible').click(function () {
    let input_val = $('input[name=nickname_visible]').val()
    if (input_val == 1) {
        $('.nickname_visible i').removeClass('fa-eye')
        $('.nickname_visible i').addClass('fa-eye-slash')
        $('input[name=nickname_visible]').val(0)
    } else {
        $('.nickname_visible i').addClass('fa-eye')
        $('.nickname_visible i').removeClass('fa-eye-slash')
        $('input[name=nickname_visible]').val(1)
    }
})


if (window.innerWidth < 992) {

    // close all inner dropdowns when parent is closed
    document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
        everydropdown.addEventListener('hidden.bs.dropdown', function () {
            // after dropdown is hidden, then find all submenus
            this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
                // hide every submenu as well
                everysubmenu.style.display = 'none';
            });
        })
    });

    document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
        element.addEventListener('click', function (e) {
            let nextEl = this.nextElementSibling;
            if (nextEl && nextEl.classList.contains('submenu')) {
                // prevent opening link if link needs to open dropdown
                e.preventDefault();
                if (nextEl.style.display == 'block') {
                    nextEl.style.display = 'none';
                } else {
                    nextEl.style.display = 'block';
                }

            }
        });
    })
}
$('.post_comment').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var method = form.attr('method');
    $.ajax({
        type: method,
        url: url,
        data: form.serialize(),
        success: function(data) {
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.status,
                confirmButtonText: 'Kapat',
            }).then((result) => {
                location.reload();
            });
        },
        error: function(data) {
            let message = "Bir sorun oluştu lütfen tekrar deneyin."
            if (data.responseJSON.errors) {
                message = "Lütfen tüm alanları kontrol edip tekrar deneyin."
            }



            Swal.fire({
                title: 'Başarısız!',
                text: message,
                icon: "error",
                confirmButtonText: 'Kapat',
            })
        }
    });
})

$('.set_like').on('click', function() {
    let type = $(this).data('type')
    let user = $(this).data('user')
    let likeable_id = $(this).data('likeable')
    if (user) {
        $.ajax({
            url: `/like/${likeable_id}/${type}/1`,
            type: "GET",
            success: function(data) {
                $.each($('.post_like_count'), function(key, value) {
                    let inner_type = $(this).data('type')
                    $.ajax({
                        url: `/like-count/${likeable_id}/${inner_type}`,
                        type: "GET",
                        success: function(data) {
                            $(`.type_${inner_type}`).text(data)
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                    });
                });
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('post')
            },
        });
    } else {
        $('#loginModal').modal('show');
    }
})

$('.list-group-numbered').find('a').on('click', function(e){
    let href = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $( href).offset().top-100
    }, 300);
})

// scroll to up
let scrollButton = $(".scroll-to-up");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollButton.addClass("d-block");
        scrollButton.removeClass("d-none");
    } else {
        scrollButton.addClass("d-none");
        scrollButton.removeClass("d-block");
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

/*
 * imgCheckbox
 *
 * Version: 0.5.4
 * License: GPLv2
 * Author:  James Cuénod
 *
 */
(function($) {
    var CHK_TOGGLE = 0;
    var CHK_SELECT = 1;
    var CHK_DESELECT = 2;
    var CHECKMARK_POSITION = {
        "top-left": {
            "top": "0.5%",
            "left": "0.5%",
        },
        "top": {
            "top": "0.5%",
            "left": 0,
            "right": 0,
            "margin": "auto",
        },
        "top-right": {
            "top": "0.5%",
            "right": "0.5%",
        },
        "left": {
            "left": "0.5%",
            "bottom": 0,
            "top": 0,
            "margin": "auto",
        },
        "right": {
            "right": "0.5%",
            "bottom": 0,
            "top": 0,
            "margin": "auto",
        },
        "bottom-left": {
            "bottom": "0.5%",
            "left": "0.5%",
        },
        "bottom": {
            "bottom": "0.5%",
            "left": 0,
            "right": 0,
            "margin": "auto",
        },
        "bottom-right": {
            "bottom": "0.5%",
            "right": "0.5%",
        },
        "center": {
            "top": "0.5%",
            "bottom": "0.5%",
            "left": "0.5%",
            "right": "0.5%",
            "margin": "auto",
        },
    };

    var imgCheckboxClass = function(element, options, id) {
        var $wrapperElement, $finalStyles = {}, grayscaleStyles = {
            "span.imgCheckbox img": {
                "transform": "scale(1)",
                "filter": "none",
                "-webkit-filter": "grayscale(0)",
            },
            "span.imgCheckbox.imgChked img": {
                // "filter": "gray", //TODO - this line probably will not work but is necessary for IE
                "filter": "grayscale(1)",
                "-webkit-filter": "grayscale(1)",
            }
        }, scaleStyles = {
            "span.imgCheckbox img": {
                "transform": "scale(1)",
            },
            "span.imgCheckbox.imgChked img": {
                "transform": "scale(0.8)",
            }
        }, scaleCheckMarkStyles = {
            "span.imgCheckbox::before": {
                "transform": "scale(0)",
            },
            "span.imgCheckbox.imgChked::before": {
                "transform": "scale(1)",
            }
        }, fadeCheckMarkStyles = {
            "span.imgCheckbox::before": {
                "opacity": "0",
            },
            "span.imgCheckbox.imgChked::before": {
                "opacity": "1",
            }
        };

        /* *** STYLESHEET STUFF *** */
        // shove in the custom check mark
        if (options.checkMarkImage !== false)
            $.extend(true, $finalStyles, { "span.imgCheckbox::before": { "background-image": "url('" + options.checkMarkImage + "')" }});
        // give the checkmark dimensions
        var chkDimensions = options.checkMarkSize.split(" ");
        $.extend(true, $finalStyles, { "span.imgCheckbox::before": {
                "width": chkDimensions[0],
                "height": chkDimensions[chkDimensions.length - 1]
            }});
        // give the checkmark a position
        $.extend(true, $finalStyles, { "span.imgCheckbox::before": CHECKMARK_POSITION [ options.checkMarkPosition ] });
        // fixed image sizes
        if (options.fixedImageSize)
        {
            var imgDimensions = options.fixedImageSize.split(" ");
            $.extend(true, $finalStyles,{ "span.imgCheckbox img": {
                    "width": imgDimensions[0],
                    "height": imgDimensions[imgDimensions.length - 1]
                }});
        }

        var conditionalExtend = [
            {
                doExtension: options.graySelected,
                style: grayscaleStyles
            },
            {
                doExtension: options.scaleSelected,
                style: scaleStyles
            },
            {
                doExtension: options.scaleCheckMark,
                style: scaleCheckMarkStyles
            },
            {
                doExtension: options.fadeCheckMark,
                style: fadeCheckMarkStyles
            }
        ];
        conditionalExtend.forEach(function(extension) {
            if (extension.doExtension)
                $.extend(true, $finalStyles, extension.style);
        });

        $finalStyles = $.extend(true, {}, defaultStyles, $finalStyles, options.styles);

        // Now that we've built up our styles, inject them
        injectStylesheet($finalStyles, id);


        /* *** DOM STUFF *** */
        element.wrap("<span class='imgCheckbox" + id + "'>");
        $wrapperElement = element.parent();
        // set up select/deselect functions
        $wrapperElement.each(function() {
            var $that = $(this);
            $(this).data("imgchk.deselect", function(){
                changeSelection($that, CHK_DESELECT, options.addToForm, options.radio, options.canDeselect, $wrapperElement);
            }).data("imgchk.select", function(){
                changeSelection($that, CHK_SELECT, options.addToForm, options.radio, options.canDeselect, $wrapperElement);
            });
            $(this).children().first().data("imgchk.deselect", function(){
                changeSelection($that, CHK_DESELECT, options.addToForm, options.radio, options.canDeselect, $wrapperElement);
            }).data("imgchk.select", function(){
                changeSelection($that, CHK_SELECT, options.addToForm, options.radio, options.canDeselect, $wrapperElement);
            });
        });
        // preselect elements
        if (options.preselect === true || options.preselect.length > 0)
        {
            $wrapperElement.each(function(index) {
                if (options.preselect === true || options.preselect.indexOf(index) >= 0)
                    $(this).addClass("imgChked");
            });
        }

        // set up click handler
        $wrapperElement.click(function() {
            var el = $(this);
            changeSelection(el, CHK_TOGGLE, options.addToForm, options.radio, options.canDeselect, $wrapperElement);
            if (options.onclick)
                options.onclick(el);
        });

        /* *** INJECT INTO FORM *** */
        if (options.addToForm instanceof jQuery || options.addToForm === true)
        {
            if (options.addToForm === true)
            {
                options.addToForm = $(element).closest("form");
            }
            if (options.addToForm.length === 0)
            {
                if (options.debugMessages)
                    console.log("imgCheckbox: no form found (looks for form by default)");
                options.addToForm = false;
            }
        }
        if (options.addToForm !== false)
        {
            $(element).each(function(index) {
                var hiddenElementId = "hEI" + id + "-" + index;
                $(this).parent().data('hiddenElementId', hiddenElementId);
                var imgName = $(this).attr("name");
                // imgName = (typeof imgName != "undefined") ? imgName : $(this).attr("src").match(/\/(.*)\.[\w]+$/)[1];
                // $('<input />').attr('type', 'checkbox')
                //     .attr('name', imgName)
                //     .addClass(hiddenElementId)
                //     .css("display", "none")
                //     .prop("checked", $(this).parent().hasClass("imgChked"))
                //     .appendTo(options.addToForm);
            });
        }

        return this;
    };

    /* CSS Injection */
    function injectStylesheet(stylesObject, id)
    {
        // Create a blank style
        var style = document.createElement("style");
        // WebKit hack
        style.appendChild(document.createTextNode(""));
        // Add the <style> element to the page
        document.head.appendChild(style);

        var stylesheet = document.styleSheets[document.styleSheets.length - 1];

        for (var selector in stylesObject) {
            if (stylesObject.hasOwnProperty(selector)) {
                compatInsertRule(stylesheet, selector, buildRules(stylesObject[selector]), id);
            }
        }
    }
    function buildRules(ruleObject)
    {
        var ruleSet = "";
        for (var property in ruleObject) {
            if (ruleObject.hasOwnProperty(property)) {
                ruleSet += property + ":" + ruleObject[property] + ";";
            }
        }
        return ruleSet;
    }
    function compatInsertRule(stylesheet, selector, cssText, id)
    {
        var modifiedSelector = selector.replace(".imgCheckbox", ".imgCheckbox" + id);
        // IE8 uses "addRule", everyone else uses "insertRule"
        if (stylesheet.insertRule) {
            stylesheet.insertRule(modifiedSelector + '{' + cssText + '}', 0);
        } else {
            stylesheet.addRule(modifiedSelector, cssText, 0);
        }
    }

    function changeSelection($chosenElement, howToModify, addToForm, radio, canDeselect, $wrapperElement)
    {
        if (radio && howToModify !== CHK_DESELECT)
        {
            $wrapperElement.not($chosenElement).removeClass("imgChked");
            if (canDeselect)
            {
                $chosenElement.toggleClass("imgChked");
            }
            else {
                $chosenElement.addClass("imgChked");
            }
        }
        else
        {
            switch (howToModify) {
                case CHK_DESELECT:
                    $chosenElement.removeClass("imgChked");
                    break;
                case CHK_TOGGLE:
                    $chosenElement.toggleClass("imgChked");
                    break;
                case CHK_SELECT:
                    $chosenElement.addClass("imgChked");
                    break;
            }
        }
        if (addToForm)
            updateFormValues(radio ? $wrapperElement : $chosenElement);
    }
    function updateFormValues($element)
    {
        $element.each(function() {
            $( "." + $(this).data("hiddenElementId") ).prop("checked", $(this).hasClass("imgChked"));
        });
    }


    /* Init */
    $.fn.imgCheckbox = function(options) {
        if ($(this).data("imgCheckboxId"))
            //already initialised: old instance = $.fn.imgCheckbox.instances[$(this).data("imgCheckboxId") - 1];
            return this;
        else
        {
            var optionsWithDefaults = $.extend(true, {}, $.fn.imgCheckbox.defaults, options);
            var $that = new imgCheckboxClass($(this), optionsWithDefaults, $.fn.imgCheckbox.instances.length);
            $(this).data("imgCheckboxId", $.fn.imgCheckbox.instances.push($that));
            if (optionsWithDefaults.onload)
                optionsWithDefaults.onload();
            return this;
        }
    };
    $.fn.deselect = function() {
        if (this.data("imgchk.deselect"))
        {
            this.data("imgchk.deselect")();
        }
        return this;
    };
    $.fn.select = function() {
        if (this.data("imgchk.select"))
        {
            this.data("imgchk.select")();
        }
        return this;
    };
    $.fn.imgCheckbox.instances = [];
    $.fn.imgCheckbox.defaults = {
        "graySelected": true,
        "scaleSelected": true,
        "fixedImageSize": false,
        "checkMarkSize": "30px",
        "checkMarkPosition": "top-left",
        "scaleCheckMark": true,
        "fadeCheckMark": false,
        "addToForm": true,
        "preselect": [],
        "radio": false,
        "canDeselect": false,
        "onload": false,
        "onclick": false,
        "debugMessages": false,
    };
    var defaultStyles = {
        "span.imgCheckbox img": {
            "display": "block",
            "margin": "0",
            "padding": "0",
            "transition-duration": "300ms",
        },
        "span.imgCheckbox.imgChked img": {
        },
        "span.imgCheckbox": {
            "cursor":"pointer",
            "user-select": "none",
            "-webkit-user-select": "none",  /* Chrome all / Safari all */
            "-moz-user-select": "none",	 /* Firefox all */
            "-ms-user-select": "none",	  /* IE 10+ */
            "position": "relative",
            "margin": "5px",
            "display": "inline-block",
            "padding": "3px 5px 5px",
            "border": "1px solid transparent",
            "transition-duration": "300ms",
        },
        "span.imgCheckbox.imgChked": {
            "border-color": "#ccc",
            "cursor":"pointer",
            "user-select": "none",
            "-webkit-user-select": "none",  /* Chrome all / Safari all */
            "-moz-user-select": "none",	 /* Firefox all */
            "-ms-user-select": "none",	  /* IE 10+ */
            "position": "relative",
            "padding": "3px 5px 5px",
            "margin": "5px",
            "display": "inline-block",
            "border": "1.3px solid rgb(153 153 153)",
            "transition-duration": "300ms",
        },
        "span.imgCheckbox::before": {
            "display": "block",
            "background-size": "100% 100%",
            "content": "''",
            "color": "white",
            "font-weight": "bold",
            "border-radius": "50%",
            "position": "absolute",
            "margin": "0.5%",
            "z-index": "1",
            "text-align": "center",
            "transition-duration": "300ms",
        },
        "span.imgCheckbox.imgChked::before": {
        }
    };

})( jQuery );
