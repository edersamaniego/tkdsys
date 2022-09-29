<?php

namespace PHPMaker2022\school;

// Page object
$ConfNewsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_news: currentTable } });
var currentForm, currentPageID;
var fconf_newsview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_newsview = new ew.Form("fconf_newsview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_newsview;
    loadjs.done("fconf_newsview");
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
<form name="fconf_newsview" id="fconf_newsview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_news">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_news_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_news_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <tr id="r_date"<?= $Page->date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_news_date"><?= $Page->date->caption() ?></span></td>
        <td data-name="date"<?= $Page->date->cellAttributes() ?>>
<span id="el_conf_news_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descriptionEN->Visible) { // descriptionEN ?>
    <tr id="r_descriptionEN"<?= $Page->descriptionEN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_news_descriptionEN"><?= $Page->descriptionEN->caption() ?></span></td>
        <td data-name="descriptionEN"<?= $Page->descriptionEN->cellAttributes() ?>>
<span id="el_conf_news_descriptionEN">
<span<?= $Page->descriptionEN->viewAttributes() ?>>
<?= $Page->descriptionEN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
    <tr id="r_link"<?= $Page->link->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_news_link"><?= $Page->link->caption() ?></span></td>
        <td data-name="link"<?= $Page->link->cellAttributes() ?>>
<span id="el_conf_news_link">
<span<?= $Page->link->viewAttributes() ?>>
<?= $Page->link->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descriptionBR->Visible) { // descriptionBR ?>
    <tr id="r_descriptionBR"<?= $Page->descriptionBR->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_news_descriptionBR"><?= $Page->descriptionBR->caption() ?></span></td>
        <td data-name="descriptionBR"<?= $Page->descriptionBR->cellAttributes() ?>>
<span id="el_conf_news_descriptionBR">
<span<?= $Page->descriptionBR->viewAttributes() ?>>
<?= $Page->descriptionBR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descriptionSP->Visible) { // descriptionSP ?>
    <tr id="r_descriptionSP"<?= $Page->descriptionSP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_news_descriptionSP"><?= $Page->descriptionSP->caption() ?></span></td>
        <td data-name="descriptionSP"<?= $Page->descriptionSP->cellAttributes() ?>>
<span id="el_conf_news_descriptionSP">
<span<?= $Page->descriptionSP->viewAttributes() ?>>
<?= $Page->descriptionSP->getViewValue() ?></span>
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
