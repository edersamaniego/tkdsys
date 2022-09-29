<?php

namespace PHPMaker2022\school;

// Page object
$SchoolModalityView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_modality: currentTable } });
var currentForm, currentPageID;
var fschool_modalityview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_modalityview = new ew.Form("fschool_modalityview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fschool_modalityview;
    loadjs.done("fschool_modalityview");
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
<form name="fschool_modalityview" id="fschool_modalityview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_modality">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_modality_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_school_modality_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_modality_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_school_modality_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
    <tr id="r_martialArtId"<?= $Page->martialArtId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_modality_martialArtId"><?= $Page->martialArtId->caption() ?></span></td>
        <td data-name="martialArtId"<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el_school_modality_martialArtId">
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nameBR->Visible) { // nameBR ?>
    <tr id="r_nameBR"<?= $Page->nameBR->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_modality_nameBR"><?= $Page->nameBR->caption() ?></span></td>
        <td data-name="nameBR"<?= $Page->nameBR->cellAttributes() ?>>
<span id="el_school_modality_nameBR">
<span<?= $Page->nameBR->viewAttributes() ?>>
<?= $Page->nameBR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nameES->Visible) { // nameES ?>
    <tr id="r_nameES"<?= $Page->nameES->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_modality_nameES"><?= $Page->nameES->caption() ?></span></td>
        <td data-name="nameES"<?= $Page->nameES->cellAttributes() ?>>
<span id="el_school_modality_nameES">
<span<?= $Page->nameES->viewAttributes() ?>>
<?= $Page->nameES->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nameEN->Visible) { // nameEN ?>
    <tr id="r_nameEN"<?= $Page->nameEN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_modality_nameEN"><?= $Page->nameEN->caption() ?></span></td>
        <td data-name="nameEN"<?= $Page->nameEN->cellAttributes() ?>>
<span id="el_school_modality_nameEN">
<span<?= $Page->nameEN->viewAttributes() ?>>
<?= $Page->nameEN->getViewValue() ?></span>
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
