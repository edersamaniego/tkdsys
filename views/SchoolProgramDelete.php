<?php

namespace PHPMaker2022\school;

// Page object
$SchoolProgramDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_program: currentTable } });
var currentForm, currentPageID;
var fschool_programdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_programdelete = new ew.Form("fschool_programdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fschool_programdelete;
    loadjs.done("fschool_programdelete");
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
<form name="fschool_programdelete" id="fschool_programdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_program">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_school_program_id" class="school_program_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->program->Visible) { // program ?>
        <th class="<?= $Page->program->headerCellClass() ?>"><span id="elh_school_program_program" class="school_program_program"><?= $Page->program->caption() ?></span></th>
<?php } ?>
<?php if ($Page->timeContractByMonth->Visible) { // timeContractByMonth ?>
        <th class="<?= $Page->timeContractByMonth->headerCellClass() ?>"><span id="elh_school_program_timeContractByMonth" class="school_program_timeContractByMonth"><?= $Page->timeContractByMonth->caption() ?></span></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th class="<?= $Page->value->headerCellClass() ?>"><span id="elh_school_program_value" class="school_program_value"><?= $Page->value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
        <th class="<?= $Page->modalityId->headerCellClass() ?>"><span id="elh_school_program_modalityId" class="school_program_modalityId"><?= $Page->modalityId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contractId->Visible) { // contractId ?>
        <th class="<?= $Page->contractId->headerCellClass() ?>"><span id="elh_school_program_contractId" class="school_program_contractId"><?= $Page->contractId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_school_program_schoolId" class="school_program_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_id" class="el_school_program_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->program->Visible) { // program ?>
        <td<?= $Page->program->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_program" class="el_school_program_program">
<span<?= $Page->program->viewAttributes() ?>>
<?= $Page->program->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->timeContractByMonth->Visible) { // timeContractByMonth ?>
        <td<?= $Page->timeContractByMonth->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_timeContractByMonth" class="el_school_program_timeContractByMonth">
<span<?= $Page->timeContractByMonth->viewAttributes() ?>>
<?= $Page->timeContractByMonth->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <td<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_value" class="el_school_program_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
        <td<?= $Page->modalityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_modalityId" class="el_school_program_modalityId">
<span<?= $Page->modalityId->viewAttributes() ?>>
<?= $Page->modalityId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contractId->Visible) { // contractId ?>
        <td<?= $Page->contractId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_contractId" class="el_school_program_contractId">
<span<?= $Page->contractId->viewAttributes() ?>>
<?= $Page->contractId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_program_schoolId" class="el_school_program_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
