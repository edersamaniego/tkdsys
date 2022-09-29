<?php

namespace PHPMaker2022\school;

// Page object
$ConfUfAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_uf: currentTable } });
var currentForm, currentPageID;
var fconf_ufaddopt;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_ufaddopt = new ew.Form("fconf_ufaddopt", "addopt");
    currentPageID = ew.PAGE_ID = "addopt";
    currentForm = fconf_ufaddopt;

    // Add fields
    var fields = currentTable.fields;
    fconf_ufaddopt.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["UF", [fields.UF.visible && fields.UF.required ? ew.Validators.required(fields.UF.caption) : null], fields.UF.isInvalid],
        ["abbreviation", [fields.abbreviation.visible && fields.abbreviation.required ? ew.Validators.required(fields.abbreviation.caption) : null], fields.abbreviation.isInvalid],
        ["countryId", [fields.countryId.visible && fields.countryId.required ? ew.Validators.required(fields.countryId.caption) : null, ew.Validators.integer], fields.countryId.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_ufaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_ufaddopt.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_ufaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fconf_ufaddopt" id="fconf_ufaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="conf_uf">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->id->Visible) { // id ?>
    <div<?= $Page->id->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_id"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->id->cellAttributes() ?>>
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="conf_uf" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UF->Visible) { // UF ?>
    <div<?= $Page->UF->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_UF"><?= $Page->UF->caption() ?><?= $Page->UF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->UF->cellAttributes() ?>>
<input type="<?= $Page->UF->getInputTextType() ?>" name="x_UF" id="x_UF" data-table="conf_uf" data-field="x_UF" value="<?= $Page->UF->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->UF->getPlaceHolder()) ?>"<?= $Page->UF->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->UF->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->abbreviation->Visible) { // abbreviation ?>
    <div<?= $Page->abbreviation->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_abbreviation"><?= $Page->abbreviation->caption() ?><?= $Page->abbreviation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->abbreviation->cellAttributes() ?>>
<input type="<?= $Page->abbreviation->getInputTextType() ?>" name="x_abbreviation" id="x_abbreviation" data-table="conf_uf" data-field="x_abbreviation" value="<?= $Page->abbreviation->EditValue ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->abbreviation->getPlaceHolder()) ?>"<?= $Page->abbreviation->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->abbreviation->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <div<?= $Page->countryId->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_countryId"><?= $Page->countryId->caption() ?><?= $Page->countryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->countryId->cellAttributes() ?>>
<input type="<?= $Page->countryId->getInputTextType() ?>" name="x_countryId" id="x_countryId" data-table="conf_uf" data-field="x_countryId" value="<?= $Page->countryId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->countryId->getPlaceHolder()) ?>"<?= $Page->countryId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->countryId->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("conf_uf");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
