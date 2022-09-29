<?php

namespace PHPMaker2022\school;

// Page object
$ConfSchooltypeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_schooltype: currentTable } });
var currentForm, currentPageID;
var fconf_schooltypeadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_schooltypeadd = new ew.Form("fconf_schooltypeadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_schooltypeadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_schooltypeadd.addFields([
        ["typeBr", [fields.typeBr.visible && fields.typeBr.required ? ew.Validators.required(fields.typeBr.caption) : null], fields.typeBr.isInvalid],
        ["typeEs", [fields.typeEs.visible && fields.typeEs.required ? ew.Validators.required(fields.typeEs.caption) : null], fields.typeEs.isInvalid],
        ["typeEn", [fields.typeEn.visible && fields.typeEn.required ? ew.Validators.required(fields.typeEn.caption) : null], fields.typeEn.isInvalid],
        ["licensevalue", [fields.licensevalue.visible && fields.licensevalue.required ? ew.Validators.required(fields.licensevalue.caption) : null, ew.Validators.float], fields.licensevalue.isInvalid],
        ["_default", [fields._default.visible && fields._default.required ? ew.Validators.required(fields._default.caption) : null], fields._default.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_schooltypeadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_schooltypeadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fconf_schooltypeadd.lists._default = <?= $Page->_default->toClientList($Page) ?>;
    loadjs.done("fconf_schooltypeadd");
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
<form name="fconf_schooltypeadd" id="fconf_schooltypeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_schooltype">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->typeBr->Visible) { // typeBr ?>
    <div id="r_typeBr"<?= $Page->typeBr->rowAttributes() ?>>
        <label id="elh_conf_schooltype_typeBr" for="x_typeBr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->typeBr->caption() ?><?= $Page->typeBr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->typeBr->cellAttributes() ?>>
<span id="el_conf_schooltype_typeBr">
<input type="<?= $Page->typeBr->getInputTextType() ?>" name="x_typeBr" id="x_typeBr" data-table="conf_schooltype" data-field="x_typeBr" value="<?= $Page->typeBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->typeBr->getPlaceHolder()) ?>"<?= $Page->typeBr->editAttributes() ?> aria-describedby="x_typeBr_help">
<?= $Page->typeBr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->typeBr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->typeEs->Visible) { // typeEs ?>
    <div id="r_typeEs"<?= $Page->typeEs->rowAttributes() ?>>
        <label id="elh_conf_schooltype_typeEs" for="x_typeEs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->typeEs->caption() ?><?= $Page->typeEs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->typeEs->cellAttributes() ?>>
<span id="el_conf_schooltype_typeEs">
<input type="<?= $Page->typeEs->getInputTextType() ?>" name="x_typeEs" id="x_typeEs" data-table="conf_schooltype" data-field="x_typeEs" value="<?= $Page->typeEs->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->typeEs->getPlaceHolder()) ?>"<?= $Page->typeEs->editAttributes() ?> aria-describedby="x_typeEs_help">
<?= $Page->typeEs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->typeEs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->typeEn->Visible) { // typeEn ?>
    <div id="r_typeEn"<?= $Page->typeEn->rowAttributes() ?>>
        <label id="elh_conf_schooltype_typeEn" for="x_typeEn" class="<?= $Page->LeftColumnClass ?>"><?= $Page->typeEn->caption() ?><?= $Page->typeEn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->typeEn->cellAttributes() ?>>
<span id="el_conf_schooltype_typeEn">
<input type="<?= $Page->typeEn->getInputTextType() ?>" name="x_typeEn" id="x_typeEn" data-table="conf_schooltype" data-field="x_typeEn" value="<?= $Page->typeEn->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->typeEn->getPlaceHolder()) ?>"<?= $Page->typeEn->editAttributes() ?> aria-describedby="x_typeEn_help">
<?= $Page->typeEn->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->typeEn->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->licensevalue->Visible) { // licensevalue ?>
    <div id="r_licensevalue"<?= $Page->licensevalue->rowAttributes() ?>>
        <label id="elh_conf_schooltype_licensevalue" for="x_licensevalue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->licensevalue->caption() ?><?= $Page->licensevalue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->licensevalue->cellAttributes() ?>>
<span id="el_conf_schooltype_licensevalue">
<input type="<?= $Page->licensevalue->getInputTextType() ?>" name="x_licensevalue" id="x_licensevalue" data-table="conf_schooltype" data-field="x_licensevalue" value="<?= $Page->licensevalue->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->licensevalue->getPlaceHolder()) ?>"<?= $Page->licensevalue->editAttributes() ?> aria-describedby="x_licensevalue_help">
<?= $Page->licensevalue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->licensevalue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
    <div id="r__default"<?= $Page->_default->rowAttributes() ?>>
        <label id="elh_conf_schooltype__default" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_default->caption() ?><?= $Page->_default->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_default->cellAttributes() ?>>
<span id="el_conf_schooltype__default">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->_default->isInvalidClass() ?>" data-table="conf_schooltype" data-field="x__default" name="x__default[]" id="x__default_545461" value="1"<?= ConvertToBool($Page->_default->CurrentValue) ? " checked" : "" ?><?= $Page->_default->editAttributes() ?> aria-describedby="x__default_help">
    <div class="invalid-feedback"><?= $Page->_default->getErrorMessage() ?></div>
</div>
<?= $Page->_default->getCustomMessage() ?>
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
    ew.addEventHandlers("conf_schooltype");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
