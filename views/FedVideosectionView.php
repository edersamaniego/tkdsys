<?php

namespace PHPMaker2022\school;

// Page object
$FedVideosectionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_videosection: currentTable } });
var currentForm, currentPageID;
var ffed_videosectionview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videosectionview = new ew.Form("ffed_videosectionview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffed_videosectionview;
    loadjs.done("ffed_videosectionview");
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
<form name="ffed_videosectionview" id="ffed_videosectionview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_videosection">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_videosection_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_videosection_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->section->Visible) { // section ?>
    <tr id="r_section"<?= $Page->section->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_videosection_section"><?= $Page->section->caption() ?></span></td>
        <td data-name="section"<?= $Page->section->cellAttributes() ?>>
<span id="el_fed_videosection_section">
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sectionBr->Visible) { // sectionBr ?>
    <tr id="r_sectionBr"<?= $Page->sectionBr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_videosection_sectionBr"><?= $Page->sectionBr->caption() ?></span></td>
        <td data-name="sectionBr"<?= $Page->sectionBr->cellAttributes() ?>>
<span id="el_fed_videosection_sectionBr">
<span<?= $Page->sectionBr->viewAttributes() ?>>
<?= $Page->sectionBr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sectionSp->Visible) { // sectionSp ?>
    <tr id="r_sectionSp"<?= $Page->sectionSp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_videosection_sectionSp"><?= $Page->sectionSp->caption() ?></span></td>
        <td data-name="sectionSp"<?= $Page->sectionSp->cellAttributes() ?>>
<span id="el_fed_videosection_sectionSp">
<span<?= $Page->sectionSp->viewAttributes() ?>>
<?= $Page->sectionSp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_videosection__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fed_videosection__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_videosection_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_videosection_createDate">
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
<?php
    if (in_array("fed_videosubsection", explode(",", $Page->getCurrentDetailTable())) && $fed_videosubsection->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fed_videosubsection", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FedVideosubsectionGrid.php" ?>
<?php } ?>
<?php
    if (in_array("fed_video", explode(",", $Page->getCurrentDetailTable())) && $fed_video->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fed_video", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FedVideoGrid.php" ?>
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
