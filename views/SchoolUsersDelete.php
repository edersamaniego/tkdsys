<?php

namespace PHPMaker2022\school;

// Page object
$SchoolUsersDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_users: currentTable } });
var currentForm, currentPageID;
var fschool_usersdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_usersdelete = new ew.Form("fschool_usersdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fschool_usersdelete;
    loadjs.done("fschool_usersdelete");
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
<form name="fschool_usersdelete" id="fschool_usersdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_users">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_school_users_id" class="school_users_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_school_users_name" class="school_users_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <th class="<?= $Page->lastName->headerCellClass() ?>"><span id="elh_school_users_lastName" class="school_users_lastName"><?= $Page->lastName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolIdMaster->Visible) { // schoolIdMaster ?>
        <th class="<?= $Page->schoolIdMaster->headerCellClass() ?>"><span id="elh_school_users_schoolIdMaster" class="school_users_schoolIdMaster"><?= $Page->schoolIdMaster->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_school_users_schoolId" class="school_users_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
        <th class="<?= $Page->_login->headerCellClass() ?>"><span id="elh_school_users__login" class="school_users__login"><?= $Page->_login->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_school_users__email" class="school_users__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activateEmail->Visible) { // activateEmail ?>
        <th class="<?= $Page->activateEmail->headerCellClass() ?>"><span id="elh_school_users_activateEmail" class="school_users_activateEmail"><?= $Page->activateEmail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><span id="elh_school_users__password" class="school_users__password"><?= $Page->_password->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><span id="elh_school_users_createUserId" class="school_users_createUserId"><?= $Page->createUserId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_school_users_createDate" class="school_users_createDate"><?= $Page->createDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
        <th class="<?= $Page->level->headerCellClass() ?>"><span id="elh_school_users_level" class="school_users_level"><?= $Page->level->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_school_users_id" class="el_school_users_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_name" class="el_school_users_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <td<?= $Page->lastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_lastName" class="el_school_users_lastName">
<span<?= $Page->lastName->viewAttributes() ?>>
<?= $Page->lastName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolIdMaster->Visible) { // schoolIdMaster ?>
        <td<?= $Page->schoolIdMaster->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
<span<?= $Page->schoolIdMaster->viewAttributes() ?>>
<?= $Page->schoolIdMaster->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_schoolId" class="el_school_users_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
        <td<?= $Page->_login->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users__login" class="el_school_users__login">
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users__email" class="el_school_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->activateEmail->Visible) { // activateEmail ?>
        <td<?= $Page->activateEmail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_activateEmail" class="el_school_users_activateEmail">
<span<?= $Page->activateEmail->viewAttributes() ?>>
<?= $Page->activateEmail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <td<?= $Page->_password->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users__password" class="el_school_users__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_createUserId" class="el_school_users_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_createDate" class="el_school_users_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
        <td<?= $Page->level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_users_level" class="el_school_users_level">
<span<?= $Page->level->viewAttributes() ?>>
<?= $Page->level->getViewValue() ?></span>
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
