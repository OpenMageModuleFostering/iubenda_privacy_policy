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
 
/**
 * Renderer for Iubenda Policy banner in System Configuration
 * 
 * @author     
 */
class Iubenda_Policy_Block_Adminhtml_System_Config_Fieldset_Hint
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_template = 'iubenda/policy/system/config/fieldset/hint.phtml';

    /**
     * Render fieldset html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->toHtml();
    }
}