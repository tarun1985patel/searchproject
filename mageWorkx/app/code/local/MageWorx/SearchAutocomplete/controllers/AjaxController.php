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
//3
require_once 'Mage/CatalogSearch/controllers/AjaxController.php';

class MageWorx_SearchAutocomplete_AjaxController extends Mage_CatalogSearch_AjaxController {

    public function suggestAction() {        
		
		$qry=Mage::app()->getRequest()->getParam('q');
		if(class_exists(Memcache)){
			$memcache = new Memcache; 
			$host=Mage::getStoreConfig('mageworx_tweaks/searchautocomplete/search_memcache_host');
			$port=Mage::getStoreConfig('mageworx_tweaks/searchautocomplete/search_memcache_port');
			if($memcache->connect($host, $port)){
				if($html=$memcache->get($qry))
				{	
					echo $html;
					exit;
				}
			}
		}
					
		

        if (!Mage::helper('searchautocomplete')->isEnabled()) return parent::suggestAction();        
                
        //add query filter prior
        
        $queryText = $this->getRequest()->getParam('q', false);
        
		if (!$queryText || $queryText == '') {
            exit();
        }
        $words = Mage::helper('core/string')->splitWords($queryText, true, 0);
        $deniedWords = Mage::getStoreConfig('mageworx_tweaks/searchautocomplete/exlude_words_in_search',Mage::app()->getStore());
        
        $listDeniedWords = Mage::helper('core/string')->splitWords( $deniedWords, true, 0,",");
        $queryText = "";
        foreach ( $words as $word ) {            
            if( !in_array( $word, $listDeniedWords )){
                $queryText .= $word." ";                
            }                        
        }
		
        $queryModel = Mage::helper('catalogsearch')->getQuery();
        $queryModel->setStoreId(Mage::app()->getStore()->getId());
        $queryModel->prepare();
        $queryModel->save();

        
        if (Mage::helper('searchautocomplete')->isSuggestedSearches()) {
            //$suggestData = $this->getLayout()->createBlock('catalogsearch/autocomplete')->getSuggestData();
            $suggestData = Mage::getResourceModel('searchautocomplete/query_collection')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->setQueryFilter($queryText)
                ->setLimit(Mage::helper('searchautocomplete')->getSuggestedSearchesResults())
                ->toArray();
				
        } else {
            $suggestData = array();
        }    
        
        if (Mage::helper('searchautocomplete')->isSearchProducts()) {
            $products = Mage::getModel('catalogsearch/layer')->getProductCollection()->load();
        } else {
            $products = array();
        }
		
        if (Mage::helper('searchautocomplete')->isSearchCategories()) {
            $categories = Mage::getModel('searchautocomplete/search')->getRelevantCategoriesByQuery();
        } else {
            $categories = array();
        }    
        
        if (Mage::helper('searchautocomplete')->isSearchCms()) {
            $cmsPages = Mage::getModel('searchautocomplete/search')->getCmsPageCollection();
        } else {
            $cmsPages = array();
        }

        if (count($suggestData) && count($products) && count($categories) && count($cmsPages)) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('searchautocomplete/autocomplete')
                    ->setSuggestData($suggestData)
                    ->setProducts($products)
                    ->setCategories($categories)
                    ->setCmsPages($cmsPages)                    
                    ->toHtml());
        } elseif ( !count($suggestData) && count($products) && count($categories) && count($cmsPages) ) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('searchautocomplete/autocomplete')                    
                    ->setProducts($products)
                    ->setCategories($categories)
                    ->setCmsPages($cmsPages)                    
                    ->toHtml());         
        } elseif ( !count($suggestData) && count($products) && count($categories) && !count($cmsPages) ) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('searchautocomplete/autocomplete')                    
                    ->setProducts($products)
                    ->setCategories($categories)
                    ->toHtml());         
        } elseif ( !count($suggestData) && count($products) && count($categories) && !count($cmsPages) ) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('searchautocomplete/autocomplete')                    
                    ->setProducts($products)
                    ->setCategories($categories)
                    ->toHtml());         
        } elseif ( count($products) && !count($categories)  ) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('searchautocomplete/autocomplete')
                    ->setProducts($products)                    
                    ->toHtml());
        } elseif ( !count($products) && count($categories)  ) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('searchautocomplete/autocomplete')
                    ->setCategories($categories)                                    
                    ->toHtml());         
        } else {
            exit();
        }
    }
}