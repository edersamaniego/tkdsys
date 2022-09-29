<?php

namespace PHPMaker2022\school;

// Page object
$TesTestJudgeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test_judge: currentTable } });
var currentForm, currentPageID;
var ftes_test_judgeadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_test_judgeadd = new ew.Form("ftes_test_judgeadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ftes_test_judgeadd;

    // Add fields
    var fields = currentTable.fields;
    ftes_test_judgeadd.addFields([
        ["judgeMemberId", [fields.judgeMemberId.visible && fields.judgeMemberId.required ? ew.Validators.required(fields.judgeMemberId.caption) : null, ew.Validators.integer], fields.judgeMemberId.isInvalid],
        ["testId", [fields.testId.visible && fields.testId.required ? ew.Validators.required(fields.testId.caption) : null, ew.Validators.integer], fields.testId.isInvalid],
        ["rankId", [fields.rankId.visible && fields.rankId.required ? ew.Validators.required(fields.rankId.caption) : null, ew.Validators.integer], fields.rankId.isInvalid],
        ["instructorRegister", [fields.instructorRegister.visible && fields.instructorRegister.required ? ew.Validators.required(fields.instructorRegister.caption) : null], fields.instructorRegister.isInvalid],
        ["federationRegister", [fields.federationRegister.visible && fields.federationRegister.required ? ew.Validators.required(fields.federationRegister.caption) : null], fields.federationRegister.isInvalid],
        ["memberCityId", [fields.memberCityId.visible && fields.memberCityId.required ? ew.Validators.required(fields.memberCityId.caption) : null, ew.Validators.integer], fields.memberCityId.isInvalid]
    ]);

    // Form_CustomValidate
    ftes_test_judgeadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_test_judgeadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ftes_test_judgeadd");
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
<form name="ftes_test_judgeadd" id="ftes_test_judgeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test_judge">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->judgeMemberId->Visible) { // judgeMemberId ?>
    <div id="r_judgeMemberId"<?= $Page->judgeMemberId->rowAttributes() ?>>
        <label id="elh_tes_test_judge_judgeMemberId" for="x_judgeMemberId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->judgeMemberId->caption() ?><?= $Page->judgeMemberId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->judgeMemberId->cellAttributes() ?>>
<span id="el_tes_test_judge_judgeMemberId">
<input type="<?= $Page->judgeMemberId->getInputTextType() ?>" name="x_judgeMemberId" id="x_judgeMemberId" data-table="tes_test_judge" data-field="x_judgeMemberId" value="<?= $Page->judgeMemberId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->judgeMemberId->getPlaceHolder()) ?>"<?= $Page->judgeMemberId->editAttributes() ?> aria-describedby="x_judgeMemberId_help">
<?= $Page->judgeMemberId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->judgeMemberId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <div id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <label id="elh_tes_test_judge_testId" for="x_testId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testId->caption() ?><?= $Page->testId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_test_judge_testId">
<input type="<?= $Page->testId->getInputTextType() ?>" name="x_testId" id="x_testId" data-table="tes_test_judge" data-field="x_testId" value="<?= $Page->testId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->testId->getPlaceHolder()) ?>"<?= $Page->testId->editAttributes() ?> aria-describedby="x_testId_help">
<?= $Page->testId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
    <div id="r_rankId"<?= $Page->rankId->rowAttributes() ?>>
        <label id="elh_tes_test_judge_rankId" for="x_rankId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rankId->caption() ?><?= $Page->rankId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rankId->cellAttributes() ?>>
<span id="el_tes_test_judge_rankId">
<input type="<?= $Page->rankId->getInputTextType() ?>" name="x_rankId" id="x_rankId" data-table="tes_test_judge" data-field="x_rankId" value="<?= $Page->rankId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rankId->getPlaceHolder()) ?>"<?= $Page->rankId->editAttributes() ?> aria-describedby="x_rankId_help">
<?= $Page->rankId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rankId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorRegister->Visible) { // instructorRegister ?>
    <div id="r_instructorRegister"<?= $Page->instructorRegister->rowAttributes() ?>>
        <label id="elh_tes_test_judge_instructorRegister" for="x_instructorRegister" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorRegister->caption() ?><?= $Page->instructorRegister->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorRegister->cellAttributes() ?>>
<span id="el_tes_test_judge_instructorRegister">
<input type="<?= $Page->instructorRegister->getInputTextType() ?>" name="x_instructorRegister" id="x_instructorRegister" data-table="tes_test_judge" data-field="x_instructorRegister" value="<?= $Page->instructorRegister->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->instructorRegister->getPlaceHolder()) ?>"<?= $Page->instructorRegister->editAttributes() ?> aria-describedby="x_instructorRegister_help">
<?= $Page->instructorRegister->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->instructorRegister->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
    <div id="r_federationRegister"<?= $Page->federationRegister->rowAttributes() ?>>
        <label id="elh_tes_test_judge_federationRegister" for="x_federationRegister" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationRegister->caption() ?><?= $Page->federationRegister->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el_tes_test_judge_federationRegister">
<input type="<?= $Page->federationRegister->getInputTextType() ?>" name="x_federationRegister" id="x_federationRegister" data-table="tes_test_judge" data-field="x_federationRegister" value="<?= $Page->federationRegister->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->federationRegister->getPlaceHolder()) ?>"<?= $Page->federationRegister->editAttributes() ?> aria-describedby="x_federationRegister_help">
<?= $Page->federationRegister->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationRegister->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->memberCityId->Visible) { // memberCityId ?>
    <div id="r_memberCityId"<?= $Page->memberCityId->rowAttributes() ?>>
        <label id="elh_tes_test_judge_memberCityId" for="x_memberCityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->memberCityId->caption() ?><?= $Page->memberCityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->memberCityId->cellAttributes() ?>>
<span id="el_tes_test_judge_memberCityId">
<input type="<?= $Page->memberCityId->getInputTextType() ?>" name="x_memberCityId" id="x_memberCityId" data-table="tes_test_judge" data-field="x_memberCityId" value="<?= $Page->memberCityId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->memberCityId->getPlaceHolder()) ?>"<?= $Page->memberCityId->editAttributes() ?> aria-describedby="x_memberCityId_help">
<?= $Page->memberCityId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->memberCityId->getErrorMessage() ?></div>
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
    ew.addEventHandlers("tes_test_judge");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
