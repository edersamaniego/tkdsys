<?php

namespace PHPMaker2022\school;

// Page object
$FedVideosubsectionEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_videosubsection: currentTable } });
var currentForm, currentPageID;
var ffed_videosubsectionedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videosubsectionedit = new ew.Form("ffed_videosubsectionedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffed_videosubsectionedit;

    // Add fields
    var fields = currentTable.fields;
    ffed_videosubsectionedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["section", [fields.section.visible && fields.section.required ? ew.Validators.required(fields.section.caption) : null], fields.section.isInvalid],
        ["subsection", [fields.subsection.visible && fields.subsection.required ? ew.Validators.required(fields.subsection.caption) : null], fields.subsection.isInvalid],
        ["subsectionBr", [fields.subsectionBr.visible && fields.subsectionBr.required ? ew.Validators.required(fields.subsectionBr.caption) : null], fields.subsectionBr.isInvalid],
        ["subsectionSp", [fields.subsectionSp.visible && fields.subsectionSp.required ? ew.Validators.required(fields.subsectionSp.caption) : null], fields.subsectionSp.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null, ew.Validators.integer], fields._userId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_videosubsectionedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_videosubsectionedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_videosubsectionedit.lists.section = <?= $Page->section->toClientList($Page) ?>;
    loadjs.done("ffed_videosubsectionedit");
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
<?php if (!$Page->IsModal) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<form name="ffed_videosubsectionedit" id="ffed_videosubsectionedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_videosubsection">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fed_videosection") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_videosection">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->section->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fed_videosubsection_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_videosubsection_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->section->Visible) { // section ?>
    <div id="r_section"<?= $Page->section->rowAttributes() ?>>
        <label id="elh_fed_videosubsection_section" for="x_section" class="<?= $Page->LeftColumnClass ?>"><?= $Page->section->caption() ?><?= $Page->section->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->section->cellAttributes() ?>>
<?php if ($Page->section->getSessionValue() != "") { ?>
<span<?= $Page->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->section->getDisplayValue($Page->section->ViewValue) ?></span></span>
<input type="hidden" id="x_section" name="x_section" value="<?= HtmlEncode($Page->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fed_videosubsection_section">
    <select
        id="x_section"
        name="x_section"
        class="form-select ew-select<?= $Page->section->isInvalidClass() ?>"
        data-select2-id="ffed_videosubsectionedit_x_section"
        data-table="fed_videosubsection"
        data-field="x_section"
        data-value-separator="<?= $Page->section->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->section->getPlaceHolder()) ?>"
        <?= $Page->section->editAttributes() ?>>
        <?= $Page->section->selectOptionListHtml("x_section") ?>
    </select>
    <?= $Page->section->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->section->getErrorMessage() ?></div>
<?= $Page->section->Lookup->getParamTag($Page, "p_x_section") ?>
<script>
loadjs.ready("ffed_videosubsectionedit", function() {
    var options = { name: "x_section", selectId: "ffed_videosubsectionedit_x_section" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_videosubsectionedit.lists.section.lookupOptions.length) {
        options.data = { id: "x_section", form: "ffed_videosubsectionedit" };
    } else {
        options.ajax = { id: "x_section", form: "ffed_videosubsectionedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_videosubsection.fields.section.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
    <div id="r_subsection"<?= $Page->subsection->rowAttributes() ?>>
        <label id="elh_fed_videosubsection_subsection" for="x_subsection" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subsection->caption() ?><?= $Page->subsection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subsection->cellAttributes() ?>>
<span id="el_fed_videosubsection_subsection">
<input type="<?= $Page->subsection->getInputTextType() ?>" name="x_subsection" id="x_subsection" data-table="fed_videosubsection" data-field="x_subsection" value="<?= $Page->subsection->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->subsection->getPlaceHolder()) ?>"<?= $Page->subsection->editAttributes() ?> aria-describedby="x_subsection_help">
<?= $Page->subsection->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subsection->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subsectionBr->Visible) { // subsectionBr ?>
    <div id="r_subsectionBr"<?= $Page->subsectionBr->rowAttributes() ?>>
        <label id="elh_fed_videosubsection_subsectionBr" for="x_subsectionBr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subsectionBr->caption() ?><?= $Page->subsectionBr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subsectionBr->cellAttributes() ?>>
<span id="el_fed_videosubsection_subsectionBr">
<input type="<?= $Page->subsectionBr->getInputTextType() ?>" name="x_subsectionBr" id="x_subsectionBr" data-table="fed_videosubsection" data-field="x_subsectionBr" value="<?= $Page->subsectionBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->subsectionBr->getPlaceHolder()) ?>"<?= $Page->subsectionBr->editAttributes() ?> aria-describedby="x_subsectionBr_help">
<?= $Page->subsectionBr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subsectionBr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subsectionSp->Visible) { // subsectionSp ?>
    <div id="r_subsectionSp"<?= $Page->subsectionSp->rowAttributes() ?>>
        <label id="elh_fed_videosubsection_subsectionSp" for="x_subsectionSp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subsectionSp->caption() ?><?= $Page->subsectionSp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subsectionSp->cellAttributes() ?>>
<span id="el_fed_videosubsection_subsectionSp">
<input type="<?= $Page->subsectionSp->getInputTextType() ?>" name="x_subsectionSp" id="x_subsectionSp" data-table="fed_videosubsection" data-field="x_subsectionSp" value="<?= $Page->subsectionSp->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->subsectionSp->getPlaceHolder()) ?>"<?= $Page->subsectionSp->editAttributes() ?> aria-describedby="x_subsectionSp_help">
<?= $Page->subsectionSp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subsectionSp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <div id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <label id="elh_fed_videosubsection__userId" for="x__userId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_userId->caption() ?><?= $Page->_userId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fed_videosubsection__userId">
<input type="<?= $Page->_userId->getInputTextType() ?>" name="x__userId" id="x__userId" data-table="fed_videosubsection" data-field="x__userId" value="<?= $Page->_userId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_userId->getPlaceHolder()) ?>"<?= $Page->_userId->editAttributes() ?> aria-describedby="x__userId_help">
<?= $Page->_userId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_userId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_fed_videosubsection_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_videosubsection_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_videosubsection" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_videosubsectionedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ffed_videosubsectionedit", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("fed_video", explode(",", $Page->getCurrentDetailTable())) && $fed_video->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fed_video", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FedVideoGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fed_videosubsection");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
