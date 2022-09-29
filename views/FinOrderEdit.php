<?php

namespace PHPMaker2022\school;

// Page object
$FinOrderEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_order: currentTable } });
var currentForm, currentPageID;
var ffin_orderedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_orderedit = new ew.Form("ffin_orderedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffin_orderedit;

    // Add fields
    var fields = currentTable.fields;
    ffin_orderedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["discountId", [fields.discountId.visible && fields.discountId.required ? ew.Validators.required(fields.discountId.caption) : null, ew.Validators.integer], fields.discountId.isInvalid],
        ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
        ["due", [fields.due.visible && fields.due.required ? ew.Validators.required(fields.due.caption) : null, ew.Validators.datetime(fields.due.clientFormatPattern)], fields.due.isInvalid],
        ["debtor", [fields.debtor.visible && fields.debtor.required ? ew.Validators.required(fields.debtor.caption) : null, ew.Validators.integer], fields.debtor.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_orderedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_orderedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_orderedit.lists.discountId = <?= $Page->discountId->toClientList($Page) ?>;
    loadjs.done("ffin_orderedit");
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
<?php if (!$Page->IsModal) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<form name="ffin_orderedit" id="ffin_orderedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_order">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fin_order_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_order_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_order" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->discountId->Visible) { // discountId ?>
    <div id="r_discountId"<?= $Page->discountId->rowAttributes() ?>>
        <label id="elh_fin_order_discountId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->discountId->caption() ?><?= $Page->discountId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->discountId->cellAttributes() ?>>
<span id="el_fin_order_discountId">
<?php
$onchange = $Page->discountId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->discountId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->discountId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_discountId" class="ew-auto-suggest">
    <input type="<?= $Page->discountId->getInputTextType() ?>" class="form-control" name="sv_x_discountId" id="sv_x_discountId" value="<?= RemoveHtml($Page->discountId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->discountId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->discountId->getPlaceHolder()) ?>"<?= $Page->discountId->editAttributes() ?> aria-describedby="x_discountId_help">
</span>
<selection-list hidden class="form-control" data-table="fin_order" data-field="x_discountId" data-input="sv_x_discountId" data-value-separator="<?= $Page->discountId->displayValueSeparatorAttribute() ?>" name="x_discountId" id="x_discountId" value="<?= HtmlEncode($Page->discountId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->discountId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->discountId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_orderedit", function() {
    ffin_orderedit.createAutoSuggest(Object.assign({"id":"x_discountId","forceSelect":false}, ew.vars.tables.fin_order.fields.discountId.autoSuggestOptions));
});
</script>
<?= $Page->discountId->Lookup->getParamTag($Page, "p_x_discountId") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date"<?= $Page->date->rowAttributes() ?>>
        <label id="elh_fin_order_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date->cellAttributes() ?>>
<span id="el_fin_order_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="fin_order" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_orderedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_orderedit", "x_date", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
    <div id="r_due"<?= $Page->due->rowAttributes() ?>>
        <label id="elh_fin_order_due" for="x_due" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due->caption() ?><?= $Page->due->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due->cellAttributes() ?>>
<span id="el_fin_order_due">
<input type="<?= $Page->due->getInputTextType() ?>" name="x_due" id="x_due" data-table="fin_order" data-field="x_due" value="<?= $Page->due->EditValue ?>" placeholder="<?= HtmlEncode($Page->due->getPlaceHolder()) ?>"<?= $Page->due->editAttributes() ?> aria-describedby="x_due_help">
<?= $Page->due->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due->getErrorMessage() ?></div>
<?php if (!$Page->due->ReadOnly && !$Page->due->Disabled && !isset($Page->due->EditAttrs["readonly"]) && !isset($Page->due->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_orderedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_orderedit", "x_due", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->debtor->Visible) { // debtor ?>
    <div id="r_debtor"<?= $Page->debtor->rowAttributes() ?>>
        <label id="elh_fin_order_debtor" for="x_debtor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->debtor->caption() ?><?= $Page->debtor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->debtor->cellAttributes() ?>>
<span id="el_fin_order_debtor">
<input type="<?= $Page->debtor->getInputTextType() ?>" name="x_debtor" id="x_debtor" data-table="fin_order" data-field="x_debtor" value="<?= $Page->debtor->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->debtor->getPlaceHolder()) ?>"<?= $Page->debtor->editAttributes() ?> aria-describedby="x_debtor_help">
<?= $Page->debtor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->debtor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("fin_orderdetails", explode(",", $Page->getCurrentDetailTable())) && $fin_orderdetails->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_orderdetails", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinOrderdetailsGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fin_order");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
