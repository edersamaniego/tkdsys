<?php

namespace PHPMaker2022\school;

// Page object
$FedVideosectionAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_videosection: currentTable } });
var currentForm, currentPageID;
var ffed_videosectionadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videosectionadd = new ew.Form("ffed_videosectionadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_videosectionadd;

    // Add fields
    var fields = currentTable.fields;
    ffed_videosectionadd.addFields([
        ["section", [fields.section.visible && fields.section.required ? ew.Validators.required(fields.section.caption) : null], fields.section.isInvalid],
        ["sectionBr", [fields.sectionBr.visible && fields.sectionBr.required ? ew.Validators.required(fields.sectionBr.caption) : null], fields.sectionBr.isInvalid],
        ["sectionSp", [fields.sectionSp.visible && fields.sectionSp.required ? ew.Validators.required(fields.sectionSp.caption) : null], fields.sectionSp.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null], fields._userId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null], fields.createDate.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_videosectionadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_videosectionadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffed_videosectionadd");
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
<form name="ffed_videosectionadd" id="ffed_videosectionadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_videosection">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->section->Visible) { // section ?>
    <div id="r_section"<?= $Page->section->rowAttributes() ?>>
        <label id="elh_fed_videosection_section" for="x_section" class="<?= $Page->LeftColumnClass ?>"><?= $Page->section->caption() ?><?= $Page->section->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->section->cellAttributes() ?>>
<span id="el_fed_videosection_section">
<input type="<?= $Page->section->getInputTextType() ?>" name="x_section" id="x_section" data-table="fed_videosection" data-field="x_section" value="<?= $Page->section->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->section->getPlaceHolder()) ?>"<?= $Page->section->editAttributes() ?> aria-describedby="x_section_help">
<?= $Page->section->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->section->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sectionBr->Visible) { // sectionBr ?>
    <div id="r_sectionBr"<?= $Page->sectionBr->rowAttributes() ?>>
        <label id="elh_fed_videosection_sectionBr" for="x_sectionBr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sectionBr->caption() ?><?= $Page->sectionBr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sectionBr->cellAttributes() ?>>
<span id="el_fed_videosection_sectionBr">
<input type="<?= $Page->sectionBr->getInputTextType() ?>" name="x_sectionBr" id="x_sectionBr" data-table="fed_videosection" data-field="x_sectionBr" value="<?= $Page->sectionBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->sectionBr->getPlaceHolder()) ?>"<?= $Page->sectionBr->editAttributes() ?> aria-describedby="x_sectionBr_help">
<?= $Page->sectionBr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sectionBr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sectionSp->Visible) { // sectionSp ?>
    <div id="r_sectionSp"<?= $Page->sectionSp->rowAttributes() ?>>
        <label id="elh_fed_videosection_sectionSp" for="x_sectionSp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sectionSp->caption() ?><?= $Page->sectionSp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sectionSp->cellAttributes() ?>>
<span id="el_fed_videosection_sectionSp">
<input type="<?= $Page->sectionSp->getInputTextType() ?>" name="x_sectionSp" id="x_sectionSp" data-table="fed_videosection" data-field="x_sectionSp" value="<?= $Page->sectionSp->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->sectionSp->getPlaceHolder()) ?>"<?= $Page->sectionSp->editAttributes() ?> aria-describedby="x_sectionSp_help">
<?= $Page->sectionSp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sectionSp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("fed_videosubsection", explode(",", $Page->getCurrentDetailTable())) && $fed_videosubsection->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fed_videosubsection", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FedVideosubsectionGrid.php" ?>
<?php } ?>
<?php
    if (in_array("fed_video", explode(",", $Page->getCurrentDetailTable())) && $fed_video->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fed_video", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FedVideoGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fed_videosection");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
