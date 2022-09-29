/**
 * Create Time Picker (for PHPMaker 2022)
 * @license Copyright (c) e.World Technology Limited. All rights reserved.
 */
ew.createTimePicker = function(formid, id, options) {
    if (id.includes("$rowindex$"))
        return;
    var $ = jQuery,
        el = ew.getElement(id, formid),
        $el = $(el),
        isInvalid = $el.hasClass("is-invalid"),
        format = options.timeFormat;
    if ($el.hasClass("ui-timepicker-input"))
        return;
    if (format)
        options.timeFormat = data => ew.formatDateTime(data, format);
    var inputGroup = $.isBoolean(options.inputGroup) ? options.inputGroup : true;
    delete(options.inputGroup);
    $el.timepicker(options).on("showTimepicker", function() {
        this.timepickerObj.list.width($el.outerWidth() - 2);
    }).on("focus", function() {
        $el.tooltip("hide").tooltip("disable");
    }).on("blur", function() {
        $el.tooltip("enable");
    });
    if (inputGroup) {
        var $btn = $('<button type="button"><i class="far fa-clock"></i></button>')
            .addClass("btn btn-default")
            .on("click", function() {
                $el.timepicker("show");
            });
        $el.wrap(`<div class="input-group${isInvalid ? " is-invalid" : ""}"></div>`).after($btn);
    }
}
