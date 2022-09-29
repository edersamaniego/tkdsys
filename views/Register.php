<?php

namespace PHPMaker2022\school;

// Page object
$Register = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_users: currentTable } });
var currentForm, currentPageID;
var fregister;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fregister = new ew.Form("fregister", "register");
    currentPageID = ew.PAGE_ID = "register";
    currentForm = fregister;

    // Add fields
    var fields = currentTable.fields;
    fregister.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["lastName", [fields.lastName.visible && fields.lastName.required ? ew.Validators.required(fields.lastName.caption) : null], fields.lastName.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.username(fields._email.raw), ew.Validators.email], fields._email.isInvalid],
        ["c__password", [ew.Validators.required(ew.language.phrase("ConfirmPassword")), ew.Validators.mismatchPassword], fields._password.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null, ew.Validators.password(fields._password.raw)], fields._password.isInvalid]
    ]);

    // Form_CustomValidate
    fregister.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregister.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="school_users">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<div class="ew-register-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_school_users_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_school_users_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="school_users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_school_users_name">
<span<?= $Page->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->name->getDisplayValue($Page->name->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_name" data-hidden="1" name="x_name" id="x_name" value="<?= HtmlEncode($Page->name->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
    <div id="r_lastName"<?= $Page->lastName->rowAttributes() ?>>
        <label id="elh_school_users_lastName" for="x_lastName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastName->caption() ?><?= $Page->lastName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastName->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_school_users_lastName">
<input type="<?= $Page->lastName->getInputTextType() ?>" name="x_lastName" id="x_lastName" data-table="school_users" data-field="x_lastName" value="<?= $Page->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lastName->getPlaceHolder()) ?>"<?= $Page->lastName->editAttributes() ?> aria-describedby="x_lastName_help">
<?= $Page->lastName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_school_users_lastName">
<span<?= $Page->lastName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->lastName->getDisplayValue($Page->lastName->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_lastName" data-hidden="1" name="x_lastName" id="x_lastName" value="<?= HtmlEncode($Page->lastName->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_school_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_school_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="school_users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_school_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_email->getDisplayValue($Page->_email->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x__email" data-hidden="1" name="x__email" id="x__email" value="<?= HtmlEncode($Page->_email->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_school_users__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_school_users__password">
<div class="input-group">
    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-field="x__password" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_school_users__password">
<span<?= $Page->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_password->getDisplayValue($Page->_password->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="x__password" id="x__password" value="<?= HtmlEncode($Page->_password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r_c__password" class="row">
        <label id="elh_c_school_users__password" for="c__password" class="<?= $Page->LeftColumnClass ?>"><?= $Language->phrase("Confirm") ?> <?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_c_school_users__password">
<div class="input-group">
    <input type="password" name="c__password" id="c__password" autocomplete="new-password" data-field="x__password" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_c_school_users__password">
<span<?= $Page->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_password->getDisplayValue($Page->_password->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="c__password" id="c__password" value="<?= HtmlEncode($Page->_password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
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
    ew.addEventHandlers("school_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
