<?php

class MageWorx_SearchAutocomplete_Block_Result extends Mage_CatalogSearch_Block_Result {

    protected $_pageCollection;
    protected $_blogCollection;

    public function getPageResultCount() {
        if (!$this->getData('page_result_count')) {
            $size = $this->_getPageCollection()->getSize();
            $this->setPageResultCount($size);
        }
        return $this->getData('page_result_count');
    }

    protected function _getPageCollection() {
        if (is_null($this->_pageCollection)) {
            $this->_pageCollection = Mage::getResourceModel('searchautocomplete/fulltext_collection');
            $this->_pageCollection
					->addSearchFilter(Mage::helper('catalogSearch')->getEscapedQueryText())
                    ->addStoreFilter(Mage::app()->getStore());
        }
        
        return $this->_pageCollection;
    }

    protected function _getBlogCollection() {
        if (is_null($this->_blogCollection)) {
            $this->_blogCollection = Mage::getResourceModel('searchautocomplete/fulltext_blog_collection');
            $this->_blogCollection->addSearchFilter(Mage::helper('catalogSearch')->getEscapedQueryText())
                    ->addStoreFilter(Mage::app()->getStore());
        }
        return $this->_blogCollection;
    }

    protected function _sanitizeContent($page) {
        return Mage::helper('searchautocomplete')->sanitizeContent($this->_toHtmlContent($page));
    }

    protected function _toHtmlContent($page) {
		$content = ($page->getContent()) ? $page->getContent() : $page->getPostContent();
		$processor = Mage::getModel('searchautocomplete/cms_content_filter');
		$designSettings = $processor->getDesignSettings();
		$arStoreId = $page->getStoreId();
		$designSettings->setStore($arStoreId[0]);
		$designSettings->setArea('frontend');                
		$html = $processor->process($content);
        return $html;
    }

}