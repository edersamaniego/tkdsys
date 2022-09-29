<?php

namespace PHPMaker2022\school;

// Page object
$TesAprovedDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_aproved: currentTable } });
var currentForm, currentPageID;
var ftes_aproveddelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_aproveddelete = new ew.Form("ftes_aproveddelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ftes_aproveddelete;
    loadjs.done("ftes_aproveddelete");
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
<form name="ftes_aproveddelete" id="ftes_aproveddelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_aproved">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_tes_aproved_id" class="tes_aproved_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->resultAmountId->Visible) { // resultAmountId ?>
        <th class="<?= $Page->resultAmountId->headerCellClass() ?>"><span id="elh_tes_aproved_resultAmountId" class="tes_aproved_resultAmountId"><?= $Page->resultAmountId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
        <th class="<?= $Page->federationId->headerCellClass() ?>"><span id="elh_tes_aproved_federationId" class="tes_aproved_federationId"><?= $Page->federationId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_tes_aproved_schoolId" class="tes_aproved_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th class="<?= $Page->testId->headerCellClass() ?>"><span id="elh_tes_aproved_testId" class="tes_aproved_testId"><?= $Page->testId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th class="<?= $Page->memberId->headerCellClass() ?>"><span id="elh_tes_aproved_memberId" class="tes_aproved_memberId"><?= $Page->memberId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->memberName->Visible) { // memberName ?>
        <th class="<?= $Page->memberName->headerCellClass() ?>"><span id="elh_tes_aproved_memberName" class="tes_aproved_memberName"><?= $Page->memberName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><span id="elh_tes_aproved_createUserId" class="tes_aproved_createUserId"><?= $Page->createUserId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_tes_aproved_createDate" class="tes_aproved_createDate"><?= $Page->createDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->newRankId->Visible) { // newRankId ?>
        <th class="<?= $Page->newRankId->headerCellClass() ?>"><span id="elh_tes_aproved_newRankId" class="tes_aproved_newRankId"><?= $Page->newRankId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->oldRankId->Visible) { // oldRankId ?>
        <th class="<?= $Page->oldRankId->headerCellClass() ?>"><span id="elh_tes_aproved_oldRankId" class="tes_aproved_oldRankId"><?= $Page->oldRankId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_tes_aproved_id" class="el_tes_aproved_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->resultAmountId->Visible) { // resultAmountId ?>
        <td<?= $Page->resultAmountId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_resultAmountId" class="el_tes_aproved_resultAmountId">
<span<?= $Page->resultAmountId->viewAttributes() ?>>
<?= $Page->resultAmountId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
        <td<?= $Page->federationId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_federationId" class="el_tes_aproved_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_schoolId" class="el_tes_aproved_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <td<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_testId" class="el_tes_aproved_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <td<?= $Page->memberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_memberId" class="el_tes_aproved_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->memberName->Visible) { // memberName ?>
        <td<?= $Page->memberName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_memberName" class="el_tes_aproved_memberName">
<span<?= $Page->memberName->viewAttributes() ?>>
<?= $Page->memberName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_createUserId" class="el_tes_aproved_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_createDate" class="el_tes_aproved_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->newRankId->Visible) { // newRankId ?>
        <td<?= $Page->newRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_newRankId" class="el_tes_aproved_newRankId">
<span<?= $Page->newRankId->viewAttributes() ?>>
<?= $Page->newRankId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->oldRankId->Visible) { // oldRankId ?>
        <td<?= $Page->oldRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_oldRankId" class="el_tes_aproved_oldRankId">
<span<?= $Page->oldRankId->viewAttributes() ?>>
<?= $Page->oldRankId->getViewValue() ?></span>
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
