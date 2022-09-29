<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditorsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_creditors: currentTable } });
var currentForm, currentPageID;
var ffin_creditorsview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditorsview = new ew.Form("ffin_creditorsview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffin_creditorsview;
    loadjs.done("ffin_creditorsview");
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
<form name="ffin_creditorsview" id="ffin_creditorsview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_creditors">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_creditors_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->creditor->Visible) { // creditor ?>
    <tr id="r_creditor"<?= $Page->creditor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_creditor"><?= $Page->creditor->caption() ?></span></td>
        <td data-name="creditor"<?= $Page->creditor->cellAttributes() ?>>
<span id="el_fin_creditors_creditor">
<span<?= $Page->creditor->viewAttributes() ?>>
<?= $Page->creditor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uniqueCode->Visible) { // uniqueCode ?>
    <tr id="r_uniqueCode"<?= $Page->uniqueCode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_uniqueCode"><?= $Page->uniqueCode->caption() ?></span></td>
        <td data-name="uniqueCode"<?= $Page->uniqueCode->cellAttributes() ?>>
<span id="el_fin_creditors_uniqueCode">
<span<?= $Page->uniqueCode->viewAttributes() ?>>
<?= $Page->uniqueCode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IDcode->Visible) { // IDcode ?>
    <tr id="r_IDcode"<?= $Page->IDcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_IDcode"><?= $Page->IDcode->caption() ?></span></td>
        <td data-name="IDcode"<?= $Page->IDcode->cellAttributes() ?>>
<span id="el_fin_creditors_IDcode">
<span<?= $Page->IDcode->viewAttributes() ?>>
<?= $Page->IDcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->adress->Visible) { // adress ?>
    <tr id="r_adress"<?= $Page->adress->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_adress"><?= $Page->adress->caption() ?></span></td>
        <td data-name="adress"<?= $Page->adress->cellAttributes() ?>>
<span id="el_fin_creditors_adress">
<span<?= $Page->adress->viewAttributes() ?>>
<?= $Page->adress->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
    <tr id="r_number"<?= $Page->number->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_number"><?= $Page->number->caption() ?></span></td>
        <td data-name="number"<?= $Page->number->cellAttributes() ?>>
<span id="el_fin_creditors_number">
<span<?= $Page->number->viewAttributes() ?>>
<?= $Page->number->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <tr id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_neighborhood"><?= $Page->neighborhood->caption() ?></span></td>
        <td data-name="neighborhood"<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fin_creditors_neighborhood">
<span<?= $Page->neighborhood->viewAttributes() ?>>
<?= $Page->neighborhood->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <tr id="r_country"<?= $Page->country->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_country"><?= $Page->country->caption() ?></span></td>
        <td data-name="country"<?= $Page->country->cellAttributes() ?>>
<span id="el_fin_creditors_country">
<span<?= $Page->country->viewAttributes() ?>>
<?= $Page->country->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <tr id="r_state"<?= $Page->state->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_state"><?= $Page->state->caption() ?></span></td>
        <td data-name="state"<?= $Page->state->cellAttributes() ?>>
<span id="el_fin_creditors_state">
<span<?= $Page->state->viewAttributes() ?>>
<?= $Page->state->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <tr id="r_city"<?= $Page->city->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_city"><?= $Page->city->caption() ?></span></td>
        <td data-name="city"<?= $Page->city->cellAttributes() ?>>
<span id="el_fin_creditors_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telephone1->Visible) { // telephone1 ?>
    <tr id="r_telephone1"<?= $Page->telephone1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_telephone1"><?= $Page->telephone1->caption() ?></span></td>
        <td data-name="telephone1"<?= $Page->telephone1->cellAttributes() ?>>
<span id="el_fin_creditors_telephone1">
<span<?= $Page->telephone1->viewAttributes() ?>>
<?= $Page->telephone1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telephone2->Visible) { // telephone2 ?>
    <tr id="r_telephone2"<?= $Page->telephone2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_telephone2"><?= $Page->telephone2->caption() ?></span></td>
        <td data-name="telephone2"<?= $Page->telephone2->cellAttributes() ?>>
<span id="el_fin_creditors_telephone2">
<span<?= $Page->telephone2->viewAttributes() ?>>
<?= $Page->telephone2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <tr id="r_website"<?= $Page->website->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_website"><?= $Page->website->caption() ?></span></td>
        <td data-name="website"<?= $Page->website->cellAttributes() ?>>
<span id="el_fin_creditors_website">
<span<?= $Page->website->viewAttributes() ?>>
<?= $Page->website->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email1->Visible) { // email1 ?>
    <tr id="r_email1"<?= $Page->email1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_email1"><?= $Page->email1->caption() ?></span></td>
        <td data-name="email1"<?= $Page->email1->cellAttributes() ?>>
<span id="el_fin_creditors_email1">
<span<?= $Page->email1->viewAttributes() ?>>
<?= $Page->email1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email2->Visible) { // email2 ?>
    <tr id="r_email2"<?= $Page->email2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_email2"><?= $Page->email2->caption() ?></span></td>
        <td data-name="email2"<?= $Page->email2->cellAttributes() ?>>
<span id="el_fin_creditors_email2">
<span<?= $Page->email2->viewAttributes() ?>>
<?= $Page->email2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_creditors_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_register->Visible) { // register ?>
    <tr id="r__register"<?= $Page->_register->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors__register"><?= $Page->_register->caption() ?></span></td>
        <td data-name="_register"<?= $Page->_register->cellAttributes() ?>>
<span id="el_fin_creditors__register">
<span<?= $Page->_register->viewAttributes() ?>>
<?= $Page->_register->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastupdate->Visible) { // lastupdate ?>
    <tr id="r_lastupdate"<?= $Page->lastupdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_creditors_lastupdate"><?= $Page->lastupdate->caption() ?></span></td>
        <td data-name="lastupdate"<?= $Page->lastupdate->cellAttributes() ?>>
<span id="el_fin_creditors_lastupdate">
<span<?= $Page->lastupdate->viewAttributes() ?>>
<?= $Page->lastupdate->getViewValue() ?></span>
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
