<?php

namespace PHPMaker2022\school;

// Page object
$ConfMembertypeEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_membertype: currentTable } });
var currentForm, currentPageID;
var fconf_membertypeedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_membertypeedit = new ew.Form("fconf_membertypeedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fconf_membertypeedit;

    // Add fields
    var fields = currentTable.fields;
    fconf_membertypeedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
        ["isStudent", [fields.isStudent.visible && fields.isStudent.required ? ew.Validators.required(fields.isStudent.caption) : null], fields.isStudent.isInvalid],
        ["isOwner", [fields.isOwner.visible && fields.isOwner.required ? ew.Validators.required(fields.isOwner.caption) : null], fields.isOwner.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_membertypeedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_membertypeedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fconf_membertypeedit.lists.isStudent = <?= $Page->isStudent->toClientList($Page) ?>;
    fconf_membertypeedit.lists.isOwner = <?= $Page->isOwner->toClientList($Page) ?>;
    loadjs.done("fconf_membertypeedit");
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
<form name="fconf_membertypeedit" id="fconf_membertypeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_membertype">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_conf_membertype_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_membertype_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="conf_membertype" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_conf_membertype_type" for="x_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_conf_membertype_type">
<input type="<?= $Page->type->getInputTextType() ?>" name="x_type" id="x_type" data-table="conf_membertype" data-field="x_type" value="<?= $Page->type->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"<?= $Page->type->editAttributes() ?> aria-describedby="x_type_help">
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isStudent->Visible) { // isStudent ?>
    <div id="r_isStudent"<?= $Page->isStudent->rowAttributes() ?>>
        <label id="elh_conf_membertype_isStudent" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isStudent->caption() ?><?= $Page->isStudent->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isStudent->cellAttributes() ?>>
<span id="el_conf_membertype_isStudent">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->isStudent->isInvalidClass() ?>" data-table="conf_membertype" data-field="x_isStudent" name="x_isStudent[]" id="x_isStudent_134292" value="1"<?= ConvertToBool($Page->isStudent->CurrentValue) ? " checked" : "" ?><?= $Page->isStudent->editAttributes() ?> aria-describedby="x_isStudent_help">
    <div class="invalid-feedback"><?= $Page->isStudent->getErrorMessage() ?></div>
</div>
<?= $Page->isStudent->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isOwner->Visible) { // isOwner ?>
    <div id="r_isOwner"<?= $Page->isOwner->rowAttributes() ?>>
        <label id="elh_conf_membertype_isOwner" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isOwner->caption() ?><?= $Page->isOwner->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isOwner->cellAttributes() ?>>
<span id="el_conf_membertype_isOwner">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->isOwner->isInvalidClass() ?>" data-table="conf_membertype" data-field="x_isOwner" name="x_isOwner[]" id="x_isOwner_696171" value="1"<?= ConvertToBool($Page->isOwner->CurrentValue) ? " checked" : "" ?><?= $Page->isOwner->editAttributes() ?> aria-describedby="x_isOwner_help">
    <div class="invalid-feedback"><?= $Page->isOwner->getErrorMessage() ?></div>
</div>
<?= $Page->isOwner->getCustomMessage() ?>
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
    ew.addEventHandlers("conf_membertype");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
