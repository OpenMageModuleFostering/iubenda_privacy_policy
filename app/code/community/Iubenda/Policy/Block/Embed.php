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
class Iubenda_Policy_Block_Embed extends Mage_Core_Block_Template
{
	public function getEmbeddingCode(){
		return Mage::helper('iubenda_policy')->embeddedCode(true);
	}
}