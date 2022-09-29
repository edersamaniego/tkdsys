<?php

namespace PHPMaker2022\school;

// Page object
$FinCheckingaccountAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_checkingaccount: currentTable } });
var currentForm, currentPageID;
var ffin_checkingaccountadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_checkingaccountadd = new ew.Form("ffin_checkingaccountadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_checkingaccountadd;

    // Add fields
    var fields = currentTable.fields;
    ffin_checkingaccountadd.addFields([
        ["bank", [fields.bank.visible && fields.bank.required ? ew.Validators.required(fields.bank.caption) : null], fields.bank.isInvalid],
        ["responsable", [fields.responsable.visible && fields.responsable.required ? ew.Validators.required(fields.responsable.caption) : null], fields.responsable.isInvalid],
        ["balance", [fields.balance.visible && fields.balance.required ? ew.Validators.required(fields.balance.caption) : null, ew.Validators.float], fields.balance.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["telephone", [fields.telephone.visible && fields.telephone.required ? ew.Validators.required(fields.telephone.caption) : null], fields.telephone.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null], fields._userId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["organizationId", [fields.organizationId.visible && fields.organizationId.required ? ew.Validators.required(fields.organizationId.caption) : null], fields.organizationId.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_checkingaccountadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_checkingaccountadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_checkingaccountadd.lists._userId = <?= $Page->_userId->toClientList($Page) ?>;
    ffin_checkingaccountadd.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    ffin_checkingaccountadd.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    ffin_checkingaccountadd.lists.organizationId = <?= $Page->organizationId->toClientList($Page) ?>;
    loadjs.done("ffin_checkingaccountadd");
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
<form name="ffin_checkingaccountadd" id="ffin_checkingaccountadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_checkingaccount">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->bank->Visible) { // bank ?>
    <div id="r_bank"<?= $Page->bank->rowAttributes() ?>>
        <label id="elh_fin_checkingaccount_bank" for="x_bank" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bank->caption() ?><?= $Page->bank->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bank->cellAttributes() ?>>
<span id="el_fin_checkingaccount_bank">
<input type="<?= $Page->bank->getInputTextType() ?>" name="x_bank" id="x_bank" data-table="fin_checkingaccount" data-field="x_bank" value="<?= $Page->bank->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bank->getPlaceHolder()) ?>"<?= $Page->bank->editAttributes() ?> aria-describedby="x_bank_help">
<?= $Page->bank->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bank->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->responsable->Visible) { // responsable ?>
    <div id="r_responsable"<?= $Page->responsable->rowAttributes() ?>>
        <label id="elh_fin_checkingaccount_responsable" for="x_responsable" class="<?= $Page->LeftColumnClass ?>"><?= $Page->responsable->caption() ?><?= $Page->responsable->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->responsable->cellAttributes() ?>>
<span id="el_fin_checkingaccount_responsable">
<input type="<?= $Page->responsable->getInputTextType() ?>" name="x_responsable" id="x_responsable" data-table="fin_checkingaccount" data-field="x_responsable" value="<?= $Page->responsable->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->responsable->getPlaceHolder()) ?>"<?= $Page->responsable->editAttributes() ?> aria-describedby="x_responsable_help">
<?= $Page->responsable->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->responsable->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
    <div id="r_balance"<?= $Page->balance->rowAttributes() ?>>
        <label id="elh_fin_checkingaccount_balance" for="x_balance" class="<?= $Page->LeftColumnClass ?>"><?= $Page->balance->caption() ?><?= $Page->balance->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->balance->cellAttributes() ?>>
<span id="el_fin_checkingaccount_balance">
<input type="<?= $Page->balance->getInputTextType() ?>" name="x_balance" id="x_balance" data-table="fin_checkingaccount" data-field="x_balance" value="<?= $Page->balance->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->balance->getPlaceHolder()) ?>"<?= $Page->balance->editAttributes() ?> aria-describedby="x_balance_help">
<?= $Page->balance->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->balance->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_fin_checkingaccount_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_checkingaccount_obs">
<textarea data-table="fin_checkingaccount" data-field="x_obs" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telephone->Visible) { // telephone ?>
    <div id="r_telephone"<?= $Page->telephone->rowAttributes() ?>>
        <label id="elh_fin_checkingaccount_telephone" for="x_telephone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telephone->caption() ?><?= $Page->telephone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telephone->cellAttributes() ?>>
<span id="el_fin_checkingaccount_telephone">
<input type="<?= $Page->telephone->getInputTextType() ?>" name="x_telephone" id="x_telephone" data-table="fin_checkingaccount" data-field="x_telephone" value="<?= $Page->telephone->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->telephone->getPlaceHolder()) ?>"<?= $Page->telephone->editAttributes() ?> aria-describedby="x_telephone_help">
<?= $Page->telephone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telephone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("fin_debit", explode(",", $Page->getCurrentDetailTable())) && $fin_debit->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_debit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinDebitGrid.php" ?>
<?php } ?>
<?php
    if (in_array("fin_credit", explode(",", $Page->getCurrentDetailTable())) && $fin_credit->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_credit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinCreditGrid.php" ?>
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
    ew.addEventHandlers("fin_checkingaccount");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
