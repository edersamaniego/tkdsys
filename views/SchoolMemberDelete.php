<?php

namespace PHPMaker2022\school;

// Page object
$SchoolMemberDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_member: currentTable } });
var currentForm, currentPageID;
var fschool_memberdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_memberdelete = new ew.Form("fschool_memberdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fschool_memberdelete;
    loadjs.done("fschool_memberdelete");
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
<form name="fschool_memberdelete" id="fschool_memberdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_member">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_school_member_id" class="school_member_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_school_member_name" class="school_member_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <th class="<?= $Page->lastName->headerCellClass() ?>"><span id="elh_school_member_lastName" class="school_member_lastName"><?= $Page->lastName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <th class="<?= $Page->martialArtId->headerCellClass() ?>"><span id="elh_school_member_martialArtId" class="school_member_martialArtId"><?= $Page->martialArtId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <th class="<?= $Page->rankId->headerCellClass() ?>"><span id="elh_school_member_rankId" class="school_member_rankId"><?= $Page->rankId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <th class="<?= $Page->photo->headerCellClass() ?>"><span id="elh_school_member_photo" class="school_member_photo"><?= $Page->photo->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_school_member_id" class="el_school_member_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_member_name" class="el_school_member_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <td<?= $Page->lastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_member_lastName" class="el_school_member_lastName">
<span<?= $Page->lastName->viewAttributes() ?>>
<?= $Page->lastName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <td<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_member_martialArtId" class="el_school_member_martialArtId">
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <td<?= $Page->rankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_member_rankId" class="el_school_member_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <td<?= $Page->photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_member_photo" class="el_school_member_photo">
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
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
