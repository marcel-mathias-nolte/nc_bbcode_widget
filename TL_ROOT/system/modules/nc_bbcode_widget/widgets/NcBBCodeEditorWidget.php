<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   NC BBCode Widgets 
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015
 * @website	  https://www.noltecomputer.com
 * @license   <marcel.nolte@noltecomputer.de> wrote this file. As long as you retain this notice you
 *            can do whatever you want with this stuff. If we meet some day, and you think this stuff 
 *            is worth it, you can buy me a beer in return. Meanwhile you can provide a link to my
 *            homepage, if you want, or send me a postcard. Be creative! Marcel Mathias Nolte
 */
 
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace NC;

/**
 * Class NcBBCodeEditorWidget
 *
 * Widget "bbcode".
 */
class NcBBCodeEditorWidget extends \Widget
{
	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Rows
	 * @var integer
	 */
	protected $intRows = 12;

	/**
	 * Columns
	 * @var integer
	 */
	protected $intCols = 80;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'widget_textarea_bbcode';

	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'maxlength':
				if ($varValue > 0)
				{
					$this->arrAttributes['maxlength'] =  $varValue;
				}
				break;

			case 'mandatory':
				if ($varValue)
				{
					$this->arrAttributes['required'] = 'required';
				}
				else
				{
					unset($this->arrAttributes['required']);
				}
				parent::__set($strKey, $varValue);
				break;

			case 'placeholder':
				$this->arrAttributes['placeholder'] = $varValue;
				break;

			case 'size':
				$arrSize = deserialize($varValue);
				$this->intRows = $arrSize[0];
				$this->intCols = $arrSize[1];
				break;

			case 'rows':
				$this->intRows = $varValue;
				break;

			case 'cols':
				$this->intCols = $varValue;
				break;
				
			case 'blnShowLabelInside':
				$this->blnShowLabelInside = $varValue;
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}
	
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		return '';
	}

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function compile()
	{
		global $objPage;
		$arrStrip = array();

		// XHTML does not support maxlength
		if ($objPage->outputFormat == 'xhtml')
		{
			$arrStrip[] = 'maxlength';
		}

		$this->Template->strId = $this->strId;
		$this->Template->hasErrors = $this->hasErrors();
		$this->Template->arrErrors = $this->arrErrors;
		$this->Template->strName = $this->strName;
		$this->Template->strId = $this->strId;
		$this->Template->strLabel = $this->strLabel;
		$this->Template->strClass = 'textarea bbcode' . (strlen($this->strClass) ? ' ' . $this->strClass : '');
		$this->Template->intRows = $this->intRows;
		$this->Template->intCols = $this->intCols;
		$this->Template->strClass = $this->strClass;
		$this->Template->strAttributes = $this->getAttributes($arrStrip);
		$this->Template->varValue = $this->blnShowLabelInside && empty($this->varValue) ? $this->strLabel : specialchars(str_replace('\n', "\n", $this->varValue));	
		$this->Template->strPreviewLabel = $GLOBALS['TL_LANG']['MSC']['bbcode_preview'];
		$this->Template->mandatory = $this->mandatory;
		
		return parent::compile();
	}

}