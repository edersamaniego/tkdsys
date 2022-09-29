<?php

namespace PHPMaker2022\school;

// Page object
$TesCertificateEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_certificate: currentTable } });
var currentForm, currentPageID;
var ftes_certificateedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_certificateedit = new ew.Form("ftes_certificateedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ftes_certificateedit;

    // Add fields
    var fields = currentTable.fields;
    ftes_certificateedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["background", [fields.background.visible && fields.background.required ? ew.Validators.fileRequired(fields.background.caption) : null], fields.background.isInvalid],
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["titlePosX", [fields.titlePosX.visible && fields.titlePosX.required ? ew.Validators.required(fields.titlePosX.caption) : null], fields.titlePosX.isInvalid],
        ["titlePosY", [fields.titlePosY.visible && fields.titlePosY.required ? ew.Validators.required(fields.titlePosY.caption) : null], fields.titlePosY.isInvalid],
        ["titleFont", [fields.titleFont.visible && fields.titleFont.required ? ew.Validators.required(fields.titleFont.caption) : null], fields.titleFont.isInvalid],
        ["titleFontSize", [fields.titleFontSize.visible && fields.titleFontSize.required ? ew.Validators.required(fields.titleFontSize.caption) : null], fields.titleFontSize.isInvalid],
        ["titleAlign", [fields.titleAlign.visible && fields.titleAlign.required ? ew.Validators.required(fields.titleAlign.caption) : null], fields.titleAlign.isInvalid],
        ["text01", [fields.text01.visible && fields.text01.required ? ew.Validators.required(fields.text01.caption) : null], fields.text01.isInvalid],
        ["txt01PosX", [fields.txt01PosX.visible && fields.txt01PosX.required ? ew.Validators.required(fields.txt01PosX.caption) : null], fields.txt01PosX.isInvalid],
        ["txt01PosY", [fields.txt01PosY.visible && fields.txt01PosY.required ? ew.Validators.required(fields.txt01PosY.caption) : null], fields.txt01PosY.isInvalid],
        ["text02", [fields.text02.visible && fields.text02.required ? ew.Validators.required(fields.text02.caption) : null], fields.text02.isInvalid],
        ["txt02PosX", [fields.txt02PosX.visible && fields.txt02PosX.required ? ew.Validators.required(fields.txt02PosX.caption) : null], fields.txt02PosX.isInvalid],
        ["txt02PosY", [fields.txt02PosY.visible && fields.txt02PosY.required ? ew.Validators.required(fields.txt02PosY.caption) : null], fields.txt02PosY.isInvalid],
        ["textFont", [fields.textFont.visible && fields.textFont.required ? ew.Validators.required(fields.textFont.caption) : null], fields.textFont.isInvalid],
        ["textSize", [fields.textSize.visible && fields.textSize.required ? ew.Validators.required(fields.textSize.caption) : null], fields.textSize.isInvalid],
        ["studentFont", [fields.studentFont.visible && fields.studentFont.required ? ew.Validators.required(fields.studentFont.caption) : null], fields.studentFont.isInvalid],
        ["studentSize", [fields.studentSize.visible && fields.studentSize.required ? ew.Validators.required(fields.studentSize.caption) : null], fields.studentSize.isInvalid],
        ["studentPosX", [fields.studentPosX.visible && fields.studentPosX.required ? ew.Validators.required(fields.studentPosX.caption) : null], fields.studentPosX.isInvalid],
        ["studentPosY", [fields.studentPosY.visible && fields.studentPosY.required ? ew.Validators.required(fields.studentPosY.caption) : null], fields.studentPosY.isInvalid],
        ["instructorFont", [fields.instructorFont.visible && fields.instructorFont.required ? ew.Validators.required(fields.instructorFont.caption) : null], fields.instructorFont.isInvalid],
        ["instructorSize", [fields.instructorSize.visible && fields.instructorSize.required ? ew.Validators.required(fields.instructorSize.caption) : null], fields.instructorSize.isInvalid],
        ["instructorPosX", [fields.instructorPosX.visible && fields.instructorPosX.required ? ew.Validators.required(fields.instructorPosX.caption) : null], fields.instructorPosX.isInvalid],
        ["instructorPosY", [fields.instructorPosY.visible && fields.instructorPosY.required ? ew.Validators.required(fields.instructorPosY.caption) : null], fields.instructorPosY.isInvalid],
        ["assistantPosX", [fields.assistantPosX.visible && fields.assistantPosX.required ? ew.Validators.required(fields.assistantPosX.caption) : null], fields.assistantPosX.isInvalid],
        ["assistantPosY", [fields.assistantPosY.visible && fields.assistantPosY.required ? ew.Validators.required(fields.assistantPosY.caption) : null], fields.assistantPosY.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["orientation", [fields.orientation.visible && fields.orientation.required ? ew.Validators.required(fields.orientation.caption) : null], fields.orientation.isInvalid],
        ["size", [fields.size.visible && fields.size.required ? ew.Validators.required(fields.size.caption) : null], fields.size.isInvalid],
        ["martialArtId", [fields.martialArtId.visible && fields.martialArtId.required ? ew.Validators.required(fields.martialArtId.caption) : null], fields.martialArtId.isInvalid]
    ]);

    // Form_CustomValidate
    ftes_certificateedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_certificateedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftes_certificateedit.lists.titleAlign = <?= $Page->titleAlign->toClientList($Page) ?>;
    ftes_certificateedit.lists.textFont = <?= $Page->textFont->toClientList($Page) ?>;
    ftes_certificateedit.lists.studentFont = <?= $Page->studentFont->toClientList($Page) ?>;
    ftes_certificateedit.lists.instructorFont = <?= $Page->instructorFont->toClientList($Page) ?>;
    ftes_certificateedit.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    ftes_certificateedit.lists.orientation = <?= $Page->orientation->toClientList($Page) ?>;
    ftes_certificateedit.lists.size = <?= $Page->size->toClientList($Page) ?>;
    ftes_certificateedit.lists.martialArtId = <?= $Page->martialArtId->toClientList($Page) ?>;
    loadjs.done("ftes_certificateedit");
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
<form name="ftes_certificateedit" id="ftes_certificateedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_certificate">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_tes_certificate_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_certificate_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="tes_certificate" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_tes_certificate_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_tes_certificate_description">
<input type="<?= $Page->description->getInputTextType() ?>" name="x_description" id="x_description" data-table="tes_certificate" data-field="x_description" value="<?= $Page->description->EditValue ?>" size="40" maxlength="255" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help">
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->background->Visible) { // background ?>
    <div id="r_background"<?= $Page->background->rowAttributes() ?>>
        <label id="elh_tes_certificate_background" class="<?= $Page->LeftColumnClass ?>"><?= $Page->background->caption() ?><?= $Page->background->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->background->cellAttributes() ?>>
<span id="el_tes_certificate_background">
<div id="fd_x_background" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->background->title() ?>" data-table="tes_certificate" data-field="x_background" name="x_background" id="x_background" lang="<?= CurrentLanguageID() ?>"<?= $Page->background->editAttributes() ?> aria-describedby="x_background_help"<?= ($Page->background->ReadOnly || $Page->background->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->background->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->background->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_background" id= "fn_x_background" value="<?= $Page->background->Upload->FileName ?>">
<input type="hidden" name="fa_x_background" id= "fa_x_background" value="<?= (Post("fa_x_background") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_background" id= "fs_x_background" value="255">
<input type="hidden" name="fx_x_background" id= "fx_x_background" value="<?= $Page->background->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_background" id= "fm_x_background" value="<?= $Page->background->UploadMaxFileSize ?>">
<table id="ft_x_background" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_tes_certificate__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span id="el_tes_certificate__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="tes_certificate" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="40" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titlePosX->Visible) { // titlePosX ?>
    <div id="r_titlePosX"<?= $Page->titlePosX->rowAttributes() ?>>
        <label id="elh_tes_certificate_titlePosX" for="x_titlePosX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titlePosX->caption() ?><?= $Page->titlePosX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titlePosX->cellAttributes() ?>>
<span id="el_tes_certificate_titlePosX">
<input type="<?= $Page->titlePosX->getInputTextType() ?>" name="x_titlePosX" id="x_titlePosX" data-table="tes_certificate" data-field="x_titlePosX" value="<?= $Page->titlePosX->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->titlePosX->getPlaceHolder()) ?>"<?= $Page->titlePosX->editAttributes() ?> aria-describedby="x_titlePosX_help">
<?= $Page->titlePosX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titlePosX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titlePosY->Visible) { // titlePosY ?>
    <div id="r_titlePosY"<?= $Page->titlePosY->rowAttributes() ?>>
        <label id="elh_tes_certificate_titlePosY" for="x_titlePosY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titlePosY->caption() ?><?= $Page->titlePosY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titlePosY->cellAttributes() ?>>
<span id="el_tes_certificate_titlePosY">
<input type="<?= $Page->titlePosY->getInputTextType() ?>" name="x_titlePosY" id="x_titlePosY" data-table="tes_certificate" data-field="x_titlePosY" value="<?= $Page->titlePosY->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->titlePosY->getPlaceHolder()) ?>"<?= $Page->titlePosY->editAttributes() ?> aria-describedby="x_titlePosY_help">
<?= $Page->titlePosY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titlePosY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titleFont->Visible) { // titleFont ?>
    <div id="r_titleFont"<?= $Page->titleFont->rowAttributes() ?>>
        <label id="elh_tes_certificate_titleFont" for="x_titleFont" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titleFont->caption() ?><?= $Page->titleFont->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titleFont->cellAttributes() ?>>
<span id="el_tes_certificate_titleFont">
<input type="<?= $Page->titleFont->getInputTextType() ?>" name="x_titleFont" id="x_titleFont" data-table="tes_certificate" data-field="x_titleFont" value="<?= $Page->titleFont->EditValue ?>" size="10" maxlength="255" placeholder="<?= HtmlEncode($Page->titleFont->getPlaceHolder()) ?>"<?= $Page->titleFont->editAttributes() ?> aria-describedby="x_titleFont_help">
<?= $Page->titleFont->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titleFont->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titleFontSize->Visible) { // titleFontSize ?>
    <div id="r_titleFontSize"<?= $Page->titleFontSize->rowAttributes() ?>>
        <label id="elh_tes_certificate_titleFontSize" for="x_titleFontSize" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titleFontSize->caption() ?><?= $Page->titleFontSize->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titleFontSize->cellAttributes() ?>>
<span id="el_tes_certificate_titleFontSize">
<input type="<?= $Page->titleFontSize->getInputTextType() ?>" name="x_titleFontSize" id="x_titleFontSize" data-table="tes_certificate" data-field="x_titleFontSize" value="<?= $Page->titleFontSize->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->titleFontSize->getPlaceHolder()) ?>"<?= $Page->titleFontSize->editAttributes() ?> aria-describedby="x_titleFontSize_help">
<?= $Page->titleFontSize->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titleFontSize->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titleAlign->Visible) { // titleAlign ?>
    <div id="r_titleAlign"<?= $Page->titleAlign->rowAttributes() ?>>
        <label id="elh_tes_certificate_titleAlign" for="x_titleAlign" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titleAlign->caption() ?><?= $Page->titleAlign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titleAlign->cellAttributes() ?>>
<span id="el_tes_certificate_titleAlign">
    <select
        id="x_titleAlign"
        name="x_titleAlign"
        class="form-select ew-select<?= $Page->titleAlign->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_titleAlign"
        data-table="tes_certificate"
        data-field="x_titleAlign"
        data-value-separator="<?= $Page->titleAlign->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->titleAlign->getPlaceHolder()) ?>"
        <?= $Page->titleAlign->editAttributes() ?>>
        <?= $Page->titleAlign->selectOptionListHtml("x_titleAlign") ?>
    </select>
    <?= $Page->titleAlign->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->titleAlign->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_titleAlign", selectId: "ftes_certificateedit_x_titleAlign" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_certificateedit.lists.titleAlign.lookupOptions.length) {
        options.data = { id: "x_titleAlign", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_titleAlign", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_certificate.fields.titleAlign.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->text01->Visible) { // text01 ?>
    <div id="r_text01"<?= $Page->text01->rowAttributes() ?>>
        <label id="elh_tes_certificate_text01" for="x_text01" class="<?= $Page->LeftColumnClass ?>"><?= $Page->text01->caption() ?><?= $Page->text01->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->text01->cellAttributes() ?>>
<span id="el_tes_certificate_text01">
<textarea data-table="tes_certificate" data-field="x_text01" name="x_text01" id="x_text01" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->text01->getPlaceHolder()) ?>"<?= $Page->text01->editAttributes() ?> aria-describedby="x_text01_help"><?= $Page->text01->EditValue ?></textarea>
<?= $Page->text01->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->text01->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->txt01PosX->Visible) { // txt01PosX ?>
    <div id="r_txt01PosX"<?= $Page->txt01PosX->rowAttributes() ?>>
        <label id="elh_tes_certificate_txt01PosX" for="x_txt01PosX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->txt01PosX->caption() ?><?= $Page->txt01PosX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->txt01PosX->cellAttributes() ?>>
<span id="el_tes_certificate_txt01PosX">
<input type="<?= $Page->txt01PosX->getInputTextType() ?>" name="x_txt01PosX" id="x_txt01PosX" data-table="tes_certificate" data-field="x_txt01PosX" value="<?= $Page->txt01PosX->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->txt01PosX->getPlaceHolder()) ?>"<?= $Page->txt01PosX->editAttributes() ?> aria-describedby="x_txt01PosX_help">
<?= $Page->txt01PosX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->txt01PosX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->txt01PosY->Visible) { // txt01PosY ?>
    <div id="r_txt01PosY"<?= $Page->txt01PosY->rowAttributes() ?>>
        <label id="elh_tes_certificate_txt01PosY" for="x_txt01PosY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->txt01PosY->caption() ?><?= $Page->txt01PosY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->txt01PosY->cellAttributes() ?>>
<span id="el_tes_certificate_txt01PosY">
<input type="<?= $Page->txt01PosY->getInputTextType() ?>" name="x_txt01PosY" id="x_txt01PosY" data-table="tes_certificate" data-field="x_txt01PosY" value="<?= $Page->txt01PosY->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->txt01PosY->getPlaceHolder()) ?>"<?= $Page->txt01PosY->editAttributes() ?> aria-describedby="x_txt01PosY_help">
<?= $Page->txt01PosY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->txt01PosY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->text02->Visible) { // text02 ?>
    <div id="r_text02"<?= $Page->text02->rowAttributes() ?>>
        <label id="elh_tes_certificate_text02" for="x_text02" class="<?= $Page->LeftColumnClass ?>"><?= $Page->text02->caption() ?><?= $Page->text02->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->text02->cellAttributes() ?>>
<span id="el_tes_certificate_text02">
<textarea data-table="tes_certificate" data-field="x_text02" name="x_text02" id="x_text02" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->text02->getPlaceHolder()) ?>"<?= $Page->text02->editAttributes() ?> aria-describedby="x_text02_help"><?= $Page->text02->EditValue ?></textarea>
<?= $Page->text02->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->text02->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->txt02PosX->Visible) { // txt02PosX ?>
    <div id="r_txt02PosX"<?= $Page->txt02PosX->rowAttributes() ?>>
        <label id="elh_tes_certificate_txt02PosX" for="x_txt02PosX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->txt02PosX->caption() ?><?= $Page->txt02PosX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->txt02PosX->cellAttributes() ?>>
<span id="el_tes_certificate_txt02PosX">
<input type="<?= $Page->txt02PosX->getInputTextType() ?>" name="x_txt02PosX" id="x_txt02PosX" data-table="tes_certificate" data-field="x_txt02PosX" value="<?= $Page->txt02PosX->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->txt02PosX->getPlaceHolder()) ?>"<?= $Page->txt02PosX->editAttributes() ?> aria-describedby="x_txt02PosX_help">
<?= $Page->txt02PosX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->txt02PosX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->txt02PosY->Visible) { // txt02PosY ?>
    <div id="r_txt02PosY"<?= $Page->txt02PosY->rowAttributes() ?>>
        <label id="elh_tes_certificate_txt02PosY" for="x_txt02PosY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->txt02PosY->caption() ?><?= $Page->txt02PosY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->txt02PosY->cellAttributes() ?>>
<span id="el_tes_certificate_txt02PosY">
<input type="<?= $Page->txt02PosY->getInputTextType() ?>" name="x_txt02PosY" id="x_txt02PosY" data-table="tes_certificate" data-field="x_txt02PosY" value="<?= $Page->txt02PosY->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->txt02PosY->getPlaceHolder()) ?>"<?= $Page->txt02PosY->editAttributes() ?> aria-describedby="x_txt02PosY_help">
<?= $Page->txt02PosY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->txt02PosY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->textFont->Visible) { // textFont ?>
    <div id="r_textFont"<?= $Page->textFont->rowAttributes() ?>>
        <label id="elh_tes_certificate_textFont" for="x_textFont" class="<?= $Page->LeftColumnClass ?>"><?= $Page->textFont->caption() ?><?= $Page->textFont->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->textFont->cellAttributes() ?>>
<span id="el_tes_certificate_textFont">
    <select
        id="x_textFont"
        name="x_textFont"
        class="form-select ew-select<?= $Page->textFont->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_textFont"
        data-table="tes_certificate"
        data-field="x_textFont"
        data-value-separator="<?= $Page->textFont->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->textFont->getPlaceHolder()) ?>"
        <?= $Page->textFont->editAttributes() ?>>
        <?= $Page->textFont->selectOptionListHtml("x_textFont") ?>
    </select>
    <?= $Page->textFont->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->textFont->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_textFont", selectId: "ftes_certificateedit_x_textFont" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_certificateedit.lists.textFont.lookupOptions.length) {
        options.data = { id: "x_textFont", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_textFont", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_certificate.fields.textFont.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->textSize->Visible) { // textSize ?>
    <div id="r_textSize"<?= $Page->textSize->rowAttributes() ?>>
        <label id="elh_tes_certificate_textSize" for="x_textSize" class="<?= $Page->LeftColumnClass ?>"><?= $Page->textSize->caption() ?><?= $Page->textSize->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->textSize->cellAttributes() ?>>
<span id="el_tes_certificate_textSize">
<input type="<?= $Page->textSize->getInputTextType() ?>" name="x_textSize" id="x_textSize" data-table="tes_certificate" data-field="x_textSize" value="<?= $Page->textSize->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->textSize->getPlaceHolder()) ?>"<?= $Page->textSize->editAttributes() ?> aria-describedby="x_textSize_help">
<?= $Page->textSize->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->textSize->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->studentFont->Visible) { // studentFont ?>
    <div id="r_studentFont"<?= $Page->studentFont->rowAttributes() ?>>
        <label id="elh_tes_certificate_studentFont" for="x_studentFont" class="<?= $Page->LeftColumnClass ?>"><?= $Page->studentFont->caption() ?><?= $Page->studentFont->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->studentFont->cellAttributes() ?>>
<span id="el_tes_certificate_studentFont">
    <select
        id="x_studentFont"
        name="x_studentFont"
        class="form-select ew-select<?= $Page->studentFont->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_studentFont"
        data-table="tes_certificate"
        data-field="x_studentFont"
        data-value-separator="<?= $Page->studentFont->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->studentFont->getPlaceHolder()) ?>"
        <?= $Page->studentFont->editAttributes() ?>>
        <?= $Page->studentFont->selectOptionListHtml("x_studentFont") ?>
    </select>
    <?= $Page->studentFont->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->studentFont->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_studentFont", selectId: "ftes_certificateedit_x_studentFont" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_certificateedit.lists.studentFont.lookupOptions.length) {
        options.data = { id: "x_studentFont", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_studentFont", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_certificate.fields.studentFont.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->studentSize->Visible) { // studentSize ?>
    <div id="r_studentSize"<?= $Page->studentSize->rowAttributes() ?>>
        <label id="elh_tes_certificate_studentSize" for="x_studentSize" class="<?= $Page->LeftColumnClass ?>"><?= $Page->studentSize->caption() ?><?= $Page->studentSize->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->studentSize->cellAttributes() ?>>
<span id="el_tes_certificate_studentSize">
<input type="<?= $Page->studentSize->getInputTextType() ?>" name="x_studentSize" id="x_studentSize" data-table="tes_certificate" data-field="x_studentSize" value="<?= $Page->studentSize->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->studentSize->getPlaceHolder()) ?>"<?= $Page->studentSize->editAttributes() ?> aria-describedby="x_studentSize_help">
<?= $Page->studentSize->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->studentSize->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->studentPosX->Visible) { // studentPosX ?>
    <div id="r_studentPosX"<?= $Page->studentPosX->rowAttributes() ?>>
        <label id="elh_tes_certificate_studentPosX" for="x_studentPosX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->studentPosX->caption() ?><?= $Page->studentPosX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->studentPosX->cellAttributes() ?>>
<span id="el_tes_certificate_studentPosX">
<input type="<?= $Page->studentPosX->getInputTextType() ?>" name="x_studentPosX" id="x_studentPosX" data-table="tes_certificate" data-field="x_studentPosX" value="<?= $Page->studentPosX->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->studentPosX->getPlaceHolder()) ?>"<?= $Page->studentPosX->editAttributes() ?> aria-describedby="x_studentPosX_help">
<?= $Page->studentPosX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->studentPosX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->studentPosY->Visible) { // studentPosY ?>
    <div id="r_studentPosY"<?= $Page->studentPosY->rowAttributes() ?>>
        <label id="elh_tes_certificate_studentPosY" for="x_studentPosY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->studentPosY->caption() ?><?= $Page->studentPosY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->studentPosY->cellAttributes() ?>>
<span id="el_tes_certificate_studentPosY">
<input type="<?= $Page->studentPosY->getInputTextType() ?>" name="x_studentPosY" id="x_studentPosY" data-table="tes_certificate" data-field="x_studentPosY" value="<?= $Page->studentPosY->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->studentPosY->getPlaceHolder()) ?>"<?= $Page->studentPosY->editAttributes() ?> aria-describedby="x_studentPosY_help">
<?= $Page->studentPosY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->studentPosY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorFont->Visible) { // instructorFont ?>
    <div id="r_instructorFont"<?= $Page->instructorFont->rowAttributes() ?>>
        <label id="elh_tes_certificate_instructorFont" for="x_instructorFont" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorFont->caption() ?><?= $Page->instructorFont->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorFont->cellAttributes() ?>>
<span id="el_tes_certificate_instructorFont">
    <select
        id="x_instructorFont"
        name="x_instructorFont"
        class="form-select ew-select<?= $Page->instructorFont->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_instructorFont"
        data-table="tes_certificate"
        data-field="x_instructorFont"
        data-value-separator="<?= $Page->instructorFont->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->instructorFont->getPlaceHolder()) ?>"
        <?= $Page->instructorFont->editAttributes() ?>>
        <?= $Page->instructorFont->selectOptionListHtml("x_instructorFont") ?>
    </select>
    <?= $Page->instructorFont->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->instructorFont->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_instructorFont", selectId: "ftes_certificateedit_x_instructorFont" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_certificateedit.lists.instructorFont.lookupOptions.length) {
        options.data = { id: "x_instructorFont", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_instructorFont", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_certificate.fields.instructorFont.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorSize->Visible) { // instructorSize ?>
    <div id="r_instructorSize"<?= $Page->instructorSize->rowAttributes() ?>>
        <label id="elh_tes_certificate_instructorSize" for="x_instructorSize" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorSize->caption() ?><?= $Page->instructorSize->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorSize->cellAttributes() ?>>
<span id="el_tes_certificate_instructorSize">
<input type="<?= $Page->instructorSize->getInputTextType() ?>" name="x_instructorSize" id="x_instructorSize" data-table="tes_certificate" data-field="x_instructorSize" value="<?= $Page->instructorSize->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->instructorSize->getPlaceHolder()) ?>"<?= $Page->instructorSize->editAttributes() ?> aria-describedby="x_instructorSize_help">
<?= $Page->instructorSize->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->instructorSize->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorPosX->Visible) { // instructorPosX ?>
    <div id="r_instructorPosX"<?= $Page->instructorPosX->rowAttributes() ?>>
        <label id="elh_tes_certificate_instructorPosX" for="x_instructorPosX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorPosX->caption() ?><?= $Page->instructorPosX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorPosX->cellAttributes() ?>>
<span id="el_tes_certificate_instructorPosX">
<input type="<?= $Page->instructorPosX->getInputTextType() ?>" name="x_instructorPosX" id="x_instructorPosX" data-table="tes_certificate" data-field="x_instructorPosX" value="<?= $Page->instructorPosX->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->instructorPosX->getPlaceHolder()) ?>"<?= $Page->instructorPosX->editAttributes() ?> aria-describedby="x_instructorPosX_help">
<?= $Page->instructorPosX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->instructorPosX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorPosY->Visible) { // instructorPosY ?>
    <div id="r_instructorPosY"<?= $Page->instructorPosY->rowAttributes() ?>>
        <label id="elh_tes_certificate_instructorPosY" for="x_instructorPosY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorPosY->caption() ?><?= $Page->instructorPosY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorPosY->cellAttributes() ?>>
<span id="el_tes_certificate_instructorPosY">
<input type="<?= $Page->instructorPosY->getInputTextType() ?>" name="x_instructorPosY" id="x_instructorPosY" data-table="tes_certificate" data-field="x_instructorPosY" value="<?= $Page->instructorPosY->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->instructorPosY->getPlaceHolder()) ?>"<?= $Page->instructorPosY->editAttributes() ?> aria-describedby="x_instructorPosY_help">
<?= $Page->instructorPosY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->instructorPosY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assistantPosX->Visible) { // assistantPosX ?>
    <div id="r_assistantPosX"<?= $Page->assistantPosX->rowAttributes() ?>>
        <label id="elh_tes_certificate_assistantPosX" for="x_assistantPosX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assistantPosX->caption() ?><?= $Page->assistantPosX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assistantPosX->cellAttributes() ?>>
<span id="el_tes_certificate_assistantPosX">
<input type="<?= $Page->assistantPosX->getInputTextType() ?>" name="x_assistantPosX" id="x_assistantPosX" data-table="tes_certificate" data-field="x_assistantPosX" value="<?= $Page->assistantPosX->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->assistantPosX->getPlaceHolder()) ?>"<?= $Page->assistantPosX->editAttributes() ?> aria-describedby="x_assistantPosX_help">
<?= $Page->assistantPosX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assistantPosX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->assistantPosY->Visible) { // assistantPosY ?>
    <div id="r_assistantPosY"<?= $Page->assistantPosY->rowAttributes() ?>>
        <label id="elh_tes_certificate_assistantPosY" for="x_assistantPosY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->assistantPosY->caption() ?><?= $Page->assistantPosY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->assistantPosY->cellAttributes() ?>>
<span id="el_tes_certificate_assistantPosY">
<input type="<?= $Page->assistantPosY->getInputTextType() ?>" name="x_assistantPosY" id="x_assistantPosY" data-table="tes_certificate" data-field="x_assistantPosY" value="<?= $Page->assistantPosY->EditValue ?>" size="4" maxlength="255" placeholder="<?= HtmlEncode($Page->assistantPosY->getPlaceHolder()) ?>"<?= $Page->assistantPosY->editAttributes() ?> aria-describedby="x_assistantPosY_help">
<?= $Page->assistantPosY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->assistantPosY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_tes_certificate_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_tes_certificate_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-control ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_schoolId"
        data-table="tes_certificate"
        data-field="x_schoolId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->schoolId->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_schoolId", selectId: "ftes_certificateedit_x_schoolId" };
    if (ftes_certificateedit.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_schoolId", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.tes_certificate.fields.schoolId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orientation->Visible) { // orientation ?>
    <div id="r_orientation"<?= $Page->orientation->rowAttributes() ?>>
        <label id="elh_tes_certificate_orientation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orientation->caption() ?><?= $Page->orientation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->orientation->cellAttributes() ?>>
<span id="el_tes_certificate_orientation">
<template id="tp_x_orientation">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="tes_certificate" data-field="x_orientation" name="x_orientation" id="x_orientation"<?= $Page->orientation->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_orientation" class="ew-item-list"></div>
<selection-list hidden
    id="x_orientation"
    name="x_orientation"
    value="<?= HtmlEncode($Page->orientation->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_orientation"
    data-bs-target="dsl_x_orientation"
    data-repeatcolumn="5"
    class="form-control<?= $Page->orientation->isInvalidClass() ?>"
    data-table="tes_certificate"
    data-field="x_orientation"
    data-value-separator="<?= $Page->orientation->displayValueSeparatorAttribute() ?>"
    <?= $Page->orientation->editAttributes() ?>></selection-list>
<?= $Page->orientation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orientation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->size->Visible) { // size ?>
    <div id="r_size"<?= $Page->size->rowAttributes() ?>>
        <label id="elh_tes_certificate_size" for="x_size" class="<?= $Page->LeftColumnClass ?>"><?= $Page->size->caption() ?><?= $Page->size->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->size->cellAttributes() ?>>
<span id="el_tes_certificate_size">
    <select
        id="x_size"
        name="x_size"
        class="form-select ew-select<?= $Page->size->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_size"
        data-table="tes_certificate"
        data-field="x_size"
        data-value-separator="<?= $Page->size->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->size->getPlaceHolder()) ?>"
        <?= $Page->size->editAttributes() ?>>
        <?= $Page->size->selectOptionListHtml("x_size") ?>
    </select>
    <?= $Page->size->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->size->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_size", selectId: "ftes_certificateedit_x_size" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_certificateedit.lists.size.lookupOptions.length) {
        options.data = { id: "x_size", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_size", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_certificate.fields.size.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
    <div id="r_martialArtId"<?= $Page->martialArtId->rowAttributes() ?>>
        <label id="elh_tes_certificate_martialArtId" for="x_martialArtId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->martialArtId->caption() ?><?= $Page->martialArtId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el_tes_certificate_martialArtId">
    <select
        id="x_martialArtId"
        name="x_martialArtId"
        class="form-select ew-select<?= $Page->martialArtId->isInvalidClass() ?>"
        data-select2-id="ftes_certificateedit_x_martialArtId"
        data-table="tes_certificate"
        data-field="x_martialArtId"
        data-value-separator="<?= $Page->martialArtId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->martialArtId->getPlaceHolder()) ?>"
        <?= $Page->martialArtId->editAttributes() ?>>
        <?= $Page->martialArtId->selectOptionListHtml("x_martialArtId") ?>
    </select>
    <?= $Page->martialArtId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->martialArtId->getErrorMessage() ?></div>
<?= $Page->martialArtId->Lookup->getParamTag($Page, "p_x_martialArtId") ?>
<script>
loadjs.ready("ftes_certificateedit", function() {
    var options = { name: "x_martialArtId", selectId: "ftes_certificateedit_x_martialArtId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_certificateedit.lists.martialArtId.lookupOptions.length) {
        options.data = { id: "x_martialArtId", form: "ftes_certificateedit" };
    } else {
        options.ajax = { id: "x_martialArtId", form: "ftes_certificateedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_certificate.fields.martialArtId.selectOptions);
    ew.createSelect(options);
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
    ew.addEventHandlers("tes_certificate");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
