<?php

namespace PHPMaker2022\school;

// Page object
$FinDiscountAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_discount: currentTable } });
var currentForm, currentPageID;
var ffin_discountadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_discountadd = new ew.Form("ffin_discountadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_discountadd;

    // Add fields
    var fields = currentTable.fields;
    ffin_discountadd.addFields([
        ["discount", [fields.discount.visible && fields.discount.required ? ew.Validators.required(fields.discount.caption) : null], fields.discount.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_discountadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_discountadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_discountadd.lists.type = <?= $Page->type->toClientList($Page) ?>;
    loadjs.done("ffin_discountadd");
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
<form name="ffin_discountadd" id="ffin_discountadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_discount">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->discount->Visible) { // discount ?>
    <div id="r_discount"<?= $Page->discount->rowAttributes() ?>>
        <label id="elh_fin_discount_discount" for="x_discount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->discount->caption() ?><?= $Page->discount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->discount->cellAttributes() ?>>
<span id="el_fin_discount_discount">
<input type="<?= $Page->discount->getInputTextType() ?>" name="x_discount" id="x_discount" data-table="fin_discount" data-field="x_discount" value="<?= $Page->discount->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->discount->getPlaceHolder()) ?>"<?= $Page->discount->editAttributes() ?> aria-describedby="x_discount_help">
<?= $Page->discount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->discount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_fin_discount_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_fin_discount_type">
<template id="tp_x_type">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fin_discount" data-field="x_type" name="x_type" id="x_type"<?= $Page->type->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_type" class="ew-item-list"></div>
<selection-list hidden
    id="x_type"
    name="x_type"
    value="<?= HtmlEncode($Page->type->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_type"
    data-bs-target="dsl_x_type"
    data-repeatcolumn="5"
    class="form-control<?= $Page->type->isInvalidClass() ?>"
    data-table="fin_discount"
    data-field="x_type"
    data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
    <?= $Page->type->editAttributes() ?>></selection-list>
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_fin_discount_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_discount_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="fin_discount" data-field="x_value" value="<?= $Page->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fin_discount");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
