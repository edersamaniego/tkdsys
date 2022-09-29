<?php

namespace PHPMaker2022\school;

// Page object
$TesTestJudgeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test_judge: currentTable } });
var currentForm, currentPageID;
var ftes_test_judgedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_test_judgedelete = new ew.Form("ftes_test_judgedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ftes_test_judgedelete;
    loadjs.done("ftes_test_judgedelete");
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
<form name="ftes_test_judgedelete" id="ftes_test_judgedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test_judge">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_tes_test_judge_id" class="tes_test_judge_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->judgeMemberId->Visible) { // judgeMemberId ?>
        <th class="<?= $Page->judgeMemberId->headerCellClass() ?>"><span id="elh_tes_test_judge_judgeMemberId" class="tes_test_judge_judgeMemberId"><?= $Page->judgeMemberId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th class="<?= $Page->testId->headerCellClass() ?>"><span id="elh_tes_test_judge_testId" class="tes_test_judge_testId"><?= $Page->testId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <th class="<?= $Page->rankId->headerCellClass() ?>"><span id="elh_tes_test_judge_rankId" class="tes_test_judge_rankId"><?= $Page->rankId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->instructorRegister->Visible) { // instructorRegister ?>
        <th class="<?= $Page->instructorRegister->headerCellClass() ?>"><span id="elh_tes_test_judge_instructorRegister" class="tes_test_judge_instructorRegister"><?= $Page->instructorRegister->caption() ?></span></th>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
        <th class="<?= $Page->federationRegister->headerCellClass() ?>"><span id="elh_tes_test_judge_federationRegister" class="tes_test_judge_federationRegister"><?= $Page->federationRegister->caption() ?></span></th>
<?php } ?>
<?php if ($Page->memberCityId->Visible) { // memberCityId ?>
        <th class="<?= $Page->memberCityId->headerCellClass() ?>"><span id="elh_tes_test_judge_memberCityId" class="tes_test_judge_memberCityId"><?= $Page->memberCityId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_tes_test_judge_id" class="el_tes_test_judge_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->judgeMemberId->Visible) { // judgeMemberId ?>
        <td<?= $Page->judgeMemberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_judgeMemberId" class="el_tes_test_judge_judgeMemberId">
<span<?= $Page->judgeMemberId->viewAttributes() ?>>
<?= $Page->judgeMemberId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <td<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_testId" class="el_tes_test_judge_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <td<?= $Page->rankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_rankId" class="el_tes_test_judge_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->instructorRegister->Visible) { // instructorRegister ?>
        <td<?= $Page->instructorRegister->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_instructorRegister" class="el_tes_test_judge_instructorRegister">
<span<?= $Page->instructorRegister->viewAttributes() ?>>
<?= $Page->instructorRegister->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
        <td<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_federationRegister" class="el_tes_test_judge_federationRegister">
<span<?= $Page->federationRegister->viewAttributes() ?>>
<?= $Page->federationRegister->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->memberCityId->Visible) { // memberCityId ?>
        <td<?= $Page->memberCityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_memberCityId" class="el_tes_test_judge_memberCityId">
<span<?= $Page->memberCityId->viewAttributes() ?>>
<?= $Page->memberCityId->getViewValue() ?></span>
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
