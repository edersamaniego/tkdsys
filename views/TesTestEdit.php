<?php

namespace PHPMaker2022\school;

// Page object
$TesTestEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test: currentTable } });
var currentForm, currentPageID;
var ftes_testedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_testedit = new ew.Form("ftes_testedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ftes_testedit;

    // Add fields
    var fields = currentTable.fields;
    ftes_testedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["testCity", [fields.testCity.visible && fields.testCity.required ? ew.Validators.required(fields.testCity.caption) : null], fields.testCity.isInvalid],
        ["martialartsId", [fields.martialartsId.visible && fields.martialartsId.required ? ew.Validators.required(fields.martialartsId.caption) : null], fields.martialartsId.isInvalid],
        ["instructorId", [fields.instructorId.visible && fields.instructorId.required ? ew.Validators.required(fields.instructorId.caption) : null, ew.Validators.integer], fields.instructorId.isInvalid],
        ["auxiliarInstructorId", [fields.auxiliarInstructorId.visible && fields.auxiliarInstructorId.required ? ew.Validators.required(fields.auxiliarInstructorId.caption) : null, ew.Validators.integer], fields.auxiliarInstructorId.isInvalid],
        ["testDate", [fields.testDate.visible && fields.testDate.required ? ew.Validators.required(fields.testDate.caption) : null, ew.Validators.datetime(fields.testDate.clientFormatPattern)], fields.testDate.isInvalid],
        ["testTime", [fields.testTime.visible && fields.testTime.required ? ew.Validators.required(fields.testTime.caption) : null, ew.Validators.time(fields.testTime.clientFormatPattern)], fields.testTime.isInvalid],
        ["ceremonyDate", [fields.ceremonyDate.visible && fields.ceremonyDate.required ? ew.Validators.required(fields.ceremonyDate.caption) : null, ew.Validators.datetime(fields.ceremonyDate.clientFormatPattern)], fields.ceremonyDate.isInvalid],
        ["testTypeId", [fields.testTypeId.visible && fields.testTypeId.required ? ew.Validators.required(fields.testTypeId.caption) : null], fields.testTypeId.isInvalid],
        ["testStatusId", [fields.testStatusId.visible && fields.testStatusId.required ? ew.Validators.required(fields.testStatusId.caption) : null, ew.Validators.integer], fields.testStatusId.isInvalid],
        ["judgeId", [fields.judgeId.visible && fields.judgeId.required ? ew.Validators.required(fields.judgeId.caption) : null], fields.judgeId.isInvalid],
        ["certificateId", [fields.certificateId.visible && fields.certificateId.required ? ew.Validators.required(fields.certificateId.caption) : null], fields.certificateId.isInvalid]
    ]);

    // Form_CustomValidate
    ftes_testedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_testedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftes_testedit.lists.testCity = <?= $Page->testCity->toClientList($Page) ?>;
    ftes_testedit.lists.martialartsId = <?= $Page->martialartsId->toClientList($Page) ?>;
    ftes_testedit.lists.instructorId = <?= $Page->instructorId->toClientList($Page) ?>;
    ftes_testedit.lists.auxiliarInstructorId = <?= $Page->auxiliarInstructorId->toClientList($Page) ?>;
    ftes_testedit.lists.testTypeId = <?= $Page->testTypeId->toClientList($Page) ?>;
    ftes_testedit.lists.testStatusId = <?= $Page->testStatusId->toClientList($Page) ?>;
    ftes_testedit.lists.judgeId = <?= $Page->judgeId->toClientList($Page) ?>;
    ftes_testedit.lists.certificateId = <?= $Page->certificateId->toClientList($Page) ?>;
    loadjs.done("ftes_testedit");
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
<form name="ftes_testedit" id="ftes_testedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_tes_test_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_test_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="tes_test" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_tes_test_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_tes_test_description">
<textarea data-table="tes_test" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testCity->Visible) { // testCity ?>
    <div id="r_testCity"<?= $Page->testCity->rowAttributes() ?>>
        <label id="elh_tes_test_testCity" for="x_testCity" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testCity->caption() ?><?= $Page->testCity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testCity->cellAttributes() ?>>
<span id="el_tes_test_testCity">
    <select
        id="x_testCity"
        name="x_testCity"
        class="form-control ew-select<?= $Page->testCity->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_testCity"
        data-table="tes_test"
        data-field="x_testCity"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->testCity->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->testCity->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->testCity->getPlaceHolder()) ?>"
        <?= $Page->testCity->editAttributes() ?>>
        <?= $Page->testCity->selectOptionListHtml("x_testCity") ?>
    </select>
    <?= $Page->testCity->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->testCity->getErrorMessage() ?></div>
<?= $Page->testCity->Lookup->getParamTag($Page, "p_x_testCity") ?>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_testCity", selectId: "ftes_testedit_x_testCity" };
    if (ftes_testedit.lists.testCity.lookupOptions.length) {
        options.data = { id: "x_testCity", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_testCity", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.tes_test.fields.testCity.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->martialartsId->Visible) { // martialartsId ?>
    <div id="r_martialartsId"<?= $Page->martialartsId->rowAttributes() ?>>
        <label id="elh_tes_test_martialartsId" for="x_martialartsId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->martialartsId->caption() ?><?= $Page->martialartsId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->martialartsId->cellAttributes() ?>>
<span id="el_tes_test_martialartsId">
<?php $Page->martialartsId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_martialartsId"
        name="x_martialartsId"
        class="form-select ew-select<?= $Page->martialartsId->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_martialartsId"
        data-table="tes_test"
        data-field="x_martialartsId"
        data-value-separator="<?= $Page->martialartsId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->martialartsId->getPlaceHolder()) ?>"
        <?= $Page->martialartsId->editAttributes() ?>>
        <?= $Page->martialartsId->selectOptionListHtml("x_martialartsId") ?>
    </select>
    <?= $Page->martialartsId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->martialartsId->getErrorMessage() ?></div>
<?= $Page->martialartsId->Lookup->getParamTag($Page, "p_x_martialartsId") ?>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_martialartsId", selectId: "ftes_testedit_x_martialartsId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_testedit.lists.martialartsId.lookupOptions.length) {
        options.data = { id: "x_martialartsId", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_martialartsId", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_test.fields.martialartsId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorId->Visible) { // instructorId ?>
    <div id="r_instructorId"<?= $Page->instructorId->rowAttributes() ?>>
        <label id="elh_tes_test_instructorId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorId->caption() ?><?= $Page->instructorId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorId->cellAttributes() ?>>
<span id="el_tes_test_instructorId">
    <select
        id="x_instructorId"
        name="x_instructorId"
        class="form-control ew-select<?= $Page->instructorId->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_instructorId"
        data-table="tes_test"
        data-field="x_instructorId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->instructorId->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->instructorId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->instructorId->getPlaceHolder()) ?>"
        <?= $Page->instructorId->editAttributes() ?>>
        <?= $Page->instructorId->selectOptionListHtml("x_instructorId") ?>
    </select>
    <?= $Page->instructorId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->instructorId->getErrorMessage() ?></div>
<?= $Page->instructorId->Lookup->getParamTag($Page, "p_x_instructorId") ?>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_instructorId", selectId: "ftes_testedit_x_instructorId" };
    if (ftes_testedit.lists.instructorId.lookupOptions.length) {
        options.data = { id: "x_instructorId", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_instructorId", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.tes_test.fields.instructorId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->auxiliarInstructorId->Visible) { // auxiliarInstructorId ?>
    <div id="r_auxiliarInstructorId"<?= $Page->auxiliarInstructorId->rowAttributes() ?>>
        <label id="elh_tes_test_auxiliarInstructorId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->auxiliarInstructorId->caption() ?><?= $Page->auxiliarInstructorId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->auxiliarInstructorId->cellAttributes() ?>>
<span id="el_tes_test_auxiliarInstructorId">
    <select
        id="x_auxiliarInstructorId"
        name="x_auxiliarInstructorId"
        class="form-control ew-select<?= $Page->auxiliarInstructorId->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_auxiliarInstructorId"
        data-table="tes_test"
        data-field="x_auxiliarInstructorId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->auxiliarInstructorId->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->auxiliarInstructorId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->auxiliarInstructorId->getPlaceHolder()) ?>"
        <?= $Page->auxiliarInstructorId->editAttributes() ?>>
        <?= $Page->auxiliarInstructorId->selectOptionListHtml("x_auxiliarInstructorId") ?>
    </select>
    <?= $Page->auxiliarInstructorId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->auxiliarInstructorId->getErrorMessage() ?></div>
<?= $Page->auxiliarInstructorId->Lookup->getParamTag($Page, "p_x_auxiliarInstructorId") ?>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_auxiliarInstructorId", selectId: "ftes_testedit_x_auxiliarInstructorId" };
    if (ftes_testedit.lists.auxiliarInstructorId.lookupOptions.length) {
        options.data = { id: "x_auxiliarInstructorId", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_auxiliarInstructorId", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.tes_test.fields.auxiliarInstructorId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
    <div id="r_testDate"<?= $Page->testDate->rowAttributes() ?>>
        <label id="elh_tes_test_testDate" for="x_testDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testDate->caption() ?><?= $Page->testDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testDate->cellAttributes() ?>>
<span id="el_tes_test_testDate">
<input type="<?= $Page->testDate->getInputTextType() ?>" name="x_testDate" id="x_testDate" data-table="tes_test" data-field="x_testDate" value="<?= $Page->testDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->testDate->getPlaceHolder()) ?>"<?= $Page->testDate->editAttributes() ?> aria-describedby="x_testDate_help">
<?= $Page->testDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testDate->getErrorMessage() ?></div>
<?php if (!$Page->testDate->ReadOnly && !$Page->testDate->Disabled && !isset($Page->testDate->EditAttrs["readonly"]) && !isset($Page->testDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_testedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_testedit", "x_testDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testTime->Visible) { // testTime ?>
    <div id="r_testTime"<?= $Page->testTime->rowAttributes() ?>>
        <label id="elh_tes_test_testTime" for="x_testTime" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testTime->caption() ?><?= $Page->testTime->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testTime->cellAttributes() ?>>
<span id="el_tes_test_testTime">
<input type="<?= $Page->testTime->getInputTextType() ?>" name="x_testTime" id="x_testTime" data-table="tes_test" data-field="x_testTime" value="<?= $Page->testTime->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->testTime->getPlaceHolder()) ?>"<?= $Page->testTime->editAttributes() ?> aria-describedby="x_testTime_help">
<?= $Page->testTime->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testTime->getErrorMessage() ?></div>
<?php if (!$Page->testTime->ReadOnly && !$Page->testTime->Disabled && !isset($Page->testTime->EditAttrs["readonly"]) && !isset($Page->testTime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_testedit", "timepicker"], () => ew.createTimePicker("ftes_testedit", "x_testTime", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(4) ?>" })));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
    <div id="r_ceremonyDate"<?= $Page->ceremonyDate->rowAttributes() ?>>
        <label id="elh_tes_test_ceremonyDate" for="x_ceremonyDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ceremonyDate->caption() ?><?= $Page->ceremonyDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ceremonyDate->cellAttributes() ?>>
<span id="el_tes_test_ceremonyDate">
<input type="<?= $Page->ceremonyDate->getInputTextType() ?>" name="x_ceremonyDate" id="x_ceremonyDate" data-table="tes_test" data-field="x_ceremonyDate" value="<?= $Page->ceremonyDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->ceremonyDate->getPlaceHolder()) ?>"<?= $Page->ceremonyDate->editAttributes() ?> aria-describedby="x_ceremonyDate_help">
<?= $Page->ceremonyDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ceremonyDate->getErrorMessage() ?></div>
<?php if (!$Page->ceremonyDate->ReadOnly && !$Page->ceremonyDate->Disabled && !isset($Page->ceremonyDate->EditAttrs["readonly"]) && !isset($Page->ceremonyDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_testedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_testedit", "x_ceremonyDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testTypeId->Visible) { // testTypeId ?>
    <div id="r_testTypeId"<?= $Page->testTypeId->rowAttributes() ?>>
        <label id="elh_tes_test_testTypeId" for="x_testTypeId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testTypeId->caption() ?><?= $Page->testTypeId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testTypeId->cellAttributes() ?>>
<span id="el_tes_test_testTypeId">
    <select
        id="x_testTypeId"
        name="x_testTypeId"
        class="form-select ew-select<?= $Page->testTypeId->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_testTypeId"
        data-table="tes_test"
        data-field="x_testTypeId"
        data-value-separator="<?= $Page->testTypeId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->testTypeId->getPlaceHolder()) ?>"
        <?= $Page->testTypeId->editAttributes() ?>>
        <?= $Page->testTypeId->selectOptionListHtml("x_testTypeId") ?>
    </select>
    <?= $Page->testTypeId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->testTypeId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_testTypeId", selectId: "ftes_testedit_x_testTypeId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_testedit.lists.testTypeId.lookupOptions.length) {
        options.data = { id: "x_testTypeId", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_testTypeId", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_test.fields.testTypeId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testStatusId->Visible) { // testStatusId ?>
    <div id="r_testStatusId"<?= $Page->testStatusId->rowAttributes() ?>>
        <label id="elh_tes_test_testStatusId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testStatusId->caption() ?><?= $Page->testStatusId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testStatusId->cellAttributes() ?>>
<span id="el_tes_test_testStatusId">
<?php
$onchange = $Page->testStatusId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->testStatusId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->testStatusId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_testStatusId" class="ew-auto-suggest">
    <input type="<?= $Page->testStatusId->getInputTextType() ?>" class="form-control" name="sv_x_testStatusId" id="sv_x_testStatusId" value="<?= RemoveHtml($Page->testStatusId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->testStatusId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->testStatusId->getPlaceHolder()) ?>"<?= $Page->testStatusId->editAttributes() ?> aria-describedby="x_testStatusId_help">
</span>
<selection-list hidden class="form-control" data-table="tes_test" data-field="x_testStatusId" data-input="sv_x_testStatusId" data-value-separator="<?= $Page->testStatusId->displayValueSeparatorAttribute() ?>" name="x_testStatusId" id="x_testStatusId" value="<?= HtmlEncode($Page->testStatusId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->testStatusId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testStatusId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_testedit", function() {
    ftes_testedit.createAutoSuggest(Object.assign({"id":"x_testStatusId","forceSelect":false}, ew.vars.tables.tes_test.fields.testStatusId.autoSuggestOptions));
});
</script>
<?= $Page->testStatusId->Lookup->getParamTag($Page, "p_x_testStatusId") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->judgeId->Visible) { // judgeId ?>
    <div id="r_judgeId"<?= $Page->judgeId->rowAttributes() ?>>
        <label id="elh_tes_test_judgeId" for="x_judgeId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->judgeId->caption() ?><?= $Page->judgeId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->judgeId->cellAttributes() ?>>
<span id="el_tes_test_judgeId">
    <select
        id="x_judgeId"
        name="x_judgeId"
        class="form-control ew-select<?= $Page->judgeId->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_judgeId"
        data-table="tes_test"
        data-field="x_judgeId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->judgeId->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->judgeId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->judgeId->getPlaceHolder()) ?>"
        <?= $Page->judgeId->editAttributes() ?>>
        <?= $Page->judgeId->selectOptionListHtml("x_judgeId") ?>
    </select>
    <?= $Page->judgeId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->judgeId->getErrorMessage() ?></div>
<?= $Page->judgeId->Lookup->getParamTag($Page, "p_x_judgeId") ?>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_judgeId", selectId: "ftes_testedit_x_judgeId" };
    if (ftes_testedit.lists.judgeId.lookupOptions.length) {
        options.data = { id: "x_judgeId", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_judgeId", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.tes_test.fields.judgeId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->certificateId->Visible) { // certificateId ?>
    <div id="r_certificateId"<?= $Page->certificateId->rowAttributes() ?>>
        <label id="elh_tes_test_certificateId" for="x_certificateId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->certificateId->caption() ?><?= $Page->certificateId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->certificateId->cellAttributes() ?>>
<span id="el_tes_test_certificateId">
    <select
        id="x_certificateId"
        name="x_certificateId"
        class="form-select ew-select<?= $Page->certificateId->isInvalidClass() ?>"
        data-select2-id="ftes_testedit_x_certificateId"
        data-table="tes_test"
        data-field="x_certificateId"
        data-value-separator="<?= $Page->certificateId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->certificateId->getPlaceHolder()) ?>"
        <?= $Page->certificateId->editAttributes() ?>>
        <?= $Page->certificateId->selectOptionListHtml("x_certificateId") ?>
    </select>
    <?= $Page->certificateId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->certificateId->getErrorMessage() ?></div>
<?= $Page->certificateId->Lookup->getParamTag($Page, "p_x_certificateId") ?>
<script>
loadjs.ready("ftes_testedit", function() {
    var options = { name: "x_certificateId", selectId: "ftes_testedit_x_certificateId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_testedit.lists.certificateId.lookupOptions.length) {
        options.data = { id: "x_certificateId", form: "ftes_testedit" };
    } else {
        options.ajax = { id: "x_certificateId", form: "ftes_testedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_test.fields.certificateId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav<?= $Page->DetailPages->containerClasses() ?>" id="details_Page"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navClasses() ?>" role="tablist"><!-- .nav -->
<?php
    if (in_array("tes_candidate", explode(",", $Page->getCurrentDetailTable())) && $tes_candidate->DetailEdit) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("tes_candidate") ?><?= $Page->DetailPages->activeClasses("tes_candidate") ?>" data-bs-target="#tab_tes_candidate" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_tes_candidate" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("tes_candidate")) ?>"><?= $Language->tablePhrase("tes_candidate", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("view_test_aproveds", explode(",", $Page->getCurrentDetailTable())) && $view_test_aproveds->DetailEdit) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("view_test_aproveds") ?><?= $Page->DetailPages->activeClasses("view_test_aproveds") ?>" data-bs-target="#tab_view_test_aproveds" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_view_test_aproveds" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("view_test_aproveds")) ?>"><?= $Language->tablePhrase("view_test_aproveds", "TblCaption") ?></button></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="<?= $Page->DetailPages->tabContentClasses() ?>"><!-- .tab-content -->
<?php
    if (in_array("tes_candidate", explode(",", $Page->getCurrentDetailTable())) && $tes_candidate->DetailEdit) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("tes_candidate") ?><?= $Page->DetailPages->activeClasses("tes_candidate") ?>" id="tab_tes_candidate" role="tabpanel"><!-- page* -->
<?php include_once "TesCandidateGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("view_test_aproveds", explode(",", $Page->getCurrentDetailTable())) && $view_test_aproveds->DetailEdit) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("view_test_aproveds") ?><?= $Page->DetailPages->activeClasses("view_test_aproveds") ?>" id="tab_view_test_aproveds" role="tabpanel"><!-- page* -->
<?php include_once "ViewTestAprovedsGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("tes_test");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
