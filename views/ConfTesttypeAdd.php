<?php

namespace PHPMaker2022\school;

// Page object
$ConfTesttypeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_testtype: currentTable } });
var currentForm, currentPageID;
var fconf_testtypeadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_testtypeadd = new ew.Form("fconf_testtypeadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_testtypeadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_testtypeadd.addFields([
        ["testType", [fields.testType.visible && fields.testType.required ? ew.Validators.required(fields.testType.caption) : null], fields.testType.isInvalid],
        ["testTypeEN", [fields.testTypeEN.visible && fields.testTypeEN.required ? ew.Validators.required(fields.testTypeEN.caption) : null], fields.testTypeEN.isInvalid],
        ["testTypeES", [fields.testTypeES.visible && fields.testTypeES.required ? ew.Validators.required(fields.testTypeES.caption) : null], fields.testTypeES.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_testtypeadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_testtypeadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_testtypeadd");
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
<form name="fconf_testtypeadd" id="fconf_testtypeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_testtype">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->testType->Visible) { // testType ?>
    <div id="r_testType"<?= $Page->testType->rowAttributes() ?>>
        <label id="elh_conf_testtype_testType" for="x_testType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testType->caption() ?><?= $Page->testType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testType->cellAttributes() ?>>
<span id="el_conf_testtype_testType">
<input type="<?= $Page->testType->getInputTextType() ?>" name="x_testType" id="x_testType" data-table="conf_testtype" data-field="x_testType" value="<?= $Page->testType->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->testType->getPlaceHolder()) ?>"<?= $Page->testType->editAttributes() ?> aria-describedby="x_testType_help">
<?= $Page->testType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testTypeEN->Visible) { // testTypeEN ?>
    <div id="r_testTypeEN"<?= $Page->testTypeEN->rowAttributes() ?>>
        <label id="elh_conf_testtype_testTypeEN" for="x_testTypeEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testTypeEN->caption() ?><?= $Page->testTypeEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testTypeEN->cellAttributes() ?>>
<span id="el_conf_testtype_testTypeEN">
<input type="<?= $Page->testTypeEN->getInputTextType() ?>" name="x_testTypeEN" id="x_testTypeEN" data-table="conf_testtype" data-field="x_testTypeEN" value="<?= $Page->testTypeEN->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->testTypeEN->getPlaceHolder()) ?>"<?= $Page->testTypeEN->editAttributes() ?> aria-describedby="x_testTypeEN_help">
<?= $Page->testTypeEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testTypeEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testTypeES->Visible) { // testTypeES ?>
    <div id="r_testTypeES"<?= $Page->testTypeES->rowAttributes() ?>>
        <label id="elh_conf_testtype_testTypeES" for="x_testTypeES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testTypeES->caption() ?><?= $Page->testTypeES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testTypeES->cellAttributes() ?>>
<span id="el_conf_testtype_testTypeES">
<input type="<?= $Page->testTypeES->getInputTextType() ?>" name="x_testTypeES" id="x_testTypeES" data-table="conf_testtype" data-field="x_testTypeES" value="<?= $Page->testTypeES->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->testTypeES->getPlaceHolder()) ?>"<?= $Page->testTypeES->editAttributes() ?> aria-describedby="x_testTypeES_help">
<?= $Page->testTypeES->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testTypeES->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_testtype");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
