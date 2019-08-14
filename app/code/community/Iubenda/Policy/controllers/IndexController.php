<?php
/**
 * IUBENDA - Privacy Policy Generator
 *
 * @author     iubenda <info@iubenda.com>
 * @category   legal
 * @package    Iubenda_Policy
 * @copyright  Copyright (c) 2003-2012 iubenda srl (http://www.iubenda.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.html (GPL)
 */

class Iubenda_Policy_IndexController extends Mage_Core_Controller_Front_Action
{

	# Pre dispatch action that allows to redirect to no route page in case of disabled extension through admin panel
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::helper('iubenda_policy')->isEmbeddingEnabled()) {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }
    }
	
	# Valid routes to here are:
	# /privacy-policy
	# /privacy-policy/index
	# /privacy-policy/index/index
	# Please note:
	# to allow store dependent link to PP, in admin section CMS -> Static Blocks -> Footer links you may add following link to pp: {{store}}privacy-policy
	# Please note:
	# in order the above to work correctly, set magento's url store dependent, via admin section System -> Configuration -> General -> Web -> Url Options -> Add Store Code to Urls -> Yes
    public function indexAction() {
		
		// specific filter for privacy policy body embedded as a page
        if (!Mage::helper('iubenda_policy')->directEmbed()) {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }
		
		$this->loadLayout();
		$this->renderLayout();

    }

}
?>