<?php

namespace PHPMaker2022\school;

// Page object
$ConfScholarityEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_scholarity: currentTable } });
var currentForm, currentPageID;
var fconf_scholarityedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_scholarityedit = new ew.Form("fconf_scholarityedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fconf_scholarityedit;

    // Add fields
    var fields = currentTable.fields;
    fconf_scholarityedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["escolarityBR", [fields.escolarityBR.visible && fields.escolarityBR.required ? ew.Validators.required(fields.escolarityBR.caption) : null], fields.escolarityBR.isInvalid],
        ["escolarityEN", [fields.escolarityEN.visible && fields.escolarityEN.required ? ew.Validators.required(fields.escolarityEN.caption) : null], fields.escolarityEN.isInvalid],
        ["escolaritySP", [fields.escolaritySP.visible && fields.escolaritySP.required ? ew.Validators.required(fields.escolaritySP.caption) : null], fields.escolaritySP.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_scholarityedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_scholarityedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_scholarityedit");
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
<form name="fconf_scholarityedit" id="fconf_scholarityedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_scholarity">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_conf_scholarity_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_scholarity_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="conf_scholarity" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escolarityBR->Visible) { // escolarityBR ?>
    <div id="r_escolarityBR"<?= $Page->escolarityBR->rowAttributes() ?>>
        <label id="elh_conf_scholarity_escolarityBR" for="x_escolarityBR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escolarityBR->caption() ?><?= $Page->escolarityBR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escolarityBR->cellAttributes() ?>>
<span id="el_conf_scholarity_escolarityBR">
<input type="<?= $Page->escolarityBR->getInputTextType() ?>" name="x_escolarityBR" id="x_escolarityBR" data-table="conf_scholarity" data-field="x_escolarityBR" value="<?= $Page->escolarityBR->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->escolarityBR->getPlaceHolder()) ?>"<?= $Page->escolarityBR->editAttributes() ?> aria-describedby="x_escolarityBR_help">
<?= $Page->escolarityBR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escolarityBR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escolarityEN->Visible) { // escolarityEN ?>
    <div id="r_escolarityEN"<?= $Page->escolarityEN->rowAttributes() ?>>
        <label id="elh_conf_scholarity_escolarityEN" for="x_escolarityEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escolarityEN->caption() ?><?= $Page->escolarityEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escolarityEN->cellAttributes() ?>>
<span id="el_conf_scholarity_escolarityEN">
<input type="<?= $Page->escolarityEN->getInputTextType() ?>" name="x_escolarityEN" id="x_escolarityEN" data-table="conf_scholarity" data-field="x_escolarityEN" value="<?= $Page->escolarityEN->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->escolarityEN->getPlaceHolder()) ?>"<?= $Page->escolarityEN->editAttributes() ?> aria-describedby="x_escolarityEN_help">
<?= $Page->escolarityEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escolarityEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escolaritySP->Visible) { // escolaritySP ?>
    <div id="r_escolaritySP"<?= $Page->escolaritySP->rowAttributes() ?>>
        <label id="elh_conf_scholarity_escolaritySP" for="x_escolaritySP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escolaritySP->caption() ?><?= $Page->escolaritySP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escolaritySP->cellAttributes() ?>>
<span id="el_conf_scholarity_escolaritySP">
<input type="<?= $Page->escolaritySP->getInputTextType() ?>" name="x_escolaritySP" id="x_escolaritySP" data-table="conf_scholarity" data-field="x_escolaritySP" value="<?= $Page->escolaritySP->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->escolaritySP->getPlaceHolder()) ?>"<?= $Page->escolaritySP->editAttributes() ?> aria-describedby="x_escolaritySP_help">
<?= $Page->escolaritySP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escolaritySP->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_scholarity");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
