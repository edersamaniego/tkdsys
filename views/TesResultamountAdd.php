<?php

namespace PHPMaker2022\school;

// Page object
$TesResultamountAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_resultamount: currentTable } });
var currentForm, currentPageID;
var ftes_resultamountadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_resultamountadd = new ew.Form("ftes_resultamountadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ftes_resultamountadd;

    // Add fields
    var fields = currentTable.fields;
    ftes_resultamountadd.addFields([
        ["federationId", [fields.federationId.visible && fields.federationId.required ? ew.Validators.required(fields.federationId.caption) : null, ew.Validators.integer], fields.federationId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid],
        ["testId", [fields.testId.visible && fields.testId.required ? ew.Validators.required(fields.testId.caption) : null, ew.Validators.integer], fields.testId.isInvalid],
        ["sendingDate", [fields.sendingDate.visible && fields.sendingDate.required ? ew.Validators.required(fields.sendingDate.caption) : null, ew.Validators.datetime(fields.sendingDate.clientFormatPattern)], fields.sendingDate.isInvalid],
        ["paymentDate", [fields.paymentDate.visible && fields.paymentDate.required ? ew.Validators.required(fields.paymentDate.caption) : null, ew.Validators.datetime(fields.paymentDate.clientFormatPattern)], fields.paymentDate.isInvalid],
        ["printingDate", [fields.printingDate.visible && fields.printingDate.required ? ew.Validators.required(fields.printingDate.caption) : null, ew.Validators.datetime(fields.printingDate.clientFormatPattern)], fields.printingDate.isInvalid],
        ["shippedDate", [fields.shippedDate.visible && fields.shippedDate.required ? ew.Validators.required(fields.shippedDate.caption) : null, ew.Validators.datetime(fields.shippedDate.clientFormatPattern)], fields.shippedDate.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null, ew.Validators.integer], fields.status.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid],
        ["totalAmount", [fields.totalAmount.visible && fields.totalAmount.required ? ew.Validators.required(fields.totalAmount.caption) : null, ew.Validators.integer], fields.totalAmount.isInvalid],
        ["paymentId", [fields.paymentId.visible && fields.paymentId.required ? ew.Validators.required(fields.paymentId.caption) : null, ew.Validators.integer], fields.paymentId.isInvalid],
        ["totalValue", [fields.totalValue.visible && fields.totalValue.required ? ew.Validators.required(fields.totalValue.caption) : null, ew.Validators.float], fields.totalValue.isInvalid]
    ]);

    // Form_CustomValidate
    ftes_resultamountadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_resultamountadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ftes_resultamountadd");
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
<form name="ftes_resultamountadd" id="ftes_resultamountadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_resultamount">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->federationId->Visible) { // federationId ?>
    <div id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <label id="elh_tes_resultamount_federationId" for="x_federationId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationId->caption() ?><?= $Page->federationId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationId->cellAttributes() ?>>
<span id="el_tes_resultamount_federationId">
<input type="<?= $Page->federationId->getInputTextType() ?>" name="x_federationId" id="x_federationId" data-table="tes_resultamount" data-field="x_federationId" value="<?= $Page->federationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->federationId->getPlaceHolder()) ?>"<?= $Page->federationId->editAttributes() ?> aria-describedby="x_federationId_help">
<?= $Page->federationId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_tes_resultamount_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_tes_resultamount_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="ftes_resultamountadd_x_schoolId"
        data-table="tes_resultamount"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_resultamountadd", function() {
    var options = { name: "x_schoolId", selectId: "ftes_resultamountadd_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_resultamountadd.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "ftes_resultamountadd" };
    } else {
        options.ajax = { id: "x_schoolId", form: "ftes_resultamountadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_resultamount.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_tes_resultamount_schoolId">
<input type="<?= $Page->schoolId->getInputTextType() ?>" name="x_schoolId" id="x_schoolId" data-table="tes_resultamount" data-field="x_schoolId" value="<?= $Page->schoolId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"<?= $Page->schoolId->editAttributes() ?> aria-describedby="x_schoolId_help">
<?= $Page->schoolId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <div id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <label id="elh_tes_resultamount_testId" for="x_testId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testId->caption() ?><?= $Page->testId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_resultamount_testId">
<input type="<?= $Page->testId->getInputTextType() ?>" name="x_testId" id="x_testId" data-table="tes_resultamount" data-field="x_testId" value="<?= $Page->testId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->testId->getPlaceHolder()) ?>"<?= $Page->testId->editAttributes() ?> aria-describedby="x_testId_help">
<?= $Page->testId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sendingDate->Visible) { // sendingDate ?>
    <div id="r_sendingDate"<?= $Page->sendingDate->rowAttributes() ?>>
        <label id="elh_tes_resultamount_sendingDate" for="x_sendingDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sendingDate->caption() ?><?= $Page->sendingDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sendingDate->cellAttributes() ?>>
<span id="el_tes_resultamount_sendingDate">
<input type="<?= $Page->sendingDate->getInputTextType() ?>" name="x_sendingDate" id="x_sendingDate" data-table="tes_resultamount" data-field="x_sendingDate" value="<?= $Page->sendingDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->sendingDate->getPlaceHolder()) ?>"<?= $Page->sendingDate->editAttributes() ?> aria-describedby="x_sendingDate_help">
<?= $Page->sendingDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sendingDate->getErrorMessage() ?></div>
<?php if (!$Page->sendingDate->ReadOnly && !$Page->sendingDate->Disabled && !isset($Page->sendingDate->EditAttrs["readonly"]) && !isset($Page->sendingDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_resultamountadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_resultamountadd", "x_sendingDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
    <div id="r_paymentDate"<?= $Page->paymentDate->rowAttributes() ?>>
        <label id="elh_tes_resultamount_paymentDate" for="x_paymentDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentDate->caption() ?><?= $Page->paymentDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el_tes_resultamount_paymentDate">
<input type="<?= $Page->paymentDate->getInputTextType() ?>" name="x_paymentDate" id="x_paymentDate" data-table="tes_resultamount" data-field="x_paymentDate" value="<?= $Page->paymentDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->paymentDate->getPlaceHolder()) ?>"<?= $Page->paymentDate->editAttributes() ?> aria-describedby="x_paymentDate_help">
<?= $Page->paymentDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentDate->getErrorMessage() ?></div>
<?php if (!$Page->paymentDate->ReadOnly && !$Page->paymentDate->Disabled && !isset($Page->paymentDate->EditAttrs["readonly"]) && !isset($Page->paymentDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_resultamountadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_resultamountadd", "x_paymentDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->printingDate->Visible) { // printingDate ?>
    <div id="r_printingDate"<?= $Page->printingDate->rowAttributes() ?>>
        <label id="elh_tes_resultamount_printingDate" for="x_printingDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->printingDate->caption() ?><?= $Page->printingDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->printingDate->cellAttributes() ?>>
<span id="el_tes_resultamount_printingDate">
<input type="<?= $Page->printingDate->getInputTextType() ?>" name="x_printingDate" id="x_printingDate" data-table="tes_resultamount" data-field="x_printingDate" value="<?= $Page->printingDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->printingDate->getPlaceHolder()) ?>"<?= $Page->printingDate->editAttributes() ?> aria-describedby="x_printingDate_help">
<?= $Page->printingDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->printingDate->getErrorMessage() ?></div>
<?php if (!$Page->printingDate->ReadOnly && !$Page->printingDate->Disabled && !isset($Page->printingDate->EditAttrs["readonly"]) && !isset($Page->printingDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_resultamountadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_resultamountadd", "x_printingDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->shippedDate->Visible) { // shippedDate ?>
    <div id="r_shippedDate"<?= $Page->shippedDate->rowAttributes() ?>>
        <label id="elh_tes_resultamount_shippedDate" for="x_shippedDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->shippedDate->caption() ?><?= $Page->shippedDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->shippedDate->cellAttributes() ?>>
<span id="el_tes_resultamount_shippedDate">
<input type="<?= $Page->shippedDate->getInputTextType() ?>" name="x_shippedDate" id="x_shippedDate" data-table="tes_resultamount" data-field="x_shippedDate" value="<?= $Page->shippedDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->shippedDate->getPlaceHolder()) ?>"<?= $Page->shippedDate->editAttributes() ?> aria-describedby="x_shippedDate_help">
<?= $Page->shippedDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->shippedDate->getErrorMessage() ?></div>
<?php if (!$Page->shippedDate->ReadOnly && !$Page->shippedDate->Disabled && !isset($Page->shippedDate->EditAttrs["readonly"]) && !isset($Page->shippedDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_resultamountadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_resultamountadd", "x_shippedDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_tes_resultamount_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_tes_resultamount_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="tes_resultamount" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_tes_resultamount_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_tes_resultamount_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="tes_resultamount" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_tes_resultamount_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_tes_resultamount_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="tes_resultamount" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_resultamountadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_resultamountadd", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totalAmount->Visible) { // totalAmount ?>
    <div id="r_totalAmount"<?= $Page->totalAmount->rowAttributes() ?>>
        <label id="elh_tes_resultamount_totalAmount" for="x_totalAmount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totalAmount->caption() ?><?= $Page->totalAmount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totalAmount->cellAttributes() ?>>
<span id="el_tes_resultamount_totalAmount">
<input type="<?= $Page->totalAmount->getInputTextType() ?>" name="x_totalAmount" id="x_totalAmount" data-table="tes_resultamount" data-field="x_totalAmount" value="<?= $Page->totalAmount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totalAmount->getPlaceHolder()) ?>"<?= $Page->totalAmount->editAttributes() ?> aria-describedby="x_totalAmount_help">
<?= $Page->totalAmount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totalAmount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentId->Visible) { // paymentId ?>
    <div id="r_paymentId"<?= $Page->paymentId->rowAttributes() ?>>
        <label id="elh_tes_resultamount_paymentId" for="x_paymentId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentId->caption() ?><?= $Page->paymentId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentId->cellAttributes() ?>>
<span id="el_tes_resultamount_paymentId">
<input type="<?= $Page->paymentId->getInputTextType() ?>" name="x_paymentId" id="x_paymentId" data-table="tes_resultamount" data-field="x_paymentId" value="<?= $Page->paymentId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->paymentId->getPlaceHolder()) ?>"<?= $Page->paymentId->editAttributes() ?> aria-describedby="x_paymentId_help">
<?= $Page->paymentId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->paymentId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totalValue->Visible) { // totalValue ?>
    <div id="r_totalValue"<?= $Page->totalValue->rowAttributes() ?>>
        <label id="elh_tes_resultamount_totalValue" for="x_totalValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totalValue->caption() ?><?= $Page->totalValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totalValue->cellAttributes() ?>>
<span id="el_tes_resultamount_totalValue">
<input type="<?= $Page->totalValue->getInputTextType() ?>" name="x_totalValue" id="x_totalValue" data-table="tes_resultamount" data-field="x_totalValue" value="<?= $Page->totalValue->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totalValue->getPlaceHolder()) ?>"<?= $Page->totalValue->editAttributes() ?> aria-describedby="x_totalValue_help">
<?= $Page->totalValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totalValue->getErrorMessage() ?></div>
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
    ew.addEventHandlers("tes_resultamount");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
