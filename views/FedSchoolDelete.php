<?php

namespace PHPMaker2022\school;

// Page object
$FedSchoolDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_school: currentTable } });
var currentForm, currentPageID;
var ffed_schooldelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_schooldelete = new ew.Form("ffed_schooldelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_schooldelete;
    loadjs.done("ffed_schooldelete");
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
<form name="ffed_schooldelete" id="ffed_schooldelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_school">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_school_id" class="fed_school_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
        <th class="<?= $Page->masterSchoolId->headerCellClass() ?>"><span id="elh_fed_school_masterSchoolId" class="fed_school_masterSchoolId"><?= $Page->masterSchoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
        <th class="<?= $Page->school->headerCellClass() ?>"><span id="elh_fed_school_school" class="fed_school_school"><?= $Page->school->caption() ?></span></th>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <th class="<?= $Page->countryId->headerCellClass() ?>"><span id="elh_fed_school_countryId" class="fed_school_countryId"><?= $Page->countryId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <th class="<?= $Page->cityId->headerCellClass() ?>"><span id="elh_fed_school_cityId" class="fed_school_cityId"><?= $Page->cityId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
        <th class="<?= $Page->owner->headerCellClass() ?>"><span id="elh_fed_school_owner" class="fed_school_owner"><?= $Page->owner->caption() ?></span></th>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
        <th class="<?= $Page->applicationId->headerCellClass() ?>"><span id="elh_fed_school_applicationId" class="fed_school_applicationId"><?= $Page->applicationId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
        <th class="<?= $Page->isheadquarter->headerCellClass() ?>"><span id="elh_fed_school_isheadquarter" class="fed_school_isheadquarter"><?= $Page->isheadquarter->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_school_id" class="el_fed_school_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
        <td<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
        <td<?= $Page->school->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_school" class="el_fed_school_school">
<span<?= $Page->school->viewAttributes() ?>>
<?= $Page->school->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <td<?= $Page->countryId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_countryId" class="el_fed_school_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <td<?= $Page->cityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_cityId" class="el_fed_school_cityId">
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
        <td<?= $Page->owner->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_owner" class="el_fed_school_owner">
<span<?= $Page->owner->viewAttributes() ?>>
<?= $Page->owner->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
        <td<?= $Page->applicationId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_applicationId" class="el_fed_school_applicationId">
<span<?= $Page->applicationId->viewAttributes() ?>>
<?= $Page->applicationId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
        <td<?= $Page->isheadquarter->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<span<?= $Page->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isheadquarter->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Page->RowCount ?>"></label>
</div></span>
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
