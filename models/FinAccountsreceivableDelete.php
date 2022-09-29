<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinAccountsreceivableDelete extends FinAccountsreceivable
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_accountsreceivable';

    // Page object name
    public $PageObjName = "FinAccountsreceivableDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (fin_accountsreceivable)
        if (!isset($GLOBALS["fin_accountsreceivable"]) || get_class($GLOBALS["fin_accountsreceivable"]) == PROJECT_NAMESPACE . "fin_accountsreceivable") {
            $GLOBALS["fin_accountsreceivable"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fin_accountsreceivable');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("fin_accountsreceivable");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->issue->setVisibility();
        $this->due->setVisibility();
        $this->historic->Visible = false;
        $this->income->setVisibility();
        $this->status->setVisibility();
        $this->obs->Visible = false;
        $this->value->setVisibility();
        $this->deferred->Visible = false;
        $this->amountInstallments->Visible = false;
        $this->totalValueDeferred->Visible = false;
        $this->firstdateInstallment->Visible = false;
        $this->actualInstallment->Visible = false;
        $this->orderId->setVisibility();
        $this->balance->setVisibility();
        $this->_userId->Visible = false;
        $this->debtorId->setVisibility();
        $this->accountFather->Visible = false;
        $this->schoolId->Visible = false;
        $this->lastUserId->Visible = false;
        $this->_register->Visible = false;
        $this->lastUpdate->Visible = false;
        $this->licenseId->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->income);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->deferred);
        $this->setupLookupOptions($this->orderId);
        $this->setupLookupOptions($this->_userId);
        $this->setupLookupOptions($this->debtorId);
        $this->setupLookupOptions($this->accountFather);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->lastUserId);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("FinAccountsreceivableList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Check if valid User ID
        $conn = $this->getConnection();
        $sql = $this->getSql($this->CurrentFilter);
        $rows = $conn->fetchAllAssociative($sql);
        $res = true;
        foreach ($rows as $row) {
            $this->loadRowValues($row);
            if (!$this->showOptionLink("delete")) {
                $userIdMsg = $Language->phrase("NoDeletePermission");
                $this->setFailureMessage($userIdMsg);
                $res = false;
                break;
            }
        }
        if (!$res) {
            $this->terminate("FinAccountsreceivableList"); // Return to list
            return;
        }

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("FinAccountsreceivableList"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAll(FetchMode::ASSOCIATIVE);
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
        $this->id->setDbValue($row['id']);
        $this->issue->setDbValue($row['issue']);
        $this->due->setDbValue($row['due']);
        $this->historic->setDbValue($row['historic']);
        $this->income->setDbValue($row['income']);
        if (array_key_exists('EV__income', $row)) {
            $this->income->VirtualValue = $row['EV__income']; // Set up virtual field value
        } else {
            $this->income->VirtualValue = ""; // Clear value
        }
        $this->status->setDbValue($row['status']);
        $this->obs->setDbValue($row['obs']);
        $this->value->setDbValue($row['value']);
        $this->deferred->setDbValue($row['deferred']);
        $this->amountInstallments->setDbValue($row['amountInstallments']);
        $this->totalValueDeferred->setDbValue($row['totalValueDeferred']);
        $this->firstdateInstallment->setDbValue($row['firstdateInstallment']);
        $this->actualInstallment->setDbValue($row['actualInstallment']);
        $this->orderId->setDbValue($row['orderId']);
        $this->balance->setDbValue($row['balance']);
        $this->_userId->setDbValue($row['userId']);
        $this->debtorId->setDbValue($row['debtorId']);
        $this->accountFather->setDbValue($row['accountFather']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->_register->setDbValue($row['register']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->licenseId->setDbValue($row['licenseId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['issue'] = $this->issue->DefaultValue;
        $row['due'] = $this->due->DefaultValue;
        $row['historic'] = $this->historic->DefaultValue;
        $row['income'] = $this->income->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['value'] = $this->value->DefaultValue;
        $row['deferred'] = $this->deferred->DefaultValue;
        $row['amountInstallments'] = $this->amountInstallments->DefaultValue;
        $row['totalValueDeferred'] = $this->totalValueDeferred->DefaultValue;
        $row['firstdateInstallment'] = $this->firstdateInstallment->DefaultValue;
        $row['actualInstallment'] = $this->actualInstallment->DefaultValue;
        $row['orderId'] = $this->orderId->DefaultValue;
        $row['balance'] = $this->balance->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['debtorId'] = $this->debtorId->DefaultValue;
        $row['accountFather'] = $this->accountFather->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['lastUserId'] = $this->lastUserId->DefaultValue;
        $row['register'] = $this->_register->DefaultValue;
        $row['lastUpdate'] = $this->lastUpdate->DefaultValue;
        $row['licenseId'] = $this->licenseId->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // issue

        // due

        // historic

        // income

        // status

        // obs

        // value

        // deferred

        // amountInstallments

        // totalValueDeferred

        // firstdateInstallment

        // actualInstallment

        // orderId

        // balance

        // userId

        // debtorId

        // accountFather

        // schoolId

        // lastUserId

        // register

        // lastUpdate

        // licenseId

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // issue
            $this->issue->ViewValue = $this->issue->CurrentValue;
            $this->issue->ViewValue = FormatDateTime($this->issue->ViewValue, $this->issue->formatPattern());
            $this->issue->ViewCustomAttributes = "";

            // due
            $this->due->ViewValue = $this->due->CurrentValue;
            $this->due->ViewValue = FormatDateTime($this->due->ViewValue, $this->due->formatPattern());
            $this->due->ViewCustomAttributes = "";

            // historic
            $this->historic->ViewValue = $this->historic->CurrentValue;
            $this->historic->ViewCustomAttributes = "";

            // income
            if ($this->income->VirtualValue != "") {
                $this->income->ViewValue = $this->income->VirtualValue;
            } else {
                $curVal = strval($this->income->CurrentValue);
                if ($curVal != "") {
                    $this->income->ViewValue = $this->income->lookupCacheOption($curVal);
                    if ($this->income->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->income->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->income->Lookup->renderViewRow($rswrk[0]);
                            $this->income->ViewValue = $this->income->displayValue($arwrk);
                        } else {
                            $this->income->ViewValue = FormatNumber($this->income->CurrentValue, $this->income->formatPattern());
                        }
                    }
                } else {
                    $this->income->ViewValue = null;
                }
            }
            $this->income->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // value
            $this->value->ViewValue = $this->value->CurrentValue;
            $this->value->ViewValue = FormatNumber($this->value->ViewValue, $this->value->formatPattern());
            $this->value->ViewCustomAttributes = "";

            // deferred
            if (ConvertToBool($this->deferred->CurrentValue)) {
                $this->deferred->ViewValue = $this->deferred->tagCaption(1) != "" ? $this->deferred->tagCaption(1) : "Yes";
            } else {
                $this->deferred->ViewValue = $this->deferred->tagCaption(2) != "" ? $this->deferred->tagCaption(2) : "No";
            }
            $this->deferred->ViewCustomAttributes = "";

            // amountInstallments
            $this->amountInstallments->ViewValue = $this->amountInstallments->CurrentValue;
            $this->amountInstallments->ViewValue = FormatNumber($this->amountInstallments->ViewValue, $this->amountInstallments->formatPattern());
            $this->amountInstallments->ViewCustomAttributes = "";

            // totalValueDeferred
            $this->totalValueDeferred->ViewValue = $this->totalValueDeferred->CurrentValue;
            $this->totalValueDeferred->ViewValue = FormatNumber($this->totalValueDeferred->ViewValue, $this->totalValueDeferred->formatPattern());
            $this->totalValueDeferred->ViewCustomAttributes = "";

            // firstdateInstallment
            $this->firstdateInstallment->ViewValue = $this->firstdateInstallment->CurrentValue;
            $this->firstdateInstallment->ViewValue = FormatDateTime($this->firstdateInstallment->ViewValue, $this->firstdateInstallment->formatPattern());
            $this->firstdateInstallment->ViewCustomAttributes = "";

            // actualInstallment
            $this->actualInstallment->ViewValue = $this->actualInstallment->CurrentValue;
            $this->actualInstallment->ViewValue = FormatNumber($this->actualInstallment->ViewValue, $this->actualInstallment->formatPattern());
            $this->actualInstallment->ViewCustomAttributes = "";

            // orderId
            $this->orderId->ViewValue = $this->orderId->CurrentValue;
            $curVal = strval($this->orderId->CurrentValue);
            if ($curVal != "") {
                $this->orderId->ViewValue = $this->orderId->lookupCacheOption($curVal);
                if ($this->orderId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->orderId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->orderId->Lookup->renderViewRow($rswrk[0]);
                        $this->orderId->ViewValue = $this->orderId->displayValue($arwrk);
                    } else {
                        $this->orderId->ViewValue = FormatNumber($this->orderId->CurrentValue, $this->orderId->formatPattern());
                    }
                }
            } else {
                $this->orderId->ViewValue = null;
            }
            $this->orderId->ViewCustomAttributes = "";

            // balance
            $this->balance->ViewValue = $this->balance->CurrentValue;
            $this->balance->ViewValue = FormatNumber($this->balance->ViewValue, $this->balance->formatPattern());
            $this->balance->ViewCustomAttributes = "";

            // userId
            $this->_userId->ViewValue = $this->_userId->CurrentValue;
            $curVal = strval($this->_userId->CurrentValue);
            if ($curVal != "") {
                $this->_userId->ViewValue = $this->_userId->lookupCacheOption($curVal);
                if ($this->_userId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->_userId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_userId->Lookup->renderViewRow($rswrk[0]);
                        $this->_userId->ViewValue = $this->_userId->displayValue($arwrk);
                    } else {
                        $this->_userId->ViewValue = FormatNumber($this->_userId->CurrentValue, $this->_userId->formatPattern());
                    }
                }
            } else {
                $this->_userId->ViewValue = null;
            }
            $this->_userId->ViewCustomAttributes = "";

            // debtorId
            $this->debtorId->ViewValue = $this->debtorId->CurrentValue;
            $curVal = strval($this->debtorId->CurrentValue);
            if ($curVal != "") {
                $this->debtorId->ViewValue = $this->debtorId->lookupCacheOption($curVal);
                if ($this->debtorId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->debtorId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->debtorId->Lookup->renderViewRow($rswrk[0]);
                        $this->debtorId->ViewValue = $this->debtorId->displayValue($arwrk);
                    } else {
                        $this->debtorId->ViewValue = FormatNumber($this->debtorId->CurrentValue, $this->debtorId->formatPattern());
                    }
                }
            } else {
                $this->debtorId->ViewValue = null;
            }
            $this->debtorId->ViewCustomAttributes = "";

            // accountFather
            $this->accountFather->ViewValue = $this->accountFather->CurrentValue;
            $curVal = strval($this->accountFather->CurrentValue);
            if ($curVal != "") {
                $this->accountFather->ViewValue = $this->accountFather->lookupCacheOption($curVal);
                if ($this->accountFather->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->accountFather->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->accountFather->Lookup->renderViewRow($rswrk[0]);
                        $this->accountFather->ViewValue = $this->accountFather->displayValue($arwrk);
                    } else {
                        $this->accountFather->ViewValue = FormatNumber($this->accountFather->CurrentValue, $this->accountFather->formatPattern());
                    }
                }
            } else {
                $this->accountFather->ViewValue = null;
            }
            $this->accountFather->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
            $curVal = strval($this->schoolId->CurrentValue);
            if ($curVal != "") {
                $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
                if ($this->schoolId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->schoolId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->schoolId->Lookup->renderViewRow($rswrk[0]);
                        $this->schoolId->ViewValue = $this->schoolId->displayValue($arwrk);
                    } else {
                        $this->schoolId->ViewValue = FormatNumber($this->schoolId->CurrentValue, $this->schoolId->formatPattern());
                    }
                }
            } else {
                $this->schoolId->ViewValue = null;
            }
            $this->schoolId->ViewCustomAttributes = "";

            // lastUserId
            $this->lastUserId->ViewValue = $this->lastUserId->CurrentValue;
            $curVal = strval($this->lastUserId->CurrentValue);
            if ($curVal != "") {
                $this->lastUserId->ViewValue = $this->lastUserId->lookupCacheOption($curVal);
                if ($this->lastUserId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->lastUserId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->lastUserId->Lookup->renderViewRow($rswrk[0]);
                        $this->lastUserId->ViewValue = $this->lastUserId->displayValue($arwrk);
                    } else {
                        $this->lastUserId->ViewValue = FormatNumber($this->lastUserId->CurrentValue, $this->lastUserId->formatPattern());
                    }
                }
            } else {
                $this->lastUserId->ViewValue = null;
            }
            $this->lastUserId->ViewCustomAttributes = "";

            // register
            $this->_register->ViewValue = $this->_register->CurrentValue;
            $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
            $this->_register->ViewCustomAttributes = "";

            // lastUpdate
            $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
            $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
            $this->lastUpdate->ViewCustomAttributes = "";

            // licenseId
            $this->licenseId->ViewValue = $this->licenseId->CurrentValue;
            $this->licenseId->ViewValue = FormatNumber($this->licenseId->ViewValue, $this->licenseId->formatPattern());
            $this->licenseId->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";
            $this->issue->TooltipValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";
            $this->due->TooltipValue = "";

            // income
            $this->income->LinkCustomAttributes = "";
            $this->income->HrefValue = "";
            $this->income->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";
            $this->value->TooltipValue = "";

            // orderId
            $this->orderId->LinkCustomAttributes = "";
            $this->orderId->HrefValue = "";
            $this->orderId->TooltipValue = "";

            // balance
            $this->balance->LinkCustomAttributes = "";
            $this->balance->HrefValue = "";
            $this->balance->TooltipValue = "";

            // debtorId
            $this->debtorId->LinkCustomAttributes = "";
            $this->debtorId->HrefValue = "";
            $this->debtorId->TooltipValue = "";

            // licenseId
            $this->licenseId->LinkCustomAttributes = "";
            $this->licenseId->HrefValue = "";
            $this->licenseId->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteSomeRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->schoolId->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FinAccountsreceivableList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_income":
                    break;
                case "x_status":
                    break;
                case "x_deferred":
                    break;
                case "x_orderId":
                    break;
                case "x__userId":
                    break;
                case "x_debtorId":
                    break;
                case "x_accountFather":
                    break;
                case "x_schoolId":
                    break;
                case "x_lastUserId":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }
}
