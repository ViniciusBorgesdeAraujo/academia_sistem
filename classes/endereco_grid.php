<?php
namespace PHPMaker2020\sistema;

/**
 * Page class
 */
class endereco_grid extends endereco
{

	// Page ID
	public $PageID = "grid";

	// Project ID
	public $ProjectID = "{448C0B4B-C32A-40EF-8151-41E96F03E813}";

	// Table name
	public $TableName = 'endereco';

	// Page object name
	public $PageObjName = "endereco_grid";

	// Grid form hidden field names
	public $FormName = "fenderecogrid";
	public $FormActionName = "k_action";
	public $FormKeyName = "k_key";
	public $FormOldKeyName = "k_oldkey";
	public $FormBlankRowName = "k_blankrow";
	public $FormKeyCountName = "key_count";

	// Page URLs
	public $AddUrl;
	public $EditUrl;
	public $CopyUrl;
	public $DeleteUrl;
	public $ViewUrl;
	public $ListUrl;

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken;

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading != "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading != "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
		return $url;
	}

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = TRUE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message != "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fas fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage != "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fas fa-exclamation"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage != "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fas fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage != "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fas fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = [];

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message != "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage != "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage != "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage != "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header != "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer != "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(Config("TOKEN_NAME")) === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn(Post(Config("TOKEN_NAME")), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = Config("CREATE_TOKEN_FUNC"); // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $DashboardReport;
		global $UserTable;

		// Check token
		$this->CheckToken = Config("CHECK_TOKEN");

		// Initialize
		$this->FormActionName .= "_" . $this->FormName;
		$this->FormKeyName .= "_" . $this->FormName;
		$this->FormOldKeyName .= "_" . $this->FormName;
		$this->FormBlankRowName .= "_" . $this->FormName;
		$this->FormKeyCountName .= "_" . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (endereco)
		if (!isset($GLOBALS["endereco"]) || get_class($GLOBALS["endereco"]) == PROJECT_NAMESPACE . "endereco") {
			$GLOBALS["endereco"] = &$this;

			// $GLOBALS["MasterTable"] = &$GLOBALS["Table"];
			// if (!isset($GLOBALS["Table"]))
			// 	$GLOBALS["Table"] = &$GLOBALS["endereco"];

		}
		$this->AddUrl = "enderecoadd.php";

		// Table object (pessoa)
		if (!isset($GLOBALS['pessoa']))
			$GLOBALS['pessoa'] = new pessoa();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'grid');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'endereco');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = $this->getConnection();

		// User table object (pessoa)
		$UserTable = $UserTable ?: new pessoa();

		// List options
		$this->ListOptions = new ListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		if (!$this->OtherOptions)
			$this->OtherOptions = new ListOptionsArray();
		$this->OtherOptions["addedit"] = new ListOptions("div");
		$this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Export
		global $endereco;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($endereco);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url === "")
			return;
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url != "") {
			if (!Config("DEBUG") && ob_get_length())
				ob_end_clean();
			SaveDebugMessage();
			AddHeader("Location", $url);
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = [];
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
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
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									Config("API_FIELD_NAME") . "=" . $fld->Param . "&" .
									Config("API_KEY_NAME") . "=" . rawurlencode($this->getRecordKeyValue($ar)))); //*** need to add this? API may not be in the same folder
								$row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									"fn=" . Encrypt($fld->physicalUploadPath() . $val)));
								$row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
							} else { // Multiple files
								$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
								$ar = [];
								foreach ($files as $file) {
									$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
										Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
										"fn=" . Encrypt($fld->physicalUploadPath() . $file)));
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
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
			$key .= @$ar['idendereco'];
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
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->idendereco->Visible = FALSE;
	}

	// Lookup data
	public function lookup()
	{
		global $Language, $Security;
		if (!isset($Language))
			$Language = new Language(Config("LANGUAGE_FOLDER"), Post("language", ""));

		// Set up API request
		if (!ValidApiRequest())
			return FALSE;
		$this->setupApiSecurity();

		// Get lookup object
		$fieldName = Post("field");
		if (!array_key_exists($fieldName, $this->fields))
			return FALSE;
		$lookupField = $this->fields[$fieldName];
		$lookup = $lookupField->Lookup;
		if ($lookup === NULL)
			return FALSE;
		$tbl = $lookup->getTable();
		if (!$Security->allowLookup(Config("PROJECT_ID") . $tbl->TableName)) // Lookup permission
			return FALSE;

		// Get lookup parameters
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Param("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
			$lookup->FilterFields = []; // Skip parent fields if any
			$lookup->FilterValues[] = $keys; // Lookup values
			$pageSize = -1; // Show all records
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect != "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter != "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy != "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson($this); // Use settings from current page
	}

	// Set up API security
	public function setupApiSecurity()
	{
		global $Security;

		// Setup security for API request
		if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
		$Security->loadCurrentUserLevel(Config("PROJECT_ID") . $this->TableName);
		if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
		$Security->UserID_Loading();
		$Security->loadUserID();
		$Security->UserID_Loaded();
	}

	// Class variables
	public $ListOptions; // List options
	public $ExportOptions; // Export options
	public $SearchOptions; // Search options
	public $OtherOptions; // Other options
	public $FilterOptions; // Filter options
	public $ImportOptions; // Import options
	public $ListActions; // List actions
	public $SelectedCount = 0;
	public $SelectedIndex = 0;
	public $ShowOtherOptions = FALSE;
	public $DisplayRecords = 10;
	public $StartRecord;
	public $StopRecord;
	public $TotalRecords = 0;
	public $RecordRange = 10;
	public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
	public $DefaultSearchWhere = ""; // Default search WHERE clause
	public $SearchWhere = ""; // Search WHERE clause
	public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
	public $SearchRowCount = 0; // For extended search
	public $SearchColumnCount = 0; // For extended search
	public $SearchFieldsPerRow = 1; // For extended search
	public $RecordCount = 0; // Record count
	public $EditRowCount;
	public $StartRowCount = 1;
	public $RowCount = 0;
	public $Attrs = []; // Row attributes and cell attributes
	public $RowIndex = 0; // Row index
	public $KeyCount = 0; // Key count
	public $RowAction = ""; // Row action
	public $RowOldKey = ""; // Row old key (for copy)
	public $MultiColumnClass = "col-sm";
	public $MultiColumnEditClass = "w-100";
	public $DbMasterFilter = ""; // Master filter
	public $DbDetailFilter = ""; // Detail filter
	public $MasterRecordExists;
	public $MultiSelectKey;
	public $Command;
	public $RestoreSearch = FALSE;
	public $DetailPages;
	public $OldRecordset;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SearchError;

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (ValidApiRequest()) { // API request
			$this->setupApiSecurity(); // Set up API Security
		} else {
			$Security = new AdvancedSecurity();
			if (IsPasswordExpired())
				$this->terminate(GetUrl("changepwd.php"));
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canList()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				$this->terminate(GetUrl("index.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
				if (strval($Security->currentUserID()) == "") {
					$this->setFailureMessage(DeniedMessage()); // Set no permission
					$this->terminate(GetUrl("enderecolist.php"));
					return;
				}
			}
		}

		// Update last accessed time
		if ($UserProfile->isValidUser(CurrentUserName(), session_id())) {
		} else {
			Write($Language->phrase("UserProfileCorrupted"));
			$this->terminate();
		}

		// Get grid add count
		$gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->setupListOptions();
		$this->idendereco->Visible = FALSE;
		$this->idacademia->setVisibility();
		$this->idpessoa->setVisibility();
		$this->CEP->setVisibility();
		$this->UF->setVisibility();
		$this->Cidade->setVisibility();
		$this->Bairro->setVisibility();
		$this->Rua->setVisibility();
		$this->Numero->setVisibility();
		$this->Complemento->setVisibility();
		$this->hideFieldsForAddEdit();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up master detail parameters
		$this->setupMasterParms();

		// Setup other options
		$this->setupOtherOptions();

		// Set up lookup cache
		$this->setupLookupOptions($this->idacademia);
		$this->setupLookupOptions($this->idpessoa);

		// Search filters
		$srchAdvanced = ""; // Advanced search filter
		$srchBasic = ""; // Basic search filter
		$filter = "";

		// Get command
		$this->Command = strtolower(Get("cmd"));
		if ($this->isPageRequest()) { // Validate request

			// Set up records per page
			$this->setupDisplayRecords();

			// Handle reset command
			$this->resetCmd();

			// Hide list options
			if ($this->isExport()) {
				$this->ListOptions->hideAllOptions(["sequence"]);
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->isGridAdd() || $this->isGridEdit()) {
				$this->ListOptions->hideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->isGridAdd() || $this->isGridEdit()) {
					$item = $this->ListOptions["griddelete"];
					if ($item)
						$item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->setupSortOrder();
		}

		// Restore display records
		if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
			$this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecords = 10; // Load default
			$this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
		}

		// Load Sorting Order
		if ($this->Command != "json")
			$this->loadSortOrder();

		// Build filter
		$filter = "";
		if (!$Security->canList())
			$filter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter

		// Add master User ID filter
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			if ($this->getCurrentMasterTable() == "academia")
				$this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "academia"); // Add master User ID filter
			if ($this->getCurrentMasterTable() == "pessoa")
				$this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "pessoa"); // Add master User ID filter
		}
		AddFilter($filter, $this->DbDetailFilter);
		AddFilter($filter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "academia") {
			global $academia;
			$rsmaster = $academia->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("academialist.php"); // Return to master page
			} else {
				$academia->loadListRowValues($rsmaster);
				$academia->RowType = ROWTYPE_MASTER; // Master row
				$academia->renderListRow();
				$rsmaster->close();
			}
		}

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "pessoa") {
			global $pessoa;
			$rsmaster = $pessoa->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("pessoalist.php"); // Return to master page
			} else {
				$pessoa->loadListRowValues($rsmaster);
				$pessoa->RowType = ROWTYPE_MASTER; // Master row
				$pessoa->renderListRow();
				$rsmaster->close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSql = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $filter;
		} else {
			$this->setSessionWhere($filter);
			$this->CurrentFilter = "";
		}
		if ($this->isGridAdd()) {
			if ($this->CurrentMode == "copy") {
				$selectLimit = $this->UseSelectLimit;
				if ($selectLimit) {
					$this->TotalRecords = $this->listRecordCount();
					$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
				} else {
					if ($this->Recordset = $this->loadRecordset())
						$this->TotalRecords = $this->Recordset->RecordCount();
				}
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->TotalRecords;
			} else {
				$this->CurrentFilter = "0=1";
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->GridAddRowCount;
			}
			$this->TotalRecords = $this->DisplayRecords;
			$this->StopRecord = $this->DisplayRecords;
		} else {
			$selectLimit = $this->UseSelectLimit;
			if ($selectLimit) {
				$this->TotalRecords = $this->listRecordCount();
			} else {
				if ($this->Recordset = $this->loadRecordset())
					$this->TotalRecords = $this->Recordset->RecordCount();
			}
			$this->StartRecord = 1;
			$this->DisplayRecords = $this->TotalRecords; // Display all records
			if ($selectLimit)
				$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
		}

		// Normal return
		if (IsApi()) {
			$rows = $this->getRecordsFromRecordset($this->Recordset);
			$this->Recordset->close();
			WriteJson(["success" => TRUE, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
			$this->terminate(TRUE);
		}

		// Set up pager
		$this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
	}

	// Set up number of records displayed per page
	protected function setupDisplayRecords()
	{
		$wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
		if ($wrk != "") {
			if (is_numeric($wrk)) {
				$this->DisplayRecords = (int)$wrk;
			} else {
				if (SameText($wrk, "all")) { // Display all records
					$this->DisplayRecords = -1;
				} else {
					$this->DisplayRecords = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecords); // Save to Session

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Exit inline mode
	protected function clearInlineMode()
	{
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	protected function gridAddMode()
	{
		$this->CurrentAction = "gridadd";
		$_SESSION[SESSION_INLINE_MODE] = "gridadd";
		$this->hideFieldsForAddEdit();
	}

	// Switch to Grid Edit mode
	protected function gridEditMode()
	{
		$this->CurrentAction = "gridedit";
		$_SESSION[SESSION_INLINE_MODE] = "gridedit";
		$this->hideFieldsForAddEdit();
	}

	// Perform update to grid
	public function gridUpdate()
	{
		global $Language, $CurrentForm, $FormError;
		$gridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->buildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		if ($rs = $conn->execute($sql)) {
			$rsold = $rs->getRows();
			$rs->close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}
		$key = "";

		// Update row index and get row key
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$CurrentForm->Index = $rowindex;
			$rowkey = strval($CurrentForm->getValue($this->FormKeyName));
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction != "insertdelete") { // Skip insert then deleted rows
				$this->loadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$gridUpdate = $this->setupKeyValues($rowkey); // Set up key values
				} else {
					$gridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->emptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($gridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->getRecordFilter();
						$gridUpdate = $this->deleteRows(); // Delete this row
					} else if (!$this->validateForm()) {
						$gridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($FormError);
					} else {
						if ($rowaction == "insert") {
							$gridUpdate = $this->addRow(); // Insert this row
						} else {
							if ($rowkey != "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$gridUpdate = $this->editRow(); // Update this row
							}
						} // End update
					}
				}
				if ($gridUpdate) {
					if ($key != "")
						$key .= ", ";
					$key .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($gridUpdate) {

			// Get new recordset
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->clearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
		}
		return $gridUpdate;
	}

	// Build filter for all keys
	protected function buildKeyFilter()
	{
		global $CurrentForm;
		$wrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$CurrentForm->Index = $rowindex;
		$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		while ($thisKey != "") {
			if ($this->setupKeyValues($thisKey)) {
				$filter = $this->getRecordFilter();
				if ($wrkFilter != "")
					$wrkFilter .= " OR ";
				$wrkFilter .= $filter;
			} else {
				$wrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$CurrentForm->Index = $rowindex;
			$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		}
		return $wrkFilter;
	}

	// Set up key values
	protected function setupKeyValues($key)
	{
		$arKeyFlds = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
		if (count($arKeyFlds) >= 1) {
			$this->idendereco->setOldValue($arKeyFlds[0]);
			if (!is_numeric($this->idendereco->OldValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	public function gridInsert()
	{
		global $Language, $CurrentForm, $FormError;
		$rowindex = 1;
		$gridInsert = FALSE;
		$conn = $this->getConnection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
			return FALSE;
		}

		// Init key filter
		$wrkfilter = "";
		$addcnt = 0;
		$key = "";

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "" && $rowaction != "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
				$this->loadOldRecord(); // Load old record
			}
			$this->loadFormValues(); // Get form values
			if (!$this->emptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->validateForm()) {
					$gridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($FormError);
				} else {
					$gridInsert = $this->addRow($this->OldRecordset); // Insert this row
				}
				if ($gridInsert) {
					if ($key != "")
						$key .= Config("COMPOSITE_KEY_SEPARATOR");
					$key .= $this->idendereco->CurrentValue;

					// Add filter for this record
					$filter = $this->getRecordFilter();
					if ($wrkfilter != "")
						$wrkfilter .= " OR ";
					$wrkfilter .= $filter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->clearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($gridInsert) {

			// Get new recordset
			$this->CurrentFilter = $wrkfilter;
			$sql = $this->getCurrentSql();
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->clearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
		}
		return $gridInsert;
	}

	// Check if empty row
	public function emptyRow()
	{
		global $CurrentForm;
		if ($CurrentForm->hasValue("x_idacademia") && $CurrentForm->hasValue("o_idacademia") && $this->idacademia->CurrentValue != $this->idacademia->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_idpessoa") && $CurrentForm->hasValue("o_idpessoa") && $this->idpessoa->CurrentValue != $this->idpessoa->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_CEP") && $CurrentForm->hasValue("o_CEP") && $this->CEP->CurrentValue != $this->CEP->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_UF") && $CurrentForm->hasValue("o_UF") && $this->UF->CurrentValue != $this->UF->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Cidade") && $CurrentForm->hasValue("o_Cidade") && $this->Cidade->CurrentValue != $this->Cidade->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Bairro") && $CurrentForm->hasValue("o_Bairro") && $this->Bairro->CurrentValue != $this->Bairro->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Rua") && $CurrentForm->hasValue("o_Rua") && $this->Rua->CurrentValue != $this->Rua->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Numero") && $CurrentForm->hasValue("o_Numero") && $this->Numero->CurrentValue != $this->Numero->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Complemento") && $CurrentForm->hasValue("o_Complemento") && $this->Complemento->CurrentValue != $this->Complemento->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	public function validateGridForm()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else if (!$this->validateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	public function getGridFormValues()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = [];

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->getFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	public function restoreCurrentRowFormValues($idx)
	{
		global $CurrentForm;

		// Get row based on current index
		$CurrentForm->Index = $idx;
		$this->loadFormValues(); // Load form values
	}

	// Set up sort parameters
	protected function setupSortOrder()
	{

		// Check for "order" parameter
		if (Get("order") !== NULL) {
			$this->CurrentOrder = Get("order");
			$this->CurrentOrderType = Get("ordertype", "");
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	protected function loadSortOrder()
	{
		$orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($orderBy == "") {
			if ($this->getSqlOrderBy() != "") {
				$orderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($orderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)

	protected function resetCmd()
	{

		// Check if reset command
		if (StartsString("reset", $this->Command)) {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idacademia->setSessionValue("");
				$this->idpessoa->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
			}

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Set up list options
	protected function setupListOptions()
	{
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canAdd();
		$item->OnLeft = TRUE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;

		//$this->ListOptions->ButtonClass = ""; // Class for button group
		// Call ListOptions_Load event

		$this->ListOptions_Load();
		$item = $this->ListOptions[$this->ListOptions->GroupOptionName];
		$item->Visible = $this->ListOptions->groupOptionVisible();
	}

	// Render list options
	public function renderListOptions()
	{
		global $Security, $Language, $CurrentForm;
		$this->ListOptions->loadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode != "view") {
			$CurrentForm->Index = $this->RowIndex;
			$actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$keyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
			if ($CurrentForm->hasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
			if ($this->RowOldKey != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $CurrentForm->getValue($this->FormKeyName);
				$this->setupKeyValues($rowkey);

				// Reload hidden key for delete
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . HtmlEncode($rowkey) . "\">";
			}
			if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$options = &$this->ListOptions;
				$options->UseButtonGroup = TRUE; // Use button group for grid delete button
				$opt = $options["griddelete"];
				if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$opt->Body = "&nbsp;";
				} else {
					$opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
				}
			}
		}
		if ($this->CurrentMode == "view") { // View mode

		// "view"
		$opt = $this->ListOptions["view"];
		$viewcaption = HtmlTitle($Language->phrase("ViewLink"));
		if ($Security->canView() && $this->showOptionLink('view')) {
			$opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode($this->ViewUrl) . "\">" . $Language->phrase("ViewLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "edit"
		$opt = $this->ListOptions["edit"];
		$editcaption = HtmlTitle($Language->phrase("EditLink"));
		if ($Security->canEdit() && $this->showOptionLink('edit')) {
			$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode($this->EditUrl) . "\">" . $Language->phrase("EditLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "copy"
		$opt = $this->ListOptions["copy"];
		$copycaption = HtmlTitle($Language->phrase("CopyLink"));
		if ($Security->canAdd() && $this->showOptionLink('add')) {
			$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode($this->CopyUrl) . "\">" . $Language->phrase("CopyLink") . "</a>";
		} else {
			$opt->Body = "";
		}
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex) && $this->RowAction != "delete") {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->idendereco->CurrentValue . "\">";
		}
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	public function setRecordKey(&$key, $rs)
	{
		$key = "";
		if ($key != "")
			$key .= Config("COMPOSITE_KEY_SEPARATOR");
		$key .= $rs->fields('idendereco');
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$option = $this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;

		//$option->ButtonClass = ""; // Class for button group
		$item = &$option->add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->add("add");
			$addcaption = HtmlTitle($Language->phrase("AddLink"));
			$this->AddUrl = $this->getAddUrl();
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode($this->AddUrl) . "\">" . $Language->phrase("AddLink") . "</a>";
			$item->Visible = $this->AddUrl != "" && $Security->canAdd();
		}
	}

	// Render other options
	public function renderOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = $options["addedit"];
				$option->UseDropDownButton = FALSE;
				$item = &$option->add("addblankrow");
				$item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->canAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = $options["addedit"];
			$item = $option["add"];
			$this->ShowOtherOptions = $item && $item->Visible;
		}
	}

	// Set up list options (extended codes)
	protected function setupListOptionsExt()
	{
	}

	// Render list options (extended codes)
	protected function renderListOptionsExt()
	{
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idendereco->CurrentValue = NULL;
		$this->idendereco->OldValue = $this->idendereco->CurrentValue;
		$this->idacademia->CurrentValue = NULL;
		$this->idacademia->OldValue = $this->idacademia->CurrentValue;
		$this->idpessoa->CurrentValue = CurrentUserID();
		$this->idpessoa->OldValue = $this->idpessoa->CurrentValue;
		$this->CEP->CurrentValue = NULL;
		$this->CEP->OldValue = $this->CEP->CurrentValue;
		$this->UF->CurrentValue = NULL;
		$this->UF->OldValue = $this->UF->CurrentValue;
		$this->Cidade->CurrentValue = NULL;
		$this->Cidade->OldValue = $this->Cidade->CurrentValue;
		$this->Bairro->CurrentValue = NULL;
		$this->Bairro->OldValue = $this->Bairro->CurrentValue;
		$this->Rua->CurrentValue = NULL;
		$this->Rua->OldValue = $this->Rua->CurrentValue;
		$this->Numero->CurrentValue = NULL;
		$this->Numero->OldValue = $this->Numero->CurrentValue;
		$this->Complemento->CurrentValue = NULL;
		$this->Complemento->OldValue = $this->Complemento->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;
		$CurrentForm->FormName = $this->FormName;

		// Check field name 'idacademia' first before field var 'x_idacademia'
		$val = $CurrentForm->hasValue("idacademia") ? $CurrentForm->getValue("idacademia") : $CurrentForm->getValue("x_idacademia");
		if (!$this->idacademia->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idacademia->Visible = FALSE; // Disable update for API request
			else
				$this->idacademia->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_idacademia"))
			$this->idacademia->setOldValue($CurrentForm->getValue("o_idacademia"));

		// Check field name 'idpessoa' first before field var 'x_idpessoa'
		$val = $CurrentForm->hasValue("idpessoa") ? $CurrentForm->getValue("idpessoa") : $CurrentForm->getValue("x_idpessoa");
		if (!$this->idpessoa->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idpessoa->Visible = FALSE; // Disable update for API request
			else
				$this->idpessoa->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_idpessoa"))
			$this->idpessoa->setOldValue($CurrentForm->getValue("o_idpessoa"));

		// Check field name 'CEP' first before field var 'x_CEP'
		$val = $CurrentForm->hasValue("CEP") ? $CurrentForm->getValue("CEP") : $CurrentForm->getValue("x_CEP");
		if (!$this->CEP->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->CEP->Visible = FALSE; // Disable update for API request
			else
				$this->CEP->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_CEP"))
			$this->CEP->setOldValue($CurrentForm->getValue("o_CEP"));

		// Check field name 'UF' first before field var 'x_UF'
		$val = $CurrentForm->hasValue("UF") ? $CurrentForm->getValue("UF") : $CurrentForm->getValue("x_UF");
		if (!$this->UF->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->UF->Visible = FALSE; // Disable update for API request
			else
				$this->UF->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_UF"))
			$this->UF->setOldValue($CurrentForm->getValue("o_UF"));

		// Check field name 'Cidade' first before field var 'x_Cidade'
		$val = $CurrentForm->hasValue("Cidade") ? $CurrentForm->getValue("Cidade") : $CurrentForm->getValue("x_Cidade");
		if (!$this->Cidade->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Cidade->Visible = FALSE; // Disable update for API request
			else
				$this->Cidade->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Cidade"))
			$this->Cidade->setOldValue($CurrentForm->getValue("o_Cidade"));

		// Check field name 'Bairro' first before field var 'x_Bairro'
		$val = $CurrentForm->hasValue("Bairro") ? $CurrentForm->getValue("Bairro") : $CurrentForm->getValue("x_Bairro");
		if (!$this->Bairro->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Bairro->Visible = FALSE; // Disable update for API request
			else
				$this->Bairro->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Bairro"))
			$this->Bairro->setOldValue($CurrentForm->getValue("o_Bairro"));

		// Check field name 'Rua' first before field var 'x_Rua'
		$val = $CurrentForm->hasValue("Rua") ? $CurrentForm->getValue("Rua") : $CurrentForm->getValue("x_Rua");
		if (!$this->Rua->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Rua->Visible = FALSE; // Disable update for API request
			else
				$this->Rua->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Rua"))
			$this->Rua->setOldValue($CurrentForm->getValue("o_Rua"));

		// Check field name 'Numero' first before field var 'x_Numero'
		$val = $CurrentForm->hasValue("Numero") ? $CurrentForm->getValue("Numero") : $CurrentForm->getValue("x_Numero");
		if (!$this->Numero->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Numero->Visible = FALSE; // Disable update for API request
			else
				$this->Numero->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Numero"))
			$this->Numero->setOldValue($CurrentForm->getValue("o_Numero"));

		// Check field name 'Complemento' first before field var 'x_Complemento'
		$val = $CurrentForm->hasValue("Complemento") ? $CurrentForm->getValue("Complemento") : $CurrentForm->getValue("x_Complemento");
		if (!$this->Complemento->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Complemento->Visible = FALSE; // Disable update for API request
			else
				$this->Complemento->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Complemento"))
			$this->Complemento->setOldValue($CurrentForm->getValue("o_Complemento"));

		// Check field name 'idendereco' first before field var 'x_idendereco'
		$val = $CurrentForm->hasValue("idendereco") ? $CurrentForm->getValue("idendereco") : $CurrentForm->getValue("x_idendereco");
		if (!$this->idendereco->IsDetailKey && !$this->isGridAdd() && !$this->isAdd())
			$this->idendereco->setFormValue($val);
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		if (!$this->isGridAdd() && !$this->isAdd())
			$this->idendereco->CurrentValue = $this->idendereco->FormValue;
		$this->idacademia->CurrentValue = $this->idacademia->FormValue;
		$this->idpessoa->CurrentValue = $this->idpessoa->FormValue;
		$this->CEP->CurrentValue = $this->CEP->FormValue;
		$this->UF->CurrentValue = $this->UF->FormValue;
		$this->Cidade->CurrentValue = $this->Cidade->FormValue;
		$this->Bairro->CurrentValue = $this->Bairro->FormValue;
		$this->Rua->CurrentValue = $this->Rua->FormValue;
		$this->Numero->CurrentValue = $this->Numero->FormValue;
		$this->Complemento->CurrentValue = $this->Complemento->FormValue;
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = $this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = "";
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->idendereco->setDbValue($row['idendereco']);
		$this->idacademia->setDbValue($row['idacademia']);
		$this->idpessoa->setDbValue($row['idpessoa']);
		$this->CEP->setDbValue($row['CEP']);
		$this->UF->setDbValue($row['UF']);
		$this->Cidade->setDbValue($row['Cidade']);
		$this->Bairro->setDbValue($row['Bairro']);
		$this->Rua->setDbValue($row['Rua']);
		$this->Numero->setDbValue($row['Numero']);
		$this->Complemento->setDbValue($row['Complemento']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idendereco'] = $this->idendereco->CurrentValue;
		$row['idacademia'] = $this->idacademia->CurrentValue;
		$row['idpessoa'] = $this->idpessoa->CurrentValue;
		$row['CEP'] = $this->CEP->CurrentValue;
		$row['UF'] = $this->UF->CurrentValue;
		$row['Cidade'] = $this->Cidade->CurrentValue;
		$row['Bairro'] = $this->Bairro->CurrentValue;
		$row['Rua'] = $this->Rua->CurrentValue;
		$row['Numero'] = $this->Numero->CurrentValue;
		$row['Complemento'] = $this->Complemento->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		$keys = [$this->RowOldKey];
		$cnt = count($keys);
		if ($cnt >= 1) {
			if (strval($keys[0]) != "")
				$this->idendereco->OldValue = strval($keys[0]); // idendereco
			else
				$validKey = FALSE;
		} else {
			$validKey = FALSE;
		}

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = $this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->getViewUrl();
		$this->EditUrl = $this->getEditUrl();
		$this->CopyUrl = $this->getCopyUrl();
		$this->DeleteUrl = $this->getDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idendereco
		// idacademia
		// idpessoa
		// CEP
		// UF
		// Cidade
		// Bairro
		// Rua
		// Numero
		// Complemento

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// idendereco
			$this->idendereco->ViewValue = $this->idendereco->CurrentValue;
			$this->idendereco->ViewCustomAttributes = "";

			// idacademia
			$curVal = strval($this->idacademia->CurrentValue);
			if ($curVal != "") {
				$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
				if ($this->idacademia->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idacademia->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idacademia->ViewValue = $this->idacademia->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idacademia->ViewValue = $this->idacademia->CurrentValue;
					}
				}
			} else {
				$this->idacademia->ViewValue = NULL;
			}
			$this->idacademia->ViewCustomAttributes = "";

			// idpessoa
			$curVal = strval($this->idpessoa->CurrentValue);
			if ($curVal != "") {
				$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
				if ($this->idpessoa->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idpessoa->ViewValue = $this->idpessoa->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
					}
				}
			} else {
				$this->idpessoa->ViewValue = NULL;
			}
			$this->idpessoa->ViewCustomAttributes = "";

			// CEP
			$this->CEP->ViewValue = $this->CEP->CurrentValue;
			$this->CEP->ViewCustomAttributes = "";

			// UF
			$this->UF->ViewValue = $this->UF->CurrentValue;
			$this->UF->ViewCustomAttributes = "";

			// Cidade
			$this->Cidade->ViewValue = $this->Cidade->CurrentValue;
			$this->Cidade->ViewCustomAttributes = "";

			// Bairro
			$this->Bairro->ViewValue = $this->Bairro->CurrentValue;
			$this->Bairro->ViewCustomAttributes = "";

			// Rua
			$this->Rua->ViewValue = $this->Rua->CurrentValue;
			$this->Rua->ViewCustomAttributes = "";

			// Numero
			$this->Numero->ViewValue = $this->Numero->CurrentValue;
			$this->Numero->ViewCustomAttributes = "";

			// Complemento
			$this->Complemento->ViewValue = $this->Complemento->CurrentValue;
			$this->Complemento->ViewCustomAttributes = "";

			// idacademia
			$this->idacademia->LinkCustomAttributes = "";
			$this->idacademia->HrefValue = "";
			$this->idacademia->TooltipValue = "";

			// idpessoa
			$this->idpessoa->LinkCustomAttributes = "";
			$this->idpessoa->HrefValue = "";
			$this->idpessoa->TooltipValue = "";

			// CEP
			$this->CEP->LinkCustomAttributes = "";
			$this->CEP->HrefValue = "";
			$this->CEP->TooltipValue = "";

			// UF
			$this->UF->LinkCustomAttributes = "";
			$this->UF->HrefValue = "";
			$this->UF->TooltipValue = "";

			// Cidade
			$this->Cidade->LinkCustomAttributes = "";
			$this->Cidade->HrefValue = "";
			$this->Cidade->TooltipValue = "";

			// Bairro
			$this->Bairro->LinkCustomAttributes = "";
			$this->Bairro->HrefValue = "";
			$this->Bairro->TooltipValue = "";

			// Rua
			$this->Rua->LinkCustomAttributes = "";
			$this->Rua->HrefValue = "";
			$this->Rua->TooltipValue = "";

			// Numero
			$this->Numero->LinkCustomAttributes = "";
			$this->Numero->HrefValue = "";
			$this->Numero->TooltipValue = "";

			// Complemento
			$this->Complemento->LinkCustomAttributes = "";
			$this->Complemento->HrefValue = "";
			$this->Complemento->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// idacademia
			$this->idacademia->EditAttrs["class"] = "form-control";
			$this->idacademia->EditCustomAttributes = "";
			if ($this->idacademia->getSessionValue() != "") {
				$this->idacademia->CurrentValue = $this->idacademia->getSessionValue();
				$this->idacademia->OldValue = $this->idacademia->CurrentValue;
				$curVal = strval($this->idacademia->CurrentValue);
				if ($curVal != "") {
					$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
					if ($this->idacademia->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idacademia->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idacademia->ViewValue = $this->idacademia->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idacademia->ViewValue = $this->idacademia->CurrentValue;
						}
					}
				} else {
					$this->idacademia->ViewValue = NULL;
				}
				$this->idacademia->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idacademia->CurrentValue));
				if ($curVal != "")
					$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
				else
					$this->idacademia->ViewValue = $this->idacademia->Lookup !== NULL && is_array($this->idacademia->Lookup->Options) ? $curVal : NULL;
				if ($this->idacademia->ViewValue !== NULL) { // Load from cache
					$this->idacademia->EditValue = array_values($this->idacademia->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idacademia`" . SearchString("=", $this->idacademia->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->idacademia->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idacademia->EditValue = $arwrk;
				}
			}

			// idpessoa
			$this->idpessoa->EditAttrs["class"] = "form-control";
			$this->idpessoa->EditCustomAttributes = "";
			if ($this->idpessoa->getSessionValue() != "") {
				$this->idpessoa->CurrentValue = $this->idpessoa->getSessionValue();
				$this->idpessoa->OldValue = $this->idpessoa->CurrentValue;
				$curVal = strval($this->idpessoa->CurrentValue);
				if ($curVal != "") {
					$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
					if ($this->idpessoa->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idpessoa->ViewValue = $this->idpessoa->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
						}
					}
				} else {
					$this->idpessoa->ViewValue = NULL;
				}
				$this->idpessoa->ViewCustomAttributes = "";
			} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
				$this->idpessoa->CurrentValue = CurrentUserID();
				$curVal = strval($this->idpessoa->CurrentValue);
				if ($curVal != "") {
					$this->idpessoa->EditValue = $this->idpessoa->lookupCacheOption($curVal);
					if ($this->idpessoa->EditValue === NULL) { // Lookup from database
						$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idpessoa->EditValue = $this->idpessoa->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idpessoa->EditValue = $this->idpessoa->CurrentValue;
						}
					}
				} else {
					$this->idpessoa->EditValue = NULL;
				}
				$this->idpessoa->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idpessoa->CurrentValue));
				if ($curVal != "")
					$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
				else
					$this->idpessoa->ViewValue = $this->idpessoa->Lookup !== NULL && is_array($this->idpessoa->Lookup->Options) ? $curVal : NULL;
				if ($this->idpessoa->ViewValue !== NULL) { // Load from cache
					$this->idpessoa->EditValue = array_values($this->idpessoa->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idpessoa`" . SearchString("=", $this->idpessoa->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->idpessoa->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idpessoa->EditValue = $arwrk;
				}
			}

			// CEP
			$this->CEP->EditAttrs["class"] = "form-control";
			$this->CEP->EditCustomAttributes = "";
			if (!$this->CEP->Raw)
				$this->CEP->CurrentValue = HtmlDecode($this->CEP->CurrentValue);
			$this->CEP->EditValue = HtmlEncode($this->CEP->CurrentValue);
			$this->CEP->PlaceHolder = RemoveHtml($this->CEP->caption());

			// UF
			$this->UF->EditAttrs["class"] = "form-control";
			$this->UF->EditCustomAttributes = "";
			if (!$this->UF->Raw)
				$this->UF->CurrentValue = HtmlDecode($this->UF->CurrentValue);
			$this->UF->EditValue = HtmlEncode($this->UF->CurrentValue);
			$this->UF->PlaceHolder = RemoveHtml($this->UF->caption());

			// Cidade
			$this->Cidade->EditAttrs["class"] = "form-control";
			$this->Cidade->EditCustomAttributes = "";
			if (!$this->Cidade->Raw)
				$this->Cidade->CurrentValue = HtmlDecode($this->Cidade->CurrentValue);
			$this->Cidade->EditValue = HtmlEncode($this->Cidade->CurrentValue);
			$this->Cidade->PlaceHolder = RemoveHtml($this->Cidade->caption());

			// Bairro
			$this->Bairro->EditAttrs["class"] = "form-control";
			$this->Bairro->EditCustomAttributes = "";
			if (!$this->Bairro->Raw)
				$this->Bairro->CurrentValue = HtmlDecode($this->Bairro->CurrentValue);
			$this->Bairro->EditValue = HtmlEncode($this->Bairro->CurrentValue);
			$this->Bairro->PlaceHolder = RemoveHtml($this->Bairro->caption());

			// Rua
			$this->Rua->EditAttrs["class"] = "form-control";
			$this->Rua->EditCustomAttributes = "";
			if (!$this->Rua->Raw)
				$this->Rua->CurrentValue = HtmlDecode($this->Rua->CurrentValue);
			$this->Rua->EditValue = HtmlEncode($this->Rua->CurrentValue);
			$this->Rua->PlaceHolder = RemoveHtml($this->Rua->caption());

			// Numero
			$this->Numero->EditAttrs["class"] = "form-control";
			$this->Numero->EditCustomAttributes = "";
			if (!$this->Numero->Raw)
				$this->Numero->CurrentValue = HtmlDecode($this->Numero->CurrentValue);
			$this->Numero->EditValue = HtmlEncode($this->Numero->CurrentValue);
			$this->Numero->PlaceHolder = RemoveHtml($this->Numero->caption());

			// Complemento
			$this->Complemento->EditAttrs["class"] = "form-control";
			$this->Complemento->EditCustomAttributes = "";
			if (!$this->Complemento->Raw)
				$this->Complemento->CurrentValue = HtmlDecode($this->Complemento->CurrentValue);
			$this->Complemento->EditValue = HtmlEncode($this->Complemento->CurrentValue);
			$this->Complemento->PlaceHolder = RemoveHtml($this->Complemento->caption());

			// Add refer script
			// idacademia

			$this->idacademia->LinkCustomAttributes = "";
			$this->idacademia->HrefValue = "";

			// idpessoa
			$this->idpessoa->LinkCustomAttributes = "";
			$this->idpessoa->HrefValue = "";

			// CEP
			$this->CEP->LinkCustomAttributes = "";
			$this->CEP->HrefValue = "";

			// UF
			$this->UF->LinkCustomAttributes = "";
			$this->UF->HrefValue = "";

			// Cidade
			$this->Cidade->LinkCustomAttributes = "";
			$this->Cidade->HrefValue = "";

			// Bairro
			$this->Bairro->LinkCustomAttributes = "";
			$this->Bairro->HrefValue = "";

			// Rua
			$this->Rua->LinkCustomAttributes = "";
			$this->Rua->HrefValue = "";

			// Numero
			$this->Numero->LinkCustomAttributes = "";
			$this->Numero->HrefValue = "";

			// Complemento
			$this->Complemento->LinkCustomAttributes = "";
			$this->Complemento->HrefValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// idacademia
			$this->idacademia->EditAttrs["class"] = "form-control";
			$this->idacademia->EditCustomAttributes = "";
			if ($this->idacademia->getSessionValue() != "") {
				$this->idacademia->CurrentValue = $this->idacademia->getSessionValue();
				$this->idacademia->OldValue = $this->idacademia->CurrentValue;
				$curVal = strval($this->idacademia->CurrentValue);
				if ($curVal != "") {
					$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
					if ($this->idacademia->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idacademia->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idacademia->ViewValue = $this->idacademia->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idacademia->ViewValue = $this->idacademia->CurrentValue;
						}
					}
				} else {
					$this->idacademia->ViewValue = NULL;
				}
				$this->idacademia->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idacademia->CurrentValue));
				if ($curVal != "")
					$this->idacademia->ViewValue = $this->idacademia->lookupCacheOption($curVal);
				else
					$this->idacademia->ViewValue = $this->idacademia->Lookup !== NULL && is_array($this->idacademia->Lookup->Options) ? $curVal : NULL;
				if ($this->idacademia->ViewValue !== NULL) { // Load from cache
					$this->idacademia->EditValue = array_values($this->idacademia->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idacademia`" . SearchString("=", $this->idacademia->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->idacademia->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idacademia->EditValue = $arwrk;
				}
			}

			// idpessoa
			$this->idpessoa->EditAttrs["class"] = "form-control";
			$this->idpessoa->EditCustomAttributes = "";
			if ($this->idpessoa->getSessionValue() != "") {
				$this->idpessoa->CurrentValue = $this->idpessoa->getSessionValue();
				$this->idpessoa->OldValue = $this->idpessoa->CurrentValue;
				$curVal = strval($this->idpessoa->CurrentValue);
				if ($curVal != "") {
					$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
					if ($this->idpessoa->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idpessoa->ViewValue = $this->idpessoa->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
						}
					}
				} else {
					$this->idpessoa->ViewValue = NULL;
				}
				$this->idpessoa->ViewCustomAttributes = "";
			} elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
				$this->idpessoa->CurrentValue = CurrentUserID();
				$curVal = strval($this->idpessoa->CurrentValue);
				if ($curVal != "") {
					$this->idpessoa->EditValue = $this->idpessoa->lookupCacheOption($curVal);
					if ($this->idpessoa->EditValue === NULL) { // Lookup from database
						$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idpessoa->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idpessoa->EditValue = $this->idpessoa->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idpessoa->EditValue = $this->idpessoa->CurrentValue;
						}
					}
				} else {
					$this->idpessoa->EditValue = NULL;
				}
				$this->idpessoa->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idpessoa->CurrentValue));
				if ($curVal != "")
					$this->idpessoa->ViewValue = $this->idpessoa->lookupCacheOption($curVal);
				else
					$this->idpessoa->ViewValue = $this->idpessoa->Lookup !== NULL && is_array($this->idpessoa->Lookup->Options) ? $curVal : NULL;
				if ($this->idpessoa->ViewValue !== NULL) { // Load from cache
					$this->idpessoa->EditValue = array_values($this->idpessoa->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idpessoa`" . SearchString("=", $this->idpessoa->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->idpessoa->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idpessoa->EditValue = $arwrk;
				}
			}

			// CEP
			$this->CEP->EditAttrs["class"] = "form-control";
			$this->CEP->EditCustomAttributes = "";
			if (!$this->CEP->Raw)
				$this->CEP->CurrentValue = HtmlDecode($this->CEP->CurrentValue);
			$this->CEP->EditValue = HtmlEncode($this->CEP->CurrentValue);
			$this->CEP->PlaceHolder = RemoveHtml($this->CEP->caption());

			// UF
			$this->UF->EditAttrs["class"] = "form-control";
			$this->UF->EditCustomAttributes = "";
			if (!$this->UF->Raw)
				$this->UF->CurrentValue = HtmlDecode($this->UF->CurrentValue);
			$this->UF->EditValue = HtmlEncode($this->UF->CurrentValue);
			$this->UF->PlaceHolder = RemoveHtml($this->UF->caption());

			// Cidade
			$this->Cidade->EditAttrs["class"] = "form-control";
			$this->Cidade->EditCustomAttributes = "";
			if (!$this->Cidade->Raw)
				$this->Cidade->CurrentValue = HtmlDecode($this->Cidade->CurrentValue);
			$this->Cidade->EditValue = HtmlEncode($this->Cidade->CurrentValue);
			$this->Cidade->PlaceHolder = RemoveHtml($this->Cidade->caption());

			// Bairro
			$this->Bairro->EditAttrs["class"] = "form-control";
			$this->Bairro->EditCustomAttributes = "";
			if (!$this->Bairro->Raw)
				$this->Bairro->CurrentValue = HtmlDecode($this->Bairro->CurrentValue);
			$this->Bairro->EditValue = HtmlEncode($this->Bairro->CurrentValue);
			$this->Bairro->PlaceHolder = RemoveHtml($this->Bairro->caption());

			// Rua
			$this->Rua->EditAttrs["class"] = "form-control";
			$this->Rua->EditCustomAttributes = "";
			if (!$this->Rua->Raw)
				$this->Rua->CurrentValue = HtmlDecode($this->Rua->CurrentValue);
			$this->Rua->EditValue = HtmlEncode($this->Rua->CurrentValue);
			$this->Rua->PlaceHolder = RemoveHtml($this->Rua->caption());

			// Numero
			$this->Numero->EditAttrs["class"] = "form-control";
			$this->Numero->EditCustomAttributes = "";
			if (!$this->Numero->Raw)
				$this->Numero->CurrentValue = HtmlDecode($this->Numero->CurrentValue);
			$this->Numero->EditValue = HtmlEncode($this->Numero->CurrentValue);
			$this->Numero->PlaceHolder = RemoveHtml($this->Numero->caption());

			// Complemento
			$this->Complemento->EditAttrs["class"] = "form-control";
			$this->Complemento->EditCustomAttributes = "";
			if (!$this->Complemento->Raw)
				$this->Complemento->CurrentValue = HtmlDecode($this->Complemento->CurrentValue);
			$this->Complemento->EditValue = HtmlEncode($this->Complemento->CurrentValue);
			$this->Complemento->PlaceHolder = RemoveHtml($this->Complemento->caption());

			// Edit refer script
			// idacademia

			$this->idacademia->LinkCustomAttributes = "";
			$this->idacademia->HrefValue = "";

			// idpessoa
			$this->idpessoa->LinkCustomAttributes = "";
			$this->idpessoa->HrefValue = "";

			// CEP
			$this->CEP->LinkCustomAttributes = "";
			$this->CEP->HrefValue = "";

			// UF
			$this->UF->LinkCustomAttributes = "";
			$this->UF->HrefValue = "";

			// Cidade
			$this->Cidade->LinkCustomAttributes = "";
			$this->Cidade->HrefValue = "";

			// Bairro
			$this->Bairro->LinkCustomAttributes = "";
			$this->Bairro->HrefValue = "";

			// Rua
			$this->Rua->LinkCustomAttributes = "";
			$this->Rua->HrefValue = "";

			// Numero
			$this->Numero->LinkCustomAttributes = "";
			$this->Numero->HrefValue = "";

			// Complemento
			$this->Complemento->LinkCustomAttributes = "";
			$this->Complemento->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->idacademia->Required) {
			if (!$this->idacademia->IsDetailKey && $this->idacademia->FormValue != NULL && $this->idacademia->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idacademia->caption(), $this->idacademia->RequiredErrorMessage));
			}
		}
		if ($this->idpessoa->Required) {
			if (!$this->idpessoa->IsDetailKey && $this->idpessoa->FormValue != NULL && $this->idpessoa->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idpessoa->caption(), $this->idpessoa->RequiredErrorMessage));
			}
		}
		if ($this->CEP->Required) {
			if (!$this->CEP->IsDetailKey && $this->CEP->FormValue != NULL && $this->CEP->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->CEP->caption(), $this->CEP->RequiredErrorMessage));
			}
		}
		if ($this->UF->Required) {
			if (!$this->UF->IsDetailKey && $this->UF->FormValue != NULL && $this->UF->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->UF->caption(), $this->UF->RequiredErrorMessage));
			}
		}
		if ($this->Cidade->Required) {
			if (!$this->Cidade->IsDetailKey && $this->Cidade->FormValue != NULL && $this->Cidade->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Cidade->caption(), $this->Cidade->RequiredErrorMessage));
			}
		}
		if ($this->Bairro->Required) {
			if (!$this->Bairro->IsDetailKey && $this->Bairro->FormValue != NULL && $this->Bairro->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Bairro->caption(), $this->Bairro->RequiredErrorMessage));
			}
		}
		if ($this->Rua->Required) {
			if (!$this->Rua->IsDetailKey && $this->Rua->FormValue != NULL && $this->Rua->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Rua->caption(), $this->Rua->RequiredErrorMessage));
			}
		}
		if ($this->Numero->Required) {
			if (!$this->Numero->IsDetailKey && $this->Numero->FormValue != NULL && $this->Numero->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Numero->caption(), $this->Numero->RequiredErrorMessage));
			}
		}
		if ($this->Complemento->Required) {
			if (!$this->Complemento->IsDetailKey && $this->Complemento->FormValue != NULL && $this->Complemento->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Complemento->caption(), $this->Complemento->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Delete records based on current filter
	protected function deleteRows()
	{
		global $Language, $Security;
		if (!$Security->canDelete()) {
			$this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$deleteRows = TRUE;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
			$rs->close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->getRows() : [];

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->close();

		// Call row deleting event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$deleteRows = $this->Row_Deleting($row);
				if (!$deleteRows)
					break;
			}
		}
		if ($deleteRows) {
			$key = "";
			foreach ($rsold as $row) {
				$thisKey = "";
				if ($thisKey != "")
					$thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
				$thisKey .= $row['idendereco'];
				if (Config("DELETE_UPLOADED_FILES")) // Delete old files
					$this->deleteUploadedFiles($row);
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				$deleteRows = $this->delete($row); // Delete
				$conn->raiseErrorFn = "";
				if ($deleteRows === FALSE)
					break;
				if ($key != "")
					$key .= ", ";
				$key .= $thisKey;
			}
		}
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

		// Call Row Deleted event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}

		// Write JSON for API request (Support single row only)
		if (IsApi() && $deleteRows) {
			$row = $this->getRecordsFromRecordset($rsold, TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $deleteRows;
	}

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$oldKeyFilter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($oldKeyFilter);
		$conn = $this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// idacademia
			$this->idacademia->setDbValueDef($rsnew, $this->idacademia->CurrentValue, NULL, $this->idacademia->ReadOnly);

			// idpessoa
			$this->idpessoa->setDbValueDef($rsnew, $this->idpessoa->CurrentValue, NULL, $this->idpessoa->ReadOnly);

			// CEP
			$this->CEP->setDbValueDef($rsnew, $this->CEP->CurrentValue, NULL, $this->CEP->ReadOnly);

			// UF
			$this->UF->setDbValueDef($rsnew, $this->UF->CurrentValue, NULL, $this->UF->ReadOnly);

			// Cidade
			$this->Cidade->setDbValueDef($rsnew, $this->Cidade->CurrentValue, NULL, $this->Cidade->ReadOnly);

			// Bairro
			$this->Bairro->setDbValueDef($rsnew, $this->Bairro->CurrentValue, NULL, $this->Bairro->ReadOnly);

			// Rua
			$this->Rua->setDbValueDef($rsnew, $this->Rua->CurrentValue, NULL, $this->Rua->ReadOnly);

			// Numero
			$this->Numero->setDbValueDef($rsnew, $this->Numero->CurrentValue, NULL, $this->Numero->ReadOnly);

			// Complemento
			$this->Complemento->setDbValueDef($rsnew, $this->Complemento->CurrentValue, NULL, $this->Complemento->ReadOnly);

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);

			// Check for duplicate key when key changed
			if ($updateRow) {
				$newKeyFilter = $this->getRecordFilter($rsnew);
				if ($newKeyFilter != $oldKeyFilter) {
					$rsChk = $this->loadRs($newKeyFilter);
					if ($rsChk && !$rsChk->EOF) {
						$keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
						$this->setFailureMessage($keyErrMsg);
						$rsChk->close();
						$updateRow = FALSE;
					}
				}
			}
			if ($updateRow) {
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = "";
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage != "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Clean upload path if any
		if ($editRow) {
		}

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check if valid User ID
		$validUser = FALSE;
		if ($Security->currentUserID() != "" && !EmptyValue($this->idpessoa->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->idpessoa->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->idpessoa->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}

		// Check if valid key values for master user
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$masterFilter = $this->sqlMasterFilter_pessoa();
			if (strval($this->idpessoa->CurrentValue) != "") {
				$masterFilter = str_replace("@idpessoa@", AdjustSql($this->idpessoa->CurrentValue, "DB"), $masterFilter);
			} else {
				$masterFilter = "";
			}
			if ($masterFilter != "") {
				$rsmaster = $GLOBALS["pessoa"]->loadRs($masterFilter);
				$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
				$validMasterKey = TRUE;
				if ($this->MasterRecordExists) {
					$validMasterKey = $Security->isValidUserID($rsmaster->fields['idpessoa']);
				} elseif ($this->getCurrentMasterTable() == "pessoa") {
					$validMasterKey = FALSE;
				}
				if (!$validMasterKey) {
					$masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
					$masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
					$this->setFailureMessage($masterUserIdMsg);
					return FALSE;
				}
				if ($rsmaster)
					$rsmaster->close();
			}
		}

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "academia") {
				$this->idacademia->CurrentValue = $this->idacademia->getSessionValue();
			}
			if ($this->getCurrentMasterTable() == "pessoa") {
				$this->idpessoa->CurrentValue = $this->idpessoa->getSessionValue();
			}
		$conn = $this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// idacademia
		$this->idacademia->setDbValueDef($rsnew, $this->idacademia->CurrentValue, NULL, FALSE);

		// idpessoa
		$this->idpessoa->setDbValueDef($rsnew, $this->idpessoa->CurrentValue, NULL, FALSE);

		// CEP
		$this->CEP->setDbValueDef($rsnew, $this->CEP->CurrentValue, NULL, FALSE);

		// UF
		$this->UF->setDbValueDef($rsnew, $this->UF->CurrentValue, NULL, FALSE);

		// Cidade
		$this->Cidade->setDbValueDef($rsnew, $this->Cidade->CurrentValue, NULL, FALSE);

		// Bairro
		$this->Bairro->setDbValueDef($rsnew, $this->Bairro->CurrentValue, NULL, FALSE);

		// Rua
		$this->Rua->setDbValueDef($rsnew, $this->Rua->CurrentValue, NULL, FALSE);

		// Numero
		$this->Numero->setDbValueDef($rsnew, $this->Numero->CurrentValue, NULL, FALSE);

		// Complemento
		$this->Complemento->setDbValueDef($rsnew, $this->Complemento->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = "";
			if ($addRow) {
			}
		} else {
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("InsertCancelled"));
			}
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Clean upload path if any
		if ($addRow) {
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Show link optionally based on User ID
	protected function showOptionLink($id = "")
	{
		global $Security;
		if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id))
			return $Security->isValidUserID($this->idpessoa->CurrentValue);
		return TRUE;
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{

		// Hide foreign keys
		$masterTblVar = $this->getCurrentMasterTable();
		if ($masterTblVar == "academia") {
			$this->idacademia->Visible = FALSE;
			if ($GLOBALS["academia"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		if ($masterTblVar == "pessoa") {
			$this->idpessoa->Visible = FALSE;
			if ($GLOBALS["pessoa"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// Get default connection and filter
			$conn = $this->getConnection();
			$lookupFilter = "";

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL and connection
			switch ($fld->FieldVar) {
				case "x_idacademia":
					break;
				case "x_idpessoa":
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
				$totalCnt = $this->getRecordCount($sql, $conn);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_idacademia":
							break;
						case "x_idpessoa":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
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
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions["new"]->Body = "xxx";

	}
} // End class
?>