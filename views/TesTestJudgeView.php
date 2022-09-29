<?php

namespace PHPMaker2022\school;

// Page object
$TesTestJudgeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test_judge: currentTable } });
var currentForm, currentPageID;
var ftes_test_judgeview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_test_judgeview = new ew.Form("ftes_test_judgeview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ftes_test_judgeview;
    loadjs.done("ftes_test_judgeview");
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
<form name="ftes_test_judgeview" id="ftes_test_judgeview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test_judge">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_test_judge_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->judgeMemberId->Visible) { // judgeMemberId ?>
    <tr id="r_judgeMemberId"<?= $Page->judgeMemberId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_judgeMemberId"><?= $Page->judgeMemberId->caption() ?></span></td>
        <td data-name="judgeMemberId"<?= $Page->judgeMemberId->cellAttributes() ?>>
<span id="el_tes_test_judge_judgeMemberId">
<span<?= $Page->judgeMemberId->viewAttributes() ?>>
<?= $Page->judgeMemberId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <tr id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_testId"><?= $Page->testId->caption() ?></span></td>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_test_judge_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
    <tr id="r_rankId"<?= $Page->rankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_rankId"><?= $Page->rankId->caption() ?></span></td>
        <td data-name="rankId"<?= $Page->rankId->cellAttributes() ?>>
<span id="el_tes_test_judge_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorRegister->Visible) { // instructorRegister ?>
    <tr id="r_instructorRegister"<?= $Page->instructorRegister->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_instructorRegister"><?= $Page->instructorRegister->caption() ?></span></td>
        <td data-name="instructorRegister"<?= $Page->instructorRegister->cellAttributes() ?>>
<span id="el_tes_test_judge_instructorRegister">
<span<?= $Page->instructorRegister->viewAttributes() ?>>
<?= $Page->instructorRegister->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
    <tr id="r_federationRegister"<?= $Page->federationRegister->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_federationRegister"><?= $Page->federationRegister->caption() ?></span></td>
        <td data-name="federationRegister"<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el_tes_test_judge_federationRegister">
<span<?= $Page->federationRegister->viewAttributes() ?>>
<?= $Page->federationRegister->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberCityId->Visible) { // memberCityId ?>
    <tr id="r_memberCityId"<?= $Page->memberCityId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_test_judge_memberCityId"><?= $Page->memberCityId->caption() ?></span></td>
        <td data-name="memberCityId"<?= $Page->memberCityId->cellAttributes() ?>>
<span id="el_tes_test_judge_memberCityId">
<span<?= $Page->memberCityId->viewAttributes() ?>>
<?= $Page->memberCityId->getViewValue() ?></span>
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
