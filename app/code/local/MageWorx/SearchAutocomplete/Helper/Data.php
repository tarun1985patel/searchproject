<?php
/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SearchAutocomplete
 * @copyright  Copyright (c) 2011 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * Search Autocomplete extension
 *
 * @category   MageWorx
 * @package    MageWorx_SearchAutocomplete
 * @author     MageWorx Dev Team
 */

class MageWorx_SearchAutocomplete_Helper_Data extends Mage_Core_Helper_Abstract {
    
    const XML_SEARCHAUTOCOMPLETE_ENABLED = 'mageworx_tweaks/searchautocomplete/enabled';
    const XML_SEARCHAUTOCOMPLETE_HIGHLIGHTING_ENABLED = 'mageworx_tweaks/searchautocomplete/highlighting_enabled';
    const XML_SEARCHAUTOCOMPLETE_SEPARATOR_ENABLED = 'mageworx_tweaks/searchautocomplete/separator_enabled';
    
    const XML_SEARCHAUTOCOMPLETE_SUGGESTED_SEARCHES = 'mageworx_tweaks/searchautocomplete/suggested_searches';
    const XML_SEARCHAUTOCOMPLETE_SUGGESTED_SEARCHES_RESULTS = 'mageworx_tweaks/searchautocomplete/suggested_searches_results';
    
    const XML_SEARCHAUTOCOMPLETE_SEARCH_PRODUCTS = 'mageworx_tweaks/searchautocomplete/search_products';
    const XML_SEARCHAUTOCOMPLETE_PRODUCT_IMAGE_SIZE = 'mageworx_tweaks/searchautocomplete/product_image_size';
    const XML_SEARCHAUTOCOMPLETE_PRODUCT_SEARCH_RESULTS = 'mageworx_tweaks/searchautocomplete/product_search_results';
    const XML_SEARCHAUTOCOMPLETE_PRODUCT_SEARCH_RESULTS_SORT_ORDER = 'mageworx_tweaks/searchautocomplete/product_search_results_sort_order';
    const XML_SEARCHAUTOCOMPLETE_PRODUCT_SEARCH_RESULT_FIELDS = 'mageworx_tweaks/searchautocomplete/product_search_result_fields';
    const XML_SEARCHAUTOCOMPLETE_PRODUCT_SHORT_DESCRIPTION_SIZE = 'mageworx_tweaks/searchautocomplete/product_short_description_size';
    const XML_SEARCHAUTOCOMPLETE_PRODUCT_TITLE_SIZE = 'mageworx_tweaks/searchautocomplete/product_title_size';
    
    const XML_SEARCHAUTOCOMPLETE_SEARCH_CATEGORIES = 'mageworx_tweaks/searchautocomplete/search_categories';
    const XML_SEARCHAUTOCOMPLETE_CATEGORY_SEARCH_RESULTS = 'mageworx_tweaks/searchautocomplete/category_search_results';    
    
    const XML_SEARCHAUTOCOMPLETE_SEARCH_CMS = 'mageworx_tweaks/searchautocomplete/search_cms';
    const XML_SEARCHAUTOCOMPLETE_CMS_SEARCH_RESULT_FIELDS = 'mageworx_tweaks/searchautocomplete/cms_search_result_fields';

    const XML_SEARCHAUTOCOMPLETE_SEARCH_BLOG = 'mageworx_tweaks/searchautocomplete/search_blog';

    const XML_SEARCHAUTOCOMPLETE_SHOW_PRODUCT_RESULTS_GROUPED_BY_CATEGORIES = 'mageworx_tweaks/searchautocomplete/show_product_results_grouped_by_categories';
    
    public function isEnabled() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_ENABLED);
    }
    
    public function isHighlightingEnabled() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_HIGHLIGHTING_ENABLED);
    }
    
    public function isSeparatorEnabled() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_SEPARATOR_ENABLED);
    }    
    
    public function isSuggestedSearches() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_SUGGESTED_SEARCHES);
    }
    
    public function getSuggestedSearchesResults() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_SUGGESTED_SEARCHES_RESULTS);
    }
    
    public function isSearchProducts() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_SEARCH_PRODUCTS);
    }    
    
    public function getProductImageSize() {
        $size = Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_PRODUCT_IMAGE_SIZE);
        $size = explode('x', trim($size));

        return $size;
    }

    public function getProductSearchResults() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_PRODUCT_SEARCH_RESULTS);
    }

    public function getProductSearchResultsSortOrder() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_PRODUCT_SEARCH_RESULTS_SORT_ORDER);
    }

    public function getProductShortDescriptionSize() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_PRODUCT_SHORT_DESCRIPTION_SIZE);
    }
    
    public function getProductTitleSize() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_PRODUCT_TITLE_SIZE);
    }
    
    public function getProductSearchResultFields() {
        return explode(',', Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_PRODUCT_SEARCH_RESULT_FIELDS));
    }
    

    public function isSearchCategories() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_SEARCH_CATEGORIES);
    }
    
    public function getCatalogSearchResults() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_CATEGORY_SEARCH_RESULTS);
    }   

    public function isSearchCms() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_SEARCH_CMS);
    }

    public function isSearchBlog() {
        return Mage::getStoreConfigFlag(self::XML_SEARCHAUTOCOMPLETE_SEARCH_BLOG) && (string)Mage::getConfig()->getModuleConfig('AW_Blog')->active == 'true';
    }
    
    public function getCmsSearchResultFields() {
        return explode(',', Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_CMS_SEARCH_RESULT_FIELDS));        
    }
    
    public function getSearchType($storeId = null) {
        return Mage::getStoreConfig(Mage_CatalogSearch_Model_Fulltext::XML_PATH_CATALOG_SEARCH_TYPE, $storeId);
    }

	public function isShowProductResultsGroupedByCategories() {
        return Mage::getStoreConfig(self::XML_SEARCHAUTOCOMPLETE_SHOW_PRODUCT_RESULTS_GROUPED_BY_CATEGORIES);
    }
    
    public function limitText($str, $limit) {
        $str = trim($str);        
        $words = explode(' ', $str);
        if (count($words) > $limit) {
            $str = implode(' ', array_slice($words, 0, $limit)) . '...';
        }        
        return $this->highlightText($str);
        
    }
        
    public function highlightText($str) {
        if (!$this->isHighlightingEnabled()) return $str;
        $q = Mage::helper('catalogsearch')->getEscapedQueryText();
        $q = preg_quote($q, '/');
        return preg_replace('/('.$q.')/is', '<highlight>\\1</highlight>', $str);        
    }    

    public function getMoreResultsUrl() {
        $urlParams = array();
        $urlParams['_current'] = true;
        $urlParams['_escape'] = true;
        $urlParams['_use_rewrite'] = false;
        $params = array(
            Mage::helper('catalogsearch')->getQueryParamName() => Mage::helper('catalogsearch')->getEscapedQueryText()
        );
        $urlParams['_query'] = $params;
        return Mage::getUrl('catalogsearch/result', $urlParams);
    }

    public function sanitizeContent($text) {
        $search = array('@&lt;script.*?&gt;.*?&lt;/script&gt;@si', '@&lt;style.*?&gt;.*?&lt;/style&gt;@si');
        $replace = array('', '');
        $text = trim(strip_tags(preg_replace($search, $replace, $text)));        
        preg_match('/^([^.!?\s]*[\.!?\s]+){0,30}/', $text, $abstract);
        $result = trim(count($abstract) > 0 ? $abstract[0] : '');
        if ($result!='' && strlen($text)>strlen($result)) $result .= '...';
        return $this->highlightText($result);
    }
}