<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountspayableView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountspayable: currentTable } });
var currentForm, currentPageID;
var ffin_accountspayableview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountspayableview = new ew.Form("ffin_accountspayableview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffin_accountspayableview;
    loadjs.done("ffin_accountspayableview");
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
<form name="ffin_accountspayableview" id="ffin_accountspayableview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountspayable">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_FinAccountspayableView"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_fin_accountspayable1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fin_accountspayable1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_fin_accountspayable2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fin_accountspayable2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_fin_accountspayable4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fin_accountspayable4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_fin_accountspayable1" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_accountspayable_id" data-page="1">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->departamentId->Visible) { // departamentId ?>
    <tr id="r_departamentId"<?= $Page->departamentId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_departamentId"><?= $Page->departamentId->caption() ?></span></td>
        <td data-name="departamentId"<?= $Page->departamentId->cellAttributes() ?>>
<span id="el_fin_accountspayable_departamentId" data-page="1">
<span<?= $Page->departamentId->viewAttributes() ?>>
<?= $Page->departamentId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->costCenterId->Visible) { // costCenterId ?>
    <tr id="r_costCenterId"<?= $Page->costCenterId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_costCenterId"><?= $Page->costCenterId->caption() ?></span></td>
        <td data-name="costCenterId"<?= $Page->costCenterId->cellAttributes() ?>>
<span id="el_fin_accountspayable_costCenterId" data-page="1">
<span<?= $Page->costCenterId->viewAttributes() ?>>
<?= $Page->costCenterId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
    <tr id="r_historic"<?= $Page->historic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_historic"><?= $Page->historic->caption() ?></span></td>
        <td data-name="historic"<?= $Page->historic->cellAttributes() ?>>
<span id="el_fin_accountspayable_historic" data-page="1">
<span<?= $Page->historic->viewAttributes() ?>>
<?= $Page->historic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
    <tr id="r_issue"<?= $Page->issue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_issue"><?= $Page->issue->caption() ?></span></td>
        <td data-name="issue"<?= $Page->issue->cellAttributes() ?>>
<span id="el_fin_accountspayable_issue" data-page="1">
<span<?= $Page->issue->viewAttributes() ?>>
<?= $Page->issue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
    <tr id="r_due"<?= $Page->due->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_due"><?= $Page->due->caption() ?></span></td>
        <td data-name="due"<?= $Page->due->cellAttributes() ?>>
<span id="el_fin_accountspayable_due" data-page="1">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <tr id="r_value"<?= $Page->value->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_value"><?= $Page->value->caption() ?></span></td>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_accountspayable_value" data-page="1">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->employeeId->Visible) { // employeeId ?>
    <tr id="r_employeeId"<?= $Page->employeeId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_employeeId"><?= $Page->employeeId->caption() ?></span></td>
        <td data-name="employeeId"<?= $Page->employeeId->cellAttributes() ?>>
<span id="el_fin_accountspayable_employeeId" data-page="1">
<span<?= $Page->employeeId->viewAttributes() ?>>
<?= $Page->employeeId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_fin_accountspayable_status" data-page="1">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amountPaid->Visible) { // amountPaid ?>
    <tr id="r_amountPaid"<?= $Page->amountPaid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_amountPaid"><?= $Page->amountPaid->caption() ?></span></td>
        <td data-name="amountPaid"<?= $Page->amountPaid->cellAttributes() ?>>
<span id="el_fin_accountspayable_amountPaid" data-page="1">
<span<?= $Page->amountPaid->viewAttributes() ?>>
<?= $Page->amountPaid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->creditorsId->Visible) { // creditorsId ?>
    <tr id="r_creditorsId"<?= $Page->creditorsId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_creditorsId"><?= $Page->creditorsId->caption() ?></span></td>
        <td data-name="creditorsId"<?= $Page->creditorsId->cellAttributes() ?>>
<span id="el_fin_accountspayable_creditorsId" data-page="1">
<span<?= $Page->creditorsId->viewAttributes() ?>>
<?= $Page->creditorsId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
    <tr id="r_typeId"<?= $Page->typeId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_typeId"><?= $Page->typeId->caption() ?></span></td>
        <td data-name="typeId"<?= $Page->typeId->cellAttributes() ?>>
<span id="el_fin_accountspayable_typeId" data-page="1">
<span<?= $Page->typeId->viewAttributes() ?>>
<?= $Page->typeId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_accountspayable_obs" data-page="1">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountFather->Visible) { // accountFather ?>
    <tr id="r_accountFather"<?= $Page->accountFather->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_accountFather"><?= $Page->accountFather->caption() ?></span></td>
        <td data-name="accountFather"<?= $Page->accountFather->cellAttributes() ?>>
<span id="el_fin_accountspayable_accountFather" data-page="1">
<span<?= $Page->accountFather->viewAttributes() ?>>
<?= $Page->accountFather->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
    <tr id="r_licenseId"<?= $Page->licenseId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_licenseId"><?= $Page->licenseId->caption() ?></span></td>
        <td data-name="licenseId"<?= $Page->licenseId->cellAttributes() ?>>
<span id="el_fin_accountspayable_licenseId" data-page="1">
<span<?= $Page->licenseId->viewAttributes() ?>>
<?= $Page->licenseId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_fin_accountspayable2" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->invoiceFile->Visible) { // invoiceFile ?>
    <tr id="r_invoiceFile"<?= $Page->invoiceFile->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_invoiceFile"><?= $Page->invoiceFile->caption() ?></span></td>
        <td data-name="invoiceFile"<?= $Page->invoiceFile->cellAttributes() ?>>
<span id="el_fin_accountspayable_invoiceFile" data-page="2">
<span<?= $Page->invoiceFile->viewAttributes() ?>>
<?= GetFileViewTag($Page->invoiceFile, $Page->invoiceFile->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->guaranteeFile->Visible) { // guaranteeFile ?>
    <tr id="r_guaranteeFile"<?= $Page->guaranteeFile->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_guaranteeFile"><?= $Page->guaranteeFile->caption() ?></span></td>
        <td data-name="guaranteeFile"<?= $Page->guaranteeFile->cellAttributes() ?>>
<span id="el_fin_accountspayable_guaranteeFile" data-page="2">
<span<?= $Page->guaranteeFile->viewAttributes() ?>>
<?= GetFileViewTag($Page->guaranteeFile, $Page->guaranteeFile->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->attachedFile->Visible) { // attachedFile ?>
    <tr id="r_attachedFile"<?= $Page->attachedFile->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_attachedFile"><?= $Page->attachedFile->caption() ?></span></td>
        <td data-name="attachedFile"<?= $Page->attachedFile->cellAttributes() ?>>
<span id="el_fin_accountspayable_attachedFile" data-page="2">
<span<?= $Page->attachedFile->viewAttributes() ?>>
<?= GetFileViewTag($Page->attachedFile, $Page->attachedFile->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_fin_accountspayable3" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_fin_accountspayable4" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fin_accountspayable__userId" data-page="4">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_fin_accountspayable_schoolId" data-page="4">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUserId->Visible) { // lastUserId ?>
    <tr id="r_lastUserId"<?= $Page->lastUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_lastUserId"><?= $Page->lastUserId->caption() ?></span></td>
        <td data-name="lastUserId"<?= $Page->lastUserId->cellAttributes() ?>>
<span id="el_fin_accountspayable_lastUserId" data-page="4">
<span<?= $Page->lastUserId->viewAttributes() ?>>
<?= $Page->lastUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->registerDate->Visible) { // registerDate ?>
    <tr id="r_registerDate"<?= $Page->registerDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_registerDate"><?= $Page->registerDate->caption() ?></span></td>
        <td data-name="registerDate"<?= $Page->registerDate->cellAttributes() ?>>
<span id="el_fin_accountspayable_registerDate" data-page="4">
<span<?= $Page->registerDate->viewAttributes() ?>>
<?= $Page->registerDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
    <tr id="r_lastUpdate"<?= $Page->lastUpdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_lastUpdate"><?= $Page->lastUpdate->caption() ?></span></td>
        <td data-name="lastUpdate"<?= $Page->lastUpdate->cellAttributes() ?>>
<span id="el_fin_accountspayable_lastUpdate" data-page="4">
<span<?= $Page->lastUpdate->viewAttributes() ?>>
<?= $Page->lastUpdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->incomeReceivable->Visible) { // incomeReceivable ?>
    <tr id="r_incomeReceivable"<?= $Page->incomeReceivable->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountspayable_incomeReceivable"><?= $Page->incomeReceivable->caption() ?></span></td>
        <td data-name="incomeReceivable"<?= $Page->incomeReceivable->cellAttributes() ?>>
<span id="el_fin_accountspayable_incomeReceivable" data-page="4">
<span<?= $Page->incomeReceivable->viewAttributes() ?>>
<?= $Page->incomeReceivable->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
    </div>
</div>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<?php
    if (in_array("fin_debit", explode(",", $Page->getCurrentDetailTable())) && $fin_debit->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_debit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinDebitGrid.php" ?>
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
