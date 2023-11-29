<?php
namespace PHPMaker2020\sistema;

/**
 * Page class
 */
class aulas_add extends aulas
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{448C0B4B-C32A-40EF-8151-41E96F03E813}";

	// Table name
	public $TableName = 'aulas';

	// Page object name
	public $PageObjName = "aulas_add";

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (aulas)
		if (!isset($GLOBALS["aulas"]) || get_class($GLOBALS["aulas"]) == PROJECT_NAMESPACE . "aulas") {
			$GLOBALS["aulas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["aulas"];
		}

		// Table object (pessoa)
		if (!isset($GLOBALS['pessoa']))
			$GLOBALS['pessoa'] = new pessoa();

		// Table object (turnos)
		if (!isset($GLOBALS['turnos']))
			$GLOBALS['turnos'] = new turnos();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'aulas');

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
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $aulas;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($aulas);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url, "modal" => "1"];
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "aulasview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
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
			$key .= @$ar['idaulas'];
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
			$this->idaulas->Visible = FALSE;
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
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRecord;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;
	public $DetailPages; // Detail pages object

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Is modal
		$this->IsModal = (Param("modal") == "1");

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (ValidApiRequest()) { // API request
			$this->setupApiSecurity(); // Set up API Security
			if (!$Security->canAdd()) {
				SetStatus(401); // Unauthorized
				return;
			}
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
			if (!$Security->canAdd()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("aulaslist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
				if (strval($Security->currentUserID()) == "") {
					$this->setFailureMessage(DeniedMessage()); // Set no permission
					$this->terminate(GetUrl("aulaslist.php"));
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

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->idaulas->Visible = FALSE;
		$this->idturnos->setVisibility();
		$this->idaluno->setVisibility();
		$this->nome->setVisibility();
		$this->ativado->setVisibility();
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

		// Set up detail page object
		$this->setupDetailPages();

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

		// Set up lookup cache
		$this->setupLookupOptions($this->idturnos);
		$this->setupLookupOptions($this->idaluno);
		$this->setupLookupOptions($this->nome);

		// Check permission
		if (!$Security->canAdd()) {
			$this->setFailureMessage(DeniedMessage()); // No permission
			$this->terminate("aulaslist.php");
			return;
		}

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-add-form ew-horizontal";
		$postBack = FALSE;

		// Set up current action
		if (IsApi()) {
			$this->CurrentAction = "insert"; // Add record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get form action
			$postBack = TRUE;
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (Get("idaulas") !== NULL) {
				$this->idaulas->setQueryStringValue(Get("idaulas"));
				$this->setKey("idaulas", $this->idaulas->CurrentValue); // Set up key
			} else {
				$this->setKey("idaulas", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "copy"; // Copy record
			} else {
				$this->CurrentAction = "show"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->loadOldRecord();

		// Set up master/detail parameters
		// NOTE: must be after loadOldRecord to prevent master key values overwritten

		$this->setupMasterParms();

		// Load form values
		if ($postBack) {
			$this->loadFormValues(); // Load form values
		}

		// Set up detail parameters
		$this->setupDetailParms();

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues(); // Restore form values
				$this->setFailureMessage($FormError);
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = "show"; // Form error, reset action
				}
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "copy": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("aulaslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->setupDetailParms();
				break;
			case "insert": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
					$returnUrl = $this->GetAddUrl();
					if (GetPageName($returnUrl) == "aulaslist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "aulasview.php")
						$returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
					if (IsApi()) { // Return to caller
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl);
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->setupDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render row based on row type
		$this->RowType = ROWTYPE_ADD; // Render add type

		// Render row
		$this->resetAttributes();
		$this->renderRow();
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idaulas->CurrentValue = NULL;
		$this->idaulas->OldValue = $this->idaulas->CurrentValue;
		$this->idturnos->CurrentValue = NULL;
		$this->idturnos->OldValue = $this->idturnos->CurrentValue;
		$this->idaluno->CurrentValue = CurrentUserID();
		$this->nome->CurrentValue = NULL;
		$this->nome->OldValue = $this->nome->CurrentValue;
		$this->ativado->CurrentValue = NULL;
		$this->ativado->OldValue = $this->ativado->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'idturnos' first before field var 'x_idturnos'
		$val = $CurrentForm->hasValue("idturnos") ? $CurrentForm->getValue("idturnos") : $CurrentForm->getValue("x_idturnos");
		if (!$this->idturnos->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idturnos->Visible = FALSE; // Disable update for API request
			else
				$this->idturnos->setFormValue($val);
		}

		// Check field name 'idaluno' first before field var 'x_idaluno'
		$val = $CurrentForm->hasValue("idaluno") ? $CurrentForm->getValue("idaluno") : $CurrentForm->getValue("x_idaluno");
		if (!$this->idaluno->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idaluno->Visible = FALSE; // Disable update for API request
			else
				$this->idaluno->setFormValue($val);
		}

		// Check field name 'nome' first before field var 'x_nome'
		$val = $CurrentForm->hasValue("nome") ? $CurrentForm->getValue("nome") : $CurrentForm->getValue("x_nome");
		if (!$this->nome->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->nome->Visible = FALSE; // Disable update for API request
			else
				$this->nome->setFormValue($val);
		}

		// Check field name 'ativado' first before field var 'x_ativado'
		$val = $CurrentForm->hasValue("ativado") ? $CurrentForm->getValue("ativado") : $CurrentForm->getValue("x_ativado");
		if (!$this->ativado->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->ativado->Visible = FALSE; // Disable update for API request
			else
				$this->ativado->setFormValue($val);
		}

		// Check field name 'idaulas' first before field var 'x_idaulas'
		$val = $CurrentForm->hasValue("idaulas") ? $CurrentForm->getValue("idaulas") : $CurrentForm->getValue("x_idaulas");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->idturnos->CurrentValue = $this->idturnos->FormValue;
		$this->idaluno->CurrentValue = $this->idaluno->FormValue;
		$this->nome->CurrentValue = $this->nome->FormValue;
		$this->ativado->CurrentValue = $this->ativado->FormValue;
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

		// Check if valid User ID
		if ($res) {
			$res = $this->showOptionLink('add');
			if (!$res) {
				$userIdMsg = DeniedMessage();
				$this->setFailureMessage($userIdMsg);
			}
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
		$this->idaulas->setDbValue($row['idaulas']);
		$this->idturnos->setDbValue($row['idturnos']);
		$this->idaluno->setDbValue($row['idaluno']);
		$this->nome->setDbValue($row['nome']);
		$this->ativado->setDbValue($row['ativado']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idaulas'] = $this->idaulas->CurrentValue;
		$row['idturnos'] = $this->idturnos->CurrentValue;
		$row['idaluno'] = $this->idaluno->CurrentValue;
		$row['nome'] = $this->nome->CurrentValue;
		$row['ativado'] = $this->ativado->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("idaulas")) != "")
			$this->idaulas->OldValue = $this->getKey("idaulas"); // idaulas
		else
			$validKey = FALSE;

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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idaulas
		// idturnos
		// idaluno
		// nome
		// ativado

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// idaulas
			$this->idaulas->ViewValue = $this->idaulas->CurrentValue;
			$this->idaulas->ViewCustomAttributes = "";

			// idturnos
			$curVal = strval($this->idturnos->CurrentValue);
			if ($curVal != "") {
				$this->idturnos->ViewValue = $this->idturnos->lookupCacheOption($curVal);
				if ($this->idturnos->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idturnos`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idturnos->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idturnos->ViewValue = $this->idturnos->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idturnos->ViewValue = $this->idturnos->CurrentValue;
					}
				}
			} else {
				$this->idturnos->ViewValue = NULL;
			}
			$this->idturnos->ViewCustomAttributes = "";

			// idaluno
			$curVal = strval($this->idaluno->CurrentValue);
			if ($curVal != "") {
				$this->idaluno->ViewValue = $this->idaluno->lookupCacheOption($curVal);
				if ($this->idaluno->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->idaluno->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idaluno->ViewValue = $this->idaluno->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idaluno->ViewValue = $this->idaluno->CurrentValue;
					}
				}
			} else {
				$this->idaluno->ViewValue = NULL;
			}
			$this->idaluno->ViewCustomAttributes = "";

			// nome
			$curVal = strval($this->nome->CurrentValue);
			if ($curVal != "") {
				$this->nome->ViewValue = $this->nome->lookupCacheOption($curVal);
				if ($this->nome->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idacademia`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->nome->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->nome->ViewValue = $this->nome->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->nome->ViewValue = $this->nome->CurrentValue;
					}
				}
			} else {
				$this->nome->ViewValue = NULL;
			}
			$this->nome->ViewCustomAttributes = "";

			// ativado
			if (strval($this->ativado->CurrentValue) != "") {
				$this->ativado->ViewValue = $this->ativado->optionCaption($this->ativado->CurrentValue);
			} else {
				$this->ativado->ViewValue = NULL;
			}
			$this->ativado->ViewCustomAttributes = "";

			// idturnos
			$this->idturnos->LinkCustomAttributes = "";
			$this->idturnos->HrefValue = "";
			$this->idturnos->TooltipValue = "";

			// idaluno
			$this->idaluno->LinkCustomAttributes = "";
			$this->idaluno->HrefValue = "";
			$this->idaluno->TooltipValue = "";

			// nome
			$this->nome->LinkCustomAttributes = "";
			$this->nome->HrefValue = "";
			$this->nome->TooltipValue = "";

			// ativado
			$this->ativado->LinkCustomAttributes = "";
			$this->ativado->HrefValue = "";
			$this->ativado->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// idturnos
			$this->idturnos->EditAttrs["class"] = "form-control";
			$this->idturnos->EditCustomAttributes = "";
			if ($this->idturnos->getSessionValue() != "") {
				$this->idturnos->CurrentValue = $this->idturnos->getSessionValue();
				$curVal = strval($this->idturnos->CurrentValue);
				if ($curVal != "") {
					$this->idturnos->ViewValue = $this->idturnos->lookupCacheOption($curVal);
					if ($this->idturnos->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idturnos`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idturnos->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idturnos->ViewValue = $this->idturnos->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idturnos->ViewValue = $this->idturnos->CurrentValue;
						}
					}
				} else {
					$this->idturnos->ViewValue = NULL;
				}
				$this->idturnos->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idturnos->CurrentValue));
				if ($curVal != "")
					$this->idturnos->ViewValue = $this->idturnos->lookupCacheOption($curVal);
				else
					$this->idturnos->ViewValue = $this->idturnos->Lookup !== NULL && is_array($this->idturnos->Lookup->Options) ? $curVal : NULL;
				if ($this->idturnos->ViewValue !== NULL) { // Load from cache
					$this->idturnos->EditValue = array_values($this->idturnos->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idturnos`" . SearchString("=", $this->idturnos->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->idturnos->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idturnos->EditValue = $arwrk;
				}
			}

			// idaluno
			$this->idaluno->EditAttrs["class"] = "form-control";
			$this->idaluno->EditCustomAttributes = "";
			if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("add")) { // Non system admin
				$this->idaluno->CurrentValue = CurrentUserID();
				$curVal = strval($this->idaluno->CurrentValue);
				if ($curVal != "") {
					$this->idaluno->EditValue = $this->idaluno->lookupCacheOption($curVal);
					if ($this->idaluno->EditValue === NULL) { // Lookup from database
						$filterWrk = "`idpessoa`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->idaluno->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idaluno->EditValue = $this->idaluno->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idaluno->EditValue = $this->idaluno->CurrentValue;
						}
					}
				} else {
					$this->idaluno->EditValue = NULL;
				}
				$this->idaluno->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idaluno->CurrentValue));
				if ($curVal != "")
					$this->idaluno->ViewValue = $this->idaluno->lookupCacheOption($curVal);
				else
					$this->idaluno->ViewValue = $this->idaluno->Lookup !== NULL && is_array($this->idaluno->Lookup->Options) ? $curVal : NULL;
				if ($this->idaluno->ViewValue !== NULL) { // Load from cache
					$this->idaluno->EditValue = array_values($this->idaluno->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idpessoa`" . SearchString("=", $this->idaluno->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->idaluno->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idaluno->EditValue = $arwrk;
				}
			}

			// nome
			$this->nome->EditAttrs["class"] = "form-control";
			$this->nome->EditCustomAttributes = "";
			$curVal = trim(strval($this->nome->CurrentValue));
			if ($curVal != "")
				$this->nome->ViewValue = $this->nome->lookupCacheOption($curVal);
			else
				$this->nome->ViewValue = $this->nome->Lookup !== NULL && is_array($this->nome->Lookup->Options) ? $curVal : NULL;
			if ($this->nome->ViewValue !== NULL) { // Load from cache
				$this->nome->EditValue = array_values($this->nome->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idacademia`" . SearchString("=", $this->nome->CurrentValue, DATATYPE_NUMBER, "");
				}
				$sqlWrk = $this->nome->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->nome->EditValue = $arwrk;
			}

			// ativado
			$this->ativado->EditCustomAttributes = "";
			$this->ativado->EditValue = $this->ativado->options(FALSE);

			// Add refer script
			// idturnos

			$this->idturnos->LinkCustomAttributes = "";
			$this->idturnos->HrefValue = "";

			// idaluno
			$this->idaluno->LinkCustomAttributes = "";
			$this->idaluno->HrefValue = "";

			// nome
			$this->nome->LinkCustomAttributes = "";
			$this->nome->HrefValue = "";

			// ativado
			$this->ativado->LinkCustomAttributes = "";
			$this->ativado->HrefValue = "";
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

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->idturnos->Required) {
			if (!$this->idturnos->IsDetailKey && $this->idturnos->FormValue != NULL && $this->idturnos->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idturnos->caption(), $this->idturnos->RequiredErrorMessage));
			}
		}
		if ($this->idaluno->Required) {
			if (!$this->idaluno->IsDetailKey && $this->idaluno->FormValue != NULL && $this->idaluno->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idaluno->caption(), $this->idaluno->RequiredErrorMessage));
			}
		}
		if ($this->nome->Required) {
			if (!$this->nome->IsDetailKey && $this->nome->FormValue != NULL && $this->nome->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->nome->caption(), $this->nome->RequiredErrorMessage));
			}
		}
		if ($this->ativado->Required) {
			if ($this->ativado->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->ativado->caption(), $this->ativado->RequiredErrorMessage));
			}
		}

		// Validate detail grid
		$detailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("pessoa", $detailTblVar) && $GLOBALS["pessoa"]->DetailAdd) {
			if (!isset($GLOBALS["pessoa_grid"]))
				$GLOBALS["pessoa_grid"] = new pessoa_grid(); // Get detail page object
			$GLOBALS["pessoa_grid"]->validateGridForm();
		}
		if (in_array("videos", $detailTblVar) && $GLOBALS["videos"]->DetailAdd) {
			if (!isset($GLOBALS["videos_grid"]))
				$GLOBALS["videos_grid"] = new videos_grid(); // Get detail page object
			$GLOBALS["videos_grid"]->validateGridForm();
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

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check if valid User ID
		$validUser = FALSE;
		if ($Security->currentUserID() != "" && !EmptyValue($this->idaluno->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->idaluno->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->idaluno->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}
		$conn = $this->getConnection();

		// Begin transaction
		if ($this->getCurrentDetailTable() != "")
			$conn->beginTrans();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// idturnos
		$this->idturnos->setDbValueDef($rsnew, $this->idturnos->CurrentValue, NULL, FALSE);

		// idaluno
		$this->idaluno->setDbValueDef($rsnew, $this->idaluno->CurrentValue, NULL, FALSE);

		// nome
		$this->nome->setDbValueDef($rsnew, $this->nome->CurrentValue, NULL, FALSE);

		// ativado
		$this->ativado->setDbValueDef($rsnew, $this->ativado->CurrentValue, 0, FALSE);

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

		// Add detail records
		if ($addRow) {
			$detailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("pessoa", $detailTblVar) && $GLOBALS["pessoa"]->DetailAdd) {
				$GLOBALS["pessoa"]->idaula->setSessionValue($this->idaulas->CurrentValue); // Set master key
				if (!isset($GLOBALS["pessoa_grid"]))
					$GLOBALS["pessoa_grid"] = new pessoa_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "pessoa"); // Load user level of detail table
				$addRow = $GLOBALS["pessoa_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["pessoa"]->idaula->setSessionValue(""); // Clear master key if insert failed
				}
			}
			if (in_array("videos", $detailTblVar) && $GLOBALS["videos"]->DetailAdd) {
				$GLOBALS["videos"]->idaulas->setSessionValue($this->idaulas->CurrentValue); // Set master key
				if (!isset($GLOBALS["videos_grid"]))
					$GLOBALS["videos_grid"] = new videos_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "videos"); // Load user level of detail table
				$addRow = $GLOBALS["videos_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["videos"]->idaulas->setSessionValue(""); // Clear master key if insert failed
				}
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() != "") {
			if ($addRow) {
				$conn->commitTrans(); // Commit transaction
			} else {
				$conn->rollbackTrans(); // Rollback transaction
			}
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
			return $Security->isValidUserID($this->idaluno->CurrentValue);
		return TRUE;
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{
		$validMaster = FALSE;

		// Get the keys for master table
		if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== NULL) {
			$masterTblVar = $master;
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "turnos") {
				$validMaster = TRUE;
				if (($parm = Get("fk_idturnos", Get("idturnos"))) !== NULL) {
					$GLOBALS["turnos"]->idturnos->setQueryStringValue($parm);
					$this->idturnos->setQueryStringValue($GLOBALS["turnos"]->idturnos->QueryStringValue);
					$this->idturnos->setSessionValue($this->idturnos->QueryStringValue);
					if (!is_numeric($GLOBALS["turnos"]->idturnos->QueryStringValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		} elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== NULL) {
			$masterTblVar = $master;
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "turnos") {
				$validMaster = TRUE;
				if (($parm = Post("fk_idturnos", Post("idturnos"))) !== NULL) {
					$GLOBALS["turnos"]->idturnos->setFormValue($parm);
					$this->idturnos->setFormValue($GLOBALS["turnos"]->idturnos->FormValue);
					$this->idturnos->setSessionValue($this->idturnos->FormValue);
					if (!is_numeric($GLOBALS["turnos"]->idturnos->FormValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		}
		if ($validMaster) {

			// Save current master table
			$this->setCurrentMasterTable($masterTblVar);

			// Reset start record counter (new master key)
			if (!$this->isAddOrEdit()) {
				$this->StartRecord = 1;
				$this->setStartRecordNumber($this->StartRecord);
			}

			// Clear previous master key from Session
			if ($masterTblVar != "turnos") {
				if ($this->idturnos->CurrentValue == "")
					$this->idturnos->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	protected function setupDetailParms()
	{

		// Get the keys for master table
		$detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
		if ($detailTblVar !== NULL) {
			$this->setCurrentDetailTable($detailTblVar);
		} else {
			$detailTblVar = $this->getCurrentDetailTable();
		}
		if ($detailTblVar != "") {
			$detailTblVar = explode(",", $detailTblVar);
			if (in_array("pessoa", $detailTblVar)) {
				if (!isset($GLOBALS["pessoa_grid"]))
					$GLOBALS["pessoa_grid"] = new pessoa_grid();
				if ($GLOBALS["pessoa_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["pessoa_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["pessoa_grid"]->CurrentMode = "add";
					$GLOBALS["pessoa_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["pessoa_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["pessoa_grid"]->setStartRecordNumber(1);
					$GLOBALS["pessoa_grid"]->idaula->IsDetailKey = TRUE;
					$GLOBALS["pessoa_grid"]->idaula->CurrentValue = $this->idaulas->CurrentValue;
					$GLOBALS["pessoa_grid"]->idaula->setSessionValue($GLOBALS["pessoa_grid"]->idaula->CurrentValue);
				}
			}
			if (in_array("videos", $detailTblVar)) {
				if (!isset($GLOBALS["videos_grid"]))
					$GLOBALS["videos_grid"] = new videos_grid();
				if ($GLOBALS["videos_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["videos_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["videos_grid"]->CurrentMode = "add";
					$GLOBALS["videos_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["videos_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["videos_grid"]->setStartRecordNumber(1);
					$GLOBALS["videos_grid"]->idaulas->IsDetailKey = TRUE;
					$GLOBALS["videos_grid"]->idaulas->CurrentValue = $this->idaulas->CurrentValue;
					$GLOBALS["videos_grid"]->idaulas->setSessionValue($GLOBALS["videos_grid"]->idaulas->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("aulaslist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
	}

	// Set up detail pages
	protected function setupDetailPages()
	{
		$pages = new SubPages();
		$pages->Style = "tabs";
		$pages->add('pessoa');
		$pages->add('videos');
		$this->DetailPages = $pages;
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
				case "x_idturnos":
					break;
				case "x_idaluno":
					break;
				case "x_nome":
					break;
				case "x_ativado":
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
						case "x_idturnos":
							break;
						case "x_idaluno":
							break;
						case "x_nome":
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
} // End class
?>