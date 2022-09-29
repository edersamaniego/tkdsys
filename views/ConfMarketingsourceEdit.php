<?php

namespace PHPMaker2022\school;

// Page object
$ConfMarketingsourceEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_marketingsource: currentTable } });
var currentForm, currentPageID;
var fconf_marketingsourceedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_marketingsourceedit = new ew.Form("fconf_marketingsourceedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fconf_marketingsourceedit;

    // Add fields
    var fields = currentTable.fields;
    fconf_marketingsourceedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["marketingsourceBR", [fields.marketingsourceBR.visible && fields.marketingsourceBR.required ? ew.Validators.required(fields.marketingsourceBR.caption) : null], fields.marketingsourceBR.isInvalid],
        ["marketingsourceEN", [fields.marketingsourceEN.visible && fields.marketingsourceEN.required ? ew.Validators.required(fields.marketingsourceEN.caption) : null], fields.marketingsourceEN.isInvalid],
        ["marketingsourceSP", [fields.marketingsourceSP.visible && fields.marketingsourceSP.required ? ew.Validators.required(fields.marketingsourceSP.caption) : null], fields.marketingsourceSP.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_marketingsourceedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_marketingsourceedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_marketingsourceedit");
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
<form name="fconf_marketingsourceedit" id="fconf_marketingsourceedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_marketingsource">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_conf_marketingsource_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_marketingsource_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="conf_marketingsource" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marketingsourceBR->Visible) { // marketingsourceBR ?>
    <div id="r_marketingsourceBR"<?= $Page->marketingsourceBR->rowAttributes() ?>>
        <label id="elh_conf_marketingsource_marketingsourceBR" for="x_marketingsourceBR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marketingsourceBR->caption() ?><?= $Page->marketingsourceBR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marketingsourceBR->cellAttributes() ?>>
<span id="el_conf_marketingsource_marketingsourceBR">
<input type="<?= $Page->marketingsourceBR->getInputTextType() ?>" name="x_marketingsourceBR" id="x_marketingsourceBR" data-table="conf_marketingsource" data-field="x_marketingsourceBR" value="<?= $Page->marketingsourceBR->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->marketingsourceBR->getPlaceHolder()) ?>"<?= $Page->marketingsourceBR->editAttributes() ?> aria-describedby="x_marketingsourceBR_help">
<?= $Page->marketingsourceBR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->marketingsourceBR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marketingsourceEN->Visible) { // marketingsourceEN ?>
    <div id="r_marketingsourceEN"<?= $Page->marketingsourceEN->rowAttributes() ?>>
        <label id="elh_conf_marketingsource_marketingsourceEN" for="x_marketingsourceEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marketingsourceEN->caption() ?><?= $Page->marketingsourceEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marketingsourceEN->cellAttributes() ?>>
<span id="el_conf_marketingsource_marketingsourceEN">
<input type="<?= $Page->marketingsourceEN->getInputTextType() ?>" name="x_marketingsourceEN" id="x_marketingsourceEN" data-table="conf_marketingsource" data-field="x_marketingsourceEN" value="<?= $Page->marketingsourceEN->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->marketingsourceEN->getPlaceHolder()) ?>"<?= $Page->marketingsourceEN->editAttributes() ?> aria-describedby="x_marketingsourceEN_help">
<?= $Page->marketingsourceEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->marketingsourceEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marketingsourceSP->Visible) { // marketingsourceSP ?>
    <div id="r_marketingsourceSP"<?= $Page->marketingsourceSP->rowAttributes() ?>>
        <label id="elh_conf_marketingsource_marketingsourceSP" for="x_marketingsourceSP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marketingsourceSP->caption() ?><?= $Page->marketingsourceSP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marketingsourceSP->cellAttributes() ?>>
<span id="el_conf_marketingsource_marketingsourceSP">
<input type="<?= $Page->marketingsourceSP->getInputTextType() ?>" name="x_marketingsourceSP" id="x_marketingsourceSP" data-table="conf_marketingsource" data-field="x_marketingsourceSP" value="<?= $Page->marketingsourceSP->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->marketingsourceSP->getPlaceHolder()) ?>"<?= $Page->marketingsourceSP->editAttributes() ?> aria-describedby="x_marketingsourceSP_help">
<?= $Page->marketingsourceSP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->marketingsourceSP->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_marketingsource");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
