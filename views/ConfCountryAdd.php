<?php

namespace PHPMaker2022\school;

// Page object
$ConfCountryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_country: currentTable } });
var currentForm, currentPageID;
var fconf_countryadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_countryadd = new ew.Form("fconf_countryadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_countryadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_countryadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["country", [fields.country.visible && fields.country.required ? ew.Validators.required(fields.country.caption) : null], fields.country.isInvalid],
        ["countryLanguage", [fields.countryLanguage.visible && fields.countryLanguage.required ? ew.Validators.required(fields.countryLanguage.caption) : null], fields.countryLanguage.isInvalid],
        ["countryFlag", [fields.countryFlag.visible && fields.countryFlag.required ? ew.Validators.required(fields.countryFlag.caption) : null], fields.countryFlag.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_countryadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_countryadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_countryadd");
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
<form name="fconf_countryadd" id="fconf_countryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_country">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_conf_country_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_country_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="conf_country" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <div id="r_country"<?= $Page->country->rowAttributes() ?>>
        <label id="elh_conf_country_country" for="x_country" class="<?= $Page->LeftColumnClass ?>"><?= $Page->country->caption() ?><?= $Page->country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->country->cellAttributes() ?>>
<span id="el_conf_country_country">
<input type="<?= $Page->country->getInputTextType() ?>" name="x_country" id="x_country" data-table="conf_country" data-field="x_country" value="<?= $Page->country->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->country->getPlaceHolder()) ?>"<?= $Page->country->editAttributes() ?> aria-describedby="x_country_help">
<?= $Page->country->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->country->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryLanguage->Visible) { // countryLanguage ?>
    <div id="r_countryLanguage"<?= $Page->countryLanguage->rowAttributes() ?>>
        <label id="elh_conf_country_countryLanguage" for="x_countryLanguage" class="<?= $Page->LeftColumnClass ?>"><?= $Page->countryLanguage->caption() ?><?= $Page->countryLanguage->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->countryLanguage->cellAttributes() ?>>
<span id="el_conf_country_countryLanguage">
<input type="<?= $Page->countryLanguage->getInputTextType() ?>" name="x_countryLanguage" id="x_countryLanguage" data-table="conf_country" data-field="x_countryLanguage" value="<?= $Page->countryLanguage->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->countryLanguage->getPlaceHolder()) ?>"<?= $Page->countryLanguage->editAttributes() ?> aria-describedby="x_countryLanguage_help">
<?= $Page->countryLanguage->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->countryLanguage->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryFlag->Visible) { // countryFlag ?>
    <div id="r_countryFlag"<?= $Page->countryFlag->rowAttributes() ?>>
        <label id="elh_conf_country_countryFlag" for="x_countryFlag" class="<?= $Page->LeftColumnClass ?>"><?= $Page->countryFlag->caption() ?><?= $Page->countryFlag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->countryFlag->cellAttributes() ?>>
<span id="el_conf_country_countryFlag">
<input type="<?= $Page->countryFlag->getInputTextType() ?>" name="x_countryFlag" id="x_countryFlag" data-table="conf_country" data-field="x_countryFlag" value="<?= $Page->countryFlag->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->countryFlag->getPlaceHolder()) ?>"<?= $Page->countryFlag->editAttributes() ?> aria-describedby="x_countryFlag_help">
<?= $Page->countryFlag->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->countryFlag->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_country");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
