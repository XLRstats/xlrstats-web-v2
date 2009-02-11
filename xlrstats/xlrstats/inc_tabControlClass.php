<?php

/**
 * Generates a tab control using html and javascript
 *
 * @author Botan Guner
 *
 * @link botan.guner@gmail.com
 *
 * @abstract A PHP Class that genaretes a tab page control using html and javascript
 *
 * @package tabControl
 *
 * @see http://botan.fikriala.com
 *
 * @version 0.2
 *
 * @todo Documentation
 * @todo Mozilla, Netscape on Windows support
 * @todo Macintosh support
 */
class TabControl {
	/**
	 * Main tabcontrol settings...
	 *
	 * @var Array
	 */
	public $settings;
	/**
	 * Main HTML table...
	 *
	 * @var String
	 */
	public $table;
	/**
	 * Custom CSS attributes...
	 *
	 * @var Array
	 */
	public $style=array();
	/**
	 * Tab Page Titles...
	 *
	 * @var Array
	 */
	public $titles=array();
	/**
	 * The contests that is displayed in the tab page.
	 *
	 * @var String
	 */
	public $contents=array();
	/**
	 * Status Bar messages...
	 *
	 * @var Array
	 */
	public $sbMessages=array();
	/**
	 * Is custom setings defined or not default false...
	 *
	 * @var Boolean
	 */
	public $settingsDefined=false;
	/**
	 * Is custom style defined or not default false...
	 *
	 * @var Boolean
	 */
	public $styleDefined=false;
	/**
	 * The Javascript functions
	 * Functions
	 * ---------
	 * showHidePages(itemToShow)	-> Hides the tab pages and shows the itemToShow
	 * tab_over(w,s)				-> The Mouseover state of the tabs
	 * tab_click(w)					-> The Click state of the tabs
	 * setMessageText(g)			-> Show the statusbar messages
	 *
	 *
	 * Public Variables
	 * ---------
	 * var selected_tab
	 *
	 * @var String
	 */
	public $javasScripts;


	/**
	 * Writes the default values for the tabControl or define custom attributes
	 *
	 * @param integer $selectedTab
	 * @param string $controlWidth
	 * @param string $pageHeight
	 * @param integer $tabPageCount
	 * @param string $tabSpace
	 * @param string $align
	 * @param string $valign
	 * @param array $titles
	 * @param array $contents
	 * @param array $statusBarMessages
	 */
	function defineSettings($selectedTab= 0,$controlWidth= "400",$pageHeight= "200px",$tabPageCount= 3,$tabSpace= "2px",$align= "left",$valign= "top",$titles=array("Tab 1","Tab 2","Tab 3"),$contents=array("Content 1","Content 2","Content 3"),$statusBarMessages=array("Statusbar Message 1","Statusbar Message 2","Statusbar Message 2")) {

		$this->settings["selectedTab"]	= $selectedTab		;
		$this->settings["controlWidth"]	= $controlWidth		;
		$this->settings["tabPageCount"]	= $tabPageCount		;
		$this->settings["columnCount"]	= $tabPageCount+($tabPageCount-1);
		$this->settings["tabSpace"]		= $tabSpace			;
		$this->settings["pageHeight"]	= $pageHeight		;
		$this->settings["align"]		= $align			;
		$this->settings["valign"]		= $valign			;

		if(count($titles)>0) {
			foreach ($titles as $titles_value) {
				$this->titles[]		= $titles_value;
			}
		} else {
			$this->titles			= array_fill(0,$this->settings["tabPageCount"],"Tab");
		}


		if(count($contents)>0) {
			foreach($contents as $contents_key => $contents_value) {
				$this->contents[]	= $contents_value;
			}
		} else {
			$this->contents			= array_fill(0,$this->settings["tabPageCount"],"&nbsp;");
		}


		if(count($statusBarMessages)>0) {
			foreach ($statusBarMessages as $sbMessages_key => $sbMessages_value) {
				$this->sbMessages[]	= $sbMessages_value;
			}
		} else {
			$this->sbMessages		= array_fill(0,$this->settings["tabPageCount"],"&nbsp;");
		}

		if($this->styleDefined==false) {
			$this->defineStyle();
		}
		$this->settingsDefined=true;
		$this->createControl();
	}

	/**
	 * Defines the a default style or assing custom values to the attributes
	 *
	 * @param string $backgroundColor
	 * @param string $selectedBgColor
	 * @param string $mouseOverColor
	 * @param string $borderColor
	 * @param string $borderSize
	 * @param string $borderStyle
	 * @param string $font
	 * @param string $textAlign
	 * @param string $fontSize
	 * @param string $fontWeight
	 */
	function defineStyle($ptab_backgroundColor= "buttonface",$ptab_selectedBgColor= "#EBEBEB",$ptab_mouseOverColor= "#9CAECF",$ptab_borderColor= "black",$ptab_borderSize= "1px",$ptab_borderStyle= "solid",$ptab_font= "Geneva, Arial, Helvetica, sans-serif",$ptab_textAlign= "center",$ptab_fontSize= "12px",$ptab_fontWeight= "bold",$ptab_Color="#FFFFFF") {
		$this->style["Color"]           = $ptab_Color;
    $this->style["backgroundColor"]	= $ptab_backgroundColor	;
		$this->style["selectedBgColor"]	= $ptab_selectedBgColor	;
		$this->style["mouseOverColor"]	= $ptab_mouseOverColor	;
		$this->style["borderColor"]		  = $ptab_borderColor		;
		$this->style["borderSize"]		  = $ptab_borderSize		;
		$this->style["borderStyle"]		  = $ptab_borderStyle		;
		$this->style["fontFamily"]		  = $ptab_font				;
		$this->style["textAlign"]		    = $ptab_textAlign		;
		$this->style["fontSize"]	     	= $ptab_fontSize			;
		$this->style["fontWeight"]	   	= $ptab_fontWeight		;
		$this->styleDefined				      = true				;
	}

	/**
	 * Writes the CSS
	 *
	 */
	function writeCSS() {
		$this->style["styleSheet"] = "
<style type='text/css'>
<!--
.tabs {
	color:".$this->style["Color"].";
  border-left:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
	border-top:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
	border-right:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
	background-color:".$this->style["backgroundColor"].";
	font-family:".$this->style["fontFamily"].";
	text-align:".$this->style["textAlign"].";
	font-size:".$this->style["fontSize"].";
	font-weight:".$this->style["fontWeight"].";
	cursor:pointer;
	cursor:hand;
}
.tab_gaps {
	border-bottom:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
}
.tab_pages {
	border-left:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
	border-bottom:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
	border-right:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";
	background-color:".$this->style["backgroundColor"].";
	display:;
}
-->
</style>
		";
	}

	/**
	 * Writes the Javascript functions
	 *
	 */
	function writeJavaScripts(){
		$this->javasScripts["scripts"] = "
<script language='javascript' type='text/javascript'>
	var selected_tab=\"".$this->settings["selectedTab"]."\";
	function showHidePages(itemToShow) {
		var obj = document.GetElementById(itemToShow);
		if(obj.style.display==\"none\") {
			obj.style.display=\"block\";
		}
	}
	function tab_over(w,s)
	{
		if(s==\"1\")
		{
			w.style.background = \"".$this->style["mouseOverColor"]."\";
		}
		else
		{
			w.style.background = \"".$this->style["backgroundColor"]."\";
		}
		//alert(selected_tab);
		document.getElementById(\"tab\"+selected_tab).style.background=\"".$this->style["selectedBgColor"]."\";
	}
	function tab_click(w) {
		selected_tab=w;
		for(i=0;i<".$this->settings["tabPageCount"].";i++)
		{
			document.getElementById(\"tab\"+i).style.background = \"".$this->style["backgroundColor"]."\";
			document.getElementById(\"rpages\"+i).style.background=\"".$this->style["backgroundColor"]."\";
			document.getElementById(\"rpages\"+i).style.display=\"none\";
		}
		for(j=0;j<".$this->settings["columnCount"].";j++) {
			try
			{
				document.getElementById(\"tab\"+j).style.borderBottom=\"".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"]."\";
			}
			catch(e) {}
		}
		document.getElementById(\"tab\"+w).style.background = \"".$this->style["selectedBgColor"]."\";
		document.getElementById(\"rpages\"+w).style.background=\"".$this->style["selectedBgColor"]."\";
		document.getElementById(\"cpages\"+w).style.background=\"".$this->style["selectedBgColor"]."\";
		document.getElementById(\"rpages\"+w).style.display=\"\";
		document.getElementById(\"tab\"+w).style.borderBottom=\"none\";

	}
function setMessageText(g) {
	var statusbar=document.getElementById(\"statusBar\");
	statusbar.innerHTML=g;
}
</script>
		";
	}

	/**
	 * Main code that generates the visual tabPages and control
	 *
	 * @param string $tableID
	 */
	function createControl($tableID="tabControl"){
		$this->settings["tableID"]=$tableID;
		$this->table["tableStart"]	= "<table width='".$this->settings["controlWidth"]."' onMouseOut='setMessageText(\"&nbsp;\")' id='".$this->settings["tableID"]."' border='0' cellspacing='0' cellpadding='0'>
	";
		//starting to create the tabs
		$this->table["rowStart"]	= "<tr>
	";
		$this->table["tabsColumns"]	= "";
		$this->table["tabPages"]	= "";
		$j							= 0;
		//tabs
		for ($i=0;$i<$this->settings["columnCount"];$i++) {
			if (($i % 2) == 0) {
				//tabs
				$properties = " class='tabs' id='tab$j'  onMouseOver=\"tab_over(this,'1');setMessageText('".$this->sbMessages[$j]."')\" onMouseOut=\"tab_over(this,'0')\" onClick=\"tab_click($j);tab_over(this,'0')\"";
				$title		= $this->titles[$j];
				$j++;
			}
			else
			{
				//tabs gaps
				$properties = " style='width:".$this->settings["tabSpace"]."' class='tab_gaps' id='gap$i'";
				$title		= "&nbsp;";
			}

			$this->table["tabsColumns"]	.= "	<td$properties>$title</td>
	";

		}
		//pages
		for ($i=0;$i<$this->settings["tabPageCount"];$i++) {
			$this->table["tabPages"]	.= "	<tr id='rpages$i' style='height:".$this->settings["pageHeight"].";' class='tab_pages'>
			<td colspan=".$this->settings["columnCount"]." id='cpages$i' align='".$this->settings["align"]."' class='tab_pages' valign='".$this->settings["valign"]."'>".$this->contents[$i]."</td>
	</tr>
	";
		}
		$this->table["rowEnd"]		= "</tr>
";



		$this->table["tableEnd"]	= "</table>
		";
	}

	/**
	 * Generates a status bar that displays shor messages when mouse is over the tabs
	 *
	 */
	function writeStatusBar(){
		$this->table["statusBar"] = "
		<tr>
		<td colspan=".$this->settings["columnCount"].">
		<table width=100%  border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td style='font-family:Geneva, Arial, Helvetica, sans-serif;font-size:10px;border-bottom:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";border-left:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";background-color:".$this->style["backgroundColor"].";' id='statusBar'>&nbsp;</td>
				<td style='width:10px;cursor:se-resize;border-bottom:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";border-right:".$this->style["borderSize"]." ".$this->style["borderStyle"]." ".$this->style["borderColor"].";background-color:".$this->style["backgroundColor"].";'>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
		";
	}

	/**
	 * Sets the selected tab selected
	 *
	 */
	function theEnd(){
		if($this->settings["selectedTab"]==0) {
			$minus = 0;
		} else {
			$minus = 1;
		}

		$this->javasScripts["theEnd"] = "
		<script language='javascript' type='text/javascript'>
			tab_click(\"".($this->settings["selectedTab"]-$minus)."\");
		</script>
		";
	}

	/**
	 * Generates the control
	 *
	 */
	function writeControl(){

		if($this->settingsDefined==false) {
			$this->defineSettings();
		}
		$this->writeCSS();
		echo $this->style["styleSheet"];
		$this->writeJavaScripts();
		echo $this->javasScripts["scripts"];
		echo $this->table["tableStart"];
		echo $this->table["rowStart"];
		echo $this->table["tabsColumns"];
		echo $this->table["rowEnd"];
		echo $this->table["tabPages"];
		$this->writeStatusBar();
		echo $this->table["statusBar"];
		$this->theEnd();
		echo $this->table["tableEnd"];
		echo $this->javasScripts["theEnd"];
	}

}
?>
