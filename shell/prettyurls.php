<?php

require_once 'abstract.php';

class LCB_PrettyUrls_Tool extends Mage_Shell_Abstract
{

    const ACTION = 'action';

    public function run()
    {

        $products = Mage::getModel('catalog/product');

        if ($this->getArg(self::ACTION)) {

            switch ($this->getArg(self::ACTION)) {
                case self::ACTION_REBUILD:
                    $this->rebuildUrls();
                    break;
                default:
                    echo $this->usageHelp();
            }
        }
    }

    public function rebuildUrls()
    {
        
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
        
Usage:  php prettyurls.php [action]

  -h              - Short alias for help
  -action rebuild - resaves all url_keys from product names     


USAGE;
    }

}

$shell = new LCB_PrettyUrls_Tool();
$shell->run();
