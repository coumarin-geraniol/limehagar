<?php

/*
* LimeSurvey
* Copyright (C) 2007-2011 The LimeSurvey Project Team / Carsten Schmitz
* All rights reserved.
* License: GNU/GPL License v2 or later, see LICENSE.php
* LimeSurvey is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
*/
# override the default TCPDF config file
if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
    define('K_TCPDF_EXTERNAL_CONFIG', true);
}

# include TCPDF
require(APPPATH . 'config/tcpdf' . EXT);

/**
* page format
*/
(!defined('PDF_PAGE_FORMAT')) ? (define('PDF_PAGE_FORMAT', $tcpdf['page_format'] ?? 'A4')) : '';

/**
* page orientation (P=portrait, L=landscape)
*/
(!defined('PDF_PAGE_ORIENTATION')) ? (define('PDF_PAGE_ORIENTATION', $tcpdf['page_orientation'] ?? 'P')) : '';

/**
* document creator
*/
(!defined('PDF_CREATOR')) ? (define('PDF_CREATOR', $tcpdf['creator'] ?? 'TCPDF')) : '';

/**
* document author
*/
(!defined('PDF_AUTHOR')) ? (define('PDF_AUTHOR', $tcpdf['author'] ?? 'TCPDF')) : '';

/**
* header title
*/
(!defined('PDF_HEADER_TITLE')) ? (define('PDF_HEADER_TITLE', $tcpdf['header_title'] ?? 'TCPDF Example')) : '';

/**
* header description string
*/
(!defined('PDF_HEADER_STRING')) ? (define('PDF_HEADER_STRING', $tcpdf['header_string'] ?? "by Nicola Asuni - Tecnick.com\nwww.tcpdf.org")) : '';

/**
* image logo
*/
(!defined('PDF_HEADER_LOGO')) ? (define('PDF_HEADER_LOGO', $tcpdf['header_logo'] ?? 'tcpdf_logo.jpg')) : '';

/**
* header logo image width [mm]
*/
(!defined('PDF_HEADER_LOGO_WIDTH')) ? (define('PDF_HEADER_LOGO_WIDTH', $tcpdf['header_logo_width'] ?? 30)) : '';

/**
*  document unit of measure [pt=point, mm=millimeter, cm=centimeter, in=inch]
*/
(!defined('PDF_UNIT')) ? (define('PDF_UNIT', $tcpdf['page_unit'] ?? 'mm')) : '';

/**
* header margin
*/
(!defined('PDF_MARGIN_HEADER')) ? (define('PDF_MARGIN_HEADER', $tcpdf['header_margin'] ?? 5)) : '';

/**
* footer margin
*/
(!defined('PDF_MARGIN_FOOTER')) ? (define('PDF_MARGIN_FOOTER', $tcpdf['footer_margin'] ?? 10)) : '';

/**
* top margin
*/
(!defined('PDF_MARGIN_TOP')) ? (define('PDF_MARGIN_TOP', $tcpdf['margin_top'] ?? 27)) : '';

/**
* bottom margin
*/
(!defined('PDF_MARGIN_BOTTOM')) ? (define('PDF_MARGIN_BOTTOM', $tcpdf['margin_bottom'] ?? 25)) : '';

/**
* left margin
*/
(!defined('PDF_MARGIN_LEFT')) ? (define('PDF_MARGIN_LEFT', $tcpdf['margin_left'] ?? 15)) : '';

/**
* right margin
*/
(!defined('PDF_MARGIN_RIGHT')) ? (define('PDF_MARGIN_RIGHT', $tcpdf['margin_right'] ?? 15)) : '';

/**
* default main font name
*/
(!defined('PDF_FONT_NAME_MAIN')) ? (define('PDF_FONT_NAME_MAIN', $tcpdf['page_font'] ?? 'helvetica')) : '';

/**
* default main font size
*/
(!defined('PDF_FONT_SIZE_MAIN')) ? (define('PDF_FONT_SIZE_MAIN', $tcpdf['page_font_size'] ?? 10)) : '';

/**
* default data font name
*/
(!defined('PDF_FONT_NAME_DATA')) ? (define('PDF_FONT_NAME_DATA', $tcpdf['data_font'] ?? 'helvetica')) : '';

/**
* default data font size
*/
(!defined('PDF_FONT_SIZE_DATA')) ? (define('PDF_FONT_SIZE_DATA', $tcpdf['data_font_size'] ?? 8)) : '';

/**
* default monospaced font name
*/
(!defined('PDF_FONT_MONOSPACED')) ? (define('PDF_FONT_MONOSPACED', $tcpdf['mono_font'] ?? 'courier')) : '';

/**
* ratio used to adjust the conversion of pixels to user units
*/
(!defined('PDF_IMAGE_SCALE_RATIO')) ? (define('PDF_IMAGE_SCALE_RATIO', $tcpdf['image_scale'] ?? 1.25)) : '';

/**
* magnification factor for titles
*/
(!defined('HEAD_MAGNIFICATION')) ? (define('HEAD_MAGNIFICATION', 1.1)) : ''; // never used in TCPDF 6.

/**
* height of cell repect font height
*/
(!defined('K_CELL_HEIGHT_RATIO')) ? (define('K_CELL_HEIGHT_RATIO', $tcpdf['cell_height_ratio'] ?? 1.25)) : '';

/**
* title magnification respect main font size
*/
(!defined('K_TITLE_MAGNIFICATION')) ? (define('K_TITLE_MAGNIFICATION', 1.3)) : ''; // never used in TCPDF 6.

/**
* reduction factor for small font
*/
(!defined('K_SMALL_RATIO')) ? (define('K_SMALL_RATIO', $tcpdf['small_font_ratio'] ?? 2 / 3)) : '';

/**
* set to true to enable the special procedure used to avoid the overlapping of symbols on Thai language
*/
(!defined('K_THAI_TOPCHARS')) ? (define('K_THAI_TOPCHARS', $tcpdf['thai_top_chars'] ?? true)) : '';

/**
* if true allows to call TCPDF methods using HTML syntax
* IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
*/
(!defined('K_TCPDF_CALLS_IN_HTML')) ? (define('K_TCPDF_CALLS_IN_HTML', $tcpdf['tcpdf_in_html'] ?? true)) : '';


/************************************************************
* TCPDF - CodeIgniter Integration
* Library file
* ----------------------------------------------------------
* @author Jonathon Hill http://jonathonhill.net
* @version 1.0
* @package tcpdf_ci
***********************************************************/
class pdf extends TCPDF
{


    /**
     * TCPDF system constants that map to settings in our config file
     *
     * @var array
     * @access private
     */
    private $cfg_constant_map = array(
        'K_PATH_MAIN'   => 'base_directory',
        'K_PATH_URL'    => 'base_url',
        'K_PATH_FONTS'  => 'fonts_directory',
        'K_PATH_CACHE'  => 'cache_directory',
        'K_PATH_IMAGES' => 'image_directory',
        'K_BLANK_IMAGE' => 'blank_image',
        'K_SMALL_RATIO' => 'small_font_ratio',
    );


    /**
     * Settings from our APPPATH/config/tcpdf.php file
     *
     * @var array
     * @access private
     */
    private $_config = array();

    /**
     * Base font size for answer PDF export
     *
     * @var int
     * @access private
     */
    private $_ibaseAnswerFontSize = 12;

    /**
     * Cell height for answer PDF export
     *
     * @var int
     * @access private
     */
    private $_iCellHeight = 6;

    /**
     * Survey Information (preventing from passing to methods every time)
     *
     * @var array
     * @access private
     */
    private $_aSurveyInfo = array();

    /**
     * Set _config for pdf
     * @access public
     * @param mixed $tcpdf
     * @return
     */
    public function setConfig($tcpdf)
    {
        $this->_config = $tcpdf;
    }


    /**
     * Initialize and configure TCPDF with the settings in our config file
     *
     */
    public function __construct()
    {

        # load the config file
        require(APPPATH . 'config/tcpdf' . EXT);
        $this->_config = $tcpdf;
        unset($tcpdf);

        # set the TCPDF system constants
        foreach ($this->cfg_constant_map as $const => $cfgkey) {
            if (!defined($const)) {
                define($const, $this->_config[$cfgkey]);
                #echo sprintf("Defining: %s = %s\n<br />", $const, $this->_config[$cfgkey]);
            }
        }

        # initialize TCPDF
        parent::__construct(
            $this->_config['page_orientation'],
            $this->_config['page_unit'],
            $this->_config['page_format'],
            $this->_config['unicode'],
            $this->_config['encoding'],
            $this->_config['enable_disk_cache']
        );


        # margin settings
        $this->SetMargins($this->_config['margin_left'], $this->_config['margin_top'], $this->_config['margin_right']);

        # header settings
        $this->print_header = $this->_config['header_on'];
        #$this->print_header = FALSE;
        $this->setHeaderFont(array($this->_config['header_font'], '', $this->_config['header_font_size']));
        $this->setHeaderMargin($this->_config['header_margin']);
        //$this->SetHeaderData();
        //$this->SetHeaderData(
        //  $this->_config['header_logo'],
        //  $this->_config['header_logo_width'],
        //  $this->_config['header_title'],
        //  $this->_config['header_string']
        //);

        # footer settings
        $this->print_footer = $this->_config['footer_on'];
        $this->setFooterFont(array($this->_config['footer_font'], '', $this->_config['footer_font_size']));
        $this->setFooterMargin($this->_config['footer_margin']);

        # page break
        $this->SetAutoPageBreak($this->_config['page_break_auto'], $this->_config['footer_margin']);

        # cell settings
        $this->cMargin = $this->_config['cell_padding'];
        $this->setCellHeightRatio($this->_config['cell_height_ratio']);

        # document properties
        $this->author = $this->_config['author'];
        $this->creator = $this->_config['creator'];

        # font settings
        #$this->SetFont($this->_config['page_font'], '', $this->_config['page_font_size']);

        # image settings
        $this->setImageScale($this->_config['image_scale']);
    }

    /**
     *
     *
     * @param string $text
     * @param $format
     * @deprecated
     * @return void
     */
    public function intopdf($text, $format = '')
    {
        $text = $this->delete_html($text);
        $oldformat = $this->FontStyle;
        $this->SetFont('', $format, $this->FontSizePt);
        $this->Write(5, $text);
        $this->ln(5);
        $this->SetFont('', $oldformat, $this->FontSizePt);
    }

    /**
     *
     * Writes a big title in the page + description
     * @param $title
     * @param $description
     * @return void
     */
    public function titleintopdf($title, $description = '')
    {
        if (!empty($title)) {
            $title = $this->delete_html($title);
            $oldsize = $this->FontSizePt;
            $this->SetFontSize($oldsize + 4);
            $this->Line(5, $this->y, ($this->w - 5), $this->y);
            $this->ln(3);
            $this->MultiCell('', '', $title, '', 'C', 0);
            if (!empty($description) && isset($description)) {
                $description = $this->delete_html($description);
                $this->ln(7);
                $this->SetFontSize($oldsize + 2);
                $this->MultiCell('', '', $description, '', 'C', 0);
                $this->ln(2);
            } else {
                $this->ln(4);
            }
            $this->Line(5, $this->y, ($this->w - 5), $this->y);
            $this->ln(5);
            $this->SetFontSize($oldsize);
        }
    }
    /**
     *
     * Creates a Table with equal cell width and Bold text. Used as Head for equalTable()
     * @param $array(0=>)
     * @return void
     */
    public function tablehead($array)
    {
        //$maxwidth = array();
        $maxwidth = $this->getEqualWidth($array);
        $oldStyle = $this->FontStyle;
        $this->SetFont($this->FontFamily, 'B', $this->FontSizePt);
        $arraySize = sizeof($array);
        for ($a = 0; $a < $arraySize; $a++) {
            for ($b = 0; $b < sizeof($array[$a]); $b++) {
                $this->Cell($maxwidth, 4, $this->delete_html($array[$a][$b]), 0, 0, 'L');
            }
            $this->ln();
        }
        $this->ln(5);
        $this->SetFont($this->FontFamily, $oldStyle, $this->FontSizePt);
    }
    /**
     *
     * Creates a Table with equal cell width.
     * @param $array - table array( 0=> array("td", "td", "td"),
     *                              1=> array("td", "td", "td"))
     * @param integer $modulo - fills each second row with a light-grey for better visibility. Default is on turn off with 0
     * @return void
     */
    public function equalTable($array, $modulo = 1)
    {
        $maxwidth = $this->getEqualWidth($array);
        $this->SetFillColor(220, 220, 220);
        $arraySize = sizeof($array);
        for ($a = 0; $a < $arraySize; $a++) {
            if ($modulo) {
                if ($a % 2 === 0) {
                    $fill = 0;
                } else {
                    $fill = 1;
                }
            } else {
                $fill = 0;
            }
            for ($b = 0; $b < sizeof($array[$a]); $b++) {
                $this->Cell($maxwidth, 4, $this->delete_html($array[$a][$b]), 0, 0, 'L', $fill);
            }
            $this->ln();
        }
        $this->ln(5);
    }
    /**
     *
     * Creates a table using the full width of page
     * @param $array Table array( 0=> array("td", "td", "td"),
     *                              1=> array("td", "td", "td"))
     * @param $modulo Fills each second row with a light-grey for better visibility. Default is off, turn on with 1
     * @return void
     */
    public function tableintopdf($array, $modulo = 1)
    {
        $maxwidth = array();
        $maxwidth = $this->getFullWidth($array);

        $this->SetFillColor(220, 220, 220);
        $arraySize = sizeof($array);
        for ($a = 0; $a < $arraySize; $a++) {
            if ($modulo) {
                if ($a % 2 === 0) {
                    $fill = 0;
                } else {
                    $fill = 1;
                }
            } else {
                $fill = 0;
            }
            $subArraySize = sizeof($array[$a]);
            for ($b = 0; $b < $subArraySize; $b++) {
                //echo $maxwidth[$b]." max $b.Spalte<br/>";
                $this->Cell($maxwidth[$b], 4, $this->delete_html($array[$a][$b]), 0, 0, 'L', $fill);
            }
            $this->ln();
        }
        $this->ln(5);
    }
    /**
     *
     * creates a table with a bold head using the full width of page
     * @param $head - head array( 0=> array("th", "th", "th"))
     * @param $table - table array( 0=> array("td", "td", "td"),
     *                              1=> array("td", "td", "td"))
     * @param $modulo - fills each second row with a light-grey for better visibility. Default is on, turn off with 0
     * @return void
     */
    public function headTable($head, $table, $modulo = 1)
    {
        $array = array_merge_recursive($head, $table);
        //print_r($array);
        $maxwidth = array();
        $maxwidth = $this->getFullWidth($array);

        $this->SetFillColor(220, 220, 220);
        $iHeight = 0;
        $arraySize = sizeof($array);
        for ($a = 0; $a < $arraySize; $a++) {
            if ($modulo) {
                if ($a % 2 === 0) {
                    $fill = 1;
                } else {
                    $fill = 0;
                }
            } else {
                $fill = 0;
            }
            for ($b = 0; $b < sizeof($array[$a]); $b++) {
                $bEndOfCell = 0;
                if ($b == sizeof($array[$a]) - 1) {
                    $bEndOfCell = 1;
                }

                if ($a == 0) {
                    $oldStyle = $this->FontStyle;
                    $this->SetFont($this->FontFamily, 'B', $this->FontSizePt);

                    if ($maxwidth[$b] > 140) {
                        $maxwidth[$b] = 130;
                    }
                    if ($maxwidth[$b] < 25) {
                        $maxwidth[$b] = 25;
                    }
                    $this->MultiCell($maxwidth[$b], 6, $this->delete_html($array[$a][$b]), 0, 'L', 1, $bEndOfCell);

                    $this->SetFont($this->FontFamily, $oldStyle, $this->FontSizePt);
                } else {
                    if ($a == 1) {
                        $this->SetFillColor(240, 240, 240);
                    }
                    //echo $maxwidth[$b]." max $b.Spalte<br/>";

                    if ($maxwidth[$b] > 140) {
                        $maxwidth[$b] = 130;
                    }
                    if ($b == 0) {
                        $iHeight = $this->getStringHeight($maxwidth[$b], $this->delete_html($array[$a][$b]));
                        $this->MultiCell($maxwidth[$b], $iHeight, $this->delete_html($array[$a][$b]), 0, 'L', $fill, $bEndOfCell);
                    } else {
                        $iLines = $this->getStringHeight($maxwidth[$b], $this->delete_html($array[$a][$b]));
                        if ($iLines > $iHeight) {
                            $iHeight = $iLines;
                        }
                        $this->MultiCell($maxwidth[$b], $iHeight, $this->delete_html($array[$a][$b]), 0, 'L', $fill, $bEndOfCell);
                    }
                }
            }
        }
        $this->ln(5);
    }
    public function getminwidth($array)
    {
        $width = array();
        $arraySize = sizeof($array);
        for ($i = 0; $i < $arraySize; $i++) {
            for ($j = 0; $j < sizeof($array[$i]); $j++) {
                $stringWidth = 0;
                $chars = str_split((string) $this->delete_html($array[$i][$j]), 1);
                foreach ($chars as $char) {
                    $stringWidth = $stringWidth + $this->GetCharWidth($char);

                    //echo $stringWidth.": ".$char."<br/>";
                }
                if ($stringWidth != 0 && $stringWidth < 8) {
                    $stringWidth = $stringWidth * 3;
                }
                if (!isset($width[$j]) || $stringWidth > $width[$j]) {
                    $width[$j] = $stringWidth;
                }
            }
        }
        return $width;
    }
    public function getmaxwidth($array)
    {
        $arraySize = sizeof($array);
        for ($i = 0; $i < $arraySize; $i++) {
            for ($j = 0; $j < sizeof($array[$i]); $j++) {
                if (($i - 1) >= 0) {
                    if (strlen((string) $this->delete_html($array[($i - 1)][$j])) < strlen((string) $this->delete_html($array[$i][$j]))) {
                        $width[$j] = strlen((string) $this->delete_html($array[$i][$j]));
                    }
                } else {
                    $width[$j] = strlen((string) $this->delete_html($array[$i][$j]));
                }
            }
        }
        return ($width);
    }
    /**
     *
     * Gets the width for columns in a table based on their Stringlength and the width of the page...
     * @param $array
     * @return array with column width
     */
    public function getFullWidth($array)
    {
        $maxlength = array();
        $width = array();
        $width = $this->getminwidth($array);

        $margins = $this->getMargins();
        $deadSpace = $margins['left'] + $margins['right'];
        $fullWidth = ($this->GetLineWidth() * 1000) - $deadSpace;
        $faktor = $fullWidth / array_sum($width);

        $arraySize = sizeof($width);
        for ($i = 0; $i < $arraySize; $i++) {
            $maxlength[$i] = $faktor * $width[$i];
        }
        return $maxlength;
    }
    /**
     *
     * gets the width for each column in tables, based on pagewidth and count of columns.
     * Good for static tables with equal value String-length
     * @param $array
     * @return mixed
     */
    public function getEqualWidth($array)
    {
        $margins = $this->getMargins();
        $deadSpace = $margins['left'] + $margins['right'];

        $width = ($this->GetLineWidth() * 1000) - $deadSpace;
        $count = 0;
        $arraySize = sizeof($array);
        for ($i = 0; $i < $arraySize; $i++) {
            for ($j = 0; $j < sizeof($array[$i]); $j++) {
                if (sizeof($array[$i]) > $count) {
                    $count = sizeof($array[$i]);
                }
            }
        }

        if ($count != 0) {
            return ($width / $count);
        } else {
            return false;
        }
    }
    public function write_out($name)
    {
        $this->Output($name, "D");
    }

    public function delete_html($text)
    {
        $text = html_entity_decode((string) $text, null, 'UTF-8');
        $text = str_replace("\t", ' ', $text);
        return strip_tags($text);
    }
    /**
     *
     * Create Answer PDF document, set metadata and set title
     * @param array $aSurveyInfo - Survey Information (preventing from passing to methods every time)
     * @param array $aPdfLanguageSettings - Pdf language settings
     * @param string $sSiteName - LimeSurvey site name (header and metadata)
     * @param string $sSurveyName - Survey name (header, metadata and title),
     * @param string $sDefaultHeaderString - TCPDF header string
     * @return void
     */
    public function initAnswerPDF($aSurveyInfo, $aPdfLanguageSettings, $sSiteName, $sSurveyName, $sDefaultHeaderString = '')
    {
        if (empty($sDefaultHeaderString)) {
            $sDefaultHeaderString = $sSurveyName;
        }

        $this->_aSurveyInfo = $aSurveyInfo;
        $this->SetAuthor($sSiteName);
        $this->SetTitle($sSurveyName);
        $this->SetSubject($sSurveyName);
        $this->SetKeywords($sSurveyName);

        $this->SetFont($aPdfLanguageSettings['pdffont']);
        $this->_ibaseAnswerFontSize = $aPdfLanguageSettings['pdffontsize'];
        $this->_iCellHeight = ceil($this->_ibaseAnswerFontSize / 2);
        $this->setLanguageArray($aPdfLanguageSettings['lg']);

        $this->addHeader($aPdfLanguageSettings, $sSiteName, $sDefaultHeaderString);
        $this->AddPage();
        $this->SetFillColor(220, 220, 220);

        $this->addTitle($sSurveyName);
    }

    /**
     *
     * Add title to pdf
     * @param string $sTitle - Title
     * @param string $sSubtitle - Subtitle
     * @return void
     */
    public function addTitle($sTitle, $sSubtitle = "")
    {
        if (getGlobalSetting('pdfshowsurveytitle') == 'Y') {
            if (!empty($sTitle)) {
                $this->ln(1);
                $this->SetFontSize($this->_ibaseAnswerFontSize + 6);
                $oPurifier = new CHtmlPurifier();
                $sTitleHTML = html_entity_decode((string) stripJavaScript($oPurifier->purify($sTitle)), ENT_COMPAT);
                $this->WriteHTMLCell(0, $this->_iCellHeight, $this->getX(), $this->getY(), $sTitleHTML, 0, 1, false, true, 'C');
                if (!empty($sSubtitle)) {
                    $this->ln(1);
                    $this->SetFontSize($this->_ibaseAnswerFontSize + 2);
                    $sSubtitleHTML = html_entity_decode((string) stripJavaScript($oPurifier->purify($sSubtitle)), ENT_COMPAT);
                    $this->WriteHTMLCell(0, $this->_iCellHeight, $this->getX(), $this->getY(), $sSubtitleHTML, 0, 1, false, true, 'C');
                }
                $this->ln(6);
                $this->SetFontSize($this->_ibaseAnswerFontSize);
            }
        }
    }

    /**
     *
     * Add header to pdf
     * @param array $aPdfLanguageSettings - Pdf language settings
     * @param string $sSiteName - LimeSurvey site name (header and metadata)
     * @param string $sDefaultHeaderString - TCPDF header string
     * @return void
     */
    public function addHeader($aPdfLanguageSettings, $sSiteName, $sDefaultHeaderString)
    {

        $oTemplate = Template::getLastInstance();
        $sLogoFileName = $oTemplate->filesPath . Yii::app()->getConfig('pdflogofile');
        if (!file_exists($sLogoFileName)) {
            $sLogoFileName = '';
        }

        if (Yii::app()->getConfig('pdfshowheader') == 'Y') {
            $sHeaderTitle = Yii::app()->getConfig('pdfheadertitle');
            if ($sHeaderTitle == '') {
                $sHeaderTitle = $sSiteName;
            }
            $sHeaderString = Yii::app()->getConfig('pdfheaderstring');
            if ($sHeaderString == '') {
                $sHeaderString = $sDefaultHeaderString;
            }

            $this->SetHeaderData($sLogoFileName, Yii::app()->getConfig('pdflogowidth'), $sHeaderTitle, $sHeaderString);
            $this->SetHeaderFont(array($aPdfLanguageSettings['pdffont'], '', $this->_ibaseAnswerFontSize - 2));
            $this->SetFooterFont(array($aPdfLanguageSettings['pdffont'], '', $this->_ibaseAnswerFontSize - 2));
        }
    }

    public function Header()
    {
        if ($this->header_xobjid === false) {
            // start a new XObject Template
            $this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
            $headerfont = $this->getHeaderFont();
            $headerdata = $this->getHeaderData();
            $this->y = $this->header_margin;
            if ($this->rtl) {
                $this->x = $this->w - $this->original_rMargin;
            } else {
                $this->x = $this->original_lMargin;
            }

            if (($headerdata['logo']) and ($headerdata['logo'] != K_BLANK_IMAGE)) {
                $imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES . $headerdata['logo']);
                if (($imgtype == 'eps') or ($imgtype == 'ai')) {
                    $this->ImageEps($headerdata['logo'], '', '', $headerdata['logo_width']);
                } elseif ($imgtype == 'svg') {
                    $this->ImageSVG($headerdata['logo'], '', '', $headerdata['logo_width']);
                } else {
                    $this->Image($headerdata['logo'], '', '', $headerdata['logo_width']);
                }
                $imgy = $this->getImageRBY();
            } else {
                $imgy = $this->y;
            }
            $cell_height = $this->getCellHeight($headerfont[2] / $this->k);
            // set starting margin for text data cell
            if ($this->getRTL()) {
                $header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
            } else {
                $header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
            }
            $cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
            $this->SetTextColorArray($this->header_text_color);
            // header title
            $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
            $this->SetX($header_x);
            $this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
            // header string
            $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
            $this->SetX($header_x);
            $this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
            // print an ending header line
            $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
            $this->SetY((2.835 / $this->k) + max($imgy, $this->y));
            if ($this->rtl) {
                $this->SetX($this->original_rMargin);
            } else {
                $this->SetX($this->original_lMargin);
            }
            $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
            $this->endTemplate();
        }
        // print header template
        $x = 0;
        $dx = 0;
        if (!$this->header_xobj_autoreset and $this->booklet and (($this->page % 2) == 0)) {
            // adjust margins for booklet mode
            $dx = ($this->original_lMargin - $this->original_rMargin);
        }
        if ($this->rtl) {
            $x = $this->w + $dx;
        } else {
            $x = 0 + $dx;
        }
        $this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
        if ($this->header_xobj_autoreset) {
            // reset header xobject template at each page
            $this->header_xobjid = false;
        }
    }

    /**
     *
     * Add GID text to PDF
     * @param $sGroupName - Group name
     * @param string $sGroupDescription - Group description
     * @param $bAllowBreakPage - Allow break cell in two pages
     * @return void
     */
    public function addGidAnswer($sGroupName, $sGroupDescription, $bAllowBreakPage = false)
    {
        $oPurifier = new CHtmlPurifier();
        $sGroupName = html_entity_decode((string) stripJavaScript($oPurifier->purify($sGroupName)), ENT_COMPAT);
        $sGroupDescription = html_entity_decode((string) stripJavaScript($oPurifier->purify($sGroupDescription)), ENT_COMPAT);
        $sData['thissurvey'] = $this->_aSurveyInfo;
        $sGroupName = templatereplace($sGroupName, array(), $sData, '', $this->_aSurveyInfo['anonymized'] == "Y", null, array(), true);
        $sGroupDescription = templatereplace($sGroupDescription, array(), $sData, '', $this->_aSurveyInfo['anonymized'] == "Y", null, array(), true);

        $startPage = $this->getPage();
        $this->startTransaction();
        $this->ln(6);
        $this->SetFontSize($this->_ibaseAnswerFontSize + 4);
        $this->WriteHTMLCell(0, $this->_iCellHeight, $this->getX(), $this->getY(), $sGroupName, 0, 1, false, true, 'C');
        $this->ln(2);
        $this->SetFontSize($this->_ibaseAnswerFontSize + 2);
        $this->WriteHTMLCell(0, $this->_iCellHeight, $this->getX(), $this->getY(), $sGroupDescription, 0, 1, false, true, 'L');
        $this->ln(2);
        if ($this->getPage() != $startPage && !$bAllowBreakPage) {
            $this->rollbackTransaction(true);
            $this->AddPage();
            $this->addGidAnswer($sGroupName, $sGroupDescription, true); // Second param = true avoid an endless loop if a cell is longer than a page
        } else {
            $this->commitTransaction();
        }
    }

    /**
     *
     * Add answer to PDF
     *
     * @param string $sQuestion - Question field text array
     * @param string $sResponse - Answer field text array
     * @param boolean $bReplaceExpressions - Try to replace LimeSurvey Expressions. This is false when exporting answers PDF from admin GUI
     *                               because we can not interpret expressions so just purify.
     *                               TODO: Find a universal valid method to interpret expressions
     * @param boolean $bAllowBreakPage - Allow break cell in two pages
     * @return void
     */
    public function addAnswer($sQuestion, $sResponse, $bReplaceExpressions = true, $bAllowBreakPage = false)
    {
        $bYiiQuestionBorder = 1;
        $bQuestionFill = 1;
        $bQuestionBorder = 1;
        $bResponseBorder = 1;
        $bYiiQuestionFill = Yii::app()->getConfig('bPdfQuestionFill');
        if ($bYiiQuestionFill == 0) {
            $bQuestionFill = 0;
        }
        $bYiiQuestionBorder = Yii::app()->getConfig('bPdfQuestionBorder');
        if ($bYiiQuestionBorder == 0) {
            $bQuestionBorder = 0;
        }

        $bYiiResponseBorder = Yii::app()->getConfig('bPdfResponseBorder');
        if ($bYiiResponseBorder == '0') {
            $bResponseBorder = 0;
        }

        $oPurifier = new CHtmlPurifier();
        $sQuestionHTML = str_replace('-oth-', '', $sQuestion); // Copied from Writer::stripTagsFull. Really necessary?
        $sQuestionHTML = html_entity_decode((string) stripJavaScript($oPurifier->purify($sQuestionHTML)), ENT_COMPAT);
        if ($bReplaceExpressions) {
            $sData = array();
            $sData['thissurvey'] = $this->_aSurveyInfo;
            $sQuestionHTML = templatereplace($sQuestionHTML, array(), $sData, '', $this->_aSurveyInfo['anonymized'] == "Y", null, array(), true);
        }
        $sResponse = flattenText($sResponse, false, true, 'UTF-8', false);
        $startPage = $this->getPage();
        $this->startTransaction();
        $bYiiQuestionBold = Yii::app()->getConfig('bPdfQuestionBold');
        if ($bYiiQuestionBold == '1') {
            $sFontFamily = $this->getFontFamily();
            $this->SetFont($sFontFamily, 'B', $this->_ibaseAnswerFontSize);
        } else {
            $this->SetFontSize($this->_ibaseAnswerFontSize);
        }
        $this->WriteHTMLCell(0, $this->_iCellHeight, $this->getX(), $this->getY(), $sQuestionHTML, $bQuestionBorder, 1, $bQuestionFill, true, 'L');
        if ($bYiiQuestionBold == '1') {
            $this->SetFont($sFontFamily, '', $this->_ibaseAnswerFontSize);
        }
        $this->MultiCell(0, $this->_iCellHeight, $sResponse, $bResponseBorder, 'L', 0, 1, '', '', true);
        $this->ln(2);
        if ($this->getPage() != $startPage && !$bAllowBreakPage) {
            $this->rollbackTransaction(true);
            $this->AddPage();
            $this->addAnswer($sQuestion, $sResponse, $bReplaceExpressions, true); // "Last param = true" prevents an endless loop if a cell is longer than a page
        } else {
            $this->commitTransaction();
        }
    }
}
