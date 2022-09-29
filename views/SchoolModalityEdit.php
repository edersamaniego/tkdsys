<?php

namespace PHPMaker2022\school;

// Page object
$SchoolModalityEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_modality: currentTable } });
var currentForm, currentPageID;
var fschool_modalityedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_modalityedit = new ew.Form("fschool_modalityedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fschool_modalityedit;

    // Add fields
    var fields = currentTable.fields;
    fschool_modalityedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["nameBR", [fields.nameBR.visible && fields.nameBR.required ? ew.Validators.required(fields.nameBR.caption) : null], fields.nameBR.isInvalid],
        ["nameES", [fields.nameES.visible && fields.nameES.required ? ew.Validators.required(fields.nameES.caption) : null], fields.nameES.isInvalid],
        ["nameEN", [fields.nameEN.visible && fields.nameEN.required ? ew.Validators.required(fields.nameEN.caption) : null], fields.nameEN.isInvalid]
    ]);

    // Form_CustomValidate
    fschool_modalityedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_modalityedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fschool_modalityedit.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    fschool_modalityedit.lists.nameES = <?= $Page->nameES->toClientList($Page) ?>;
    loadjs.done("fschool_modalityedit");
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
<form name="fschool_modalityedit" id="fschool_modalityedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_modality">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_school_modality_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_school_modality_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="school_modality" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nameBR->Visible) { // nameBR ?>
    <div id="r_nameBR"<?= $Page->nameBR->rowAttributes() ?>>
        <label id="elh_school_modality_nameBR" for="x_nameBR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nameBR->caption() ?><?= $Page->nameBR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nameBR->cellAttributes() ?>>
<span id="el_school_modality_nameBR">
<input type="<?= $Page->nameBR->getInputTextType() ?>" name="x_nameBR" id="x_nameBR" data-table="school_modality" data-field="x_nameBR" value="<?= $Page->nameBR->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->nameBR->getPlaceHolder()) ?>"<?= $Page->nameBR->editAttributes() ?> aria-describedby="x_nameBR_help">
<?= $Page->nameBR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nameBR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nameES->Visible) { // nameES ?>
    <div id="r_nameES"<?= $Page->nameES->rowAttributes() ?>>
        <label id="elh_school_modality_nameES" for="x_nameES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nameES->caption() ?><?= $Page->nameES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nameES->cellAttributes() ?>>
<span id="el_school_modality_nameES">
    <select
        id="x_nameES"
        name="x_nameES"
        class="form-select ew-select<?= $Page->nameES->isInvalidClass() ?>"
        data-select2-id="fschool_modalityedit_x_nameES"
        data-table="school_modality"
        data-field="x_nameES"
        data-value-separator="<?= $Page->nameES->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nameES->getPlaceHolder()) ?>"
        <?= $Page->nameES->editAttributes() ?>>
        <?= $Page->nameES->selectOptionListHtml("x_nameES") ?>
    </select>
    <?= $Page->nameES->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->nameES->getErrorMessage() ?></div>
<?= $Page->nameES->Lookup->getParamTag($Page, "p_x_nameES") ?>
<script>
loadjs.ready("fschool_modalityedit", function() {
    var options = { name: "x_nameES", selectId: "fschool_modalityedit_x_nameES" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_modalityedit.lists.nameES.lookupOptions.length) {
        options.data = { id: "x_nameES", form: "fschool_modalityedit" };
    } else {
        options.ajax = { id: "x_nameES", form: "fschool_modalityedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_modality.fields.nameES.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nameEN->Visible) { // nameEN ?>
    <div id="r_nameEN"<?= $Page->nameEN->rowAttributes() ?>>
        <label id="elh_school_modality_nameEN" for="x_nameEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nameEN->caption() ?><?= $Page->nameEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nameEN->cellAttributes() ?>>
<span id="el_school_modality_nameEN">
<input type="<?= $Page->nameEN->getInputTextType() ?>" name="x_nameEN" id="x_nameEN" data-table="school_modality" data-field="x_nameEN" value="<?= $Page->nameEN->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nameEN->getPlaceHolder()) ?>"<?= $Page->nameEN->editAttributes() ?> aria-describedby="x_nameEN_help">
<?= $Page->nameEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nameEN->getErrorMessage() ?></div>
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
    ew.addEventHandlers("school_modality");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
