<?php

namespace PHPMaker2022\school;

// Page object
$FinOrderdetailsEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_orderdetails: currentTable } });
var currentForm, currentPageID;
var ffin_orderdetailsedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_orderdetailsedit = new ew.Form("ffin_orderdetailsedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffin_orderdetailsedit;

    // Add fields
    var fields = currentTable.fields;
    ffin_orderdetailsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["orderId", [fields.orderId.visible && fields.orderId.required ? ew.Validators.required(fields.orderId.caption) : null, ew.Validators.integer], fields.orderId.isInvalid],
        ["item", [fields.item.visible && fields.item.required ? ew.Validators.required(fields.item.caption) : null, ew.Validators.integer], fields.item.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.float], fields.amount.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["discountId", [fields.discountId.visible && fields.discountId.required ? ew.Validators.required(fields.discountId.caption) : null, ew.Validators.integer], fields.discountId.isInvalid],
        ["observation", [fields.observation.visible && fields.observation.required ? ew.Validators.required(fields.observation.caption) : null], fields.observation.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_orderdetailsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_orderdetailsedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_orderdetailsedit.lists.discountId = <?= $Page->discountId->toClientList($Page) ?>;
    loadjs.done("ffin_orderdetailsedit");
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
<form name="ffin_orderdetailsedit" id="ffin_orderdetailsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_orderdetails">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fin_order") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fin_order">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->orderId->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_orderdetails_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderId->Visible) { // orderId ?>
    <div id="r_orderId"<?= $Page->orderId->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_orderId" for="x_orderId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderId->caption() ?><?= $Page->orderId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->orderId->cellAttributes() ?>>
<?php if ($Page->orderId->getSessionValue() != "") { ?>
<span<?= $Page->orderId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->orderId->getDisplayValue($Page->orderId->ViewValue))) ?>"></span>
<input type="hidden" id="x_orderId" name="x_orderId" value="<?= HtmlEncode($Page->orderId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fin_orderdetails_orderId">
<input type="<?= $Page->orderId->getInputTextType() ?>" name="x_orderId" id="x_orderId" data-table="fin_orderdetails" data-field="x_orderId" value="<?= $Page->orderId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->orderId->getPlaceHolder()) ?>"<?= $Page->orderId->editAttributes() ?> aria-describedby="x_orderId_help">
<?= $Page->orderId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderId->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
    <div id="r_item"<?= $Page->item->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_item" for="x_item" class="<?= $Page->LeftColumnClass ?>"><?= $Page->item->caption() ?><?= $Page->item->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->item->cellAttributes() ?>>
<span id="el_fin_orderdetails_item">
<input type="<?= $Page->item->getInputTextType() ?>" name="x_item" id="x_item" data-table="fin_orderdetails" data-field="x_item" value="<?= $Page->item->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>"<?= $Page->item->editAttributes() ?> aria-describedby="x_item_help">
<?= $Page->item->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->item->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<span id="el_fin_orderdetails_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="fin_orderdetails" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_orderdetails_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="fin_orderdetails" data-field="x_value" value="<?= $Page->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->discountId->Visible) { // discountId ?>
    <div id="r_discountId"<?= $Page->discountId->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_discountId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->discountId->caption() ?><?= $Page->discountId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->discountId->cellAttributes() ?>>
<span id="el_fin_orderdetails_discountId">
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
<selection-list hidden class="form-control" data-table="fin_orderdetails" data-field="x_discountId" data-input="sv_x_discountId" data-value-separator="<?= $Page->discountId->displayValueSeparatorAttribute() ?>" name="x_discountId" id="x_discountId" value="<?= HtmlEncode($Page->discountId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->discountId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->discountId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_orderdetailsedit", function() {
    ffin_orderdetailsedit.createAutoSuggest(Object.assign({"id":"x_discountId","forceSelect":false}, ew.vars.tables.fin_orderdetails.fields.discountId.autoSuggestOptions));
});
</script>
<?= $Page->discountId->Lookup->getParamTag($Page, "p_x_discountId") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->observation->Visible) { // observation ?>
    <div id="r_observation"<?= $Page->observation->rowAttributes() ?>>
        <label id="elh_fin_orderdetails_observation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->observation->caption() ?><?= $Page->observation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->observation->cellAttributes() ?>>
<span id="el_fin_orderdetails_observation">
<?php $Page->observation->EditAttrs->appendClass("editor"); ?>
<textarea data-table="fin_orderdetails" data-field="x_observation" name="x_observation" id="x_observation" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->observation->getPlaceHolder()) ?>"<?= $Page->observation->editAttributes() ?> aria-describedby="x_observation_help"><?= $Page->observation->EditValue ?></textarea>
<?= $Page->observation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->observation->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffin_orderdetailsedit", "editor"], function() {
    ew.createEditor("ffin_orderdetailsedit", "x_observation", 35, 4, <?= $Page->observation->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("fin_orderdetails");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
