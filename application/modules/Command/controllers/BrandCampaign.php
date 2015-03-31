<?php

/**
 * Class     BrandCampaignController
 * 计划信息控制器
 *
 * @author   yangyang3
 */
class BrandCampaignController extends Base_Command_Controllers {

    /**
     * Method  stopAction
     * 终止计划
     *
     * @author yangyang3
     */
    public function stopAction() {
        $date = $this->request->getParam('date');

        if (empty($date)) {
            $date = Yaf_Registry::get('request_date');
        }

        $brand_campaign_service = new Brand_CampaignService();

        $result = true;

        //$result = $brand_campaign_service->stopByDateForCommand($date);

        if (false === $result) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->success();
    }

}