<?php

namespace PHPMaker2022\school;

// Page object
$SchoolUsersEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_users: currentTable } });
var currentForm, currentPageID;
var fschool_usersedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_usersedit = new ew.Form("fschool_usersedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fschool_usersedit;

    // Add fields
    var fields = currentTable.fields;
    fschool_usersedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["lastName", [fields.lastName.visible && fields.lastName.required ? ew.Validators.required(fields.lastName.caption) : null], fields.lastName.isInvalid],
        ["schoolIdMaster", [fields.schoolIdMaster.visible && fields.schoolIdMaster.required ? ew.Validators.required(fields.schoolIdMaster.caption) : null, ew.Validators.integer], fields.schoolIdMaster.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["_login", [fields._login.visible && fields._login.required ? ew.Validators.required(fields._login.caption) : null], fields._login.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["activateEmail", [fields.activateEmail.visible && fields.activateEmail.required ? ew.Validators.required(fields.activateEmail.caption) : null, ew.Validators.integer], fields.activateEmail.isInvalid],
        ["profileField", [fields.profileField.visible && fields.profileField.required ? ew.Validators.required(fields.profileField.caption) : null], fields.profileField.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null], fields.createDate.isInvalid],
        ["level", [fields.level.visible && fields.level.required ? ew.Validators.required(fields.level.caption) : null], fields.level.isInvalid]
    ]);

    // Form_CustomValidate
    fschool_usersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_usersedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fschool_usersedit.lists.schoolIdMaster = <?= $Page->schoolIdMaster->toClientList($Page) ?>;
    fschool_usersedit.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    fschool_usersedit.lists.createUserId = <?= $Page->createUserId->toClientList($Page) ?>;
    fschool_usersedit.lists.level = <?= $Page->level->toClientList($Page) ?>;
    loadjs.done("fschool_usersedit");
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
<form name="fschool_usersedit" id="fschool_usersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_users">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fed_school") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_school">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->schoolId->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_school_users_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_school_users_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_school_users_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_school_users_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="school_users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
    <div id="r_lastName"<?= $Page->lastName->rowAttributes() ?>>
        <label id="elh_school_users_lastName" for="x_lastName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastName->caption() ?><?= $Page->lastName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastName->cellAttributes() ?>>
<span id="el_school_users_lastName">
<input type="<?= $Page->lastName->getInputTextType() ?>" name="x_lastName" id="x_lastName" data-table="school_users" data-field="x_lastName" value="<?= $Page->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lastName->getPlaceHolder()) ?>"<?= $Page->lastName->editAttributes() ?> aria-describedby="x_lastName_help">
<?= $Page->lastName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolIdMaster->Visible) { // schoolIdMaster ?>
    <div id="r_schoolIdMaster"<?= $Page->schoolIdMaster->rowAttributes() ?>>
        <label id="elh_school_users_schoolIdMaster" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolIdMaster->caption() ?><?= $Page->schoolIdMaster->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolIdMaster->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<?php if (SameString($Page->schoolId->CurrentValue, CurrentUserID())) { ?>
    <span<?= $Page->schoolIdMaster->viewAttributes() ?>>
    <span class="form-control-plaintext"><?= $Page->schoolIdMaster->getDisplayValue($Page->schoolIdMaster->EditValue) ?></span></span>
    <input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="x_schoolIdMaster" id="x_schoolIdMaster" value="<?= HtmlEncode($Page->schoolIdMaster->CurrentValue) ?>">
<?php } else { ?>
<span id="el_school_users_schoolIdMaster">
    <select
        id="x_schoolIdMaster"
        name="x_schoolIdMaster"
        class="form-select ew-select<?= $Page->schoolIdMaster->isInvalidClass() ?>"
        data-select2-id="fschool_usersedit_x_schoolIdMaster"
        data-table="school_users"
        data-field="x_schoolIdMaster"
        data-value-separator="<?= $Page->schoolIdMaster->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolIdMaster->getPlaceHolder()) ?>"
        <?= $Page->schoolIdMaster->editAttributes() ?>>
        <?= $Page->schoolIdMaster->selectOptionListHtml("x_schoolIdMaster") ?>
    </select>
    <?= $Page->schoolIdMaster->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolIdMaster->getErrorMessage() ?></div>
<?= $Page->schoolIdMaster->Lookup->getParamTag($Page, "p_x_schoolIdMaster") ?>
<script>
loadjs.ready("fschool_usersedit", function() {
    var options = { name: "x_schoolIdMaster", selectId: "fschool_usersedit_x_schoolIdMaster" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersedit.lists.schoolIdMaster.lookupOptions.length) {
        options.data = { id: "x_schoolIdMaster", form: "fschool_usersedit" };
    } else {
        options.ajax = { id: "x_schoolIdMaster", form: "fschool_usersedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolIdMaster.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_school_users_schoolIdMaster">
<?php
$onchange = $Page->schoolIdMaster->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->schoolIdMaster->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->schoolIdMaster->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_schoolIdMaster" class="ew-auto-suggest">
    <input type="<?= $Page->schoolIdMaster->getInputTextType() ?>" class="form-control" name="sv_x_schoolIdMaster" id="sv_x_schoolIdMaster" value="<?= RemoveHtml($Page->schoolIdMaster->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolIdMaster->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->schoolIdMaster->getPlaceHolder()) ?>"<?= $Page->schoolIdMaster->editAttributes() ?> aria-describedby="x_schoolIdMaster_help">
</span>
<selection-list hidden class="form-control" data-table="school_users" data-field="x_schoolIdMaster" data-input="sv_x_schoolIdMaster" data-value-separator="<?= $Page->schoolIdMaster->displayValueSeparatorAttribute() ?>" name="x_schoolIdMaster" id="x_schoolIdMaster" value="<?= HtmlEncode($Page->schoolIdMaster->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->schoolIdMaster->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->schoolIdMaster->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_usersedit", function() {
    fschool_usersedit.createAutoSuggest(Object.assign({"id":"x_schoolIdMaster","forceSelect":false}, ew.vars.tables.school_users.fields.schoolIdMaster.autoSuggestOptions));
});
</script>
<?= $Page->schoolIdMaster->Lookup->getParamTag($Page, "p_x_schoolIdMaster") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_school_users_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if ($Page->schoolId->getSessionValue() != "") { ?>
<span<?= $Page->schoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->schoolId->getDisplayValue($Page->schoolId->ViewValue) ?></span></span>
<input type="hidden" id="x_schoolId" name="x_schoolId" value="<?= HtmlEncode($Page->schoolId->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("edit")) { // Non system admin ?>
<span id="el_school_users_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersedit_x_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("fschool_usersedit", function() {
    var options = { name: "x_schoolId", selectId: "fschool_usersedit_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersedit.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "fschool_usersedit" };
    } else {
        options.ajax = { id: "x_schoolId", form: "fschool_usersedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_school_users_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersedit_x_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("fschool_usersedit", function() {
    var options = { name: "x_schoolId", selectId: "fschool_usersedit_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersedit.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "fschool_usersedit" };
    } else {
        options.ajax = { id: "x_schoolId", form: "fschool_usersedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <div id="r__login"<?= $Page->_login->rowAttributes() ?>>
        <label id="elh_school_users__login" for="x__login" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_login->caption() ?><?= $Page->_login->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_login->cellAttributes() ?>>
<span id="el_school_users__login">
<input type="<?= $Page->_login->getInputTextType() ?>" name="x__login" id="x__login" data-table="school_users" data-field="x__login" value="<?= $Page->_login->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_login->getPlaceHolder()) ?>"<?= $Page->_login->editAttributes() ?> aria-describedby="x__login_help">
<?= $Page->_login->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_login->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_school_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_school_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="school_users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activateEmail->Visible) { // activateEmail ?>
    <div id="r_activateEmail"<?= $Page->activateEmail->rowAttributes() ?>>
        <label id="elh_school_users_activateEmail" for="x_activateEmail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activateEmail->caption() ?><?= $Page->activateEmail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activateEmail->cellAttributes() ?>>
<span id="el_school_users_activateEmail">
<input type="<?= $Page->activateEmail->getInputTextType() ?>" name="x_activateEmail" id="x_activateEmail" data-table="school_users" data-field="x_activateEmail" value="<?= $Page->activateEmail->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->activateEmail->getPlaceHolder()) ?>"<?= $Page->activateEmail->editAttributes() ?> aria-describedby="x_activateEmail_help">
<?= $Page->activateEmail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->activateEmail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->profileField->Visible) { // profileField ?>
    <div id="r_profileField"<?= $Page->profileField->rowAttributes() ?>>
        <label id="elh_school_users_profileField" for="x_profileField" class="<?= $Page->LeftColumnClass ?>"><?= $Page->profileField->caption() ?><?= $Page->profileField->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->profileField->cellAttributes() ?>>
<span id="el_school_users_profileField">
<textarea data-table="school_users" data-field="x_profileField" name="x_profileField" id="x_profileField" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->profileField->getPlaceHolder()) ?>"<?= $Page->profileField->editAttributes() ?> aria-describedby="x_profileField_help"><?= $Page->profileField->EditValue ?></textarea>
<?= $Page->profileField->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->profileField->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_school_users__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_school_users__password">
<div class="input-group">
    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
    <div id="r_level"<?= $Page->level->rowAttributes() ?>>
        <label id="elh_school_users_level" for="x_level" class="<?= $Page->LeftColumnClass ?>"><?= $Page->level->caption() ?><?= $Page->level->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_school_users_level">
<span class="form-control-plaintext"><?= $Page->level->getDisplayValue($Page->level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_school_users_level">
    <select
        id="x_level"
        name="x_level"
        class="form-select ew-select<?= $Page->level->isInvalidClass() ?>"
        data-select2-id="fschool_usersedit_x_level"
        data-table="school_users"
        data-field="x_level"
        data-value-separator="<?= $Page->level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->level->getPlaceHolder()) ?>"
        <?= $Page->level->editAttributes() ?>>
        <?= $Page->level->selectOptionListHtml("x_level") ?>
    </select>
    <?= $Page->level->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->level->getErrorMessage() ?></div>
<?= $Page->level->Lookup->getParamTag($Page, "p_x_level") ?>
<script>
loadjs.ready("fschool_usersedit", function() {
    var options = { name: "x_level", selectId: "fschool_usersedit_x_level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersedit.lists.level.lookupOptions.length) {
        options.data = { id: "x_level", form: "fschool_usersedit" };
    } else {
        options.ajax = { id: "x_level", form: "fschool_usersedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
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
    ew.addEventHandlers("school_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
