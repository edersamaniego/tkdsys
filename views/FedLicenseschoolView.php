<?php

namespace PHPMaker2022\school;

// Page object
$FedLicenseschoolView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_licenseschool: currentTable } });
var currentForm, currentPageID;
var ffed_licenseschoolview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_licenseschoolview = new ew.Form("ffed_licenseschoolview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffed_licenseschoolview;
    loadjs.done("ffed_licenseschoolview");
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
<form name="ffed_licenseschoolview" id="ffed_licenseschoolview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_licenseschool">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_licenseschool_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->application->Visible) { // application ?>
    <tr id="r_application"<?= $Page->application->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_application"><?= $Page->application->caption() ?></span></td>
        <td data-name="application"<?= $Page->application->cellAttributes() ?>>
<span id="el_fed_licenseschool_application">
<span<?= $Page->application->viewAttributes() ?>>
<?= $Page->application->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
    <tr id="r_dateLicense"<?= $Page->dateLicense->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_dateLicense"><?= $Page->dateLicense->caption() ?></span></td>
        <td data-name="dateLicense"<?= $Page->dateLicense->cellAttributes() ?>>
<span id="el_fed_licenseschool_dateLicense">
<span<?= $Page->dateLicense->viewAttributes() ?>>
<?= $Page->dateLicense->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
    <tr id="r_dateStart"<?= $Page->dateStart->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_dateStart"><?= $Page->dateStart->caption() ?></span></td>
        <td data-name="dateStart"<?= $Page->dateStart->cellAttributes() ?>>
<span id="el_fed_licenseschool_dateStart">
<span<?= $Page->dateStart->viewAttributes() ?>>
<?= $Page->dateStart->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
    <tr id="r_dateFinish"<?= $Page->dateFinish->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_dateFinish"><?= $Page->dateFinish->caption() ?></span></td>
        <td data-name="dateFinish"<?= $Page->dateFinish->cellAttributes() ?>>
<span id="el_fed_licenseschool_dateFinish">
<span<?= $Page->dateFinish->viewAttributes() ?>>
<?= $Page->dateFinish->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
    <tr id="r_schooltype"<?= $Page->schooltype->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_schooltype"><?= $Page->schooltype->caption() ?></span></td>
        <td data-name="schooltype"<?= $Page->schooltype->cellAttributes() ?>>
<span id="el_fed_licenseschool_schooltype">
<span<?= $Page->schooltype->viewAttributes() ?>>
<?= $Page->schooltype->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <tr id="r_value"<?= $Page->value->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_value"><?= $Page->value->caption() ?></span></td>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el_fed_licenseschool_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->installment->Visible) { // installment ?>
    <tr id="r_installment"<?= $Page->installment->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_installment"><?= $Page->installment->caption() ?></span></td>
        <td data-name="installment"<?= $Page->installment->cellAttributes() ?>>
<span id="el_fed_licenseschool_installment">
<span<?= $Page->installment->viewAttributes() ?>>
<?= $Page->installment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->masterSchool->Visible) { // masterSchool ?>
    <tr id="r_masterSchool"<?= $Page->masterSchool->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_masterSchool"><?= $Page->masterSchool->caption() ?></span></td>
        <td data-name="masterSchool"<?= $Page->masterSchool->cellAttributes() ?>>
<span id="el_fed_licenseschool_masterSchool">
<span<?= $Page->masterSchool->viewAttributes() ?>>
<?= $Page->masterSchool->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
    <tr id="r_school"<?= $Page->school->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_school"><?= $Page->school->caption() ?></span></td>
        <td data-name="school"<?= $Page->school->cellAttributes() ?>>
<span id="el_fed_licenseschool_school">
<span<?= $Page->school->viewAttributes() ?>>
<?= $Page->school->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fed_licenseschool__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->registerDate->Visible) { // registerDate ?>
    <tr id="r_registerDate"<?= $Page->registerDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_registerDate"><?= $Page->registerDate->caption() ?></span></td>
        <td data-name="registerDate"<?= $Page->registerDate->cellAttributes() ?>>
<span id="el_fed_licenseschool_registerDate">
<span<?= $Page->registerDate->viewAttributes() ?>>
<?= $Page->registerDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_licenseschool_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_fed_licenseschool_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
