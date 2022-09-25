
// $('.select3').select2();
/*START: tạo slug theo tiêu đề*/
function slug(title) {
    title = cnvVi(title);
    return title;
}
function cnvVi(str) {
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ|₫/g, "d");
    str = str.replace(/™/g, "");
    str = str.replace(/–/g, "");
    str = str.replace(
        /!|@|%|\||\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\”|\“|\&|\#|\[|\]|~|$|_/g,
        "-"
    );
    str = str.replace(/-+-/g, "-");
    str = str.replace(/^\-+|\-+$/g, "");
    return str;
}
$(document).on("keyup ", ".title", function () {
    var today = new Date();
    var date =
        today.getDate() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getFullYear();

    let _this = $(this);
    let metaTitle = _this.val();
    let totalCharacter = metaTitle.length;
    if (totalCharacter > 70) {
        $(".meta-title").addClass("input-error");
    } else {
        $(".meta-title").removeClass("input-error");
    }
    let slugTitle = "";
    slugTitle = slug(metaTitle);
    if ($(".meta-title").val() == "") {
        $(".g-title").text(metaTitle);
        $(".canonical").val(metaTitle);
    }
    let canonical = $(".canonical");
    if (canonical.attr("data-flag") == 0) {
        canonical.val(slugTitle);
        $(".g-link").text(BASE_URL + slugTitle + ".html");
        $(".canonical").text(slugTitle);
    }
});
/*END: tạo slug theo tiêu đề*/
/*START: ck-editor*/
$(".ck-editor-description").each(function () {
    //colorbutton,
    CKEDITOR.replace(this.id, {
        height: 200,
        extraPlugins:
            "colorbutton, panelbutton, link, justify, lineheight, font, codemirror, copyformatting,  ",
        removeButtons: "",
        entities: false,
        entities_latin: false,
        allowedContent: true,
        toolbarGroups: [
            {
                name: "clipboard",
                groups: ["clipboard", "undo"],
            },
            {
                name: "editing",
                groups: ["find", "selection", "spellchecker"],
            },

            {
                name: "document",
                groups: ["mode", "document", "doctools"],
            },
            {
                name: "colors",
            },
            {
                name: "styles",
            },
        ],
    }).on("change", function (e) {
        if (e.editor.name == "ckDescription") {
            var metaDescription =
                document.getElementById("seoDescription").value;
            if (metaDescription == "") {
                let data = decodeEntities(e.editor.getData());
                var parser = new DOMParser();
                var dom = parser.parseFromString(
                    "<!doctype html><body>" + data,
                    "text/html"
                );
                var decodedString = dom.body.textContent;
                document.getElementById("metaDescription").innerHTML =
                    decodedString.slice(0, 320);
            }
        }
    });
});
$(".ck-editor").each(function () {
    //colorbutton,
    CKEDITOR.replace(this.id, {
        height: 400,
        extraPlugins:
            "colorbutton, panelbutton, link, justify, lineheight, youtube, videodetector, image, imageresize, font, codemirror, copyformatting, find, qrc, slideshow, preview, hkemoji, contents, googledocs, codesnippet",
        removeButtons: "",
        entities: false,
        entities_latin: false,
        allowedContent: true,
        toolbarGroups: [
            {
                name: "clipboard",
                groups: ["clipboard", "undo"],
            },
            {
                name: "editing",
                groups: ["find", "selection", "spellchecker"],
            },
            {
                name: "links",
            },
            {
                name: "insert",
            },
            {
                name: "forms",
            },
            {
                name: "tools",
            },
            {
                name: "document",
                groups: ["mode", "document", "doctools"],
            },
            {
                name: "colors",
            },
            {
                name: "others",
            },
            "/",
            {
                name: "basicstyles",
                groups: ["basicstyles", "cleanup"],
            },
            {
                name: "paragraph",
                groups: ["list", "indent", "blocks", "align", "bidi"],
            },
            {
                name: "styles",
            },
        ],
    }).on("change", function (e) {
        if (e.editor.name == "ckDescription") {
            var metaDescription =
                document.getElementById("seoDescription").value;
            if (metaDescription == "") {
                let data = decodeEntities(e.editor.getData());
                var parser = new DOMParser();
                var dom = parser.parseFromString(
                    "<!doctype html><body>" + data,
                    "text/html"
                );
                var decodedString = dom.body.textContent;
                document.getElementById("metaDescription").innerHTML =
                    decodedString.slice(0, 320);
            }
        }
    });
});
function decodeEntities(encodedString) {
    var translate_re = /&(nbsp|amp|quot|lt|gt);/g;
    var translate = {
        nbsp: " ",
        amp: "&",
        quot: '"',
        lt: "<",
        gt: ">",
    };
    return encodedString
        .replace(translate_re, function (match, entity) {
            return translate[entity];
        })
        .replace(/&#(\d+);/gi, function (match, numStr) {
            var num = parseInt(numStr, 10);
            return String.fromCharCode(num);
        });
}
/*END: ck-editor*/

/*START: chọn hình ảnh: thư viện*/
/*$(document).on("click", ".img-thumbnail", function () {
    openKCFinderAlbum($(this));
});
function openKCFinderAlbum(field, type, result) {
    window.KCFinder = {
        callBack: function (url) {
            field.attr("src", url);
            field.parent().next().val(url);
            window.KCFinder = null;
        },
    };
    if (typeof type == "undefined") {
        type = "images";
    }
    window.open(
        BASE_URL +
        "library/kcfinder-3.12/browse.php?type=" +
        type +
        "&dir=images/public",
        "kcfinder_image",
        "status=0, toolbar=0, location=0, menubar=0, directories=0, " +
        "resizable=1, scrollbars=0, width=1080, height=800"
    );
    return false;
}
function openKCFinder(field, type) {
    window.KCFinder = {
        callBack: function (url) {
            field.value = url;
            window.KCFinder = null;
            $(".avatar img").attr("src", url);
        },
    };
    if (typeof type == "undefined") {
        type = "images";
    }

    window.open(
        BASE_URL +
        "library/kcfinder-3.12/browse.php?type=" +
        type +
        "&dir=images/public",
        "kcfinder_image",
        "status=0, toolbar=0, location=0, menubar=0, directories=0, " +
        "resizable=1, scrollbars=0, width=1180, height=800"
    );
} */
/*END: chọn hình ảnh: thư viện*/
function image_render(src = "") {
    let html = '<li class="ui-state-default">';
    html = html + '<div class="thumb">';
    html = html + '<span class="image img-scaledown">';
    html =
        html +
        '<img src="' +
        src +
        '" alt="" /> <input type="hidden" value="' +
        src +
        '" name="album[]" />';
    html = html + "</span>";
    html = html + '<div class="overlay"></div>';
    html =
        html +
        '<div class="delete-image"><i class="fa fa-fw fa-trash-o" aria-hidden="true"></i></div>';
    html = html + "</div>";
    html = html + "</li>";
    return html;
}
$(document).on("click", ".delete-image", function () {
    console.log(1);
    let _this = $(this);
    _this.parents("li").remove();
    if ($(".upload-list li").length <= 0) {
        $(".click-to-upload").show();
        $(".upload-list").addClass("hidden");
    }
    return false;
});
/*START: ajax order*/
$(document).on("change", ".sort-order", function () {
    let _this = $(this);
    let param = {
        module: _this.attr("data-module"),
        id: _this.attr("data-id"),
        order: _this.val(),
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL_AJAX + "ajax/ajax-order",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { param: param },
        success: function (data) {
        }
    });
    return false;
});
/*END: ajax order*/

/*START: ajax publish*/
$(document).on('change', '.publish-ajax', function () {
    let _this = $(this);
    let param = {
        module: _this.attr("data-module"),
        id: _this.attr("data-id"),
        title: _this.attr('data-title'),
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL_AJAX + "ajax/publish-ajax",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { param: param },
        success: function (data) {

        }
    });
    return false;
});
/*END: ajax publish*/

/*START: input Check All */
$(document).on('click', '#checkbox-all', function () {
    let _this = $(this);
    checkall(_this);
    change_background();
});

$(document).on('click', '.checkbox-item', function () {
    let _this = $(this);
    change_background(_this);
    check_item_all(_this);
});
function checkall(_this) {
    let table = _this.parents('table');
    if ($('#checkbox-all').length) {
        if (table.find('#checkbox-all').prop('checked')) {
            table.find('.checkbox-item').prop('checked', true);

        }
        else {
            table.find('.checkbox-item').prop('checked', false);
        }
    }
}
function check_item_all(_this) {
    let table = _this.parents('table');
    if (table.find('.checkbox-item').length) {
        if (table.find('.checkbox-item:checked').length == table.find('.checkbox-item').length) {
            table.find('#checkbox-all').prop('checked', true);
        }
        else {
            table.find('#checkbox-all').prop('checked', false);
        }
    }
}
function change_background() {
    $('.checkbox-item').each(function () {
        if ($(this).is(':checked')) {
            $(this).parents('tr').addClass('bg-active');
        } else {
            $(this).parents('tr').removeClass('bg-active');
        }
    });
}
/*END: input Check All */

/*START: Xóa 1 bản ghi*/
$(document).on("click", ".ajax-delete", function (e) {
    e.preventDefault();

    let _this = $(this);
    let param = {
        title: _this.attr("data-title"),
        name: _this.attr("data-name"),
        module: _this.attr("data-module"),
        id: _this.attr("data-id"),
        router: _this.attr("data-router"),
        child: _this.attr("data-child"),
    };
    let parent = _this.attr("data-parent"); /*Đây là khối mà sẽ ẩn sau khi xóa */
    swal(
        {
            title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
            text: param.title,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Thực hiện!",
            cancelButtonText: "Hủy bỏ!",
            closeOnConfirm: false,
            closeOnCancel: false,
        },
        function (isConfirm) {
            if (isConfirm) {
                let formURL = BASE_URL_AJAX + "ajax/ajax-delete";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: formURL,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        module: param.module,
                        id: param.id,
                        router: param.router,
                        child: param.child,
                    },
                    success: function (data) {
                        if (data.code === 200) {
                            if (typeof parent != "undefined") {
                                _this
                                    .parents("." + parent + "")
                                    .hide()
                                    .remove();
                            } else {
                                _this.parent().parent().parent().hide().remove();
                            }
                            if (param.child == 1) {
                                $("#listData" + param.id).remove();
                            }

                            swal({
                                title: "Xóa thành công!",
                                text: "Hạng mục đã được xóa khỏi danh sách.",
                                type: "success"
                            }, function () {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: "Có vấn đề xảy ra",
                                text: "Vui lòng thử lại",
                                type: "error"
                            }, function () {
                                location.reload();
                            });
                        }
                    },
                    error: function (jqXhr, json, errorThrown) {
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = "";
                        $.each(errors["errors"], function (index, value) {
                            errorsHtml += value + "/ ";
                        });
                        $("#myModal .alert").html(errorsHtml).show();
                    },
                });
            } else {
                swal({
                    title: "Hủy bỏ",
                    text: "Thao tác bị hủy bỏ",
                    type: "error"
                }, function () {
                    location.reload();
                });
            }
        }
    );
});
/*END: Xóa 1 bản ghi*/

/*START: XÓA tất cả bản ghi */
$(document).on('change', '.ajax-delete-all,.ajax-recycle-all', function () {
    let _this = $(this);
    let id_checked = []; /*Lấy id bản ghi */
    $('.checkbox-item:checked').each(function () {
        id_checked.push($(this).val());
    });
    if (id_checked.length <= 0) {
        swal({
            title: "Có vấn đề xảy ra",
            text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
            type: "error"
        }, function () {
            location.reload();
        });
        return false;
    }
    let param = {
        'title': _this.attr('data-title'),
        'module': _this.attr('data-module'),
        'router': _this.attr('data-router'),
        'child': _this.attr('data-child'),
        'list': id_checked,
    }
    let parent = _this.attr('data-parent'); /*Đây là khối mà sẽ ẩn sau khi xóa */
    swal({
        title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
        text: param.title,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Thực hiện!",
        cancelButtonText: "Hủy bỏ!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'POST',
                    url: BASE_URL_AJAX + "ajax/ajax-delete-all",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { param: param },
                    success: function (data) {
                        if (data.code == 200) {
                            setTimeout(function () { location.reload(); }, 1500);
                            for (let i = 0; i < id_checked.length; i++) {
                                $('#post-' + id_checked[i]).hide().remove()
                            }
                            swal({
                                title: "Xóa thành công!",
                                text: "Các bản ghi đã được xóa khỏi danh sách.",
                                type: "success"
                            }, function () {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: "Có vấn đề xảy ra",
                                text: "Vui lòng thử lại",
                                type: "error"
                            }, function () {
                                location.reload();
                            });
                        }
                    }
                });
            } else {
                swal({
                    title: "Hủy bỏ",
                    text: "Thao tác bị hủy bỏ",
                    type: "error"
                }, function () {
                    location.reload();
                });


            }
        });
});
/*END: XÓA tất cả bản ghi */

/*START: convert price */
$(document).on('click', '.float, .int', function () {
    let data = $(this).val();
    if (data == 0) {
        $(this).val('');
    }
});
$(document).on('keydown', '.float, .int', function (e) {
    let data = $(this).val();
    if (data == 0) {
        let unicode = e.keyCode || e.which;
        if (unicode != 190) {
            $(this).val('');
        }
    }
});
/*khi thay đổi hoặc ấn phím xong : nếu  =='' sẽ trở về không, nếu == NaN cũng về 0 */
$(document).on('change keyup blur', '.int', function () {
    let data = $(this).val();
    if (data == '') {
        $(this).val('0');
        return false;
    }
    data = data.replace(/\./gi, "");
    $(this).val(addCommas(data));
    /*khi đánh chữ thì về 0 */
    data = data.replace(/\./gi, "");
    if (isNaN(data)) {
        $(this).val('0');
        return false;
    }
});
function addCommas(nStr) {
    nStr = String(nStr);
    nStr = nStr.replace(/\./gi, "");
    let str = '';
    for (i = nStr.length; i > 0; i -= 3) {
        a = ((i - 3) < 0) ? 0 : (i - 3);
        str = nStr.slice(a, i) + '.' + str;
    }
    str = str.slice(0, str.length - 1);
    return str;
}
function replace(Str = '') {
    if (Str == '') {
        return '';
    } else {
        Str = Str.replace(/\./gi, "");
        return Str;
    }
}
/*end: convert price */

/* START: tag,brand,... */
var time;
/*tag
if ($('#tags').length) {
    select2_($('#tags'));
}
if ($('#brands').length) {
    select2_($('#brands'));
} */
if (typeof tags != 'undefined') {
    let _this = $('#tags');
    let json = _this.attr('data-json');
    let value = (typeof json != "undefined") ? window.atob(json) : '';
    value = JSON.parse(value);
    if (value != 'undefined' && value.length) {
        for (let i = 0; i < value.length; i++) {
            var option = new Option(value[i].text, value[i].id, true, true);
            $('#tags').append(option).trigger('change');
        }
    }
}

if (typeof brands != 'undefined') {
    let _this = $('#brands');
    let json = _this.attr('data-json');
    let value = (typeof json != "undefined") ? window.atob(json) : '';
    value = JSON.parse(value);
    if (value != 'undefined' && value.length) {
        for (let i = 0; i < value.length; i++) {
            var option = new Option(value[i].text, value[i].id, true, true);
            $('#brands').append(option).trigger('change');
        }
    }
}
/* END: tag,brand,... */

// function select2_(object, select = "title", condition = '') {
//     let title = object.attr('data-title');
//     let module = object.attr('id');
//     object.select2({
//         minimumInputLength: 0,
//         placeholder: title,
//         ajax: {
//             url: BASE_URL_AJAX + 'ajax/get-select2',
//             type: 'POST',
//             dataType: 'json',
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             deley: 250,
//             data: function (params) {
//                 return {
//                     locationVal: params.term,
//                     module: module,
//                     select: select,
//                     condition: condition,
//                 };
//             },
//             processResults: function (data) {
//                 console.log(data);
//                 return {
//                     results: $.map(data, function (obj, i) {
//                         return obj
//                     })
//                 }
//             },
//             cache: true,
//         }
//     });
// }

$(document).on('click', '#formPopup', function (e) {
    e.preventDefault();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        url: BASE_URL_AJAX + "ajax/ajax-create",
        type: "POST",
        dataType: "JSON",
        data: {
            module: 'tags',
            title: $('#myModal input[name="title"]').val(),
        },
        success: function (data) {
            if (data.code === 200) {
                $("#myModal .alert-popup").removeClass('alert-danger-soft').addClass(
                    'alert-success-soft');
                $("#myModal .alert-popup").html('Thêm mới thành công').show();
                setTimeout(function () {
                    $("#myModal .alert-popup").hide();
                    $('#myModal input[name="title"]').val('');
                }, 1500);
            }
        },
        error: function (jqXhr, json, errorThrown) {
            var errors = jqXhr.responseJSON;
            var errorsHtml = "";
            $.each(errors["errors"], function (index, value) {

                errorsHtml += value + "/ ";
            });
            $("#myModal .alert-popup").removeClass('alert-success-soft').addClass(
                'alert-danger-soft');
            $("#myModal .alert-popup").html(errorsHtml).show();
        },
    });
});
