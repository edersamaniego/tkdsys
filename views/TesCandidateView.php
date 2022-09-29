<?php

namespace PHPMaker2022\school;

// Page object
$TesCandidateView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_candidate: currentTable } });
var currentForm, currentPageID;
var ftes_candidateview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_candidateview = new ew.Form("ftes_candidateview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ftes_candidateview;
    loadjs.done("ftes_candidateview");
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
<form name="ftes_candidateview" id="ftes_candidateview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_candidate">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_candidate_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
    <tr id="r_memberId"<?= $Page->memberId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_memberId"><?= $Page->memberId->caption() ?></span></td>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<span id="el_tes_candidate_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
    <tr id="r_rankId"<?= $Page->rankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_rankId"><?= $Page->rankId->caption() ?></span></td>
        <td data-name="rankId"<?= $Page->rankId->cellAttributes() ?>>
<span id="el_tes_candidate_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testNominated->Visible) { // testNominated ?>
    <tr id="r_testNominated"<?= $Page->testNominated->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_testNominated"><?= $Page->testNominated->caption() ?></span></td>
        <td data-name="testNominated"<?= $Page->testNominated->cellAttributes() ?>>
<span id="el_tes_candidate_testNominated">
<span<?= $Page->testNominated->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testNominated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->testNominated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->testNominated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testNominated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testPaid->Visible) { // testPaid ?>
    <tr id="r_testPaid"<?= $Page->testPaid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_testPaid"><?= $Page->testPaid->caption() ?></span></td>
        <td data-name="testPaid"<?= $Page->testPaid->cellAttributes() ?>>
<span id="el_tes_candidate_testPaid">
<span<?= $Page->testPaid->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testPaid_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->testPaid->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->testPaid->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testPaid_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <tr id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_testId"><?= $Page->testId->caption() ?></span></td>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_candidate_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->result->Visible) { // result ?>
    <tr id="r_result"<?= $Page->result->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_result"><?= $Page->result->caption() ?></span></td>
        <td data-name="result"<?= $Page->result->cellAttributes() ?>>
<span id="el_tes_candidate_result">
<span<?= $Page->result->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_result_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->result->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->result->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_result_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nextRankId->Visible) { // nextRankId ?>
    <tr id="r_nextRankId"<?= $Page->nextRankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_nextRankId"><?= $Page->nextRankId->caption() ?></span></td>
        <td data-name="nextRankId"<?= $Page->nextRankId->cellAttributes() ?>>
<span id="el_tes_candidate_nextRankId">
<span<?= $Page->nextRankId->viewAttributes() ?>>
<?= $Page->nextRankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
    <tr id="r_memberAge"<?= $Page->memberAge->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_memberAge"><?= $Page->memberAge->caption() ?></span></td>
        <td data-name="memberAge"<?= $Page->memberAge->cellAttributes() ?>>
<span id="el_tes_candidate_memberAge">
<span<?= $Page->memberAge->viewAttributes() ?>>
<?= $Page->memberAge->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_tes_candidate_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_tes_candidate_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createUseriD->Visible) { // createUseriD ?>
    <tr id="r_createUseriD"<?= $Page->createUseriD->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_createUseriD"><?= $Page->createUseriD->caption() ?></span></td>
        <td data-name="createUseriD"<?= $Page->createUseriD->cellAttributes() ?>>
<span id="el_tes_candidate_createUseriD">
<span<?= $Page->createUseriD->viewAttributes() ?>>
<?= $Page->createUseriD->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_candidate_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_tes_candidate_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
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
