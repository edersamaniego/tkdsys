<?php

namespace PHPMaker2022\school;

// Page object
$FedVideoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_video: currentTable } });
var currentForm, currentPageID;
var ffed_videoadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videoadd = new ew.Form("ffed_videoadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_videoadd;

    // Add fields
    var fields = currentTable.fields;
    ffed_videoadd.addFields([
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["URL", [fields.URL.visible && fields.URL.required ? ew.Validators.required(fields.URL.caption) : null], fields.URL.isInvalid],
        ["thumbs", [fields.thumbs.visible && fields.thumbs.required ? ew.Validators.fileRequired(fields.thumbs.caption) : null], fields.thumbs.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["section", [fields.section.visible && fields.section.required ? ew.Validators.required(fields.section.caption) : null], fields.section.isInvalid],
        ["subsection", [fields.subsection.visible && fields.subsection.required ? ew.Validators.required(fields.subsection.caption) : null], fields.subsection.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["frame", [fields.frame.visible && fields.frame.required ? ew.Validators.required(fields.frame.caption) : null], fields.frame.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_videoadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_videoadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_videoadd.lists.section = <?= $Page->section->toClientList($Page) ?>;
    ffed_videoadd.lists.subsection = <?= $Page->subsection->toClientList($Page) ?>;
    ffed_videoadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("ffed_videoadd");
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
<form name="ffed_videoadd" id="ffed_videoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_video">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fed_videosection") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_videosection">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->section->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "fed_videosubsection") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_videosubsection">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->subsection->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_fed_video__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span id="el_fed_video__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="fed_video" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->URL->Visible) { // URL ?>
    <div id="r_URL"<?= $Page->URL->rowAttributes() ?>>
        <label id="elh_fed_video_URL" for="x_URL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->URL->caption() ?><?= $Page->URL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->URL->cellAttributes() ?>>
<span id="el_fed_video_URL">
<input type="<?= $Page->URL->getInputTextType() ?>" name="x_URL" id="x_URL" data-table="fed_video" data-field="x_URL" value="<?= $Page->URL->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->URL->getPlaceHolder()) ?>"<?= $Page->URL->editAttributes() ?> aria-describedby="x_URL_help">
<?= $Page->URL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->URL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->thumbs->Visible) { // thumbs ?>
    <div id="r_thumbs"<?= $Page->thumbs->rowAttributes() ?>>
        <label id="elh_fed_video_thumbs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->thumbs->caption() ?><?= $Page->thumbs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->thumbs->cellAttributes() ?>>
<span id="el_fed_video_thumbs">
<div id="fd_x_thumbs" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->thumbs->title() ?>" data-table="fed_video" data-field="x_thumbs" name="x_thumbs" id="x_thumbs" lang="<?= CurrentLanguageID() ?>"<?= $Page->thumbs->editAttributes() ?> aria-describedby="x_thumbs_help"<?= ($Page->thumbs->ReadOnly || $Page->thumbs->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->thumbs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->thumbs->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_thumbs" id= "fn_x_thumbs" value="<?= $Page->thumbs->Upload->FileName ?>">
<input type="hidden" name="fa_x_thumbs" id= "fa_x_thumbs" value="0">
<input type="hidden" name="fs_x_thumbs" id= "fs_x_thumbs" value="255">
<input type="hidden" name="fx_x_thumbs" id= "fx_x_thumbs" value="<?= $Page->thumbs->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_thumbs" id= "fm_x_thumbs" value="<?= $Page->thumbs->UploadMaxFileSize ?>">
<table id="ft_x_thumbs" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_fed_video_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_fed_video_description">
<textarea data-table="fed_video" data-field="x_description" name="x_description" id="x_description" cols="50" rows="3" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->section->Visible) { // section ?>
    <div id="r_section"<?= $Page->section->rowAttributes() ?>>
        <label id="elh_fed_video_section" class="<?= $Page->LeftColumnClass ?>"><?= $Page->section->caption() ?><?= $Page->section->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->section->cellAttributes() ?>>
<?php if ($Page->section->getSessionValue() != "") { ?>
<span<?= $Page->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->section->getDisplayValue($Page->section->ViewValue) ?></span></span>
<input type="hidden" id="x_section" name="x_section" value="<?= HtmlEncode($Page->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fed_video_section">
<template id="tp_x_section">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_section" name="x_section" id="x_section"<?= $Page->section->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_section" class="ew-item-list"></div>
<?php $Page->section->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<selection-list hidden
    id="x_section"
    name="x_section"
    value="<?= HtmlEncode($Page->section->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_section"
    data-bs-target="dsl_x_section"
    data-repeatcolumn="5"
    class="form-control<?= $Page->section->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_section"
    data-value-separator="<?= $Page->section->displayValueSeparatorAttribute() ?>"
    <?= $Page->section->editAttributes() ?>></selection-list>
<?= $Page->section->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->section->getErrorMessage() ?></div>
<?= $Page->section->Lookup->getParamTag($Page, "p_x_section") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
    <div id="r_subsection"<?= $Page->subsection->rowAttributes() ?>>
        <label id="elh_fed_video_subsection" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subsection->caption() ?><?= $Page->subsection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subsection->cellAttributes() ?>>
<?php if ($Page->subsection->getSessionValue() != "") { ?>
<span<?= $Page->subsection->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->subsection->getDisplayValue($Page->subsection->ViewValue) ?></span></span>
<input type="hidden" id="x_subsection" name="x_subsection" value="<?= HtmlEncode($Page->subsection->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fed_video_subsection">
<template id="tp_x_subsection">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_subsection" name="x_subsection" id="x_subsection"<?= $Page->subsection->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_subsection" class="ew-item-list"></div>
<selection-list hidden
    id="x_subsection"
    name="x_subsection"
    value="<?= HtmlEncode($Page->subsection->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_subsection"
    data-bs-target="dsl_x_subsection"
    data-repeatcolumn="5"
    class="form-control<?= $Page->subsection->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_subsection"
    data-value-separator="<?= $Page->subsection->displayValueSeparatorAttribute() ?>"
    <?= $Page->subsection->editAttributes() ?>></selection-list>
<?= $Page->subsection->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subsection->getErrorMessage() ?></div>
<?= $Page->subsection->Lookup->getParamTag($Page, "p_x_subsection") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_fed_video_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_fed_video_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-bs-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->frame->Visible) { // frame ?>
    <div id="r_frame"<?= $Page->frame->rowAttributes() ?>>
        <label id="elh_fed_video_frame" class="<?= $Page->LeftColumnClass ?>"><?= $Page->frame->caption() ?><?= $Page->frame->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->frame->cellAttributes() ?>>
<span id="el_fed_video_frame">
<?php $Page->frame->EditAttrs->appendClass("editor"); ?>
<textarea data-table="fed_video" data-field="x_frame" name="x_frame" id="x_frame" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->frame->getPlaceHolder()) ?>"<?= $Page->frame->editAttributes() ?> aria-describedby="x_frame_help"><?= $Page->frame->EditValue ?></textarea>
<?= $Page->frame->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->frame->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffed_videoadd", "editor"], function() {
    ew.createEditor("ffed_videoadd", "x_frame", 35, 4, <?= $Page->frame->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("fed_video");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
