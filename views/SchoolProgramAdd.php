<?php

namespace PHPMaker2022\school;

// Page object
$SchoolProgramAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_program: currentTable } });
var currentForm, currentPageID;
var fschool_programadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_programadd = new ew.Form("fschool_programadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fschool_programadd;

    // Add fields
    var fields = currentTable.fields;
    fschool_programadd.addFields([
        ["program", [fields.program.visible && fields.program.required ? ew.Validators.required(fields.program.caption) : null], fields.program.isInvalid],
        ["timeContractByMonth", [fields.timeContractByMonth.visible && fields.timeContractByMonth.required ? ew.Validators.required(fields.timeContractByMonth.caption) : null, ew.Validators.integer], fields.timeContractByMonth.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["modalityId", [fields.modalityId.visible && fields.modalityId.required ? ew.Validators.required(fields.modalityId.caption) : null, ew.Validators.integer], fields.modalityId.isInvalid],
        ["contractId", [fields.contractId.visible && fields.contractId.required ? ew.Validators.required(fields.contractId.caption) : null, ew.Validators.integer], fields.contractId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid]
    ]);

    // Form_CustomValidate
    fschool_programadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_programadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fschool_programadd.lists.modalityId = <?= $Page->modalityId->toClientList($Page) ?>;
    fschool_programadd.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    loadjs.done("fschool_programadd");
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
<form name="fschool_programadd" id="fschool_programadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_program">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->program->Visible) { // program ?>
    <div id="r_program"<?= $Page->program->rowAttributes() ?>>
        <label id="elh_school_program_program" for="x_program" class="<?= $Page->LeftColumnClass ?>"><?= $Page->program->caption() ?><?= $Page->program->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->program->cellAttributes() ?>>
<span id="el_school_program_program">
<input type="<?= $Page->program->getInputTextType() ?>" name="x_program" id="x_program" data-table="school_program" data-field="x_program" value="<?= $Page->program->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->program->getPlaceHolder()) ?>"<?= $Page->program->editAttributes() ?> aria-describedby="x_program_help">
<?= $Page->program->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->program->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->timeContractByMonth->Visible) { // timeContractByMonth ?>
    <div id="r_timeContractByMonth"<?= $Page->timeContractByMonth->rowAttributes() ?>>
        <label id="elh_school_program_timeContractByMonth" for="x_timeContractByMonth" class="<?= $Page->LeftColumnClass ?>"><?= $Page->timeContractByMonth->caption() ?><?= $Page->timeContractByMonth->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->timeContractByMonth->cellAttributes() ?>>
<span id="el_school_program_timeContractByMonth">
<input type="<?= $Page->timeContractByMonth->getInputTextType() ?>" name="x_timeContractByMonth" id="x_timeContractByMonth" data-table="school_program" data-field="x_timeContractByMonth" value="<?= $Page->timeContractByMonth->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->timeContractByMonth->getPlaceHolder()) ?>"<?= $Page->timeContractByMonth->editAttributes() ?> aria-describedby="x_timeContractByMonth_help">
<?= $Page->timeContractByMonth->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->timeContractByMonth->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_school_program_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_school_program_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="school_program" data-field="x_value" value="<?= $Page->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
    <div id="r_modalityId"<?= $Page->modalityId->rowAttributes() ?>>
        <label id="elh_school_program_modalityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modalityId->caption() ?><?= $Page->modalityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modalityId->cellAttributes() ?>>
<span id="el_school_program_modalityId">
<?php
$onchange = $Page->modalityId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->modalityId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->modalityId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_modalityId" class="ew-auto-suggest">
    <input type="<?= $Page->modalityId->getInputTextType() ?>" class="form-control" name="sv_x_modalityId" id="sv_x_modalityId" value="<?= RemoveHtml($Page->modalityId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->modalityId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->modalityId->getPlaceHolder()) ?>"<?= $Page->modalityId->editAttributes() ?> aria-describedby="x_modalityId_help">
</span>
<selection-list hidden class="form-control" data-table="school_program" data-field="x_modalityId" data-input="sv_x_modalityId" data-value-separator="<?= $Page->modalityId->displayValueSeparatorAttribute() ?>" name="x_modalityId" id="x_modalityId" value="<?= HtmlEncode($Page->modalityId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->modalityId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modalityId->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_programadd", function() {
    fschool_programadd.createAutoSuggest(Object.assign({"id":"x_modalityId","forceSelect":false}, ew.vars.tables.school_program.fields.modalityId.autoSuggestOptions));
});
</script>
<?= $Page->modalityId->Lookup->getParamTag($Page, "p_x_modalityId") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contractId->Visible) { // contractId ?>
    <div id="r_contractId"<?= $Page->contractId->rowAttributes() ?>>
        <label id="elh_school_program_contractId" for="x_contractId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contractId->caption() ?><?= $Page->contractId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contractId->cellAttributes() ?>>
<span id="el_school_program_contractId">
<input type="<?= $Page->contractId->getInputTextType() ?>" name="x_contractId" id="x_contractId" data-table="school_program" data-field="x_contractId" value="<?= $Page->contractId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->contractId->getPlaceHolder()) ?>"<?= $Page->contractId->editAttributes() ?> aria-describedby="x_contractId_help">
<?= $Page->contractId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contractId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_school_program_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_school_program_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_programadd_x_schoolId"
        data-table="school_program"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("fschool_programadd", function() {
    var options = { name: "x_schoolId", selectId: "fschool_programadd_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_programadd.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "fschool_programadd" };
    } else {
        options.ajax = { id: "x_schoolId", form: "fschool_programadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_program.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_school_program_schoolId">
<?php
$onchange = $Page->schoolId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->schoolId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->schoolId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_schoolId" class="ew-auto-suggest">
    <input type="<?= $Page->schoolId->getInputTextType() ?>" class="form-control" name="sv_x_schoolId" id="sv_x_schoolId" value="<?= RemoveHtml($Page->schoolId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"<?= $Page->schoolId->editAttributes() ?> aria-describedby="x_schoolId_help">
</span>
<selection-list hidden class="form-control" data-table="school_program" data-field="x_schoolId" data-input="sv_x_schoolId" data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>" name="x_schoolId" id="x_schoolId" value="<?= HtmlEncode($Page->schoolId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->schoolId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_programadd", function() {
    fschool_programadd.createAutoSuggest(Object.assign({"id":"x_schoolId","forceSelect":false}, ew.vars.tables.school_program.fields.schoolId.autoSuggestOptions));
});
</script>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
</span>
<?php } ?>
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
    ew.addEventHandlers("school_program");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
