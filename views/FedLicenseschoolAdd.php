<?php

namespace PHPMaker2022\school;

// Page object
$FedLicenseschoolAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_licenseschool: currentTable } });
var currentForm, currentPageID;
var ffed_licenseschooladd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_licenseschooladd = new ew.Form("ffed_licenseschooladd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_licenseschooladd;

    // Add fields
    var fields = currentTable.fields;
    ffed_licenseschooladd.addFields([
        ["application", [fields.application.visible && fields.application.required ? ew.Validators.required(fields.application.caption) : null, ew.Validators.integer], fields.application.isInvalid],
        ["dateLicense", [fields.dateLicense.visible && fields.dateLicense.required ? ew.Validators.required(fields.dateLicense.caption) : null, ew.Validators.datetime(fields.dateLicense.clientFormatPattern)], fields.dateLicense.isInvalid],
        ["dateStart", [fields.dateStart.visible && fields.dateStart.required ? ew.Validators.required(fields.dateStart.caption) : null, ew.Validators.datetime(fields.dateStart.clientFormatPattern)], fields.dateStart.isInvalid],
        ["dateFinish", [fields.dateFinish.visible && fields.dateFinish.required ? ew.Validators.required(fields.dateFinish.caption) : null, ew.Validators.datetime(fields.dateFinish.clientFormatPattern)], fields.dateFinish.isInvalid],
        ["schooltype", [fields.schooltype.visible && fields.schooltype.required ? ew.Validators.required(fields.schooltype.caption) : null], fields.schooltype.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["installment", [fields.installment.visible && fields.installment.required ? ew.Validators.required(fields.installment.caption) : null, ew.Validators.integer], fields.installment.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null], fields._userId.isInvalid],
        ["registerDate", [fields.registerDate.visible && fields.registerDate.required ? ew.Validators.required(fields.registerDate.caption) : null], fields.registerDate.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_licenseschooladd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_licenseschooladd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_licenseschooladd.lists.application = <?= $Page->application->toClientList($Page) ?>;
    ffed_licenseschooladd.lists.schooltype = <?= $Page->schooltype->toClientList($Page) ?>;
    ffed_licenseschooladd.lists.value = <?= $Page->value->toClientList($Page) ?>;
    ffed_licenseschooladd.lists._userId = <?= $Page->_userId->toClientList($Page) ?>;
    loadjs.done("ffed_licenseschooladd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffed_licenseschooladd" id="ffed_licenseschooladd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_licenseschool">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fed_applicationschool") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_applicationschool">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->application->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->application->Visible) { // application ?>
    <div id="r_application"<?= $Page->application->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_application" class="<?= $Page->LeftColumnClass ?>"><?= $Page->application->caption() ?><?= $Page->application->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->application->cellAttributes() ?>>
<?php if ($Page->application->getSessionValue() != "") { ?>
<span<?= $Page->application->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->application->getDisplayValue($Page->application->ViewValue) ?></span></span>
<input type="hidden" id="x_application" name="x_application" value="<?= HtmlEncode($Page->application->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fed_licenseschool_application">
<?php
$onchange = $Page->application->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->application->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->application->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_application" class="ew-auto-suggest">
    <input type="<?= $Page->application->getInputTextType() ?>" class="form-control" name="sv_x_application" id="sv_x_application" value="<?= RemoveHtml($Page->application->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->application->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->application->getPlaceHolder()) ?>"<?= $Page->application->editAttributes() ?> aria-describedby="x_application_help">
</span>
<selection-list hidden class="form-control" data-table="fed_licenseschool" data-field="x_application" data-input="sv_x_application" data-value-separator="<?= $Page->application->displayValueSeparatorAttribute() ?>" name="x_application" id="x_application" value="<?= HtmlEncode($Page->application->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->application->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->application->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_licenseschooladd", function() {
    ffed_licenseschooladd.createAutoSuggest(Object.assign({"id":"x_application","forceSelect":false}, ew.vars.tables.fed_licenseschool.fields.application.autoSuggestOptions));
});
</script>
<?= $Page->application->Lookup->getParamTag($Page, "p_x_application") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
    <div id="r_dateLicense"<?= $Page->dateLicense->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_dateLicense" for="x_dateLicense" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateLicense->caption() ?><?= $Page->dateLicense->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateLicense->cellAttributes() ?>>
<span id="el_fed_licenseschool_dateLicense">
<input type="<?= $Page->dateLicense->getInputTextType() ?>" name="x_dateLicense" id="x_dateLicense" data-table="fed_licenseschool" data-field="x_dateLicense" value="<?= $Page->dateLicense->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateLicense->getPlaceHolder()) ?>"<?= $Page->dateLicense->editAttributes() ?> aria-describedby="x_dateLicense_help">
<?= $Page->dateLicense->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateLicense->getErrorMessage() ?></div>
<?php if (!$Page->dateLicense->ReadOnly && !$Page->dateLicense->Disabled && !isset($Page->dateLicense->EditAttrs["readonly"]) && !isset($Page->dateLicense->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschooladd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ffed_licenseschooladd", "x_dateLicense", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
    <div id="r_dateStart"<?= $Page->dateStart->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_dateStart" for="x_dateStart" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateStart->caption() ?><?= $Page->dateStart->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateStart->cellAttributes() ?>>
<span id="el_fed_licenseschool_dateStart">
<input type="<?= $Page->dateStart->getInputTextType() ?>" name="x_dateStart" id="x_dateStart" data-table="fed_licenseschool" data-field="x_dateStart" value="<?= $Page->dateStart->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateStart->getPlaceHolder()) ?>"<?= $Page->dateStart->editAttributes() ?> aria-describedby="x_dateStart_help">
<?= $Page->dateStart->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateStart->getErrorMessage() ?></div>
<?php if (!$Page->dateStart->ReadOnly && !$Page->dateStart->Disabled && !isset($Page->dateStart->EditAttrs["readonly"]) && !isset($Page->dateStart->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschooladd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ffed_licenseschooladd", "x_dateStart", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
    <div id="r_dateFinish"<?= $Page->dateFinish->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_dateFinish" for="x_dateFinish" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateFinish->caption() ?><?= $Page->dateFinish->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateFinish->cellAttributes() ?>>
<span id="el_fed_licenseschool_dateFinish">
<input type="<?= $Page->dateFinish->getInputTextType() ?>" name="x_dateFinish" id="x_dateFinish" data-table="fed_licenseschool" data-field="x_dateFinish" value="<?= $Page->dateFinish->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateFinish->getPlaceHolder()) ?>"<?= $Page->dateFinish->editAttributes() ?> aria-describedby="x_dateFinish_help">
<?= $Page->dateFinish->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateFinish->getErrorMessage() ?></div>
<?php if (!$Page->dateFinish->ReadOnly && !$Page->dateFinish->Disabled && !isset($Page->dateFinish->EditAttrs["readonly"]) && !isset($Page->dateFinish->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschooladd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ffed_licenseschooladd", "x_dateFinish", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
    <div id="r_schooltype"<?= $Page->schooltype->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_schooltype" for="x_schooltype" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schooltype->caption() ?><?= $Page->schooltype->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schooltype->cellAttributes() ?>>
<span id="el_fed_licenseschool_schooltype">
<?php $Page->schooltype->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_schooltype"
        name="x_schooltype"
        class="form-select ew-select<?= $Page->schooltype->isInvalidClass() ?>"
        data-select2-id="ffed_licenseschooladd_x_schooltype"
        data-table="fed_licenseschool"
        data-field="x_schooltype"
        data-value-separator="<?= $Page->schooltype->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schooltype->getPlaceHolder()) ?>"
        <?= $Page->schooltype->editAttributes() ?>>
        <?= $Page->schooltype->selectOptionListHtml("x_schooltype") ?>
    </select>
    <?= $Page->schooltype->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schooltype->getErrorMessage() ?></div>
<?= $Page->schooltype->Lookup->getParamTag($Page, "p_x_schooltype") ?>
<script>
loadjs.ready("ffed_licenseschooladd", function() {
    var options = { name: "x_schooltype", selectId: "ffed_licenseschooladd_x_schooltype" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_licenseschooladd.lists.schooltype.lookupOptions.length) {
        options.data = { id: "x_schooltype", form: "ffed_licenseschooladd" };
    } else {
        options.ajax = { id: "x_schooltype", form: "ffed_licenseschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_licenseschool.fields.schooltype.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_fed_licenseschool_value">
<?php
$onchange = $Page->value->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->value->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->value->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_value" class="ew-auto-suggest">
    <input type="<?= $Page->value->getInputTextType() ?>" class="form-control" name="sv_x_value" id="sv_x_value" value="<?= RemoveHtml($Page->value->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
</span>
<selection-list hidden class="form-control" data-table="fed_licenseschool" data-field="x_value" data-input="sv_x_value" data-value-separator="<?= $Page->value->displayValueSeparatorAttribute() ?>" name="x_value" id="x_value" value="<?= HtmlEncode($Page->value->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_licenseschooladd", function() {
    ffed_licenseschooladd.createAutoSuggest(Object.assign({"id":"x_value","forceSelect":false}, ew.vars.tables.fed_licenseschool.fields.value.autoSuggestOptions));
});
</script>
<?= $Page->value->Lookup->getParamTag($Page, "p_x_value") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->installment->Visible) { // installment ?>
    <div id="r_installment"<?= $Page->installment->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_installment" for="x_installment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->installment->caption() ?><?= $Page->installment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->installment->cellAttributes() ?>>
<span id="el_fed_licenseschool_installment">
<input type="<?= $Page->installment->getInputTextType() ?>" name="x_installment" id="x_installment" data-table="fed_licenseschool" data-field="x_installment" value="<?= $Page->installment->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->installment->getPlaceHolder()) ?>"<?= $Page->installment->editAttributes() ?> aria-describedby="x_installment_help">
<?= $Page->installment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->installment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_fed_licenseschool_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_fed_licenseschool_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="fed_licenseschool" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fed_licenseschool");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
