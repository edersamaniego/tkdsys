<?php

namespace PHPMaker2022\school;

// Page object
$FedFilesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_files: currentTable } });
var currentForm, currentPageID;
var ffed_filesadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_filesadd = new ew.Form("ffed_filesadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_filesadd;

    // Add fields
    var fields = currentTable.fields;
    ffed_filesadd.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["thumbs", [fields.thumbs.visible && fields.thumbs.required ? ew.Validators.fileRequired(fields.thumbs.caption) : null], fields.thumbs.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["link", [fields.link.visible && fields.link.required ? ew.Validators.required(fields.link.caption) : null], fields.link.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["category", [fields.category.visible && fields.category.required ? ew.Validators.required(fields.category.caption) : null], fields.category.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_filesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_filesadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_filesadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    ffed_filesadd.lists.category = <?= $Page->category->toClientList($Page) ?>;
    ffed_filesadd.lists.type = <?= $Page->type->toClientList($Page) ?>;
    loadjs.done("ffed_filesadd");
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
<form name="ffed_filesadd" id="ffed_filesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_files">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_fed_files_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_fed_files_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="fed_files" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->thumbs->Visible) { // thumbs ?>
    <div id="r_thumbs"<?= $Page->thumbs->rowAttributes() ?>>
        <label id="elh_fed_files_thumbs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->thumbs->caption() ?><?= $Page->thumbs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->thumbs->cellAttributes() ?>>
<span id="el_fed_files_thumbs">
<div id="fd_x_thumbs" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->thumbs->title() ?>" data-table="fed_files" data-field="x_thumbs" name="x_thumbs" id="x_thumbs" lang="<?= CurrentLanguageID() ?>"<?= $Page->thumbs->editAttributes() ?> aria-describedby="x_thumbs_help"<?= ($Page->thumbs->ReadOnly || $Page->thumbs->Disabled) ? " disabled" : "" ?>>
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
        <label id="elh_fed_files_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_fed_files_description">
<textarea data-table="fed_files" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
    <div id="r_link"<?= $Page->link->rowAttributes() ?>>
        <label id="elh_fed_files_link" for="x_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->link->caption() ?><?= $Page->link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->link->cellAttributes() ?>>
<span id="el_fed_files_link">
<input type="<?= $Page->link->getInputTextType() ?>" name="x_link" id="x_link" data-table="fed_files" data-field="x_link" value="<?= $Page->link->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->link->getPlaceHolder()) ?>"<?= $Page->link->editAttributes() ?> aria-describedby="x_link_help">
<?= $Page->link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_fed_files_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_fed_files_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_files" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
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
    data-table="fed_files"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->category->Visible) { // category ?>
    <div id="r_category"<?= $Page->category->rowAttributes() ?>>
        <label id="elh_fed_files_category" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category->caption() ?><?= $Page->category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category->cellAttributes() ?>>
<span id="el_fed_files_category">
    <select
        id="x_category[]"
        name="x_category[]"
        class="form-select ew-select<?= $Page->category->isInvalidClass() ?>"
        data-select2-id="ffed_filesadd_x_category[]"
        data-table="fed_files"
        data-field="x_category"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->category->getPlaceHolder()) ?>"
        <?= $Page->category->editAttributes() ?>>
        <?= $Page->category->selectOptionListHtml("x_category[]") ?>
    </select>
    <?= $Page->category->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->category->getErrorMessage() ?></div>
<?= $Page->category->Lookup->getParamTag($Page, "p_x_category") ?>
<script>
loadjs.ready("ffed_filesadd", function() {
    var options = { name: "x_category[]", selectId: "ffed_filesadd_x_category[]" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 5;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    el.dataset.dropdown = options.dropdown;
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple fed_files-x_category-dropdown";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_filesadd.lists.category.lookupOptions.length) {
        options.data = { id: "x_category[]", form: "ffed_filesadd" };
    } else {
        options.ajax = { id: "x_category[]", form: "ffed_filesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_files.fields.category.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type"<?= $Page->type->rowAttributes() ?>>
        <label id="elh_fed_files_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span id="el_fed_files_type">
    <select
        id="x_type[]"
        name="x_type[]"
        class="form-select ew-select<?= $Page->type->isInvalidClass() ?>"
        data-select2-id="ffed_filesadd_x_type[]"
        data-table="fed_files"
        data-field="x_type"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"
        <?= $Page->type->editAttributes() ?>>
        <?= $Page->type->selectOptionListHtml("x_type[]") ?>
    </select>
    <?= $Page->type->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
<?= $Page->type->Lookup->getParamTag($Page, "p_x_type") ?>
<script>
loadjs.ready("ffed_filesadd", function() {
    var options = { name: "x_type[]", selectId: "ffed_filesadd_x_type[]" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 5;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    el.dataset.dropdown = options.dropdown;
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple fed_files-x_type-dropdown";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_filesadd.lists.type.lookupOptions.length) {
        options.data = { id: "x_type[]", form: "ffed_filesadd" };
    } else {
        options.ajax = { id: "x_type[]", form: "ffed_filesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_files.fields.type.selectOptions);
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
    ew.addEventHandlers("fed_files");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
