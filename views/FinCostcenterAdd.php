<?php

namespace PHPMaker2022\school;

// Page object
$FinCostcenterAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_costcenter: currentTable } });
var currentForm, currentPageID;
var ffin_costcenteradd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_costcenteradd = new ew.Form("ffin_costcenteradd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_costcenteradd;

    // Add fields
    var fields = currentTable.fields;
    ffin_costcenteradd.addFields([
        ["costCenter", [fields.costCenter.visible && fields.costCenter.required ? ew.Validators.required(fields.costCenter.caption) : null], fields.costCenter.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["organization", [fields.organization.visible && fields.organization.required ? ew.Validators.required(fields.organization.caption) : null], fields.organization.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_costcenteradd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_costcenteradd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_costcenteradd.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    ffin_costcenteradd.lists.organization = <?= $Page->organization->toClientList($Page) ?>;
    loadjs.done("ffin_costcenteradd");
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
<form name="ffin_costcenteradd" id="ffin_costcenteradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_costcenter">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->costCenter->Visible) { // costCenter ?>
    <div id="r_costCenter"<?= $Page->costCenter->rowAttributes() ?>>
        <label id="elh_fin_costcenter_costCenter" for="x_costCenter" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costCenter->caption() ?><?= $Page->costCenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costCenter->cellAttributes() ?>>
<span id="el_fin_costcenter_costCenter">
<input type="<?= $Page->costCenter->getInputTextType() ?>" name="x_costCenter" id="x_costCenter" data-table="fin_costcenter" data-field="x_costCenter" value="<?= $Page->costCenter->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->costCenter->getPlaceHolder()) ?>"<?= $Page->costCenter->editAttributes() ?> aria-describedby="x_costCenter_help">
<?= $Page->costCenter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->costCenter->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fin_costcenter");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
