<?php

namespace PHPMaker2022\school;

// Page object
$SchoolClassEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_class: currentTable } });
var currentForm, currentPageID;
var fschool_classedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_classedit = new ew.Form("fschool_classedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fschool_classedit;

    // Add fields
    var fields = currentTable.fields;
    fschool_classedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid],
        ["daysByWeek", [fields.daysByWeek.visible && fields.daysByWeek.required ? ew.Validators.required(fields.daysByWeek.caption) : null], fields.daysByWeek.isInvalid],
        ["beginnigTime", [fields.beginnigTime.visible && fields.beginnigTime.required ? ew.Validators.required(fields.beginnigTime.caption) : null, ew.Validators.time(fields.beginnigTime.clientFormatPattern)], fields.beginnigTime.isInvalid],
        ["endingTime", [fields.endingTime.visible && fields.endingTime.required ? ew.Validators.required(fields.endingTime.caption) : null, ew.Validators.time(fields.endingTime.clientFormatPattern)], fields.endingTime.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null, ew.Validators.integer], fields.status.isInvalid],
        ["limit", [fields.limit.visible && fields.limit.required ? ew.Validators.required(fields.limit.caption) : null, ew.Validators.integer], fields.limit.isInvalid],
        ["modalityId", [fields.modalityId.visible && fields.modalityId.required ? ew.Validators.required(fields.modalityId.caption) : null, ew.Validators.integer], fields.modalityId.isInvalid]
    ]);

    // Form_CustomValidate
    fschool_classedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_classedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fschool_classedit");
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
<form name="fschool_classedit" id="fschool_classedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_class">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_school_class_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_school_class_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="school_class" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_school_class_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("edit")) { // Non system admin ?>
<span id="el_school_class_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_classedit_x_schoolId"
        data-table="school_class"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_classedit", function() {
    var options = { name: "x_schoolId", selectId: "fschool_classedit_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_classedit.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "fschool_classedit" };
    } else {
        options.ajax = { id: "x_schoolId", form: "fschool_classedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_class.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_school_class_schoolId">
<input type="<?= $Page->schoolId->getInputTextType() ?>" name="x_schoolId" id="x_schoolId" data-table="school_class" data-field="x_schoolId" value="<?= $Page->schoolId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"<?= $Page->schoolId->editAttributes() ?> aria-describedby="x_schoolId_help">
<?= $Page->schoolId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->daysByWeek->Visible) { // daysByWeek ?>
    <div id="r_daysByWeek"<?= $Page->daysByWeek->rowAttributes() ?>>
        <label id="elh_school_class_daysByWeek" for="x_daysByWeek" class="<?= $Page->LeftColumnClass ?>"><?= $Page->daysByWeek->caption() ?><?= $Page->daysByWeek->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->daysByWeek->cellAttributes() ?>>
<span id="el_school_class_daysByWeek">
<input type="<?= $Page->daysByWeek->getInputTextType() ?>" name="x_daysByWeek" id="x_daysByWeek" data-table="school_class" data-field="x_daysByWeek" value="<?= $Page->daysByWeek->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->daysByWeek->getPlaceHolder()) ?>"<?= $Page->daysByWeek->editAttributes() ?> aria-describedby="x_daysByWeek_help">
<?= $Page->daysByWeek->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->daysByWeek->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->beginnigTime->Visible) { // beginnigTime ?>
    <div id="r_beginnigTime"<?= $Page->beginnigTime->rowAttributes() ?>>
        <label id="elh_school_class_beginnigTime" for="x_beginnigTime" class="<?= $Page->LeftColumnClass ?>"><?= $Page->beginnigTime->caption() ?><?= $Page->beginnigTime->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->beginnigTime->cellAttributes() ?>>
<span id="el_school_class_beginnigTime">
<input type="<?= $Page->beginnigTime->getInputTextType() ?>" name="x_beginnigTime" id="x_beginnigTime" data-table="school_class" data-field="x_beginnigTime" value="<?= $Page->beginnigTime->EditValue ?>" placeholder="<?= HtmlEncode($Page->beginnigTime->getPlaceHolder()) ?>"<?= $Page->beginnigTime->editAttributes() ?> aria-describedby="x_beginnigTime_help">
<?= $Page->beginnigTime->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->beginnigTime->getErrorMessage() ?></div>
<?php if (!$Page->beginnigTime->ReadOnly && !$Page->beginnigTime->Disabled && !isset($Page->beginnigTime->EditAttrs["readonly"]) && !isset($Page->beginnigTime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fschool_classedit", "timepicker"], () => ew.createTimePicker("fschool_classedit", "x_beginnigTime", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(4) ?>" })));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->endingTime->Visible) { // endingTime ?>
    <div id="r_endingTime"<?= $Page->endingTime->rowAttributes() ?>>
        <label id="elh_school_class_endingTime" for="x_endingTime" class="<?= $Page->LeftColumnClass ?>"><?= $Page->endingTime->caption() ?><?= $Page->endingTime->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->endingTime->cellAttributes() ?>>
<span id="el_school_class_endingTime">
<input type="<?= $Page->endingTime->getInputTextType() ?>" name="x_endingTime" id="x_endingTime" data-table="school_class" data-field="x_endingTime" value="<?= $Page->endingTime->EditValue ?>" placeholder="<?= HtmlEncode($Page->endingTime->getPlaceHolder()) ?>"<?= $Page->endingTime->editAttributes() ?> aria-describedby="x_endingTime_help">
<?= $Page->endingTime->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->endingTime->getErrorMessage() ?></div>
<?php if (!$Page->endingTime->ReadOnly && !$Page->endingTime->Disabled && !isset($Page->endingTime->EditAttrs["readonly"]) && !isset($Page->endingTime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fschool_classedit", "timepicker"], () => ew.createTimePicker("fschool_classedit", "x_endingTime", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(4) ?>" })));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_school_class_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_school_class_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="school_class" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit->Visible) { // limit ?>
    <div id="r_limit"<?= $Page->limit->rowAttributes() ?>>
        <label id="elh_school_class_limit" for="x_limit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit->caption() ?><?= $Page->limit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->limit->cellAttributes() ?>>
<span id="el_school_class_limit">
<input type="<?= $Page->limit->getInputTextType() ?>" name="x_limit" id="x_limit" data-table="school_class" data-field="x_limit" value="<?= $Page->limit->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->limit->getPlaceHolder()) ?>"<?= $Page->limit->editAttributes() ?> aria-describedby="x_limit_help">
<?= $Page->limit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
    <div id="r_modalityId"<?= $Page->modalityId->rowAttributes() ?>>
        <label id="elh_school_class_modalityId" for="x_modalityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modalityId->caption() ?><?= $Page->modalityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modalityId->cellAttributes() ?>>
<span id="el_school_class_modalityId">
<input type="<?= $Page->modalityId->getInputTextType() ?>" name="x_modalityId" id="x_modalityId" data-table="school_class" data-field="x_modalityId" value="<?= $Page->modalityId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->modalityId->getPlaceHolder()) ?>"<?= $Page->modalityId->editAttributes() ?> aria-describedby="x_modalityId_help">
<?= $Page->modalityId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modalityId->getErrorMessage() ?></div>
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
    ew.addEventHandlers("school_class");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
