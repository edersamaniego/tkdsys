<?php

namespace PHPMaker2022\school;

// Page object
$FinDepartmentAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_department: currentTable } });
var currentForm, currentPageID;
var ffin_departmentadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_departmentadd = new ew.Form("ffin_departmentadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_departmentadd;

    // Add fields
    var fields = currentTable.fields;
    ffin_departmentadd.addFields([
        ["department", [fields.department.visible && fields.department.required ? ew.Validators.required(fields.department.caption) : null], fields.department.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["lastupdate", [fields.lastupdate.visible && fields.lastupdate.required ? ew.Validators.required(fields.lastupdate.caption) : null], fields.lastupdate.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null], fields._userId.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_departmentadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_departmentadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_departmentadd.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    ffin_departmentadd.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    loadjs.done("ffin_departmentadd");
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
<form name="ffin_departmentadd" id="ffin_departmentadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_department">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->department->Visible) { // department ?>
    <div id="r_department"<?= $Page->department->rowAttributes() ?>>
        <label id="elh_fin_department_department" for="x_department" class="<?= $Page->LeftColumnClass ?>"><?= $Page->department->caption() ?><?= $Page->department->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->department->cellAttributes() ?>>
<span id="el_fin_department_department">
<input type="<?= $Page->department->getInputTextType() ?>" name="x_department" id="x_department" data-table="fin_department" data-field="x_department" value="<?= $Page->department->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->department->getPlaceHolder()) ?>"<?= $Page->department->editAttributes() ?> aria-describedby="x_department_help">
<?= $Page->department->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->department->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fin_department");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
