<?php

namespace PHPMaker2022\school;

// Page object
$FedVideoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_video: currentTable } });
var currentForm, currentPageID;
var ffed_videoview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videoview = new ew.Form("ffed_videoview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffed_videoview;
    loadjs.done("ffed_videoview");
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
<form name="ffed_videoview" id="ffed_videoview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_video">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->_title->Visible) { // title ?>
    <tr id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_video__title"><?= $Page->_title->caption() ?></span></td>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el_fed_video__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->URL->Visible) { // URL ?>
    <tr id="r_URL"<?= $Page->URL->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_video_URL"><?= $Page->URL->caption() ?></span></td>
        <td data-name="URL"<?= $Page->URL->cellAttributes() ?>>
<span id="el_fed_video_URL">
<span><iframe src="https://player.vimeo.com/video/<?= CurrentPage()->URL->CurrentValue ?>" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_video_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_fed_video_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->section->Visible) { // section ?>
    <tr id="r_section"<?= $Page->section->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_video_section"><?= $Page->section->caption() ?></span></td>
        <td data-name="section"<?= $Page->section->cellAttributes() ?>>
<span id="el_fed_video_section">
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
    <tr id="r_subsection"<?= $Page->subsection->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_video_subsection"><?= $Page->subsection->caption() ?></span></td>
        <td data-name="subsection"<?= $Page->subsection->cellAttributes() ?>>
<span id="el_fed_video_subsection">
<span<?= $Page->subsection->viewAttributes() ?>>
<?= $Page->subsection->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_video_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_video_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
