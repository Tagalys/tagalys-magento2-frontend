<?php
namespace Tagalys\Frontend\Helper;

class Search extends \Magento\Framework\App\Helper\AbstractHelper {
    public function __construct(
        \Tagalys\Sync\Helper\Configuration $tagalysConfiguration,
        \Tagalys\Sync\Helper\Api $tagalysApi
    ){
        $this->tagalysConfiguration = $tagalysConfiguration;
        $this->tagalysApi = $tagalysApi;
    }

    public function cachePopularSearches() {
        try {
            $setupStatus = $this->tagalysConfiguration->getConfig('setup_status');
            $setupComplete = ($setupStatus == 'completed');
            if ($setupComplete) {
                $storesForTagalys = $this->tagalysConfiguration->getStoresForTagalys();
                if ($storesForTagalys != null) {
                    foreach ($storesForTagalys as $storeId) {
                        $popularSearches = $this->tagalysApi->storeApiCall($storeId . '', '/v1/popular_searches', array());
                        if ($popularSearches != false && array_key_exists('popular_searches', $popularSearches)) {
                            $this->tagalysConfiguration->setConfig("store:{$storeId}:popular_searches", $popularSearches['popular_searches'], true);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->tagalysApi->log('local', "Error in cachePopularSearches: " . $e->getMessage());
        }
    }
}
?>