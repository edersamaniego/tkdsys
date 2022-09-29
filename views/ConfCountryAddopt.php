<?php

namespace PHPMaker2022\school;

// Page object
$ConfCountryAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_country: currentTable } });
var currentForm, currentPageID;
var fconf_countryaddopt;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_countryaddopt = new ew.Form("fconf_countryaddopt", "addopt");
    currentPageID = ew.PAGE_ID = "addopt";
    currentForm = fconf_countryaddopt;

    // Add fields
    var fields = currentTable.fields;
    fconf_countryaddopt.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["country", [fields.country.visible && fields.country.required ? ew.Validators.required(fields.country.caption) : null], fields.country.isInvalid],
        ["countryLanguage", [fields.countryLanguage.visible && fields.countryLanguage.required ? ew.Validators.required(fields.countryLanguage.caption) : null], fields.countryLanguage.isInvalid],
        ["countryFlag", [fields.countryFlag.visible && fields.countryFlag.required ? ew.Validators.required(fields.countryFlag.caption) : null], fields.countryFlag.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_countryaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_countryaddopt.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_countryaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fconf_countryaddopt" id="fconf_countryaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="conf_country">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->id->Visible) { // id ?>
    <div<?= $Page->id->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_id"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->id->cellAttributes() ?>>
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="conf_country" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <div<?= $Page->country->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_country"><?= $Page->country->caption() ?><?= $Page->country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->country->cellAttributes() ?>>
<input type="<?= $Page->country->getInputTextType() ?>" name="x_country" id="x_country" data-table="conf_country" data-field="x_country" value="<?= $Page->country->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->country->getPlaceHolder()) ?>"<?= $Page->country->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->country->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryLanguage->Visible) { // countryLanguage ?>
    <div<?= $Page->countryLanguage->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_countryLanguage"><?= $Page->countryLanguage->caption() ?><?= $Page->countryLanguage->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->countryLanguage->cellAttributes() ?>>
<input type="<?= $Page->countryLanguage->getInputTextType() ?>" name="x_countryLanguage" id="x_countryLanguage" data-table="conf_country" data-field="x_countryLanguage" value="<?= $Page->countryLanguage->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->countryLanguage->getPlaceHolder()) ?>"<?= $Page->countryLanguage->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->countryLanguage->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryFlag->Visible) { // countryFlag ?>
    <div<?= $Page->countryFlag->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_countryFlag"><?= $Page->countryFlag->caption() ?><?= $Page->countryFlag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->countryFlag->cellAttributes() ?>>
<input type="<?= $Page->countryFlag->getInputTextType() ?>" name="x_countryFlag" id="x_countryFlag" data-table="conf_country" data-field="x_countryFlag" value="<?= $Page->countryFlag->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->countryFlag->getPlaceHolder()) ?>"<?= $Page->countryFlag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->countryFlag->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_country");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
