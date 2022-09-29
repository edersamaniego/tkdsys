<?php

namespace PHPMaker2022\school;

// Page object
$SchoolClassView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_class: currentTable } });
var currentForm, currentPageID;
var fschool_classview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_classview = new ew.Form("fschool_classview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fschool_classview;
    loadjs.done("fschool_classview");
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
<form name="fschool_classview" id="fschool_classview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_class">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_school_class_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_school_class_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->daysByWeek->Visible) { // daysByWeek ?>
    <tr id="r_daysByWeek"<?= $Page->daysByWeek->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_daysByWeek"><?= $Page->daysByWeek->caption() ?></span></td>
        <td data-name="daysByWeek"<?= $Page->daysByWeek->cellAttributes() ?>>
<span id="el_school_class_daysByWeek">
<span<?= $Page->daysByWeek->viewAttributes() ?>>
<?= $Page->daysByWeek->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->beginnigTime->Visible) { // beginnigTime ?>
    <tr id="r_beginnigTime"<?= $Page->beginnigTime->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_beginnigTime"><?= $Page->beginnigTime->caption() ?></span></td>
        <td data-name="beginnigTime"<?= $Page->beginnigTime->cellAttributes() ?>>
<span id="el_school_class_beginnigTime">
<span<?= $Page->beginnigTime->viewAttributes() ?>>
<?= $Page->beginnigTime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->endingTime->Visible) { // endingTime ?>
    <tr id="r_endingTime"<?= $Page->endingTime->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_endingTime"><?= $Page->endingTime->caption() ?></span></td>
        <td data-name="endingTime"<?= $Page->endingTime->cellAttributes() ?>>
<span id="el_school_class_endingTime">
<span<?= $Page->endingTime->viewAttributes() ?>>
<?= $Page->endingTime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_school_class_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->limit->Visible) { // limit ?>
    <tr id="r_limit"<?= $Page->limit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_limit"><?= $Page->limit->caption() ?></span></td>
        <td data-name="limit"<?= $Page->limit->cellAttributes() ?>>
<span id="el_school_class_limit">
<span<?= $Page->limit->viewAttributes() ?>>
<?= $Page->limit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
    <tr id="r_modalityId"<?= $Page->modalityId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_class_modalityId"><?= $Page->modalityId->caption() ?></span></td>
        <td data-name="modalityId"<?= $Page->modalityId->cellAttributes() ?>>
<span id="el_school_class_modalityId">
<span<?= $Page->modalityId->viewAttributes() ?>>
<?= $Page->modalityId->getViewValue() ?></span>
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
