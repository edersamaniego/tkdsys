<?php

namespace PHPMaker2022\school;

// Page object
$FinEmployeeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_employee: currentTable } });
var currentForm, currentPageID;
var ffin_employeeview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_employeeview = new ew.Form("ffin_employeeview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffin_employeeview;
    loadjs.done("ffin_employeeview");
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
<form name="ffin_employeeview" id="ffin_employeeview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_employee">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_employee_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uniqueId->Visible) { // uniqueId ?>
    <tr id="r_uniqueId"<?= $Page->uniqueId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_uniqueId"><?= $Page->uniqueId->caption() ?></span></td>
        <td data-name="uniqueId"<?= $Page->uniqueId->cellAttributes() ?>>
<span id="el_fin_employee_uniqueId">
<span<?= $Page->uniqueId->viewAttributes() ?>>
<?= $Page->uniqueId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name"<?= $Page->name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el_fin_employee_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
    <tr id="r_middlename"<?= $Page->middlename->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_middlename"><?= $Page->middlename->caption() ?></span></td>
        <td data-name="middlename"<?= $Page->middlename->cellAttributes() ?>>
<span id="el_fin_employee_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <tr id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_lastname"><?= $Page->lastname->caption() ?></span></td>
        <td data-name="lastname"<?= $Page->lastname->cellAttributes() ?>>
<span id="el_fin_employee_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <tr id="r_country"<?= $Page->country->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_country"><?= $Page->country->caption() ?></span></td>
        <td data-name="country"<?= $Page->country->cellAttributes() ?>>
<span id="el_fin_employee_country">
<span<?= $Page->country->viewAttributes() ?>>
<?= $Page->country->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <tr id="r_state"<?= $Page->state->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_state"><?= $Page->state->caption() ?></span></td>
        <td data-name="state"<?= $Page->state->cellAttributes() ?>>
<span id="el_fin_employee_state">
<span<?= $Page->state->viewAttributes() ?>>
<?= $Page->state->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <tr id="r_city"<?= $Page->city->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_city"><?= $Page->city->caption() ?></span></td>
        <td data-name="city"<?= $Page->city->cellAttributes() ?>>
<span id="el_fin_employee_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <tr id="r_address"<?= $Page->address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_address"><?= $Page->address->caption() ?></span></td>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el_fin_employee_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <tr id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_neighborhood"><?= $Page->neighborhood->caption() ?></span></td>
        <td data-name="neighborhood"<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fin_employee_neighborhood">
<span<?= $Page->neighborhood->viewAttributes() ?>>
<?= $Page->neighborhood->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
    <tr id="r_zipcode"<?= $Page->zipcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_zipcode"><?= $Page->zipcode->caption() ?></span></td>
        <td data-name="zipcode"<?= $Page->zipcode->cellAttributes() ?>>
<span id="el_fin_employee_zipcode">
<span<?= $Page->zipcode->viewAttributes() ?>>
<?= $Page->zipcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_register->Visible) { // register ?>
    <tr id="r__register"<?= $Page->_register->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee__register"><?= $Page->_register->caption() ?></span></td>
        <td data-name="_register"<?= $Page->_register->cellAttributes() ?>>
<span id="el_fin_employee__register">
<span<?= $Page->_register->viewAttributes() ?>>
<?= $Page->_register->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_fin_employee_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
    <tr id="r_lastUpdate"<?= $Page->lastUpdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_lastUpdate"><?= $Page->lastUpdate->caption() ?></span></td>
        <td data-name="lastUpdate"<?= $Page->lastUpdate->cellAttributes() ?>>
<span id="el_fin_employee_lastUpdate">
<span<?= $Page->lastUpdate->viewAttributes() ?>>
<?= $Page->lastUpdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_fin_employee_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <tr id="r_masterSchoolId"<?= $Page->masterSchoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_employee_masterSchoolId"><?= $Page->masterSchoolId->caption() ?></span></td>
        <td data-name="masterSchoolId"<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el_fin_employee_masterSchoolId">
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
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
