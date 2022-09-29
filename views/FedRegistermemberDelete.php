<?php

namespace PHPMaker2022\school;

// Page object
$FedRegistermemberDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_registermember: currentTable } });
var currentForm, currentPageID;
var ffed_registermemberdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_registermemberdelete = new ew.Form("ffed_registermemberdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_registermemberdelete;
    loadjs.done("ffed_registermemberdelete");
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
<form name="ffed_registermemberdelete" id="ffed_registermemberdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_registermember">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_registermember_id" class="fed_registermember_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th class="<?= $Page->memberId->headerCellClass() ?>"><span id="elh_fed_registermember_memberId" class="fed_registermember_memberId"><?= $Page->memberId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_fed_registermember_schoolId" class="fed_registermember_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th class="<?= $Page->testId->headerCellClass() ?>"><span id="elh_fed_registermember_testId" class="fed_registermember_testId"><?= $Page->testId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->currentRankId->Visible) { // currentRankId ?>
        <th class="<?= $Page->currentRankId->headerCellClass() ?>"><span id="elh_fed_registermember_currentRankId" class="fed_registermember_currentRankId"><?= $Page->currentRankId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->registerType->Visible) { // registerType ?>
        <th class="<?= $Page->registerType->headerCellClass() ?>"><span id="elh_fed_registermember_registerType" class="fed_registermember_registerType"><?= $Page->registerType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><span id="elh_fed_registermember_createUserId" class="fed_registermember_createUserId"><?= $Page->createUserId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_fed_registermember_createDate" class="fed_registermember_createDate"><?= $Page->createDate->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_registermember_id" class="el_fed_registermember_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <td<?= $Page->memberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_memberId" class="el_fed_registermember_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_schoolId" class="el_fed_registermember_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <td<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_testId" class="el_fed_registermember_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->currentRankId->Visible) { // currentRankId ?>
        <td<?= $Page->currentRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_currentRankId" class="el_fed_registermember_currentRankId">
<span<?= $Page->currentRankId->viewAttributes() ?>>
<?= $Page->currentRankId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->registerType->Visible) { // registerType ?>
        <td<?= $Page->registerType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_registerType" class="el_fed_registermember_registerType">
<span<?= $Page->registerType->viewAttributes() ?>>
<?= $Page->registerType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_createUserId" class="el_fed_registermember_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_createDate" class="el_fed_registermember_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
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
