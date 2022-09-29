<?php

namespace PHPMaker2022\school;

// Page object
$SchoolClassDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_class: currentTable } });
var currentForm, currentPageID;
var fschool_classdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_classdelete = new ew.Form("fschool_classdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fschool_classdelete;
    loadjs.done("fschool_classdelete");
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
<form name="fschool_classdelete" id="fschool_classdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_class">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_school_class_id" class="school_class_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_school_class_schoolId" class="school_class_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->daysByWeek->Visible) { // daysByWeek ?>
        <th class="<?= $Page->daysByWeek->headerCellClass() ?>"><span id="elh_school_class_daysByWeek" class="school_class_daysByWeek"><?= $Page->daysByWeek->caption() ?></span></th>
<?php } ?>
<?php if ($Page->beginnigTime->Visible) { // beginnigTime ?>
        <th class="<?= $Page->beginnigTime->headerCellClass() ?>"><span id="elh_school_class_beginnigTime" class="school_class_beginnigTime"><?= $Page->beginnigTime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->endingTime->Visible) { // endingTime ?>
        <th class="<?= $Page->endingTime->headerCellClass() ?>"><span id="elh_school_class_endingTime" class="school_class_endingTime"><?= $Page->endingTime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_school_class_status" class="school_class_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->limit->Visible) { // limit ?>
        <th class="<?= $Page->limit->headerCellClass() ?>"><span id="elh_school_class_limit" class="school_class_limit"><?= $Page->limit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
        <th class="<?= $Page->modalityId->headerCellClass() ?>"><span id="elh_school_class_modalityId" class="school_class_modalityId"><?= $Page->modalityId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_school_class_id" class="el_school_class_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_schoolId" class="el_school_class_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->daysByWeek->Visible) { // daysByWeek ?>
        <td<?= $Page->daysByWeek->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_daysByWeek" class="el_school_class_daysByWeek">
<span<?= $Page->daysByWeek->viewAttributes() ?>>
<?= $Page->daysByWeek->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->beginnigTime->Visible) { // beginnigTime ?>
        <td<?= $Page->beginnigTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_beginnigTime" class="el_school_class_beginnigTime">
<span<?= $Page->beginnigTime->viewAttributes() ?>>
<?= $Page->beginnigTime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->endingTime->Visible) { // endingTime ?>
        <td<?= $Page->endingTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_endingTime" class="el_school_class_endingTime">
<span<?= $Page->endingTime->viewAttributes() ?>>
<?= $Page->endingTime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_status" class="el_school_class_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->limit->Visible) { // limit ?>
        <td<?= $Page->limit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_limit" class="el_school_class_limit">
<span<?= $Page->limit->viewAttributes() ?>>
<?= $Page->limit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
        <td<?= $Page->modalityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_class_modalityId" class="el_school_class_modalityId">
<span<?= $Page->modalityId->viewAttributes() ?>>
<?= $Page->modalityId->getViewValue() ?></span>
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
