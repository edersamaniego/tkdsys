<?php

namespace PHPMaker2022\school;

// Page object
$TesTestView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test: currentTable } });
var currentForm, currentPageID;
var ftes_testview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_testview = new ew.Form("ftes_testview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ftes_testview;
    loadjs.done("ftes_testview");
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
<form name="ftes_testview" id="ftes_testview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_test_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_tes_test_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testCity->Visible) { // testCity ?>
    <tr id="r_testCity"<?= $Page->testCity->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_testCity"><?= $Page->testCity->caption() ?></span></td>
        <td data-name="testCity"<?= $Page->testCity->cellAttributes() ?>>
<span id="el_tes_test_testCity">
<span<?= $Page->testCity->viewAttributes() ?>>
<?= $Page->testCity->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <tr id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_federationId"><?= $Page->federationId->caption() ?></span></td>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el_tes_test_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->martialartsId->Visible) { // martialartsId ?>
    <tr id="r_martialartsId"<?= $Page->martialartsId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_martialartsId"><?= $Page->martialartsId->caption() ?></span></td>
        <td data-name="martialartsId"<?= $Page->martialartsId->cellAttributes() ?>>
<span id="el_tes_test_martialartsId">
<span<?= $Page->martialartsId->viewAttributes() ?>>
<?= $Page->martialartsId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_tes_test_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorId->Visible) { // instructorId ?>
    <tr id="r_instructorId"<?= $Page->instructorId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_instructorId"><?= $Page->instructorId->caption() ?></span></td>
        <td data-name="instructorId"<?= $Page->instructorId->cellAttributes() ?>>
<span id="el_tes_test_instructorId">
<span<?= $Page->instructorId->viewAttributes() ?>>
<?= $Page->instructorId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->auxiliarInstructorId->Visible) { // auxiliarInstructorId ?>
    <tr id="r_auxiliarInstructorId"<?= $Page->auxiliarInstructorId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_auxiliarInstructorId"><?= $Page->auxiliarInstructorId->caption() ?></span></td>
        <td data-name="auxiliarInstructorId"<?= $Page->auxiliarInstructorId->cellAttributes() ?>>
<span id="el_tes_test_auxiliarInstructorId">
<span<?= $Page->auxiliarInstructorId->viewAttributes() ?>>
<?= $Page->auxiliarInstructorId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
    <tr id="r_testDate"<?= $Page->testDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_testDate"><?= $Page->testDate->caption() ?></span></td>
        <td data-name="testDate"<?= $Page->testDate->cellAttributes() ?>>
<span id="el_tes_test_testDate">
<span<?= $Page->testDate->viewAttributes() ?>>
<?= $Page->testDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testTime->Visible) { // testTime ?>
    <tr id="r_testTime"<?= $Page->testTime->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_testTime"><?= $Page->testTime->caption() ?></span></td>
        <td data-name="testTime"<?= $Page->testTime->cellAttributes() ?>>
<span id="el_tes_test_testTime">
<span<?= $Page->testTime->viewAttributes() ?>>
<?= $Page->testTime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
    <tr id="r_ceremonyDate"<?= $Page->ceremonyDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_ceremonyDate"><?= $Page->ceremonyDate->caption() ?></span></td>
        <td data-name="ceremonyDate"<?= $Page->ceremonyDate->cellAttributes() ?>>
<span id="el_tes_test_ceremonyDate">
<span<?= $Page->ceremonyDate->viewAttributes() ?>>
<?= $Page->ceremonyDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testTypeId->Visible) { // testTypeId ?>
    <tr id="r_testTypeId"<?= $Page->testTypeId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_testTypeId"><?= $Page->testTypeId->caption() ?></span></td>
        <td data-name="testTypeId"<?= $Page->testTypeId->cellAttributes() ?>>
<span id="el_tes_test_testTypeId">
<span<?= $Page->testTypeId->viewAttributes() ?>>
<?= $Page->testTypeId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testStatusId->Visible) { // testStatusId ?>
    <tr id="r_testStatusId"<?= $Page->testStatusId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_testStatusId"><?= $Page->testStatusId->caption() ?></span></td>
        <td data-name="testStatusId"<?= $Page->testStatusId->cellAttributes() ?>>
<span id="el_tes_test_testStatusId">
<span<?= $Page->testStatusId->viewAttributes() ?>>
<?= $Page->testStatusId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <tr id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_createUserId"><?= $Page->createUserId->caption() ?></span></td>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_tes_test_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_tes_test_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->judgeId->Visible) { // judgeId ?>
    <tr id="r_judgeId"<?= $Page->judgeId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judgeId"><?= $Page->judgeId->caption() ?></span></td>
        <td data-name="judgeId"<?= $Page->judgeId->cellAttributes() ?>>
<span id="el_tes_test_judgeId">
<span<?= $Page->judgeId->viewAttributes() ?>>
<?= $Page->judgeId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->certificateId->Visible) { // certificateId ?>
    <tr id="r_certificateId"<?= $Page->certificateId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_certificateId"><?= $Page->certificateId->caption() ?></span></td>
        <td data-name="certificateId"<?= $Page->certificateId->cellAttributes() ?>>
<span id="el_tes_test_certificateId">
<span<?= $Page->certificateId->viewAttributes() ?>>
<?= $Page->certificateId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav<?= $Page->DetailPages->containerClasses() ?>" id="details_Page"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navClasses() ?>" role="tablist"><!-- .nav -->
<?php
    if (in_array("tes_candidate", explode(",", $Page->getCurrentDetailTable())) && $tes_candidate->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("tes_candidate") ?><?= $Page->DetailPages->activeClasses("tes_candidate") ?>" data-bs-target="#tab_tes_candidate" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_tes_candidate" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("tes_candidate")) ?>"><?= $Language->tablePhrase("tes_candidate", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("tes_candidate")->Count, $Language->phrase("DetailCount")) ?></button></li>
<?php
    }
?>
<?php
    if (in_array("view_test_aproveds", explode(",", $Page->getCurrentDetailTable())) && $view_test_aproveds->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("view_test_aproveds") ?><?= $Page->DetailPages->activeClasses("view_test_aproveds") ?>" data-bs-target="#tab_view_test_aproveds" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_view_test_aproveds" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("view_test_aproveds")) ?>"><?= $Language->tablePhrase("view_test_aproveds", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("view_test_aproveds")->Count, $Language->phrase("DetailCount")) ?></button></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="<?= $Page->DetailPages->tabContentClasses() ?>"><!-- .tab-content -->
<?php
    if (in_array("tes_candidate", explode(",", $Page->getCurrentDetailTable())) && $tes_candidate->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("tes_candidate") ?><?= $Page->DetailPages->activeClasses("tes_candidate") ?>" id="tab_tes_candidate" role="tabpanel"><!-- page* -->
<?php include_once "TesCandidateGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("view_test_aproveds", explode(",", $Page->getCurrentDetailTable())) && $view_test_aproveds->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("view_test_aproveds") ?><?= $Page->DetailPages->activeClasses("view_test_aproveds") ?>" id="tab_view_test_aproveds" role="tabpanel"><!-- page* -->
<?php include_once "ViewTestAprovedsGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
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
