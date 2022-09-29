<?php

namespace PHPMaker2022\school;

// Page object
$FinPaymentmethodEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_paymentmethod: currentTable } });
var currentForm, currentPageID;
var ffin_paymentmethodedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_paymentmethodedit = new ew.Form("ffin_paymentmethodedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffin_paymentmethodedit;

    // Add fields
    var fields = currentTable.fields;
    ffin_paymentmethodedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["paymentmethod", [fields.paymentmethod.visible && fields.paymentmethod.required ? ew.Validators.required(fields.paymentmethod.caption) : null], fields.paymentmethod.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_paymentmethodedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_paymentmethodedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffin_paymentmethodedit");
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
<form name="ffin_paymentmethodedit" id="ffin_paymentmethodedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_paymentmethod">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fin_paymentmethod_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_paymentmethod_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_paymentmethod" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentmethod->Visible) { // paymentmethod ?>
    <div id="r_paymentmethod"<?= $Page->paymentmethod->rowAttributes() ?>>
        <label id="elh_fin_paymentmethod_paymentmethod" for="x_paymentmethod" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentmethod->caption() ?><?= $Page->paymentmethod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentmethod->cellAttributes() ?>>
<span id="el_fin_paymentmethod_paymentmethod">
<input type="<?= $Page->paymentmethod->getInputTextType() ?>" name="x_paymentmethod" id="x_paymentmethod" data-table="fin_paymentmethod" data-field="x_paymentmethod" value="<?= $Page->paymentmethod->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->paymentmethod->getPlaceHolder()) ?>"<?= $Page->paymentmethod->editAttributes() ?> aria-describedby="x_paymentmethod_help">
<?= $Page->paymentmethod->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentmethod->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fin_paymentmethod");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
