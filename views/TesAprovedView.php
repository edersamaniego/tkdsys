<?php

namespace PHPMaker2022\school;

// Page object
$TesAprovedView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_aproved: currentTable } });
var currentForm, currentPageID;
var ftes_aprovedview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_aprovedview = new ew.Form("ftes_aprovedview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ftes_aprovedview;
    loadjs.done("ftes_aprovedview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<?php } ?>
<form name="ftes_aprovedview" id="ftes_aprovedview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_aproved">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_aproved_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->resultAmountId->Visible) { // resultAmountId ?>
    <tr id="r_resultAmountId"<?= $Page->resultAmountId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_resultAmountId"><?= $Page->resultAmountId->caption() ?></span></td>
        <td data-name="resultAmountId"<?= $Page->resultAmountId->cellAttributes() ?>>
<span id="el_tes_aproved_resultAmountId">
<span<?= $Page->resultAmountId->viewAttributes() ?>>
<?= $Page->resultAmountId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <tr id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_federationId"><?= $Page->federationId->caption() ?></span></td>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el_tes_aproved_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_tes_aproved_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <tr id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_testId"><?= $Page->testId->caption() ?></span></td>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_aproved_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
    <tr id="r_memberId"<?= $Page->memberId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_memberId"><?= $Page->memberId->caption() ?></span></td>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<span id="el_tes_aproved_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberName->Visible) { // memberName ?>
    <tr id="r_memberName"<?= $Page->memberName->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_memberName"><?= $Page->memberName->caption() ?></span></td>
        <td data-name="memberName"<?= $Page->memberName->cellAttributes() ?>>
<span id="el_tes_aproved_memberName">
<span<?= $Page->memberName->viewAttributes() ?>>
<?= $Page->memberName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <tr id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_createUserId"><?= $Page->createUserId->caption() ?></span></td>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_tes_aproved_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_tes_aproved_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->newRankId->Visible) { // newRankId ?>
    <tr id="r_newRankId"<?= $Page->newRankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_newRankId"><?= $Page->newRankId->caption() ?></span></td>
        <td data-name="newRankId"<?= $Page->newRankId->cellAttributes() ?>>
<span id="el_tes_aproved_newRankId">
<span<?= $Page->newRankId->viewAttributes() ?>>
<?= $Page->newRankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->oldRankId->Visible) { // oldRankId ?>
    <tr id="r_oldRankId"<?= $Page->oldRankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_aproved_oldRankId"><?= $Page->oldRankId->caption() ?></span></td>
        <td data-name="oldRankId"<?= $Page->oldRankId->cellAttributes() ?>>
<span id="el_tes_aproved_oldRankId">
<span<?= $Page->oldRankId->viewAttributes() ?>>
<?= $Page->oldRankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
