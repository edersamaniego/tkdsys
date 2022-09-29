<?php

namespace PHPMaker2022\school;

// Page object
$ConfUfAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_uf: currentTable } });
var currentForm, currentPageID;
var fconf_ufadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_ufadd = new ew.Form("fconf_ufadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_ufadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_ufadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["UF", [fields.UF.visible && fields.UF.required ? ew.Validators.required(fields.UF.caption) : null], fields.UF.isInvalid],
        ["abbreviation", [fields.abbreviation.visible && fields.abbreviation.required ? ew.Validators.required(fields.abbreviation.caption) : null], fields.abbreviation.isInvalid],
        ["countryId", [fields.countryId.visible && fields.countryId.required ? ew.Validators.required(fields.countryId.caption) : null, ew.Validators.integer], fields.countryId.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_ufadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_ufadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_ufadd");
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
<form name="fconf_ufadd" id="fconf_ufadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_uf">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_conf_uf_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_uf_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="conf_uf" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UF->Visible) { // UF ?>
    <div id="r_UF"<?= $Page->UF->rowAttributes() ?>>
        <label id="elh_conf_uf_UF" for="x_UF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UF->caption() ?><?= $Page->UF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UF->cellAttributes() ?>>
<span id="el_conf_uf_UF">
<input type="<?= $Page->UF->getInputTextType() ?>" name="x_UF" id="x_UF" data-table="conf_uf" data-field="x_UF" value="<?= $Page->UF->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->UF->getPlaceHolder()) ?>"<?= $Page->UF->editAttributes() ?> aria-describedby="x_UF_help">
<?= $Page->UF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->abbreviation->Visible) { // abbreviation ?>
    <div id="r_abbreviation"<?= $Page->abbreviation->rowAttributes() ?>>
        <label id="elh_conf_uf_abbreviation" for="x_abbreviation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->abbreviation->caption() ?><?= $Page->abbreviation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->abbreviation->cellAttributes() ?>>
<span id="el_conf_uf_abbreviation">
<input type="<?= $Page->abbreviation->getInputTextType() ?>" name="x_abbreviation" id="x_abbreviation" data-table="conf_uf" data-field="x_abbreviation" value="<?= $Page->abbreviation->EditValue ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->abbreviation->getPlaceHolder()) ?>"<?= $Page->abbreviation->editAttributes() ?> aria-describedby="x_abbreviation_help">
<?= $Page->abbreviation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->abbreviation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <div id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <label id="elh_conf_uf_countryId" for="x_countryId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->countryId->caption() ?><?= $Page->countryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->countryId->cellAttributes() ?>>
<span id="el_conf_uf_countryId">
<input type="<?= $Page->countryId->getInputTextType() ?>" name="x_countryId" id="x_countryId" data-table="conf_uf" data-field="x_countryId" value="<?= $Page->countryId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->countryId->getPlaceHolder()) ?>"<?= $Page->countryId->editAttributes() ?> aria-describedby="x_countryId_help">
<?= $Page->countryId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->countryId->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_uf");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
