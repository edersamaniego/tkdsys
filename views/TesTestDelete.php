<?php

namespace PHPMaker2022\school;

// Page object
$TesTestDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test: currentTable } });
var currentForm, currentPageID;
var ftes_testdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_testdelete = new ew.Form("ftes_testdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ftes_testdelete;
    loadjs.done("ftes_testdelete");
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
<form name="ftes_testdelete" id="ftes_testdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_tes_test_id" class="tes_test_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th class="<?= $Page->description->headerCellClass() ?>"><span id="elh_tes_test_description" class="tes_test_description"><?= $Page->description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testCity->Visible) { // testCity ?>
        <th class="<?= $Page->testCity->headerCellClass() ?>"><span id="elh_tes_test_testCity" class="tes_test_testCity"><?= $Page->testCity->caption() ?></span></th>
<?php } ?>
<?php if ($Page->martialartsId->Visible) { // martialartsId ?>
        <th class="<?= $Page->martialartsId->headerCellClass() ?>"><span id="elh_tes_test_martialartsId" class="tes_test_martialartsId"><?= $Page->martialartsId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_tes_test_schoolId" class="tes_test_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
        <th class="<?= $Page->testDate->headerCellClass() ?>"><span id="elh_tes_test_testDate" class="tes_test_testDate"><?= $Page->testDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testTime->Visible) { // testTime ?>
        <th class="<?= $Page->testTime->headerCellClass() ?>"><span id="elh_tes_test_testTime" class="tes_test_testTime"><?= $Page->testTime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
        <th class="<?= $Page->ceremonyDate->headerCellClass() ?>"><span id="elh_tes_test_ceremonyDate" class="tes_test_ceremonyDate"><?= $Page->ceremonyDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->certificateId->Visible) { // certificateId ?>
        <th class="<?= $Page->certificateId->headerCellClass() ?>"><span id="elh_tes_test_certificateId" class="tes_test_certificateId"><?= $Page->certificateId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_tes_test_id" class="el_tes_test_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <td<?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_description" class="el_tes_test_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testCity->Visible) { // testCity ?>
        <td<?= $Page->testCity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_testCity" class="el_tes_test_testCity">
<span<?= $Page->testCity->viewAttributes() ?>>
<?= $Page->testCity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->martialartsId->Visible) { // martialartsId ?>
        <td<?= $Page->martialartsId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_martialartsId" class="el_tes_test_martialartsId">
<span<?= $Page->martialartsId->viewAttributes() ?>>
<?= $Page->martialartsId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_schoolId" class="el_tes_test_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
        <td<?= $Page->testDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_testDate" class="el_tes_test_testDate">
<span<?= $Page->testDate->viewAttributes() ?>>
<?= $Page->testDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testTime->Visible) { // testTime ?>
        <td<?= $Page->testTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_testTime" class="el_tes_test_testTime">
<span<?= $Page->testTime->viewAttributes() ?>>
<?= $Page->testTime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
        <td<?= $Page->ceremonyDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_ceremonyDate" class="el_tes_test_ceremonyDate">
<span<?= $Page->ceremonyDate->viewAttributes() ?>>
<?= $Page->ceremonyDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->certificateId->Visible) { // certificateId ?>
        <td<?= $Page->certificateId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_certificateId" class="el_tes_test_certificateId">
<span<?= $Page->certificateId->viewAttributes() ?>>
<?= $Page->certificateId->getViewValue() ?></span>
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
